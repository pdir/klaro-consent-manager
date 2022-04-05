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

$strTable = 'tl_klaro_config';
/*
 * Table tl_klaro_config
 */
$GLOBALS['TL_DCA'][$strTable] = [
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
                'label' => &$GLOBALS['TL_LANG'][$strTable]['edit'],
                'href' => 'act=edit',
                'icon' => 'edit.svg',
            ],
            'copy' => [
                'label' => &$GLOBALS['TL_LANG'][$strTable]['copy'],
                'href' => 'act=copy',
                'icon' => 'copy.svg',
            ],
            'delete' => [
                'label' => &$GLOBALS['TL_LANG'][$strTable]['delete'],
                'href' => 'act=delete',
                'icon' => 'delete.svg',
                'attributes' => 'onclick="if(!confirm(\''.$GLOBALS['TL_LANG']['MSC']['deleteConfirm'].'\'))return false;Backend.getScrollOffset()"',
            ],
            'show' => [
                'label' => &$GLOBALS['TL_LANG'][$strTable]['show'],
                'href' => 'act=show',
                'icon' => 'show.svg',
                'attributes' => 'style="margin-right:3px"',
            ],
        ],
    ],
    // Palettes
    'palettes' => [
        '__selector__' => ['addSubpalette'],
        'default' => '{first_legend},title;'.
            '{pages_legend},scope;'.
            '{services_legend},services;'.
            '{script_legend},scriptLoadingMode,myConfigVariableName;'.
            '{consent_legend},default,mustConsent,acceptAll,hideDeclineAll,hideLearnMore;'.
            '{cookie_legend},elementID,storageName,storageMethod,cookieDomain,cookieExpiresAfterDays;'.
            '{expert_legend},htmlTexts,testing;',
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
        'scope' => [
            'exclude' => true,
            'inputType' => 'pageTree',
            'eval' => ['fieldType' => 'checkbox', 'tl_class' => 'clr', 'multiple' => true],
            'sql' => 'blob NULL',
        ],
        'services' => [
            'exclude' => true,
            'inputType' => 'checkboxWizard',
            'eval' => ['multiple' => true, 'helpwizard' => true],
            //'reference' => &$GLOBALS['TL_LANG'][$strTable],
            'sql' => [
                'type' => 'text',
                'length' => 2048,
                'fixed' => true,
                'notnull' => false,
            ],
        ],
        'scriptLoadingMode' => [
            'inputType' => 'select',
            'exclude' => true,
            'search' => false,
            'filter' => false,
            'sorting' => false,
            'reference' => $GLOBALS['TL_LANG'][$strTable]['loading_mode_options'],
            'options' => ['', 'async', 'defer'], // https://heyklaro.com/docs/integration/overview
            'eval' => ['tl_class' => 'w25'],
            'sql' => [
                'type' => 'string',
                'length' => 50,
                'fixed' => true,
                'default' => 'defer',
            ],
        ],
        'myConfigVariableName' => [
            'exclude' => true,
            'inputType' => 'text',
            'eval' => ['tl_class' => 'w25'],
            'sql' => [
                'type' => 'string',
                'length' => 50,
                'fixed' => true,
                'default' => 'klaroConfig',
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
            'reference' => $GLOBALS['TL_LANG'][$strTable]['storage_method_options'],
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
        'cookieExpiresAfterDays' => [
            'exclude' => true,
            'inputType' => 'text',
            'eval' => ['tl_class' => 'w125'],
            'sql' => [
                'type' => 'integer',
                'unsigned' => false,
                'notnull' => true,
                'default' => 30,
                'comment' => '',
            ],
        ],
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
        'mustConsent' => [
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
        'acceptAll' => [
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
        'hideDeclineAll' => [
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
        'hideLearnMore' => [
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
    ],
];
