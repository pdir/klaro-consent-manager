<?php

declare(strict_types=1);

/*
 * Klaro Consent Manager bundle for Contao Open Source CMS
 *
 * Copyright (c) 2023 pdir / digital agentur // pdir GmbH
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

use Contao\System;
use Pdir\ContaoKlaroConsentManager\Model\KlaroConfigModel;
use Pdir\ContaoKlaroConsentManager\Model\KlaroPurposeModel;
use Pdir\ContaoKlaroConsentManager\Model\KlaroServiceModel;
use Pdir\ContaoKlaroConsentManager\Model\KlaroTranslationModel;
use Symfony\Component\HttpFoundation\Request;

/*
 * Backend modules
 */
$GLOBALS['BE_MOD']['pdir']['klaro_config'] = [
    'tables' => ['tl_klaro_config'],
];
$GLOBALS['BE_MOD']['pdir']['klaro_service'] = [
    'tables' => ['tl_klaro_service'],
];
$GLOBALS['BE_MOD']['pdir']['klaro_translation'] = [
    'tables' => ['tl_klaro_translation'],
    'stylesheet' => [
        'bundles/pdircontaoklaroconsentmanager/css/klaro.css',
    ],
    'javascript' => [
        'bundles/pdircontaoklaroconsentmanager/js/be.js',
    ],
];
$GLOBALS['BE_MOD']['pdir']['klaro_purpose'] = [
    'tables' => ['tl_klaro_purpose'],
];

$scopeMatcher = System::getContainer()->get('contao.routing.scope_matcher');
$currentRequest = System::getContainer()->get('request_stack')->getCurrentRequest() ?? Request::create('');

if ($scopeMatcher->isBackendRequest($currentRequest)) {
    // only BE
    $GLOBALS['TL_CSS'][] = 'bundles/pdircontaoklaroconsentmanager/css/be.css|static';
}

if ($scopeMatcher->isFrontendRequest($currentRequest)) {
{
    $GLOBALS['TL_CSS'][] = 'bundles/pdircontaoklaroconsentmanager/css/fe.scss|static';
}

/*
 * Models
 */
$GLOBALS['TL_MODELS']['tl_klaro_config'] = KlaroConfigModel::class;
$GLOBALS['TL_MODELS']['tl_klaro_service'] = KlaroServiceModel::class;
$GLOBALS['TL_MODELS']['tl_klaro_translation'] = KlaroTranslationModel::class;
$GLOBALS['TL_MODELS']['tl_klaro_purpose'] = KlaroPurposeModel::class;
