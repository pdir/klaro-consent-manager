
document.addEventListener('DOMContentLoaded', function(event) {

    let ctrl_ccDescription = document.getElementById('ctrl_ccDescription');
    if (ctrl_ccDescription) {
        let ccmQuestion = document.getElementById('ccmQuestion');
        ccmQuestion.innerText = ctrl_ccDescription.value.length === 0 ? '?' : ctrl_ccDescription.value;
        ctrl_ccDescription.addEventListener('keyup', function () {
            ccmQuestion.innerText = ctrl_ccDescription.value.length === 0 ? '?' : ctrl_ccDescription.value;
        });
    }

    let ctrl_ccAcceptOnce = document.getElementById('ctrl_ccAcceptOnce');
    if (ctrl_ccAcceptOnce) {
        let ccmButtonOnce = document.getElementById('ccmButtonOnce');
        ccmButtonOnce.innerText = ctrl_ccAcceptOnce.value.length === 0 ? '?' : ctrl_ccAcceptOnce.value;
        ctrl_ccAcceptOnce.addEventListener('keyup', function () {
            ccmButtonOnce.innerText = ctrl_ccAcceptOnce.value.length === 0 ? '?' : ctrl_ccAcceptOnce.value;
        });
    }

    let ctrl_ccAcceptAlways = document.getElementById('ctrl_ccAcceptAlways');
    if (ctrl_ccAcceptAlways) {
        let ccmButtonAlways = document.getElementById('ccmButtonAlways');
        ccmButtonAlways.innerText = ctrl_ccAcceptAlways.value.length === 0 ? '?' : ctrl_ccAcceptAlways.value;
        ctrl_ccAcceptAlways.addEventListener('keyup', function () {
            ccmButtonAlways.innerText = ctrl_ccAcceptAlways.value.length === 0 ? '?' : ctrl_ccAcceptAlways.value;
        });
    }
})
