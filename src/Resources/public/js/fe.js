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

let isOnceCall = false;

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
 * returns true, if all services were rejected, otherwise false
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
    let nodes = document.querySelectorAll(`[data-namep$=${key}]:not([data-namep^=servicesall])`);
    nodes.forEach(
        el => {
            let service = el.dataset.namep.substring(0, el.dataset.namep.length - key.length - 1),
                c = m.getConsent(service),
                condition = (state === 'show' ? c : !c),
                condition2 = (consent === 'agreed' ? condition : !condition);
            el.style.display = condition2 ? 'block' : 'none';
        }
    )
}

function handleWatcherUpdate(consents) {
  // iterate over each service
  for (const [service, consent] of Object.entries(consents)) {
    let selectorToShow = `[data-namep=${service}-agreed-show], [data-namep=${service}-rejected-hide]`,
      selectorToHide = `[data-namep=${service}-agreed-hide], [data-namep=${service}-rejected-show]`,
      show = document.querySelectorAll(selectorToShow),
      hide = document.querySelectorAll(selectorToHide)
    ;
    show.forEach(el => { el.style.display = consent ? 'block' : 'none'; });
    hide.forEach(el => { el.style.display = consent ? 'none' : 'block'; });
  }
}

/**
 * define a watcher object see: https://heyklaro.com/docs/api/js_api
 *
 * @type {{update: watcher1.update}}
 */
let watcher1 = {
    /**
     *
     * @param obj a klaro consent object?
     * @param name 'consent' for a normal consent update or 'applyConsent' for a contextual consent update
     * @param consents an object of the current consent state after the watcher has been triggered, like
     * { 'service0' : bool, 'service1': bool, etc... }
     */
    update: function(obj, name, consents) {
      /**
       * this strange construct, handles changes through a contextualConsent object.
       * If consented to in a context, the update callback fires multiple times,
       * setting the status of the consent multiple times as well.
       */
      if(name==='applyConsents') {
        isOnceCall = true;
        handleWatcherUpdate(obj.executedOnce);
      } else {
        if(!isOnceCall) {
          handleWatcherUpdate(consents);
          isOnceCall = false;
        }
      }
    }
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
 * these functions were called once when loading the script
 */
handleService('agreed','show');
handleService('agreed','hide');
handleService('rejected','show');
handleService('rejected','hide');

