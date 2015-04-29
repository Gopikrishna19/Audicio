/// <reference path='angular.js' />
/// <reference path='categories.js' />

var app = angular.module('audicio', ['ngRoute']);
app.directive('heading', function () {
    return {
        link: function (scope, element, attrs) {
            element.addClass('title');
            element.html("<span>" + attrs.heading + "</span>");
        }
    }
});

app.directive('step', function ($compile) {
    return {
        link: function (scope, element, attrs) {
            element.html("<span class='sep'/><span class='content'>" + attrs.step + "</span>");
        }
    }
});

app.directive('item', function () {
    return {
        link: function (scope, element, attrs) {
            element.addClass('item');
            element.bind('click', function () {
                element.toggleClass('mark');
            });
        }
    }
});

app.value('categories', talentCategories());

app.controller('MarkCtrl', function ($scope, categories) {
    $scope.categories = categories;
})

app.config(function ($routeProvider) {
    $routeProvider
        .when('/intro', {
            templateUrl: '/Assets/partials/profile-config/intro.php'
        })
        .when('/profile', {
            templateUrl: '/Assets/partials/profile-config/profile.php'
        })
        .when('/media', {
            templateUrl: '/Assets/partials/profile-config/media.php'
        })
        .when('/talents', {
            templateUrl: '/Assets/partials/profile-config/talents.php',
            controller: 'MarkCtrl'
        })
        .otherwise({
            redirectTo: '/intro'
        })
});

app.controller('MainCtrl', function ($scope, $location) {
    $scope.steps = ['intro', 'profile', 'talents', 'media'];
    $scope.index = 0;

    $scope.btnNext = "Next";
    $scope.last = false;

    $scope.next = function () {
        var i = $scope.index + 1;
        if (i < $scope.steps.length) {
            $scope.index += 1;
            $location.path($scope.steps[$scope.index]);
        } else {
            window.location.href = '/profile';
        }
    }

    $scope.onPage = function (loc) {
        if ('/' + loc == $location.path()) {
            $scope.index = $scope.steps.indexOf(loc);
            if ($scope.index == $scope.steps.length - 1) {
                $scope.btnNext = "Finish";
                $scope.last = true;
            } else {
                $scope.btnNext = "Next";
                $scope.last = false;
            }
            return true;
        }
        return false;
    }
});