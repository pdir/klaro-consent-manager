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

document.addEventListener('DOMContentLoaded', function(event) {

    let ctrl_ccDescription = document.getElementById('ctrl_ccDescription');
    if (ctrl_ccDescription) {
        let ccmQuestion = document.getElementById('ccmQuestion');
        ccmQuestion.innerText = ctrl_ccDescription.value.length === 0 ? '?' : ctrl_ccDescription.value;
        ctrl_ccDescription.addEventListener('keydown', function () {
            ccmQuestion.innerText = ctrl_ccDescription.value.length === 0 ? '?' : ctrl_ccDescription.value;
        });
    }

    let ctrl_ccAcceptOnce = document.getElementById('ctrl_ccAcceptOnce');
    if (ctrl_ccAcceptOnce) {
        let ccmButtonOnce = document.getElementById('ccmButtonOnce');
        ccmButtonOnce.innerText = ctrl_ccAcceptOnce.value.length === 0 ? '?' : ctrl_ccAcceptOnce.value;
        ctrl_ccAcceptOnce.addEventListener('keydown', function () {
            ccmButtonOnce.innerText = ctrl_ccAcceptOnce.value.length === 0 ? '?' : ctrl_ccAcceptOnce.value;
        });
    }

    let ctrl_ccAcceptAlways = document.getElementById('ctrl_ccAcceptAlways');
    if (ctrl_ccAcceptAlways) {
        let ccmButtonAlways = document.getElementById('ccmButtonAlways');
        ccmButtonAlways.innerText = ctrl_ccAcceptAlways.value.length === 0 ? '?' : ctrl_ccAcceptAlways.value;
        ctrl_ccAcceptAlways.addEventListener('keydown', function () {
            ccmButtonAlways.innerText = ctrl_ccAcceptAlways.value.length === 0 ? '?' : ctrl_ccAcceptAlways.value;
        });
    }
})
