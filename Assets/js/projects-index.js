/// <reference path='angular.js' />
/// <reference path='common.js' />

var app = angular.module('audicio', ['ngRoute']);

app.directive('heading', talentHeading);

app.config(function ($routeProvider) {
    $routeProvider
        .when('/list', {
            templateUrl: '/Assets/partials/projects/list.php',
            //controller: 'ListCtrl'
        })
        .when('/create', {
            templateUrl: '/Assets/partials/projects/create.php',
            //controller: 'CreateCtrl'
        })
        .otherwise({
            redirectTo: '/list'
        });
});

app.controller('HeadCtrl', function ($scope, $location) {
    $scope.isShowable = function (link) {
        if (link == 'all' && $location.path() != '/list') return true;
        else return false;
    }
});