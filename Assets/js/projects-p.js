/// <reference path='angular.js' />
/// <reference path='common.js' />

var app = angular.module('audicio', ['ngRoute']);

app.directive('heading', talentHeading);

app.config(function ($routeProvider) {
    $routeProvider
        .when('/home', {
            templateUrl: '/Assets/partials/projects-p/home.php',
        })
        .when('/settings', {
            templateUrl: '/Assets/partials/projects-p/settings.php',
        })
        .when('/create', { redirectTo: '/create/name' })
        .when('/c/invite', { redirectTo: '/create/invite' })
        .when('/c/audition', { redirectTo: '/create/audition' })
        .when('/create/name', {
            templateUrl: '/Assets/partials/projects-p/create-1.php',
        })
        .when('/create/invite', {
            templateUrl: '/Assets/partials/projects-p/create-2.php',
        })
        .when('/create/audition', {
            templateUrl: '/Assets/partials/projects-p/create-3.php',
        })
        .otherwise({
            redirectTo: '/home'
        });
});

app.directive('stone', function () {
    return {
        restrict: 'E',
        link: function (scope, element, attr) {
            if (attr.state == null) attr.state = 'n';
            var div = angular.element('<div />');
            div.addClass('stone');
            div.addClass(attr.state);
            div.append(angular.element('<div class="date">' + attr.date + '</div>'));
            div.append(angular.element('<div class="name">' + attr.name + '</div>'));
            element.replaceWith(div);
            element = div;
        }
    }
})

app.controller('HeadCtrl', function ($scope, $location) {
    $scope.isShowable = function (link) { return (link == 'home' && $location.path() != '/home'); }

    $scope.menu = ['settings'];
    $scope.isActive = function (route) {
        console.log('/' + route == $location.path());
        return '/' + route == $location.path();
    }
});