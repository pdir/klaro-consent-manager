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

$sgl = 'Translation';
$pl = 'Translations';
$klaro = 'Klaro';

$GLOBALS['TL_LANG']['tl_klaro_translation'] = [
    // Operations
    //'edit' => ["$sgl mit ID: %s bearbeiten", 'Datensatz mit ID: %s bearbeiten'],
    //'copy' => ["$sgl mit ID: %s kopieren", 'Datensatz mit ID: %s kopieren'],
    //'delete' => ["$sgl mit ID: %s löschen", 'Datensatz mit ID: %s löschen'],
    //'show' => ["$sgl mit ID: %s ansehen", 'Datensatz mit ID: %s ansehen'],

    // title legend
    'title_legend' => "Name of the $sgl",
    'title' => ["Name of the $sgl", "Enter a name for the $sgl here."],
    // translation legend
    'translation_legend' => $pl,
    'lang_code' => ['Language code', 'Enter here the language code according to ISO 639-1 (also called &raquo;country code&laquo;, e.g. de or de-ch).'],
    'privacyPolicyUrl' => ['Link to privacy policy', 'Select here the page with the privacy policy in the corresponding national language.'],
    'consentNotice' => ['Text for the &raquo;consent notice&laquo; (max. 4096 characters)', "This text appears in the $klaro consent manager box."],
    'consentModal' => ['Text for the &raquo;modal dialog&laquo; (max. 4096 characters)', "This text appears in the modal dialog of the $klaro consent manager."],
    'default' => ['agreed by default', 'If you enable this option, the consent for this service will be preset on loading.'],
    'translations' => [$pl, "$pl for purposes and services"],
    'purposes' => ['Translation table for registered purposes', "Here you can define the $sgl for all registered purposes. If you want to rebuild the list of keys, delete all entries and then remove the values from the last remaining key-value pair. Then click &raquo;Save&laquo; The list will then be rebuilt from the already registered purposes."],
    'services' => ['Translation table for registered services', "Here you can define the $sgl for all registered purposes. If you want to rebuild the list of keys, delete all entries and then remove the values from the last remaining key-value pair. Then click &raquo;Save&laquo; The list will then be rebuilt from the already registered services."],
    // KlaroTranslationListerner messages
    'purposesSavePronouns' => ['sgl' => ['The', 'is'], 'pl' => ['The', 'are']],
    'purposesSaveError' => '%s  translation key [<b>%s</b>] %s unknown. You can only translate the following keys: [<b>%s</b>].',
    'servicesSavePronouns' => ['sgl' => ['The', 'is'], 'pl' => ['The', 'are']],
    'servicesSaveError' => '%s translation key [<b>%s</b>] %s unknown. You can only translate the following keys: [<b>%s</b>].',
];
