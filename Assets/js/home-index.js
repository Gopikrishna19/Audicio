/// <reference path='jquery.js' />

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

    initAPIs();

    var formReg = $("form.register"), formLog = $("form.login");
    var rerr = [false, false, false], lerr = [false, false];

    var validateReg = function (e) {
        var self = $(this);
        var email = self.find("input.email").val();
        var upass = self.find("input.upass").val();
        var cpass = self.find("input.cpass").val();
        var rBtn = self.find("input.btn");

        // validate password
        if (upass.length < 6) {
            self.find(".error.upass").show().find(".msg").html("Must contain 6 characters or more");
            rerr[1] = true;
        } else if (!(/(?=\S*?[A-Za-z])(?=\S*?[0-9])\S{6,}/.test(upass))) {
            self.find(".error.upass").show().find(".msg").html("Must be alphanumeric");
            rerr[1] = true;
        } else {
            self.find(".error.upass").hide();
            rerr[1] = false;
        }

        // confirm password
        if (cpass != upass) {
            self.find(".error.cpass").show().find(".msg").html("Passwords do not match");
            rerr[2] = true;
        } else {
            self.find(".error.cpass").hide();
            rerr[2] = false;
        }

        // validate email
        if (!(/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,6}$/i.test(email))) {
            self.find(".error.email").show().find(".msg").html("Invalid Email");
            rerr[0] = true;
        } else if (email.trim() != "") {
            $.ajax({
                url: "/home/emailExists/" + btoa(email) + "/0",
                beforeSend: function () {
                    rBtn.addClass("wait").attr("disabled", "true");
                },
                success: function (e) {
                    if (e.trim() == "true") {
                        self.find(".error.email").show().find(".msg").html("Email Already Exists");
                        rerr[0] = true;
                    } else if (e.trim() == "false") {
                        self.find(".error.email").hide();
                        rerr[0] = false;
                    } else {
                        rerr[0] = true;
                        console.log(e);
                    }
                },
                error: function (e) {
                    rerr[0] = true;
                },
                complete: function () {
                    rBtn.removeClass("wait").removeAttr("disabled");
                    for (var i = 0; i < rerr.length; ++i) if (rerr[i]) return;
                    self.unbind('submit', validateReg).submit();
                }
            })
        } else self.find(".error.email").hide();

        e.preventDefault();
        return false;
    }

    var validateLog = function (e) {
        var self = $(this);
        var email = self.find("input.email").val();
        var upass = self.find("input.upass").val();
        var lBtn = self.find("input.btn");

        if (upass.trim() == "") {
            self.find(".error.upass").show().find(".msg").html("Password cannot be empty");
            lerr[1] = true;
        } else {
            self.find(".error.upass").hide();
            lerr[1] = false;
        }

        // validate email
        if (!(/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,6}$/i.test(email))) {
            self.find(".error.email").show().find(".msg").html("Invalid Email");
            lerr[0] = true;
        } else if (email.trim() != "") {
            $.ajax({
                url: "/home/emailExists/" + btoa(email) + "/1/" + btoa(upass),
                beforeSend: function () {
                    lBtn.addClass("wait").attr("disabled", "true");
                },
                success: function (e) {
                    if (e.trim() == "false") {
                        self.find(".error.email").show().find(".msg").html("Invalid Credentials");
                        self.find("input.upass").val("");
                        lerr[0] = true;
                    } else if(e.trim() == "true") {
                        self.find(".error.email").hide();
                        lerr[0] = false;
                    } else {
                        lerr[0] = true;
                        console.log(e);
                    }
                },
                error: function (e) {
                    lerr[0] = true;
                },
                complete: function () {
                    lBtn.removeClass("wait").removeAttr("disabled");
                    for (var i = 0; i < lerr.length; ++i) if (lerr[i]) return;
                    self.unbind('submit', validateLog).submit();
                }
            })
        } else self.find(".error.email").hide();

        e.preventDefault();
        return false;
    }

    formReg.submit(validateReg);

    formLog.submit(validateLog);
});

var lGoogle = {
    clientid: '993932107238-22c457mg8i3i9acfupf4fa9kc7dqiu7t.apps.googleusercontent.com',
    scopes: 'https://www.googleapis.com/auth/plus.login email',
    handleAuthResult: function (result) {
        if (result && !result.error) {
            lGoogle.getUserInfo();
        }
    },
    handleClick: function () {
        gapi.auth.authorize({ client_id: lGoogle.clientid, scope: lGoogle.scopes, immediate: false }, lGoogle.handleAuthResult);
    },
    getUserInfo: function () {
        gapi.client.load('plus', 'v1').then(function () {
            var request = gapi.client.plus.people.get({ 'userId': 'me' });
            request.then(function (resp) {
                redirect(resp.result.emails[0].value, "gp");
            }, function (reason) {
                console.log('Error: ', reason.result.error.message);
            });
        });
    },
    init: function () {
        window.__g_callback = function () { $(".lbtn.gp").click(lGoogle.handleClick); };
        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//apis.google.com/js/client:platform.js?onload=__g_callback";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'gapi-js'));
    }
};

var lFacebook = {
    clientid: '863440873728460',
    scopes: 'email',
    handleAuthResult: function (result) {
        if (result && result.status == 'connected') {
            lFacebook.getUserInfo();
        }
    },
    handleClick: function () {
        FB.login(lFacebook.handleAuthResult, { scope: lFacebook.scopes });
    },
    getUserInfo: function () {
        FB.api('/me', function (resp) {
            redirect(resp.email, "fb");
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
            $(".lbtn.fb").click(lFacebook.handleClick);
        };
        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'fapi-js'));
    }
};

function initAPIs() {
    lGoogle.init();
    lFacebook.init();
}

function redirect(email, method) {
    var form = document.createElement("form");
    form.method = 'post';
    form.action = '/home/login?m=' + method;

    var ipEmail = document.createElement("input");
    ipEmail.name = "email";
    ipEmail.value = email;

    form.appendChild(ipEmail);
    form.submit();
}