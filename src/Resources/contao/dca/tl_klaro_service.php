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

/*
 * Table tl_klaro_service
 */
$GLOBALS['TL_DCA']['tl_klaro_service'] = [
    // Config
    'config' => [
        'dataContainer' => 'Table',
        'enableVersioning' => true,
        'sql' => [
            'keys' => [
                'id' => 'primary',
            ],
        ],
    ],
    'list' => [
        'sorting' => [
            'mode' => 2,
            'fields' => ['title'],
            'flag' => 1,
            'panelLayout' => 'filter;sort,search,limit',
        ],
        'label' => [
            'fields' => ['title'],
            'format' => '%s',
        ],
        'global_operations' => [
            'all' => [
                'label' => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href' => 'act=select',
                'class' => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset()" accesskey="e"',
            ],
        ],
        'operations' => [
            'edit' => [
                'label' => &$GLOBALS['TL_LANG']['tl_klaro_service']['edit'],
                'href' => 'act=edit',
                'icon' => 'edit.svg',
            ],
            'copy' => [
                'label' => &$GLOBALS['TL_LANG']['tl_klaro_service']['copy'],
                'href' => 'act=copy',
                'icon' => 'copy.svg',
            ],
            'delete' => [
                'label' => &$GLOBALS['TL_LANG']['tl_klaro_service']['delete'],
                'href' => 'act=delete',
                'icon' => 'delete.svg',
                'attributes' => 'onclick="if(!confirm(\''.$GLOBALS['TL_LANG']['MSC']['deleteConfirm'].'\'))return false;Backend.getScrollOffset()"',
            ],
            'show' => [
                'label' => &$GLOBALS['TL_LANG']['tl_klaro_service']['show'],
                'href' => 'act=show',
                'icon' => 'show.svg',
                'attributes' => 'style="margin-right:3px"',
            ],
        ],
    ],
    // Palettes
    'palettes' => [
        '__selector__' => ['addSubpalette'],
        'default' => '{name_legend},title;'.
            '{service_legend},name,default;',
        //'{expert_legend},addSubpalette, ',
    ],
    // Subpalettes
    'subpalettes' => [
        'addSubpalette' => 'textareaField',
    ],
    // Fields
    'fields' => [
        'id' => [
            'sql' => 'int(10) unsigned NOT NULL auto_increment',
        ],
        'tstamp' => [
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ],
        'title' => [
            'inputType' => 'text',
            'exclude' => true,
            'search' => true,
            'filter' => true,
            'sorting' => true,
            'flag' => 1,
            'eval' => ['mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''",
        ],
        /*
         * Klaro Service Attributes
         */
        /*
         *  Each service must have a unique name. Klaro will look for HTML elements with a
         *  matching 'data-name' attribute to identify elements that belong to this service.
         */
        'name' => [
            'exclude' => true,
            'inputType' => 'text',
            'eval' => ['mandatory' => true, 'tl_class' => 'w25'],
            'sql' => [
                'type' => 'string',
                'length' => 255,
                'fixed' => true,
                'default' => '',
            ],
        ],
        /*
         * If 'default' is set to 'true', the service will be enabled by default. This
         * overrides the global 'default' setting.
         */
        'default' => [
            'exclude' => true,
            'inputType' => 'checkbox',
            'eval' => ['tl_class' => 'w25'],
            'sql' => [
                'type' => 'string',
                'length' => 1,
                'fixed' => true,
                'default' => '',
            ],
        ],
        /*
         * Translations belonging to this service go here. The key `zz` contains default
         * translations that will be used as a fallback if there are no translations
         * defined for a given language.
         */
        'translations' => [],

        /*
         * The purpose(s) of this service that will be listed on the consent notice. Do not
         * forget to add translations for all purposes you list here.
         */
        'purposes' => [],

        /*
         * you an either only provide a cookie name or regular expression (regex) or a list
         * consisting of a name or regex, a path and a cookie domain. Providing a path and
         * domain is necessary if you have services that set cookies for a path that is not
         * "/", or a domain that is not the current domain. If you do not set these values
         * properly, the cookie can't be deleted by Klaro, as there is no way to access the
         * path or domain of a cookie in JS. Notice that it is not possible to delete
         * cookies that were set on a third-party domain, or cookies that have the HTTPOnly
         * attribute: https://developer.mozilla.org/en-US/docs/Web/API/Document/cookie#new-cookie_domain
         */
        'cookies' => [],

        /*
         * You can define an optional callback function that will be called each time the
         * consent state for the given service changes. The consent value will be passed as
         * the first parameter to the function (true=consented). The `service` config will
         * be passed as the second parameter.
         */
        'callback' => [],

        /*
         * If 'required' is set to 'true', Klaro will not allow this service to be disabled
         * by the user. Use this for services that are always required for your website to
         * function (e.g. shopping cart cookies).
         */
        'required' => [], // false,

        /*
         * If 'optOut' is set to 'true', Klaro will load this service even before the user
         * has given explicit consent. We strongly advise against this.
         */
        'optOut' => [], // false,

        /*
         * If 'onlyOnce' is set to 'true', the service will only be executed once
         * regardless how often the user toggles it on and off. This is relevant e.g. for
         * tracking scripts that would generate new page view events every time Klaro
         * disables and re-enables them due to a consent change by the user.
         */
        'onlyOnce' => [], // true,

        /*
         * unklar
         */
        'contextualConsentOnly' => [], // true
    ],
];
