window.fbAsyncInit = function () {
    FB.init({
        appId: '1417698314990838',
        cookie: true,
        xfbml: true,
        oauth: true,
        version: 'v2.8'
    });
    FB.AppEvents.logPageView();

    $('.fb-login-button').change(function () {
        alert('woo');
    });
    FB.getLoginStatus(function (response) {
        if (response.status === 'connected') {
            $("#invitation").hide();
            $("#hint").hide();
            $("#form").show();
            var accessToken = response.authResponse.accessToken;
        }
        if (response.status === 'unknown') {
            $("#invitation").show();
            $("#hint").show();
            $("#form").hide();
        }
    });
};

(function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {
        return;
    }
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

