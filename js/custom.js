document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".call-to-action-btn a").forEach(function (anchor) {
        anchor.addEventListener("click", function (event) {
            event.preventDefault();
            this.blur();
        });
    });

    var heroSectionButton = document.getElementById("hero-section-button");
    if (heroSectionButton) {
        heroSectionButton.addEventListener("click", function (event) {
            event.preventDefault();
            this.blur();
        });
    }

    var closeCookiesButton = document.getElementById('close-cookies');
    if (closeCookiesButton) {
        closeCookiesButton.addEventListener('click', function () {
            setCookie('cookieConsent', 'accepted', 30);
            document.getElementById('cookie-consent').style.display = 'none';
        });
    }

    checkCookieConsent();
});

function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

function checkCookieConsent() {
    var consent = getCookie('cookieConsent');
    console.log(consent);
    if (consent !== 'accepted') {
        document.getElementById('cookie-consent').style.display = 'flex';
    } else {
        document.getElementById('cookie-consent').style.display = 'none';
    }
}
