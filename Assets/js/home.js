$(function () {
    $(".link.reg").click(function () {
        $("form").addClass("alt");
        setTimeout(function () {
            $(".login").css({ "z-index": "0" });
            $(".register").css({ "z-index": "1" });
            $(".register .email").focus();
        }, 300);
    });
    $(".link.log").click(function () {
        $("form").removeClass("alt");
        setTimeout(function () {
            $(".register").css({ "z-index": "0" });
            $(".login").css({ "z-index": "1" });
            $(".login .uname").focus();
        }, 300);
    });
    $("form").submit(false);
    initAPIs();
});

var lGoogle = {
    clientid: '993932107238-22c457mg8i3i9acfupf4fa9kc7dqiu7t.apps.googleusercontent.com',
    scopes: 'https://www.googleapis.com/auth/plus.login email',
    checkAuth: function () {
        console.log('In CheckAuth');
        gapi.auth.authorize({ client_id: lGoogle.clientid, scope: lGoogle.scopes, immediate: true }, lGoogle.handleAuthResult);
    },
    handleAuthResult: function (result) {
        console.log('In handle');
        if (result && !result.error) {
            lGoogle.getUserInfo();
        } else {
            $(".lbtn.gp").click(lGoogle.handleClick);
        }
    },
    handleClick: function () {
        gapi.auth.authorize({ client_id: lGoogle.clientid, scope: lGoogle.scopes, immediate: false }, lGoogle.handleAuthResult);
    },
    getUserInfo: function () {
        console.log('In UserInfo');
        gapi.client.load('plus', 'v1').then(function () {
            var request = gapi.client.plus.people.get({ 'userId': 'me' });
            request.then(function (resp) {
                redirect(resp.result.emails[0].value);
            }, function (reason) {
                console.log('Error: ', reason.result.error.message);
            });
        });
    },
    init: function () {
        window.__g_callback = function () { lGoogle.checkAuth(); };
        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//apis.google.com/js/client:platform.js?onload=__g_callback";
            fjs.parentNode.insertBefore(js, fjs);
        } (document, 'script', 'gapi-js'));
    }
};

var lFacebook = {
    clientid: '863440873728460',
    scopes: 'email',
    checkAuth: function () {
        console.log('In CheckAuth');
        FB.getLoginStatus(lFacebook.handleAuthResult);
    },
    handleAuthResult: function (result) {
        console.log('In handle');
        if (result && result.status == 'connected') {
            lFacebook.getUserInfo();
        } else {
            $(".lbtn.fb").click(lFacebook.handleClick);
        }
    },
    handleClick: function () {
        FB.login(lFacebook.handleAuthResult, { scope: lFacebook.scopes });
    },
    getUserInfo: function () {
        console.log('In UserInfo');
        FB.api('/me', function (resp) {
            redirect(resp.email);
        })
    },
    init: function () {
        window.fbAsyncInit = function () {
            FB.init({
                appId: lFacebook.clientid,
                cookie: true,
                xfbml: true,
                version: 'v2.2'
            });
            lFacebook.checkAuth();
        };
        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        } (document, 'script', 'fapi-js'));
    }
};

function initAPIs() {
    lGoogle.init();
    lFacebook.init();
}

function redirect(email) {
    window.location.href = '/profile';
}