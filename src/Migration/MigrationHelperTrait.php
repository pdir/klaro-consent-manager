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

use Contao\CoreBundle\Migration\MigrationResult;
use Contao\Model;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Types\Type;

trait MigrationHelperTrait
{
    /**
     * @param string $columnObject
     *
     * @throws Exception
     */
    public function ColumnHasType(\stdClass $columnObject, string $type): bool
    {
        return $this->columns[$columnObject->name]->getType() === Type::getType($type);
    }

    /**
     * @param string $columnObject
     *
     * @throws Exception
     */
    public function createBackupFrom(\stdClass $columnObject): MigrationResult
    {
        $this->debug("starte Backup von Spalte $columnObject->name nach {$columnObject->name}_backup");
        // update columns
        $this->columns = $this->schemaManager->listTableColumns($this->myTable);

        // test whether the backup column does not exist -> the normal case
        if (!isset($this->columns["{$columnObject->name}_backup"])) {
            $this->debug("Spalte {$columnObject->name}_backup ist nicht vorhanden -> rename $columnObject->name to {$columnObject->name}_backup.");
            // the backup colum does not exist -> do a simple rename from compatibility_timetable to compatibility_timetable_backup
            $records = $this->connection->executeStatement("ALTER TABLE $this->myTable RENAME COLUMN $columnObject->name TO {$columnObject->name}_backup");
            $result = $this->createResult(true, "{$columnObject->name}_backup created. $records records affected.");
        } else {
            $this->debug("Spalte {$columnObject->name}_backup ist vorhanden -> Kopiere $columnObject->name to {$columnObject->name}_backup.");
            // the column does exist -> do a simple column-copy from compatibility_timetable to compatibility_timetable_backup
            $records = $this->connection->executeStatement("UPDATE TABLE $this->myTable {$columnObject->name}_backup = $columnObject->name");
            $result = $this->createResult(true, "{$columnObject->name}_backup copied. $records records affected.");
        }

        // update modified columns
        $this->columns = $this->schemaManager->listTableColumns($this->myTable);

        return $result;
    }

    /**
     * @param string $columnObject
     */
    public function migrateVarcharToBlob(\stdClass $columnObject): MigrationResult
    {
        $this->debug('  -- beginne Konversion --');

        // update columns
        $this->columns = $this->schemaManager->listTableColumns($this->myTable);

        // does the source column exist?
        if (isset($this->columns[$columnObject->name])) {
            // change the column type
            $this->debug("    MODIFY COLUMN $columnObject->name blob NULL");
            $this->connection->executeStatement("ALTER TABLE $this->myTable MODIFY COLUMN $columnObject->name blob NULL");
        } else {
            // add the column
            $this->debug("    ADD COLUMN $columnObject->name blob NULL");
            $this->connection->executeStatement("ALTER TABLE $this->myTable ADD COLUMN $columnObject->name blob NULL");
        }

        $targetColumn = $columnObject->name;
        $sourceColumn = "{$columnObject->name}_backup";
        $transcoder = $columnObject->transcoder;

        $this->debug("Konvertiere von source [$sourceColumn] nach target [$targetColumn]");

        // get the model
        $model = Model::getClassFromTable($this->myTable);

        // convert data from varchar to blob
        if ($records = $model::findAll()) {
            foreach ($records as $record) {
                $this->debug("{$record->id} {$record->title}");
                $this->debug("  $sourceColumn.in  [{$record->$sourceColumn}]");
                $tr = $transcoder($record->$sourceColumn);
                $this->debug("  $targetColumn.out [$tr]");
                $record->$targetColumn = $tr;
                $record->save();
            }
            $result = $this->createResult(true, "conversion from {$columnObject->name} varchar() to $columnObject->name blob finished. {$records->count()} records affected.");
        } else {
            $result = $this->createResult(true, 'nothing to update.');
        }

        $this->debug('  -- ende Konversion --');

        return $result;
    }

    private function debug(string $message): void
    {
        if ($this::DEBUG) {
            echo "$message\n";
        }
    }
}
