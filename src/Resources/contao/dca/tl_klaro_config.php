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
 * Table tl_klaro_config
 */
$GLOBALS['TL_DCA']['tl_klaro_config'] = [
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
                'label' => &$GLOBALS['TL_LANG']['tl_klaro_config']['edit'],
                'href' => 'act=edit',
                'icon' => 'edit.svg',
            ],
            'copy' => [
                'label' => &$GLOBALS['TL_LANG']['tl_klaro_config']['copy'],
                'href' => 'act=copy',
                'icon' => 'copy.svg',
            ],
            'delete' => [
                'label' => &$GLOBALS['TL_LANG']['tl_klaro_config']['delete'],
                'href' => 'act=delete',
                'icon' => 'delete.svg',
                'attributes' => 'onclick="if(!confirm(\''.$GLOBALS['TL_LANG']['MSC']['deleteConfirm'].'\'))return false;Backend.getScrollOffset()"',
            ],
            'show' => [
                'label' => &$GLOBALS['TL_LANG']['tl_klaro_config']['show'],
                'href' => 'act=show',
                'icon' => 'show.svg',
                'attributes' => 'style="margin-right:3px"',
            ],
        ],
    ],
    // Palettes
    'palettes' => [
        '__selector__' => ['addSubpalette'],
        'default' => '{first_legend},title,selectField,checkboxField,multitextField;'.
            '{config_legend},scriptLoadingMode;'.
            '{expert_legend},htmlTexts,testing,elementID,storageName,storageMethod,cookieDomain,cookieExpiresAfterDays;',
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
        'scriptLoadingMode' => [
            'inputType' => 'select',
            'exclude' => true,
            'search' => true,
            'filter' => true,
            'sorting' => true,
            'reference' => $GLOBALS['TL_LANG']['tl_klaro_config']['loading_mode_options'],
            'options' => ['', 'async', 'defer'], // https://heyklaro.com/docs/integration/overview
            'eval' => ['tl_class' => 'w25'],
            'sql' => [
                'type' => 'string',
                'length' => 50,
                'fixed' => true,
                'default' => 'defer',
            ],
        ],
        'testing' => [
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
        'elementID' => [
            'exclude' => true,
            'inputType' => 'text',
            'eval' => ['tl_class' => 'w25 clr'],
            'sql' => [
                'type' => 'string',
                'length' => 50,
                'fixed' => true,
                'default' => 'klaro',
            ],
        ],
        'storageMethod' => [
            'inputType' => 'select',
            'exclude' => true,
            'search' => true,
            'filter' => true,
            'sorting' => true,
            'reference' => $GLOBALS['TL_LANG']['tl_klaro_config']['storage_method_options'],
            'options' => ['cookie', 'localStorage'],
            'eval' => ['tl_class' => 'w25'],
            'sql' => [
                'type' => 'string',
                'length' => 50,
                'fixed' => true,
                'default' => 'cookie',
            ],
        ],
        'storageName' => [
            'exclude' => true,
            'inputType' => 'text',
            'eval' => ['tl_class' => 'w25'],
            'sql' => [
                'type' => 'string',
                'length' => 50,
                'fixed' => true,
                'default' => 'klaro',
            ],
        ],
        'htmlTexts' => [
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
        'cookieDomain' => [
            'exclude' => true,
            'inputType' => 'text',
            'eval' => ['tl_class' => 'w25'],
            'sql' => [
                'type' => 'string',
                'length' => 50,
                'fixed' => true,
                'default' => '.example.com',
            ],
        ],
        /*
         * You can also set a custom expiration time for the Klaro cookie. By default, it
         *  will expire after 30 days. Only relevant if 'storageMethod' is set to 'cookie'.
         */
        'cookieExpiresAfterDays' => [
            'exclude' => true,
            'inputType' => 'text',
            'eval' => ['tl_class' => 'w25'],
            'sql'       => [
                'type'      => 'integer',
                'unsigned'  => false,
                'notnull'   => true,
                'default'   => 30,
                'comment'   => ''
            ],
        ],
        /*
         * Defines the default state for services in the consent modal (true=enabled by
         * default). You can override this setting in each service.
         */
        'default' => [false],
        /*
        If 'mustConsent' is set to 'true', Klaro will directly display the consent
        manager modal and not allow the user to close it before having actively
        consented or declined the use of third-party services.
        */
        'mustConsent' => [false],
        /*
        Setting 'acceptAll' to 'true' will show an "accept all" button in the notice and
        modal, which will enable all third-party services if the user clicks on it. If
        set to 'false', there will be an "accept" button that will only enable the
        services that are enabled in the consent modal.
        */
        'acceptAll' => [true],
        /*
         * Setting 'hideDeclineAll' to 'true' will hide the "decline" button in the consent
         * modal and force the user to open the modal in order to change his/her consent or
         * disable all third-party services. We strongly advise you to not use this
         * feature, as it opposes the "privacy by default" and "privacy by design"
         * principles of the GDPR (but might be acceptable in other legislations such as
         * under the CCPA)
        */
        'hideDeclineAll' => [false],
        /*
         * Setting 'hideLearnMore' to 'true' will hide the "learn more / customize" link in
         * the consent notice. We strongly advise against using this under most
         * circumstances, as it keeps the user from customizing his/her consent choices.
        */
        'hideLearnMore' => [false],















        'selectField' => [
            'inputType' => 'select',
            'exclude' => true,
            'search' => true,
            'filter' => true,
            'sorting' => true,
            'reference' => $GLOBALS['TL_LANG']['tl_klaro_config'],
            'options' => ['firstoption', 'secondoption'],
            //'foreignKey'            => 'tl_user.name',
            //'options_callback'      => array('CLASS', 'METHOD'),
            'eval' => ['includeBlankOption' => true, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''",
            //'relation'  => array('type' => 'hasOne', 'load' => 'lazy')
        ],
        'checkboxField' => [
            'inputType' => 'select',
            'exclude' => true,
            'search' => true,
            'filter' => true,
            'sorting' => true,
            'reference' => $GLOBALS['TL_LANG']['tl_klaro_config'],
            'options' => ['firstoption', 'secondoption'],
            //'foreignKey'            => 'tl_user.name',
            //'options_callback'      => array('CLASS', 'METHOD'),
            'eval' => ['includeBlankOption' => true, 'chosen' => true, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''",
            //'relation'  => array('type' => 'hasOne', 'load' => 'lazy')
        ],
        'multitextField' => [
            'inputType' => 'text',
            'exclude' => true,
            'search' => true,
            'filter' => true,
            'sorting' => true,
            'eval' => ['multiple' => true, 'size' => 4, 'decodeEntities' => true, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''",
        ],
        'addSubpalette' => [
            'exclude' => true,
            'inputType' => 'checkbox',
            'eval' => ['submitOnChange' => true, 'tl_class' => 'w50 clr'],
            'sql' => "char(1) NOT NULL default ''",
        ],
        'textareaField' => [
            'inputType' => 'textarea',
            'exclude' => true,
            'search' => true,
            'filter' => true,
            'sorting' => true,
            'eval' => ['rte' => 'tinyMCE', 'tl_class' => 'clr'],
            'sql' => 'text NULL',
        ],
    ],
];
