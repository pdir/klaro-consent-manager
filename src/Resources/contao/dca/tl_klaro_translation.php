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

$strTable = 'tl_klaro_translation';
/*
 * Table tl_klaro_service
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
        '__selector__' => [],
        'default' => '{title_legend},title;'.
            '{translation_legend},lang_code,privacyPolicyUrl;'.
            '{consent_notice_legend},consentNotice;'.
            '{consent_modal_legend},consentModal;'.
            '{purposes_legend},purposes;'.
            '{services_legend},services;'.
            '{contextual_consent_legend},ccAcceptAlways,ccAcceptOnce,ccDescription;',
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
        /* Klaro Translation Attributes */

        'lang_code' => [
            'exclude' => true,
            'inputType' => 'text',
            'eval' => ['mandatory' => true, 'tl_class' => 'w25'],
            'sql' => [
                'type' => 'string',
                'length' => 10,
                'fixed' => true,
                'default' => '',
            ],
        ],
        /*
         * You can specify a language-specific link to your privacy policy here.
         */
        'privacyPolicyUrl' => [
            'exclude' => true,
            'inputType' => 'pageTree',
            'foreignKey' => 'tl_page.title',
            'eval' => ['fieldType' => 'radio', 'tl_class' => 'clr', 'multiple' => false],
            'sql' => 'blob NULL',
        ],

        'consentNotice' => [
            'exclude' => true,
            'inputType' => 'text',
            'eval' => [
                'mandatory' => false,
                'decodeEntities' => true,
                'maxlength' => 4096,
                'tl_class' => '',
                'rte' => 'tinyMCE',
            ],
            'sql' => [
                'type' => 'string',
                'length' => 4096,
                'fixed' => false,
                'default' => '',
            ],
        ],

        'consentModal' => [
            'exclude' => true,
            'inputType' => 'text',
            'eval' => [
                'mandatory' => false,
                'decodeEntities' => true,
                'maxlength' => 4096,
                'tl_class' => '',
                'rte' => 'tinyMCE',
            ],
            'sql' => [
                'type' => 'text',
                'length' => 4096,
                'fixed' => true,
                'notnull' => false,
            ],
        ],

        'purposes' => [
            'exclude' => true,
            'inputType' => 'keyValueWizard',
            'eval' => [
                'allowHtml' => false,
                'tl_class' => 'w50',
            ],
            'sql' => 'blob NULL',
        ],

        'services' => [
            'exclude' => true,
            'inputType' => 'keyValueWizard',
            'eval' => [
                'allowHtml' => false,
                'tl_class' => 'w50',
            ],
            'sql' => 'blob NULL',
        ],

        // some undocumented srings to customize the translations of the contextualConsent messages
        'ccAcceptAlways' => [
            'exclude' => true,
            'inputType' => 'text',
            'eval' => ['mandatory' => false, 'tl_class' => 'w25'],
            'sql' => [
                'type' => 'string',
                'length' => 30,
                'fixed' => true,
                'default' => '',
            ],
        ],

        'ccAcceptOnce' => [
            'exclude' => true,
            'inputType' => 'text',
            'eval' => ['mandatory' => false, 'tl_class' => 'w25'],
            'sql' => [
                'type' => 'string',
                'length' => 30,
                'fixed' => true,
                'default' => '',
            ],
        ],

        'ccDescription' => [
            'exclude' => true,
            'inputType' => 'text',
            'eval' => ['mandatory' => false, 'tl_class' => 'w50'],
            'sql' => [
                'type' => 'text',
                'length' => 1024,
                'fixed' => true,
                'notnull' => false,
            ],
        ],
    ],
];
