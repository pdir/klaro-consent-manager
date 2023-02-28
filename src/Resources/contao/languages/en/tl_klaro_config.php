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

$sgl = 'configuration';
//$pl = 'Configurations';
$klaro = 'Klaro';

$GLOBALS['TL_LANG']['tl_klaro_config'] = [
    // Operations
    //'edit' => ["$sgl with ID: %s edit", 'Datensatz mit ID: %s bearbeiten'],
    //'copy' => ["$sgl mit ID: %s kopieren", 'Datensatz mit ID: %s kopieren'],
    //'delete' => ["$sgl mit ID: %s löschen", 'Datensatz mit ID: %s löschen'],
    //'show' => ["$sgl mit ID: %s ansehen", 'Datensatz mit ID: %s ansehen'],

    // title legend
    'title_legend' => 'Base Settings',
    'title' => ["Name of the $sgl", "Enter a name for the $sgl."],
    // services legend
    'services_legend' => 'Configure services',
    'services' => ['Services used', "Select the services to be used by $klaro here."],
    // config legend
    'script_legend' => 'Configure scripts',
    'scriptLoadingMode' => ['Loading-Mode', 'Select here how the script should be loaded. The mode &raquo;defer&laquo; should be preferred!'],
    //'loding_mode_options' see default
    'myConfigVariableName' => ['Name of the configuration variable', "By default, $klaro loads the configuration from a global variable &raquo;klaroConfig&laquo;. You can change this by specifying your own variable name."],
    // consent legend
    'consent_legend' => 'Configure consent form',
    'noticeAsModal' => ["Start $klaro as modal", "Opens $klaro on load &raquo;modal&laquo; (a modal window or dialog or similar is an object that is displayed on top of the web page and that cannot be bypassed. The user must react in some way to this object)."],
    'default' => ['Standard consent for all services', "Sets the default consent for all services (disabled by default). You can configure this setting under &raquo;$klaro services&laquo; for each service separately."],
    'mustConsent' => ['Force modal', 'If you activate this option, the consent window is displayed as a modal dialog. It is then not possible for the user to close it until they have actively agreed or declined.'],
    'acceptAll' => ['&raquo;Accept all&laquo;', 'If you enable this option, the &raquo;Accept All&laquo; button will appear in the notice and overlay, allowing you to agree to all third-party services with one click. If you disable this option, you can agree to each service individually.'],
    'hideDeclineAll' => ['Hide &raquo;reject all&laquo;', 'If you enable this option, the &raquo;decline&laquo; button in the overlay will be hidden and the user will be forced to open the overlay separately to change their consent or disable all third-party services. We strongly discourage you from using this feature as it is contrary to the &raquo;privacy by default&laquo; and &raquo;privacy by design&laquo; principles of the General Data Protection Regulation.'],
    'hideLearnMore' => ['Hide &raquo;learn more&laquo;', 'If you enable this option, the link &raquo;learn more/customize&laquo; in the consent form will be hidden. We strongly advise against doing this, as it prevents the user from customizing their consent decisions.'],
    'hideModal' => ['Disable modal on certain pages', 'Here you can define on which subpages the modal should not be displayed.'],
    // cookie legend
    'cookie_legend' => 'Configure cookies',
    'elementID' => ['DIV-Id', "You can customize here the id of the DIV element that $klaro will create at startup. By default $klaro will use &raquo;klaro&laquo;."],
    'storageName' => ['Storage key', "You can customize the key of the cookie or localStorage entry that $klaro uses to store the consent information. By default, $klaro uses &raquo;klaro&laquo;."],
    'storageMethod' => ['Storage method', "Here you can specify how $klaro stores the consent information. Select &raquo;Cookie Storage&laquo; (default) or &raquo;Browser Local Storage&laquo;."],
    //'storage_method_options' see default
    'cookieDomain' => ['Cookie domain', "You can customize the cookie domain for the consent manager. Do this if you want to get consent for multiple matching domains only once. By default, $klaro uses the current domain. This setting is relevant only if &raquo;Storage Method&laquo; is set to &raquo;Cookie Storage&laquo;."],
    'cookieExpiresAfterDays' => ['Cookie expiration time', "Here you can set expiration time for the $klaro cookie. Default is 30 days (only relevant if &raquo;Storage method&laquo; is set to &raquo;Cookie Storage&laquo;)."],
    // callback legend
    'callback_legend' => 'Callback',
    'callback' => ['<b style="color:green">callback</b>: <b style="color:blue">function</b>(consent, service) {', "<b>}</b>\nYou can define here the function body for an optional callback function that will be called each time the consent status for a given service changes. The consent value is passed as the first parameter &raquo;consent&laquo; to the function (true=agree). The &raquo;service configuration&laquo; is passed as the second parameter &raquo;service&laquo;."],
    // expert legend
    'expert_legend' => 'Test and maintenance',
    'htmlTexts' => ['HTML mode', "When this option is enabled, $klaro renders the texts specified in the &raquo;Text in consent box&laquo; and &raquo;Text in modal dialog&laquo; fields as HTML. This allows you to add custom links or interactive content, for example. You can find these fields in the $klaro translations."],
    'testing' => ['Testing mode', "If you enable testing, $klaro will not display the consent notice or the modal window by default, unless you add the special hashtag #klaro-testing to the URL. Then it is possible to test $klaro on your live website without affecting normal operation."],
];
