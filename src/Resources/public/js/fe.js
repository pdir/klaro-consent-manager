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
function agreedAll()
{
    for (let prop in c) if (Object.prototype.hasOwnProperty.call(c, prop)) if(!m.getConsent(prop)) return false;
    return true;
}

/**
 *
 * @returns {boolean}
 */
function rejectedAll()
{
    for (let prop in c) if (Object.prototype.hasOwnProperty.call(c, prop)) if(m.getConsent(prop)) return false;
    return true;
}

/**
 * handle servicesall
 */
if(agreedAll())
{
    document.querySelectorAll('[data-namep=servicesall-agreed-show]').forEach(
        el => {
            el.style.display = "block";
        });
}

/**
 *
 */
if(rejectedAll())
{
    document.querySelectorAll('[data-namep=servicesall-rejected-show]').forEach(
        el => {
            el.style.display = "block";
        });
}

document.querySelectorAll('[data-namep$=agreed-show]:not([data-namep^=servicesall])').forEach(
    el => {
        service = el.dataset.namep.substring(0, el.dataset.namep.length - 'agreed-show'.length - 1);
        if(m.getConsent(service)) {
            el.style.display = 'block';
        }  else {
            el.style.display = 'none';
        }
    }
)

console.log('agreedAll: ', agreedAll());

console.log('rejectdedAll: ', rejectedAll());
