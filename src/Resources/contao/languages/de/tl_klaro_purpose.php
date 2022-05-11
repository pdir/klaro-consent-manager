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

$sgl = 'Zweck';
//$pl = 'Dienste';
$klaro = 'Klaro';

$GLOBALS['TL_LANG']['tl_klaro_purpose'] = [
    // Operations
    'edit' => ["$sgl mit ID: %s bearbeiten", 'Datensatz mit ID: %s bearbeiten'],
    'copy' => ["$sgl mit ID: %s kopieren", 'Datensatz mit ID: %s kopieren'],
    'delete' => ["$sgl mit ID: %s löschen", 'Datensatz mit ID: %s löschen'],
    'show' => ["$sgl mit ID: %s ansehen", 'Datensatz mit ID: %s ansehen'],

    // title legend
    'title_legend' => 'Name',
    'title' => ['Name des Zwecks', 'Geben Sie einen Namen für diesen Zweck ein.'],
    // purpose legend
    'purpose_legend' => 'Zweck',
    'klaro_key' => ['Klaro Schlüssel', "Geben Sie hier die Zeichenkette ein, die $klaro intern als einheitlichen Schlüssel für diesen Zweck verwendet."],
];
