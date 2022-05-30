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

use Contao\CoreBundle\DataContainer\PaletteManipulator;

/*
 * define here the content elements for which a binding to Klaro
 * should be possible. note that for each element further code
 * must be provided in the hooks
 */
$arrAllowedCTEs = ['headline', 'text'];

foreach (array_keys($GLOBALS['TL_DCA']['tl_content']['palettes']) as $palette) {
    if (in_array($palette, $arrAllowedCTEs, true)) {
        PaletteManipulator::create()
            ->addLegend('klaro_legend', ['template_legend','template_legend:hide'], PaletteManipulator::POSITION_BEFORE)
            ->addField('klaro_state', 'klaro_legend', PaletteManipulator::POSITION_APPEND)
            ->addField('klaro_consent', 'klaro_legend', PaletteManipulator::POSITION_APPEND)
            ->addField('klaro_service', 'klaro_legend', PaletteManipulator::POSITION_APPEND)
            ->applyToPalette($palette, 'tl_content')
        ;
    }
}

$GLOBALS['TL_DCA']['tl_content']['fields']['klaro_service'] = [
    'exclude' => true,
    'search' => true,
    'inputType' => 'select',
    'eval' => ['includeBlankOption' => true, 'tl_class' => 'clr w50'],
    'relation' => ['type' => 'hasOne', 'load' => 'lazy', 'table' => 'tl_klaro_service'],
    'sql' => [
        'type' => 'integer',
        'unsigned' => false,
        'default' => 0,
        'comment' => '',
    ],
];

$GLOBALS['TL_DCA']['tl_content']['fields']['klaro_consent'] = [
    'exclude' => true,
    'search' => true,
    'inputType' => 'select',
    'options' => $GLOBALS['TL_LANG']['klaro']['klaro_consent']['options'],
    'eval' => ['maxlength' => 200, 'tl_class' => 'w25'],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['klaro_state'] = [
    'exclude' => true,
    'search' => true,
    'inputType' => 'select',
    'options' => $GLOBALS['TL_LANG']['klaro']['klaro_state']['options'],
    'eval' => ['tl_class' => 'w25'],
    'sql' => "varchar(20) NOT NULL default ''",
];

