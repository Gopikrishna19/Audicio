/// <reference path='angular.js' />
/// <reference path='common.js' />

var app = angular.module('audicio', ['ngRoute']);

app.directive('breadHeading', breadCrumbHeading);

app.directive('heading', talentHeading);

app.config(function ($routeProvider) {
    $routeProvider
        .when('/home', {
            templateUrl: '/Assets/partials/projects-p/home.php',
            controller: 'HomeCtrl',
            resolve: {
                teams: function ($http) {
                    return $http.get('/projects/getTeams/' + a_project_id);
                },
                milestones: function ($http) {
                    return $http.get('/projects/getMilestones/' + a_project_id);
                }
            }
        })
        .when('/settings', {
            templateUrl: '/Assets/partials/projects-p/settings.php',
            controller: 'SettingsCtrl',
            resolve: {
                project: function ($http) {
                    if (typeof a_project_owner == "undefined") return null;
                    else return $http.get('/projects/getProjectInfo/' + a_project_id);
                }
            }
        })
        .when('/create', { redirectTo: '/create/team' })
        .when('/create/team', {
            templateUrl: '/Assets/partials/projects-p/create-team.php',
            controller: 'CreateCtrl',
            resolve: {
                categories: function ($http) {
                    return $http.get('/projects/getCategories');
                }
            }
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
    if (typeof a_project_owner == "undefined")
        $scope.menu.splice($scope.menu.indexOf('settings'), 1);
    $scope.isActive = function (route) {
        return '/' + route == $location.path();
    }
});

app.controller('HomeCtrl', function ($scope, teams, milestones) {
    $scope.projectName = a_project_name;
    $scope.teams = teams.data;
    $scope.milestones = milestones.data;
})

app.controller('CreateCtrl', function ($scope, $http, $location, categories) {
    $scope.categories = categories.data;
    $scope.projectName = a_project_name;
    $scope.doCreate = function () {
        if (!$scope.name || !$scope.catid) return;
        if ($scope.name.trim() == "") return;
        $http.post('/projects/createTeam', {
            project: a_project_id,
            name: $scope.name,
            desc: $scope.desc || "",
            catid: $scope.catid
        }).success(function (e) {
            console.log(e);
            $location.path('/').replace();
        });
    }
});

app.controller('SettingsCtrl', function ($scope, $http, $location, project) {
    if (typeof a_project_owner == "undefined") { $location.path('/').replace(); return; }
    $scope.projectName = a_project_name;
    $scope.original = deepCopy(project.data)
    $scope.project = project.data;
    $scope.reset = function () { $scope.project = deepCopy($scope.original); }
    $scope.update = function () {
        $http.post('/projects/updateProject/', $scope.project)
            .success(function (e) {                
                $scope.original = deepCopy($scope.project);
                $scope.reset();
            });
    }
    $scope.delete = function () {
        if (confirm("Are you sure you want to delete the project? \nThis operation is irreversible!")) {
            $http.get('/projects/deleteProject/' + a_project_id)
                .success(function (e) {
                    window.location.reload();
                });
        }
    }
})