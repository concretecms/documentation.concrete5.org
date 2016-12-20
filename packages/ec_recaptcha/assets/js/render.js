function ecRecaptcha() {
    var els = document.getElementsByClassName("ecRecaptcha");
    for (var i = 0; i < els.length; i++) {
        var el = els[i];
        grecaptcha.render(el.getAttribute('id'), {
            'sitekey': el.getAttribute('data-sitekey'),
            'theme': el.getAttribute('data-theme')
        });
    }
}