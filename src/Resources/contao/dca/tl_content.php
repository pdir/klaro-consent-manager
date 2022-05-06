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

foreach ($GLOBALS['TL_DCA']['tl_content']['palettes'] as $palette) {
    if ('__selector__' !== $palette) {
        PaletteManipulator::create()
            ->addField('klaro_state', 'type', PaletteManipulator::POSITION_AFTER)
            ->addField('klaro_consent', 'type', PaletteManipulator::POSITION_AFTER)
            ->addField('klaro_service', 'type', PaletteManipulator::POSITION_AFTER)
            ->applyToPalette($palette, 'tl_content')
        ;
    }
}

$GLOBALS['TL_DCA']['tl_content']['fields']['klaro_service'] = [
    'exclude' => true,
    'search' => true,
    'inputType' => 'select',
    'options' => ['none' => 'nicht verknüpfen', 's1' => 'Dienst 1', 's2_true' => 'Dienst 2'],
    'eval' => ['tl_class' => 'clr w50'],
    'sql' => "varchar(20) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['klaro_consent'] = [
    'exclude' => true,
    'search' => true,
    'inputType' => 'select',
    'options' => ['' => 'zugestimmt', '1' => 'abgelehnt'],
    'eval' => ['maxlength' => 200, 'tl_class' => 'w25'],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['klaro_state'] = [
    'exclude' => true,
    'search' => true,
    'inputType' => 'select',
    'options' => ['1' => 'einblenden', '2' => 'ausblenden'],
    'eval' => ['tl_class' => 'w25'],
    'sql' => "varchar(20) NOT NULL default ''",
];
