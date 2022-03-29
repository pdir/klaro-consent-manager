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

$sgl = 'Konfiguration';
$pl = 'Konfigurationen';

$GLOBALS['TL_LANG']['tl_klaro_config'] = [

    // Legends
    'expert_legend' => 'Experten Einstellungen',

    // Operations
    'edit' => ["$sgl mit ID: %s bearbeiten", 'Datensatz mit ID: %s bearbeiten'],
    'copy' => ["$sgl mit ID: %s kopieren", 'Datensatz mit ID: %s kopieren'],
    'delete' => ["$sgl mit ID: %s löschen", 'Datensatz mit ID: %s löschen'],
    'show'  => ["$sgl mit ID: %s ansehen", 'Datensatz mit ID: %s ansehen'],

    // Naming
    'first_legend' => 'Basis Einstellungen',
    'title' => ["Name der $sgl", "Geben Sie einen Namen für die $sgl ein."],

    // Basic Configuration


    'selectField' => ['Select Feld', 'Wählen Sie aus.'],
    'checkboxField' => ['Chosen Feld', 'Wählen Sie aus.'],
    'multitextField' => ['Multitext Feld', 'Geben Sie die Werte ein'],
    'addSubpalette' => ['Erweiterte Einstellungen aktivieren', 'Hier können Sie die erweiterten Einstellungen aktivieren.'],
    'textareaField' => ['Textarea', 'Geben Sie einen Text ein'],

    // Expert Legend
    'testing' => ['Test-Modus aktivieren', 'Wenn Sie testing aktivieren, so zeigt Klaro standardmäßig weder den Einwilligungshinweis noch das modal-Window an, es sei denn, sie fügen den spezielle Hashtag #klaro-testing an die URL an. Dann ist es möglich, Klaro auf Ihrer Live-Website zu testen, ohne den normalen Betrieb zu beeinträchtigen.'],
    'elementID' => ['Id des klaro-DIVs', 'Sie können hier die Id des DIV-Elements anpassen, welches Klaro beim Initialisieren des Scriptes erstellt. Standardmäßig wird Klaro &raquo;klaro&laquo; verwenden.'],

    // References
    'firstoption' => 'Erste Option',
    'secondoption' => 'Zweite Option',

    // Buttons
    'customButton' => 'Custom Routine starten',
];
