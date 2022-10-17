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
//$pl = 'Translations';
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
    'translation_legend' => 'Language code and Link to your privacy policy page',
    'lang_code' => ['Language code', 'Enter here the language code according to ISO 639-1 (also called &raquo;country code&laquo;, e.g. de or de-ch).'],
    'privacyPolicyUrl' => ['Link to privacy policy', 'Select here the page with the privacy policy in the corresponding national language.'],
    // consent notice legend
    'consent_notice_legend' => 'Text for the &raquo;consent notice&laquo;',
    'consentNotice' => ['Text for the &raquo;consent notice&laquo; (max. 4096 characters)', "This text appears in the $klaro consent manager box."],
    // consent modal legend
    'consent_modal_legend' => 'Text for the &raquo;modal dialog&laquo;',
    'consentModal' => ['Text for the &raquo;modal dialog&laquo; (max. 4096 characters)', "This text appears in the modal dialog of the $klaro consent manager."],
    // purposes legend
    'purposes_legend' => 'Translations for purposes',
    'purposes' => ['Translation table for registered purposes', "Here you can define the $sgl for all registered purposes. If you want to rebuild the list of keys, delete all entries and then remove the values from the last remaining key-value pair. Then click &raquo;Save&laquo; The list will then be rebuilt from the already registered purposes."],
    'purposes_key' => ['Purpose-key', 'Here you can enter the purpose-key.'],
    'purposes_translation' => ['Translation', 'Here you can define a Translation.'],
    'purposes_description' => ['Description', 'Here you can define a Description.'],
    'purposes_empty' => 'You have not defined any <b>purposes</b> yet. Please define <b>purposes</b> first before you can enter translations for them here. here',
    // services legend
    'services_legend' => 'Translation for services',
    'services_key' => ['Service-key', 'Here you can enter the service-key.'],
    'services_translation' => ['Translation', 'Here you can define a Translation.'],
    'services_description' => ['Description', 'Here you can define a Description.'],
    'services' => ['Translation table for registered services', "Here you can define the $sgl for all registered purposes. If you want to rebuild the list of keys, delete all entries and then remove the values from the last remaining key-value pair. Then click &raquo;Save&laquo; The list will then be rebuilt from the already registered services."],
    'services_empty' => 'You have not defined any <b>services</b> yet. Please define <b>services</b> first before you can enter translations for them here. here',
    // contextual consent legend
    'contextual_consent_legend' => 'Translations for contextual consent',
    'ccAcceptAlways' => ['Button &raquo;accept always&laquo;', 'Enter your translation here.'],
    'ccAcceptOnce' => ['Button &raquo;accept once&laquo;', 'Enter your translation here.'],
    'ccDescription' => ['Description', 'Enter the hint text here. You can use the {title} variable in this string. This contains the name of the service to be agreed to.'],
    'ccMonitor' => ['Preview', ''],

    // KlaroTranslationListerner messages
    'purposesSavePronouns' => ['sgl' => ['The', 'is'], 'pl' => ['The', 'are']],
    'purposesSaveError' => '%s  translation key [<b>%s</b>] %s unknown. You can only translate the following keys: [<b>%s</b>].',

    'servicesSavePronouns' => ['sgl' => ['The', 'is'], 'pl' => ['The', 'are']],
    'servicesSaveError' => '%s translation key [<b>%s</b>] %s unknown. You can only translate the following keys: [<b>%s</b>].',
];
