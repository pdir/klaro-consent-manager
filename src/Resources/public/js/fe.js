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

/**
 *  get a ConsentManager instance
 */
let m = klaro.getManager();

/**
 * get the default static! consent configuration - note! in most cases the
 * static configuration will differ from the current consent configuration
 * in the client storage!
 */
let c = m.defaultConsents;

/**
 * returns true, if all services are accepted, otherwise false
 *
 * @returns {boolean}
 */
function consentAll()
{
    for (let prop in c) if (Object.prototype.hasOwnProperty.call(c, prop)) if(!m.getConsent(prop)) return false;

    return true;
}

/**
 * handle servicesall
 */
if(consentAll())
{
    document.querySelectorAll('[data-namep=servicesall-hide]').forEach(el => { el.dataset.namep = "servicesall-accept-show"; });
}
