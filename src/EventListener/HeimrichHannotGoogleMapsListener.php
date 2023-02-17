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

namespace Pdir\ContaoKlaroConsentManager\EventListener;

use Contao\CoreBundle\ServiceAnnotation\Hook;

class HeimrichHannotGoogleMapsListener
{
    /**
     * Adjust the generated map api. Priority -1 ensures it's called after the ReplaceDynamicScriptTagsListener
     * listener.
     *
     * @Hook("replaceDynamicScriptTags", priority=-1)
     */
    public function onReplaceDynamicScriptTags(string $buffer): string
    {
        if (!isset($GLOBALS['TL_BODY']['huhGoogleMaps'])) {
            return $buffer;
        }

        // replace ivory_google_map_init_source -> need to adjust service callback -> see docs
        preg_match('!ivory_google_map_init_source\(([^\)]+)\);!', $GLOBALS['TL_BODY']['huhGoogleMaps'], $match);
        if(isset($match[1])) {
            $GLOBALS['TL_BODY']['huhGoogleMaps'] = str_replace('script type="text/javascript"', "script type=\"text/javascript\" data-gmap-callback=$match[1]", $GLOBALS['TL_BODY']['huhGoogleMaps']);
        }
        $GLOBALS['TL_BODY']['huhGoogleMaps'] = str_replace($match[0], '', $GLOBALS['TL_BODY']['huhGoogleMaps']);

        return $buffer;
    }
}
