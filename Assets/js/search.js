/// <reference path="angular.js" />
/// <reference path="jquery.js" />

var app = angular.module('audicio', []);

app.controller('SearchCtrl', function ($scope, $http) {
    $scope.key = "";
    $scope.results = {};
    $scope.getResults = function () {
        console.log($scope.key);
        if ($scope.key.length > 2)
            $http.get('/search/getResults/' + $scope.key)
                .success(function (e) {
                    console.log(e)
                    $scope.results = e;
                })
    }
})