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

namespace Pdir\ContaoKlaroConsentManager\EventListener;

use Contao\CoreBundle\ServiceAnnotation\Hook;

/**
 * @Hook("replaceInsertTags")
 */
class KlaroButtonInsertTagListener
{
    public const TAG = 'klaro';

    public function __invoke(string $tag)
    {
        $chunks = explode('::', $tag);

        if (self::TAG !== $chunks[0]) {
            return false;
        }

        return sprintf('<a class="%s" onclick="return klaro.show();">%s</a>',
            $chunks[2] ?? 'button is-success',
            $chunks[1] ?? $GLOBALS['TL_LANG']['MSC']['klaroConsentDefaultButtonText']
        );
    }
}
