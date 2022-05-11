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

/*
 * Miscelaneous
 */
$GLOBALS['TL_LANG']['MSC']['klaroConsentDefaultButtonText'] = 'Zustimmungseinstellungen ändern';

/*
 * Errors
 */
//$GLOBALS['TL_LANG']['ERR'][''] = '';

/*
 * klaro options
 */
$GLOBALS['TL_LANG']['klaro'] = [
    'config' => [
        'loading_mode_options' => [
            '' => 'synchron',
            'defer' => 'verzögert (defer)',
            'async' => 'parallel (async)',
        ],
        'storage_method_options' => [
            'cookie' => 'Cookie Storage',
            'localStorage' => 'Browser Local Storage',
        ],
    ],
];
