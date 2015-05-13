/// <reference path='angular.js' />
/// <reference path='jquery.js' />
/// <reference path='common.js' />

var app = angular.module('audicio', ['ngRoute']);

app.directive('breadHeading', breadCrumbHeading);

app.directive('heading', talentHeading);

app.config(function ($routeProvider) {
    $routeProvider
        .when('/list', {
            templateUrl: '/Assets/partials/projects/list.php',
            controller: 'ListCtrl',
            resolve: {
                created: function ($http) {
                    return $http.get('/projects/getCreated/' + a_user_id);
                },
                joined: function ($http) {
                    return $http.get('/projects/getJoined/' + a_user_id);
                }
            }
        })
        .when('/create', {
            templateUrl: '/Assets/partials/projects/create.php',
            controller: 'CreateCtrl'
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

app.controller('ListCtrl', function ($scope, created, joined) {
    var c = created.data, j = joined.data;
    $scope.created = c || [];
    $scope.joined = j || [];
})

app.controller('CreateCtrl', function ($scope, $http, $location) {
    $scope.create = function () {
        if (!$scope.title) return;
        if ($scope.title.trim() == "") return;
        $http.post('/projects/createProject', { user: a_user_id, title: $scope.title, desc: $scope.desc || "" })
            .success(function (e) {
                console.log(e);
                $location.path('/').replace();
            })
    }
})