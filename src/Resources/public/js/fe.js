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
 *
 */
function handleService(consent, state)
{
    let key = `${consent}-${state}`;
    document.querySelectorAll(`[data-namep$=${key}]:not([data-namep^=servicesall])`).forEach(
        el => {
            let service = el.dataset.namep.substring(0, el.dataset.namep.length - key.length - 1),
                c = m.getConsent(service),
                condition = (state === 'show' ? c : !c),
                condition2 = (consent === 'agreed' ? condition : !condition);
            el.style.display = condition2 ? 'block' : 'none';
        }
    )
}

/**
 * define a watcher object see: https://heyklaro.com/docs/api/js_api
 *
 * @type {{update: watcher1.update}}
 */
watcher1 = {
    update: function(obj, name, consents) {}
}

/*  register the watcher */
m.watch(watcher1);

/**
 handle servicesall show on agreed
 */
if(agreedAll())
{
    document
        .querySelectorAll('[data-namep=servicesall-agreed-show]')
            .forEach(el => { el.style.display = "block"; });
}

/**
 * handle servicesall show on rejected
 */
if(rejectedAll())
{
    document
        .querySelectorAll('[data-namep=servicesall-rejected-show]')
            .forEach(el => { el.style.display = "block"; });
}

/**
 * handle services
 */
handleService('agreed','show');
handleService('agreed','hide');
handleService('rejected','show');
handleService('rejected','hide');

