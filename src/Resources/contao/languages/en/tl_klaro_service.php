<?php

declare(strict_types=1);

/*
 * Klaro Consent Manager bundle for Contao Open Source CMS
 *
 * Copyright (c) 2023 pdir / digital agentur // pdir GmbH
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

$sgl = 'Service';
//$pl = 'Services';
$klaro = 'Klaro';

$GLOBALS['TL_LANG']['tl_klaro_service'] = [
    // Operations
    //'edit' => ["$sgl mit ID: %s bearbeiten", 'Datensatz mit ID: %s bearbeiten'],
    //'copy' => ["$sgl mit ID: %s kopieren", 'Datensatz mit ID: %s kopieren'],
    //'delete' => ["$sgl mit ID: %s löschen", 'Datensatz mit ID: %s löschen'],
    //'show' => ["$sgl mit ID: %s ansehen", 'Datensatz mit ID: %s ansehen'],

    // title legend
    'title_legend' => 'Configuration name',
    'title' => ["Name of the $sgl configuration", 'Enter here a name for this service that contao uses.'],
    // service legend
    'service_legend' => "$klaro $sgl name und purposes",
    'name' => ["Name of the {$sgl}", "Enter the name for the $sgl that $klaro uses internally as the symbol for this service."],
    'purposes' => ['Purposes', "Select here at least one purpose to which this service is assigned. If the list is empty, you must first define at least one purpose under the menu item &raquo;$klaro-purposes&laquo;."],
    'cookies' => ['Cookie rules', "The cookie rules are a bit complicated. <a style='color:green;' href='https://heyklaro.com/docs/integration/annotated-configuration'>Here you can find more information about the $klaro cookie rules.</a>"],
    // standard legend
    'standard_legend' => 'Preferences for this service',
    'default' => ['agreed', 'If this option is enabled, consent for this service is preset when loading.'],
    'required' => ['required', "When this option is enabled, $klaro does not allow this service to be disabled by the user. Use this option for services that are necessary for your website to basically work (e.g. shopping cart cookies)."],
    'optOut' => ['opt out', "If this option is enabled, $klaro will load this service even if the user has not explicitly agreed to it. We strongly advise against this!"],
    'onlyOnce' => ['only once', "If this option is enabled, the service is executed only once, regardless of how often the user turns it on and off. This is important, for example, for tracking scripts that would generate new pageview events every time $klaro notices a change in the user's consent."],
    'contextualConsentOnly' => ['Contextual consent only', "If this option is enabled, $klaro will consider the service as &raquo;context-dependent&laquo;. This means that at the corresponding positions in the layout, a separate consent is requested before the element at that position is activated for this service."],
    // callback legend
    'callback_legend' => 'Callback',
    'callback' => ['<b style="color:green">callback</b>: <b style="color:blue">function</b>(consent, service) {', "<b>}</b> You can define here the function body for an optional callback function that will be called each time the consent status for a given service changes. The consent value is passed as the first parameter &raquo;consent&laquo; to the function (true=agree). The &raquo;service configuration&laquo; is passed as the second parameter &raquo;service&laquo;."],
    // event_handler_legend
    'event_handler_legend' => 'Event-Handler-Definitionen',
    'onAccept' => ['<b style="color:green">onAccept</b>: <b style="color:blue">function</b>(opts) {', '<b>}</b > You can define the function body for an optional event handler here.'],
    'onInit' => ['<b style="color:green">onInit</b>: <b style="color:blue">function</b>(opts) {', '<b>}</b> You can define the function body for an optional event handler here.'],
    'onDecline' => ['<b style="color:green">onDecline</b>: <b style="color:blue">function</b>(opts) {', '<b>}</b> You can define the function body for an optional event handler here.'],
    'vars' => ['<b style="color:green">vars</b>: {', '<b>}</b> You can define additional variables here.'],
];
