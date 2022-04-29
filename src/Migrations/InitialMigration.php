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
        if (!$schemaManager->tablesExist(['tl_klaro_purpose'])) {
            return false;
        }

        $count = $this->connection->fetchOne('SELECT COUNT(*) FROM tl_klaro_purpose');

        if ($count > 0) {
            return false;
        }

        return true;
    }

    public function run(): MigrationResult
    {
        $stmt = $this->connection->prepare("INSERT INTO `tl_klaro_purpose` (`id`, `tstamp`, `title`, `klaro_key`) VALUES
    (1, UNIX_TIMESTAMP(), 'Analyse', 'analytics'),
	(2, UNIX_TIMESTAMP(), 'Sicherheit', 'security'),
	(3, UNIX_TIMESTAMP(), 'Chat', 'livechat'),
	(4, UNIX_TIMESTAMP(), 'Werbung', 'advertising'),
	(5, UNIX_TIMESTAMP(), 'CSS und Styles', 'styling'),
	(6, UNIX_TIMESTAMP(), 'Video und Streaming', 'videostream');
");

        $stmt->execute();

        $count = $this->connection->fetchOne('SELECT COUNT(*) FROM tl_klaro_purpose');

        return $this->createResult(true, "$count Purposes added.");
    }
}
