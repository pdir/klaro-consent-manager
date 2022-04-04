<?php

declare(strict_types=1);

/*
 * Klaro Consent Manager bundle for Contao Open Source CMS
 *
 * Copyright (c) 2022 pdir / digital agentur // pdir GmbH
 *
 * @package    krpano-bundle
 * @link       https://pdir.de/krpano-bundle/
 * @license    LGPL-3.0-or-later
 * @author     Mathias Arzberger <develop@pdir.de>
 * @author     Christian Mette <develop@pdir.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$sgl = 'Zweck';
//$pl = 'Zwecke';
//$klaro = 'Klaro&copy;';

$GLOBALS['TL_LANG']['tl_klaro_purpose'] = [
    // Operations
    'edit' => ["$sgl mit ID: %s bearbeiten", 'Datensatz mit ID: %s bearbeiten'],
    'copy' => ["$sgl mit ID: %s kopieren", 'Datensatz mit ID: %s kopieren'],
    'delete' => ["$sgl mit ID: %s löschen", 'Datensatz mit ID: %s löschen'],
    'show' => ["$sgl mit ID: %s ansehen", 'Datensatz mit ID: %s ansehen'],

    // Naming
    'first_legend' => 'Benennung',
    'title' => ['Name des Konfiguration', "Geben Sie einen Namen für die $sgl ein."],

    // Services
    'services_legend' => "{$sgl}konfiguration",
    'name' => ["Name des {$sgl}es", "Geben Sie einen Namen für den $sgl ein."],
    'default' => ['zugestimmt?', 'Wenn Sie diese Option aktivieren, wird die Zustimmung für diesen Dienst beim Laden voreingestellt.'],
    'translation' => [],
    'purposes' => [],
];
