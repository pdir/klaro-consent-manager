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


let m = klaro.getManager();
console.log('manager geladen: ', m);

let c = m.defaultConsents;
console.log('default consents geladen: ', c);

/**
 * returns true, if all services are accepted, otherwise false
 *
 * @returns {boolean}
 */
function consentAll() {
    for (let prop in c) {
        if (Object.prototype.hasOwnProperty.call(c, prop)) {
            if(!m.getConsent(prop)) return false;
        }
    }
    return true;
}

console.log('consentAll: ', consentAll());

console.log('getConsent(matomo): ',m.getConsent('matomo'));
