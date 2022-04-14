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

namespace Pdir\ContaoKlaroConsentManager\Migrations;

use Contao\CoreBundle\Migration\AbstractMigration;
use Contao\CoreBundle\Migration\MigrationResult;
use Doctrine\DBAL\Connection;

class InitialMigration extends AbstractMigration
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function shouldRun(): bool
    {
        $schemaManager = $this->connection->getSchemaManager();

        // If the database table itself does not exist we should do nothing
        if (!$schemaManager->tablesExist(['tl_klaro_purposes'])) {
            return false;
        }

        $columns = $schemaManager->listTableColumns('tl_klaro_purposes');

        return
            isset($columns['firstname']) &&
            isset($columns['lastname']) &&
            !isset($columns['name']);
    }

    public function run(): MigrationResult
    {
        $this->connection->executeQuery("
            ALTER TABLE
                tl_customers
            ADD
                name varchar(255) NOT NULL DEFAULT ''
        ");

        $stmt = $this->connection->prepare("
            UPDATE
                tl_customers
            SET
                name = CONCAT(firstName, ' ', lastName)
        ");

        $stmt->execute();

        return $this->createResult(
            true,
            'Combined '.$stmt->rowCount().' customer names.'
        );
    }
}
