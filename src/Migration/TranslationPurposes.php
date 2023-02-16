<?php

declare(strict_types=1);

/*
 * Klaro Consent Manager bundle for Contao Open Source CMS
 *
 * Copyright (c) 2022 pdir / digital agentur // pdir GmbH
 *
 * @package    klaro-consent-manager
 * @link       https://pdir.de/consent/
 * @license    LGPL-3.0-or-later
 * @author     Mathias Arzberger <develop@pdir.de>
 * @author     Christian Mette <develop@pdir.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pdir\ContaoKlaroConsentManager\Migration;

use Contao\CoreBundle\Migration\AbstractMigration;
use Contao\CoreBundle\Migration\MigrationResult;
use Contao\StringUtil;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Pdir\ContaoKlaroConsentManager\Model\KlaroTranslationModel;

class TranslationPurposes extends AbstractMigration
{
    use MigrationHelperTrait;

    public const DEBUG = false;

    private $connection;
    private $schemaManager;
    private $columns;

    private $myTable = 'tl_klaro_translation';
    private $myJob = '';
    private \stdClass $sourceColumn;
    private \stdClass $backupColumn;

    /**
     * @throws Exception
     */
    public function __construct(Connection $connection)
    {
        /**
         * this lambda transcodes the given field value from the source field to the target field
         * it expects the raw field value as argument and must return a raw field value.
         *
         * in this particular case here, services are transcoded from old to new format
         */
        $sourceTranscoderFn = function ($value) {
            if (null === $value) {
                return $value;
            }
            // the field contains many purposes
            $items = StringUtil::deserialize($value);

            if ($this::DEBUG) {
                dump('in:  ', $items);
            }

            foreach ($items as &$purpose) {
                $purpose['translation'] = str_replace('_', ' ', $purpose['value']);
                $purpose['description'] = "<p>{$purpose['translation']}</p>";
                unset($purpose['value']);
            }

            if ($this::DEBUG) {
                dump('out: ', $items);
            }

            // the encoder must return the same type it received
            return serialize($items);
        };

        $this->connection = $connection;

        if(method_exists($connection,'createSchemaManager')) {
            $this->schemaManager = $connection->createSchemaManager();
        } else {
            $this->schemaManager = $connection->getSchemaManager();
        }

        $this->sourceColumn = new \stdClass();
        $this->sourceColumn->name = 'purposes';
        $this->sourceColumn->type = 'blob';
        $this->sourceColumn->transcoder = $sourceTranscoderFn;

        $this->myJob = "migrate the structure of field {$this->myTable}.{$this->sourceColumn->name}.";
    }

    public function getName(): string
    {
        return $this->myJob;
    }

    /**
     * @throws Exception
     */
    public function shouldRun(): bool
    {
        // if the database table itself does not exist we should do nothing
        if (!$this->schemaManager->tablesExist([$this->myTable])) {
            return false;
        }
        // get all columns
        $this->columns = $this->schemaManager->listTableColumns($this->myTable);
        // check
        if (
            isset($this->columns[$this->sourceColumn->name]) && // if the source column to be converted exists
            $this->ColumnHasType($this->sourceColumn, 'blob') && // and is of type blob
            $this->itemsAreNotConverted($this->sourceColumn) // and is not yet converted
        ) {
            return true;
        }
        // otherwise do not migrate
        return false;
    }

    /**
     * we migrate in two passes.
     */
    public function run(): MigrationResult
    {
        // test whether the source column does exist
        if (isset($this->columns[$this->sourceColumn->name])) {
            $this->debug("Spalte [{$this->sourceColumn->name}] ist vorhanden.");

            if ($this->ColumnHasType($this->sourceColumn, 'blob')) {
                $this->debug("Spalte [{$this->sourceColumn->name}] ist TYPE [{$this->sourceColumn->type}].");

                $_result = $this->migrateKeyValueToKeyTranslationDescription($this->sourceColumn);

                if ($_result->state) {
                    $result = $this->createResult(true, "key-value for column [{$this->sourceColumn->name}] migrated. {$_result->recordsConverted} records affected.");
                } else {
                    $result = $this->createResult(true, "key-value for column [{$this->sourceColumn->name}] could not migrated. {$_result->recordsFailed} records failed.");
                }
            } else {
                // some error
                $this->debug("Spalte [{$this->sourceColumn->name}] existiert, ist aber weder [text] noch [blob] -> das kann nicht migriert werden.");
                $result = $this->createResult(false, "migration error. source column [{$this->sourceColumn->name}] is neither varchar nor blob.");
            }
        } else {
            // the column does not exist -> maybe an error?
            $this->debug("  Spalte [{$this->sourceColumn->name}] existiert nicht");
        }

        return $result;
    }

    /**
     * this function is only intended for use with the TranslationModel.
     *
     * @return bool
     */
    private function itemsAreNotConverted(\stdClass $columnObject)
    {
        $result = false;

        $translations = KlaroTranslationModel::findBy(["{$columnObject->name} IS NOT NULL"], 1);

        if(null === $translations) {
            return $result;
        }

        foreach ($translations as $translation) {
            $value = $translation->{$columnObject->name};

            if (null !== $value) {
                $items = StringUtil::deserialize($value);

                foreach ($items as $item) {
                    // indicator of not yet completed migration is the presence of the "value" key.
                    $condition = \array_key_exists('value', $item);
                    // at first match return true
                    if ($condition) {
                        return $condition;
                    }
                }
            }
        }

        return $result;
    }

    /**
     * migrates the purposes field from the key-value format
     * to the key-translation-description format.
     *
     * @return bool
     */
    private function migrateKeyValueToKeyTranslationDescription(\stdClass $columnObject): \stdClass
    {
        $this->debug("migriere [{$columnObject->name}]...");

        $result = new \stdClass();
        $result->state = false;
        $result->recordsConverted = 0;
        $result->recordsFailed = 0;

        $transcoder = $columnObject->transcoder;
        $fieldName = $columnObject->name;

        // ony convert fields with valid data
        $translations = KlaroTranslationModel::findBy(["{$columnObject->name} IS NOT NULL"], 1);

        foreach ($translations as $translation) {
            $serializedValue = $translation->$fieldName;

            if (strpos($serializedValue, 'value') > 0) {
                $translation->$fieldName = $transcoder($translation->$fieldName);
                $translation->save();
                ++$result->recordsConverted;
                $result->state = true;
            } else {
                ++$result->recordsFailed;
            }
        }

        return $result;
    }
}
