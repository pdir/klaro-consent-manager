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
        'default' => '{title_legend},title;'.
            '{services_legend},services;'.
            '{script_legend},scriptLoadingMode,myConfigVariableName;'.
            '{consent_legend},noticeAsModal,mustConsent,default,acceptAll,hideDeclineAll,hideLearnMore,hideModal;'.
            '{cookie_legend},elementID,storageName,storageMethod,cookieDomain,cookieExpiresAfterDays;'.
            '{callback_legend},callback;'.
            '{expert_legend},htmlTexts,testing;',
    ],
    // Subpalettes
    'subpalettes' => [],
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
            'eval' => ['mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w75'],
            'sql' => "varchar(255) NOT NULL default ''",
        ],
        'scriptLoadingMode' => [
            'inputType' => 'select',
            'exclude' => true,
            'search' => false,
            'filter' => false,
            'sorting' => false,
            'reference' => &$GLOBALS['TL_LANG']['klaro']['config']['loading_mode_options'],
            'options' => &$GLOBALS['TL_LANG']['klaro']['config']['loading_mode_options'], // https://heyklaro.com/docs/integration/overview
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
            'eval' => ['tl_class' => 'w20 clr'],
            'sql' => [
                'type' => 'string',
                'length' => 50,
                'fixed' => true,
                'default' => 'klaro',
            ],
        ],
        'storageName' => [
            'exclude' => true,
            'inputType' => 'text',
            'eval' => ['tl_class' => 'w20'],
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
            'reference' => &$GLOBALS['TL_LANG']['klaro']['config']['storage_method_options'],
            'options' => &$GLOBALS['TL_LANG']['klaro']['config']['storage_method_options'],
            'eval' => ['tl_class' => 'w20'],
            'sql' => [
                'type' => 'string',
                'length' => 50,
                'fixed' => true,
                'default' => 'cookie',
            ],
        ],
        'cookieDomain' => [
            'exclude' => true,
            'inputType' => 'text',
            'eval' => ['tl_class' => 'w20'],
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
            'eval' => ['tl_class' => 'w20'],
            'sql' => [
                'type' => 'integer',
                'unsigned' => false,
                'notnull' => true,
                'default' => 30,
                'comment' => '',
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
        'noticeAsModal' => [
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
        'hideModal' => [
            'exclude' => true,
            'inputType' => 'pageTree',
            'foreignKey' => 'tl_page.title',
            'eval' => ['fieldType' => 'checkbox', 'tl_class' => 'clr', 'multiple' => true],
            'sql' => 'blob NULL',
        ],
        'services' => [
            'exclude' => true,
            'explanation' => 'klaro_services',
            'inputType' => 'checkboxWizard',
            'foreignKey' => 'tl_klaro_service.title',
            'relation' => ['type' => 'hasMany', 'load' => 'lazy'],
            'eval' => ['multiple' => true, 'helpwizard' => false],
            'sql' => [
                'type' => 'text',
                'length' => 2048,
                'fixed' => true,
                'notnull' => false,
            ],
        ],

        'callback' => [
            'exclude' => true,
            'inputType' => 'textarea',
            'eval' => ['style' => 'height:120px', 'preserveTags' => true, 'class' => 'monospace', 'rte' => 'ace|html', 'tl_class' => 'clr'],
            'sql' => [
                'type' => 'text',
                'length' => 4096,
                'fixed' => true,
                'notnull' => false,
            ],
        ],
    ],
];
