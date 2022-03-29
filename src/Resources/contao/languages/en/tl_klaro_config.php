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
//$pl = 'Konfigurationen';
$klaro = 'Klaro&copy;';

$GLOBALS['TL_LANG']['tl_klaro_config'] = [
    // Legends
    'expert_legend' => 'Experten Einstellungen',

    // Operations
    'edit' => ["$sgl mit ID: %s bearbeiten", 'Datensatz mit ID: %s bearbeiten'],
    'copy' => ["$sgl mit ID: %s kopieren", 'Datensatz mit ID: %s kopieren'],
    'delete' => ["$sgl mit ID: %s löschen", 'Datensatz mit ID: %s löschen'],
    'show' => ["$sgl mit ID: %s ansehen", 'Datensatz mit ID: %s ansehen'],

    // Naming
    'first_legend' => 'Basis Einstellungen',
    'title' => ["Name der $sgl", "Geben Sie einen Namen für die $sgl ein."],

    // Config
    'config_legend' => 'Skript Konfiguration',
    'scriptLoadingMode' => ['script Lademodus', ''],
    'loading_mode_options' => [
        '' => 'synchron',
        'defer' => 'verzögert (defer)',
        'async' => 'parallel (async)',
    ],

    // Basic Configuration

    'selectField' => ['Select Feld', 'Wählen Sie aus.'],
    'checkboxField' => ['Chosen Feld', 'Wählen Sie aus.'],
    'multitextField' => ['Multitext Feld', 'Geben Sie die Werte ein'],
    'addSubpalette' => ['Erweiterte Einstellungen aktivieren', 'Hier können Sie die erweiterten Einstellungen aktivieren.'],
    'textareaField' => ['Textarea', 'Geben Sie einen Text ein'],

    // Expert Legend
    'testing' => ['Test-Modus aktivieren', "Wenn Sie testing aktivieren, so zeigt $klaro standardmäßig weder den Einwilligungshinweis noch das modal-Window an, es sei denn, sie fügen den spezielle Hashtag #klaro-testing an die URL an. Dann ist es möglich, $klaro auf Ihrer Live-Website zu testen, ohne den normalen Betrieb zu beeinträchtigen."],
    'elementID' => ['klaro-elementId', "Sie können hier die Id des DIV-Elements anpassen, das $klaro beim Start erstellt. Standardmäßig wird $klaro &raquo;klaro&laquo; verwenden."],
    'storageMethod' => ['Speichermethode', "Hier können Sie festlegen, wie $klaro die Zustimmungsinformationen speichert. Wählen Sie &raquo;Cookie Storage&laquo; (Voreinstellung) oder &raquo;Browser Local Storage&laquo;."],
    'storage_method_options' => ['cookie' => 'Cookie Storage', 'localStorage' => 'Browser Local Storage'],
    'storageName' => ['Speicher-Schlüssel', "Sie können den Key (Schlüssel) des Cookies oder des localStorage-Eintrags anpassen, den $klaro für die Speicherung der Zustimmungsinformationen verwendet. Standardmäßig verwendet $klaro &raquo;klaro&laquo;."],
    'htmlTexts' => ['HTML-Modus', "Wenn diese Option aktiviert ist, rendert $klaro die Texte, die in den Feldern `consentModal.description` und `consentNotice.description` angegebenen sind als HTML. Das ermöglicht es Ihnen, z.B. benutzerdefinierte Links oder interaktive Inhalte hinzuzufügen."],
    'cookieDomain' => ['Cookie-Domain', "Sie können die Cookie-Domain für den Zustimmungsmanager anpassen. Tun Sie dies, wenn Sie die Zustimmung für mehrere übereinstimmende Domänen nur einmal erhalten möchten. Standardmäßig verwendet $klaro die aktuelle Domain. Diese Einstellung ist nur relevant, wenn &raquo;Speichermethode&laquo; auf &raquo;Cookie Storage&laquo; eingestellt ist."],

    // Buttons
    'customButton' => 'Custom Routine starten',
];
