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
            //controller: 'CreateCtrl'
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
    $scope.isShowable = function (link) {
        if (link == 'home' && $location.path() != '/home') return true;
        else if (link == 'set' && $location.path() != '/settings') return true;
        else return false;
    }
});