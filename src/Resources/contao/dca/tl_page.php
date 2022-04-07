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

PaletteManipulator::create()
    ->addLegend('klaro_legend', 'layout_legend', PaletteManipulator::POSITION_AFTER)
    ->addField('includeKlaro', 'klaro_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('root', 'tl_page')
    ->applyToPalette('rootfallback', 'tl_page');

$GLOBALS['TL_DCA']['tl_page']['palettes']['__selector__'][] = 'includeKlaro';
$GLOBALS['TL_DCA']['tl_page']['subpalettes']['includeKlaro'] = 'klaroConfig,klaroExclude';

$GLOBALS['TL_DCA']['tl_page']['fields']['includeKlaro'] = [
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['submitOnChange' => true],
    'sql' => "char(1) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_page']['fields']['klaroConfig'] = [
    'exclude' => true,
    'search' => true,
    'inputType' => 'select',
    'foreignKey' => 'tl_klaro_config.title',
    'eval' => ['chosen' => true, 'tl_class' => 'w50', 'includeBlankOption' => true],
    'sql' => "int(10) unsigned NOT NULL default 0",
    'relation' => array('type' => 'hasOne', 'load' => 'lazy')
];

$GLOBALS['TL_DCA']['tl_page']['fields']['klaroExclude'] = [
    'exclude' => true,
    'inputType' => 'pageTree',
    'foreignKey' => 'tl_page.title',
    'eval' => ['fieldType' => 'checkbox', 'tl_class' => 'clr', 'multiple' => true],
    'sql' => 'blob NULL',
];
