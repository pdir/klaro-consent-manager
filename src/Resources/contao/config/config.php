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

use Pdir\ContaoKlaroConsentManager\Model\KlaroConfigModel;
use Pdir\ContaoKlaroConsentManager\Model\KlaroPurposeModel;
use Pdir\ContaoKlaroConsentManager\Model\KlaroServiceModel;

/*
 * Backend modules
 */
$GLOBALS['BE_MOD']['pdir']['klaro_config'] = [
    'tables' => ['tl_klaro_config'],
    'stylesheet' => 'bundles/pdircontaoklaroconsentmanager/css/be.css',
];
$GLOBALS['BE_MOD']['pdir']['klaro_service'] = [
    'tables' => ['tl_klaro_service'],
    'stylesheet' => 'bundles/pdircontaoklaroconsentmanager/css/be.css',
];

/*
 * Models
 */
$GLOBALS['TL_MODELS']['tl_klaro_config'] = KlaroConfigModel::class;
$GLOBALS['TL_MODELS']['tl_klaro_service'] = KlaroServiceModel::class;
$GLOBALS['TL_MODELS']['tl_klaro_purpose'] = KlaroPurposeModel::class;
