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

$sgl = 'Übersetzung';
//$pl = 'Dienste';
$klaro = 'Klaro';

$GLOBALS['TL_LANG']['tl_klaro_translation'] = [
    // Operations
    'edit' => ["$sgl mit ID: %s bearbeiten", 'Datensatz mit ID: %s bearbeiten'],
    'copy' => ["$sgl mit ID: %s kopieren", 'Datensatz mit ID: %s kopieren'],
    'delete' => ["$sgl mit ID: %s löschen", 'Datensatz mit ID: %s löschen'],
    'show' => ["$sgl mit ID: %s ansehen", 'Datensatz mit ID: %s ansehen'],

    // name legend
    'title_legend' => "Name der $sgl",
    'title' => ["Name der $sgl", "Geben Sie einen Namen für die $sgl ein."],

    // translation legend
    'translation_legend' => 'Übersetzung',
    'lang_code' => ['Sprach-Kennzeichen', 'Geben Sie das Sprach-Kennzeichen (ISO 639-1 Code, z.B. de oder de-ch) ein.'],
    'default' => ['Standard: zugestimmt', 'Wenn Sie diese Option aktivieren, wird die Zustimmung für diesen Dienst beim Laden voreingestellt.'],
    'translations' => ['Übersetzungen', "$klaro"],

    'purposes' => ['Übersetzungstabelle für registrierte Zwecke', "Hier können Sie die $sgl für alle registrierten Zwecke definieren. Möchten Sie die Liste der Schlüssel neu aufbauen, so löschen Sie alle Einträge und entfernen Sie dann die Werte aus dem letzen verbleibenden Schlüssel-Wert-Paar. Klicken Sie dann auf &raquo;Speichern&laquo; Die Liste wird dann den bereits registrierten Zwecken erstellt."],
    //  'purposes_reference' see default
    //  'purposes_translations' see default
];
