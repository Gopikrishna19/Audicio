/// <reference path="angular.js" />
/// <reference path="jquery.js" />

var app = angular.module('audicio', ['ngRoute', 'ngSanitize']);

app.factory('profile', function ($http) {
    return $http.get('/portfolio/getEverything/' + a_profile_id);
})

app.config(function ($routeProvider) {
    $routeProvider
        .when('/profile', {
            templateUrl: '/Assets/partials/portfolio/home.php',
            controller: 'HomeCtrl'
        })
        .when('/media', {
            templateUrl: '/Assets/partials/portfolio/media.php',
            controller: 'MediaCtrl'
        })
        .otherwise({
            redirectTo: '/profile'
        })
})

app.controller('HeadCtrl', function ($scope, $location, profile) {
    profile.success(function (e) { $scope.p = e; });
    $scope.hostName = a_host_name;
    $scope.menu = ['media', 'profile'];
    if (typeof a_user_id == "undefined") $scope.menu.splice(0, 1);
    $scope.isActive = function (route) { return '/' + route == $location.path(); }
    var img = new Image();
    var profileimg = "http://audicio-s3-bucket.s3.amazonaws.com/user" + a_profile_id + "/image/image-1.jpg";
    img.onload = function () {
        $(".header .content .img img")[0].src = profileimg;
    }
    img.src = profileimg;
    $scope.noLog = typeof a_user_id == "undefined";
})

app.controller('MediaCtrl', function ($scope, $location, $sce, profile) {
    if (typeof a_user_id == "undefined") { $location.path('/').replace(); return; }
    profile.success(function (e) { $scope.p = e; });

    $scope.trust = function (res) { return $sce.trustAsResourceUrl("http://audicio-s3-bucket.s3.amazonaws.com/user" + res); }
    $scope.getVideo = function (id) { return $scope.trust(a_profile_id + "/video/video" + id + ".mp4"); }
    $scope.getImage = function (id, ext) { return $scope.trust(a_profile_id + "/image/image" + id + "." + ext); }

    $scope.previewImage = function (e) {
        var a = $(".media .images .strip .image.on"), size = "100% auto";
        var image = $(e.target).closest(".image"), img = image.find("img")[0];
        a.removeClass("on");
        image.addClass('on');
        if ((img.height / img.height) < (750 / 360)) size = "auto 100%";
        console.log(img.src);
        $(".media .images .preview .img").css({ "background-image": "url(" + img.src + ")", "background-size": size });
    }

    $scope.previewVideo = function (e) {
        var a = $(".media .videos .strip .video.on");
        var video = $(e.target).closest(".video"), vid = video.find("video").clone();
        a.removeClass("on");
        video.addClass('on');
        vid.removeAttr('width');
        vid.attr('height', '360');
        vid.attr('controls', 'true');
        $(".media .videos .preview .img").html(vid);
    }
})

app.controller('HomeCtrl', function ($scope, $location, profile) {
    profile.success(function (e) { $scope.p = e; });
})