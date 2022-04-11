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
        'default' => '{first_legend},title;'.
            '{services_legend},services;'.
            '{script_legend},scriptLoadingMode,myConfigVariableName;'.
            '{consent_legend},noticeAsModal,default,mustConsent,acceptAll,hideDeclineAll,hideLearnMore,hideModal;'.
            '{cookie_legend},elementID,storageName,storageMethod,cookieDomain,cookieExpiresAfterDays;'.
            '{translations_legend},translations;'.
            '{expert_legend},htmlTexts,testing;',
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
            'reference' => &$GLOBALS['TL_LANG']['klaro']['config']['storage_method_options'],
            'options' => &$GLOBALS['TL_LANG']['klaro']['config']['storage_method_options'],
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
        'translations' => [
            'label' => &$GLOBALS['TL_LANG']['tl_my_table']['someField'],
            'inputType' => 'multiColumnEditor',
            'exclude' => true,
            'eval' => [
                'multiColumnEditor' => [
                    // set to true if the rows should be sortable (backend only atm)
                    'sortable' => true,
                    'class' => 'some-class',
                    // set to 0 if it should also be possible to have *no* row (default: 1)
                    'minRowCount' => 1,
                    // set to 0 if an infinite number of rows should be possible (default: 0)
                    'maxRowCount' => 0,
                    // defaults to false
                    'skipCopyValuesOnAdd' => false,

                    'editorTemplate' => 'multi_column_editor_backend_default',
                    // Optional: add palette and subpalette if you need supalettes support (otherwise all fields will be shows)
                    // Legends are supported since verison 2.8
                    'palettes' => [
                        '__selector__' => [],
                        'default' => 'langKey,privacyPolicyUrl,consentNotice,consentModal',
                    ],
                    'subpalettes' => [
                        //'field1' => 'field2', // key selector
                        //'field1_10' => 'field3', // key_value selector
                    ],
                    // place your fields here as you would normally in your DCA
                    'fields' => [
                        'langKey' => [
                            'label' => &$GLOBALS['TL_LANG'][$strTable]['translations']['langKey'],
                            'exclude' => true,
                            'filter' => true,
                            'inputType' => 'select',
                            'default' => str_replace('-', '_', $GLOBALS['TL_LANGUAGE']),
                            'eval' => ['rgxp' => 'locale', 'groupStyle' => 'width:210px'],
                            'options_callback' => static function () {
                                return array_merge(
                                    System::getLanguages(true),
                                    $GLOBALS['TL_LANG']['tl_klaro_config']['translations']['fallback']
                                );
                            },
                        ],
                        'privacyPolicyUrl' => [
                            'label' => &$GLOBALS['TL_LANG'][$strTable]['translations']['privacyPolicyUrl'],
                            'inputType' => 'pageTree',
                            'foreignKey' => 'tl_page.title',
                            'eval' => ['fieldType' => 'radio', 'tl_class' => '', 'multiple' => false],
                        ],
                        'consentNotice' => [
                            'label' => &$GLOBALS['TL_LANG'][$strTable]['translations']['consentNotice'],
                            'inputType' => 'text',
                            'eval' => ['groupStyle' => ''],
                        ],
                        'consentModal' => [
                            'label' => &$GLOBALS['TL_LANG'][$strTable]['translations']['consentModal'],
                            'inputType' => 'textarea',
                            'eval' => ['groupStyle' => ''],
                        ],
                    ],
                ],
            ],
            'sql' => 'blob NULL',
        ],
    ],
];
