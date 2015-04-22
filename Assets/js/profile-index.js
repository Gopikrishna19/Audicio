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
        .when('/portfolio', {
            templateUrl: '/Assets/partials/profile/portfolio.php'
        })
        .otherwise({
            redirectTo: '/news'
        });
});

app.controller('HeadCtrl', function ($scope, $location) {
    $scope.menu = ['news', 'blog', 'portfolio', 'profile'];
    $scope.isMin = true;
    $scope.isActive = function (route) {
        return '/' + route == $location.path();
    }
    $scope.updateMin = function (route) {
        $scope.isMin = (route != "profile");
    }
})