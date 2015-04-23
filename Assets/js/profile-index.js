/// <reference path='angular.js' />

var app = angular.module('audicio', ['ngRoute']);

app.config(function ($routeProvider) {
    $routeProvider
        .when('/news', {
            templateUrl: '/Assets/partials/profile/news.php'
        })
        .when('/auditions', {
            templateUrl: '/Assets/partials/profile/auditions.php'
        })
        .when('/profile', {
            templateUrl: '/Assets/partials/profile/profile.php'
        })
        .when('/projects', {
            templateUrl: '/Assets/partials/profile/projects.php'
        })
        .otherwise({
            redirectTo: '/news'
        });
});

app.controller('HeadCtrl', function ($scope, $location) {
    $scope.menu = ['news', 'auditions', 'projects', 'profile'];
    $scope.isMin = "/profile" != $location.path();    
    $scope.isActive = function (route) {
        return '/' + route == $location.path();
    }
    $scope.updateMin = function (route) {
        $scope.isMin = (route != "profile");
    }
})