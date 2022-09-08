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

    // title legend
    'title_legend' => "Name der $sgl",
    'title' => ["Name der $sgl", "Geben Sie einen Namen für die $sgl ein."],
    // translation legend
    'translation_legend' => 'Sprach-Kennzeichen und Link zur Datenschutzerklärung',
    'lang_code' => ['Sprach-Kennzeichen', 'Geben Sie hier das Sprach-Kennzeichen gemäß ISO 639-1 (auch &raquo;Ländercoode&laquo; genannt, z.B. de oder de-ch) ein.'],
    'privacyPolicyUrl' => ['Link zur Datenschutzerklärung', 'Wählen Sie hier die Seite mit der Datenschutzerklärung in der entsprechenden Landessprache.'],
    // consent notice legend
    'consent_notice_legend' => 'Text in der Einwilligungsbox',
    'consentNotice' => ['Text in der &raquo;Einwilligungsbox&laquo; (max. 4096 Zeichen)', "Dieser Text erscheint in der Box des $klaro-Consent-Managers."],
    // consent modal legend
    'consent_modal_legend' => 'Text im Modal-Dialog',
    'consentModal' => ['Text im &raquo;Modal-Dialog&laquo; (max. 4096 Zeichen)', "Dieser Text erscheint im Modal-Dialog des $klaro-Consent-Managers."],
    // purposes legend
    'purposes_legend' => 'Übersetzungstabelle für Zwecke',
    'purposes' => ['Übersetzungstabelle für registrierte Zwecke', "Hier können Sie die $sgl für alle registrierten Zwecke definieren. Möchten Sie die Liste der Schlüssel neu aufbauen, so löschen Sie alle Einträge und entfernen Sie dann die Werte aus dem letzten verbleibenden Schlüssel-Wert-Paar. Klicken Sie dann auf &raquo;Speichern&laquo; Die Liste wird dann aus den bereits registrierten Zwecken neu erstellt."],
    'purposes_empty' => 'Sie haben noch keine <b>Zwecke</b> definiert. Bitte definieren Sie zuerst <b>Zwecke</b>, bevor Sie hier Übersetzungen für <b>diese Zwecke</b> eingeben können.',
    // services legend
    'services_legend' => 'Übersetzungstabelle für Dienste',
    'services' => ['Übersetzungstabelle für registrierte Dienste', "Hier können Sie die $sgl für alle registrierten Dienste definieren. Möchten Sie die Liste der Schlüssel neu aufbauen, so löschen Sie alle Einträge und entfernen Sie dann die Werte aus dem letzten verbleibenden Schlüssel-Wert-Paar. Klicken Sie dann auf &raquo;Speichern&laquo; Die Liste wird dann aus den bereits registrierten Zwecken neu erstellt."],
    'services_empty' => 'Sie haben noch keine <b>Dienste</b> definiert. Bitte definieren Sie zuerst <b>Dienste</b>, bevor Sie hier Übersetzungen für <b>diese Dienste</b> eingeben können.',
    // contextual consent legend
    'contextual_consent_legend' => 'Übersetzungen für kontextbezogene Zustimmung',
    'ccAcceptAlways' => ['Schaltfläche &raquo;immer zustimmen&laquo;', 'Geben Sie hier ihre Übersetzung ein.'],
    'ccAcceptOnce' => ['Schaltfläche &raquo;einmalig zustimmen&laquo;', 'Geben Sie hier ihre Übersetzung ein.'],
    'ccDescription' => ['Fragetext', 'Geben Sie hier den Fragetext ein. Sie können in dieser Zeichenkette die Variable {title} verwenden. Diese enthält den Namen des Dienstes, dem zugestimmt werden soll.'],
    'ccMonitor' => ['Vorschau', ''],

    // KlaroTranslationListerner messages
    'purposesSavePronouns' => ['sgl' => ['Der', 'ist'], 'pl' => ['Die', 'sind']],
    'purposesSaveError' => '%s Übersetzungsschlüssel [<b>%s</b>] %s unbekannt. Sie können nur folgende Schlüssel übersetzen: [<b>%s</b>].',

    'servicesSavePronouns' => ['sgl' => ['Der', 'ist'], 'pl' => ['Die', 'sind']],
    'servicesSaveError' => '%s Übersetzungsschlüssel [<b>%s</b>] %s unbekannt. Sie können nur folgende Schlüssel übersetzen: [<b>%s</b>].',
];
