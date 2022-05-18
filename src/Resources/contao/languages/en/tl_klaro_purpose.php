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

$sgl = 'purpose';
//$pl = 'Dienste';
$klaro = 'Klaro';

$GLOBALS['TL_LANG']['tl_klaro_purpose'] = [
    // title legend
    'title_legend' => 'Name',
    'title' => ["Name of the $sgl", "Enter a name for this $sgl."],
    // purpose legend
    'purpose_legend' => 'Purpose',
    'klaro_key' => ["$klaro purpose-key", "Enter here the string that $klaro uses internally as a unified key for this purpose."],
];
