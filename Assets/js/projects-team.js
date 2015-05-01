/// <reference path='angular.js' />
/// <reference path='common.js' />

var app = angular.module('audicio', ['ngRoute']);

app.directive('heading', talentHeading);

app.config(function ($routeProvider) {
    $routeProvider
        .when('/home', {
            templateUrl: '/Assets/partials/projects-team/home.php',
        })
        .when('/tasks', {
            templateUrl: '/Assets/partials/projects-team/tasks.php',
        })
        .when('/settings', {
            templateUrl: '/Assets/partials/projects-team/settings.php',
        })
        .when('/auditions', {
            templateUrl: '/Assets/partials/projects-team/auditions.php',
        })
        .otherwise({
            redirectTo: '/home'
        });
});

app.controller('HeadCtrl', function ($scope, $location) {
    $scope.isShowable = function (link) { return (link == 'home' && $location.path() != '/home'); }

    $scope.menu = ['auditions', 'settings', 'tasks'];
    $scope.isActive = function (route) {
        console.log('/' + route == $location.path());
        return '/' + route == $location.path();
    }
});