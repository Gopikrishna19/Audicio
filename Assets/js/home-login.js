/// <reference path="jquery.js" />

$(function () {
    var right = $(".block .right"), status = $(".status", right);
    $("button", right).click(function () {
        var e = getEmail();
        $.ajax({
            url: '/home/sendVerifyMail/' + e,
            beforeSend: function () {
                status.html("Sending ...");
            },
            success: function (e) {
                status.html(e);
            },
            error: function () {
                status.html("Error.");
            }
        })
    })
})