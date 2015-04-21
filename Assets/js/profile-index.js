/// <reference path='angular.js' />

var app = angular.module('audicio', ['ngRoute']);

app.config(function ($routeProvider) {
    $routeProvider
        .when('/news', {
            templateUrl: '/Assets/partials/profile/news.php'
        })
        .when('/blog', {
            templateUrl: '/Assets/partials/profile/blog.php'
        })
        .when('/profile', {
            templateUrl: '/Assets/partials/profile/profile.php'
        })
        .otherwise({
            redirectTo: '/news'
        });
});