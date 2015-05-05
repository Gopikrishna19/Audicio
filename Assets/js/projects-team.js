/// <reference path='angular.js' />
/// <reference path='common.js' />
/// <reference path='jquery.js' />
/// <reference path='moment.js' />

var app = angular.module('audicio', ['ngRoute']);

app.directive('breadHeading', breadCrumbHeading);

app.directive('heading', talentHeading);

app.directive('task', function () {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            var ng = angular; ng.ele = ng.element;
            var c = ng.ele('<div class="controls"></div>'),
                del = ng.ele('<button class="delete" />'),
                edt = ng.ele('<button class="edit" />'),
                m = ng.ele('<div class="check"></div>'),
                d = ng.ele('<div class="date">' + attrs.date + '</div>'),
                t = ng.ele('<div class="content">' + attrs.task + '</div>');
            c.append(del, edt);
            m.bind('click', function () { scope.toggleDone(attrs.key); });
            edt.bind('click', function () { scope.editTask(attrs.key); });
            del.bind('click', function () { scope.deleteTask(attrs.key); });
            element.addClass('task');
            if (attrs.done != undefined) element.addClass('done');
            else t.append(attrs.person.toLowerCase() == "anyone" ? "" : '<span class="person">' + attrs.person + '</span>');
            element.append(c, m, d, t);
        }
    }
});

app.filter('done', function () {
    return function (e, f) {
        var m = e.slice(1), a = [], f = f == undefined ? false : f;
        for (i in m) if (m[i].done == f) a.push(m[i]);
        return a;
    }
})

app.config(function ($routeProvider) {
    $routeProvider
        .when('/home', {
            templateUrl: '/Assets/partials/projects-team/home.php'
        })
        .when('/tasks', {
            templateUrl: '/Assets/partials/projects-team/tasks.php',
            controller: 'TaskCtrl'
        })
        .when('/settings', {
            templateUrl: '/Assets/partials/projects-team/settings.php'
        })
        .when('/auditions', {
            templateUrl: '/Assets/partials/projects-team/auditions.php'
        })
        .when('/auditions/new', {
            templateUrl: '/Assets/partials/projects-team/create-audition.php'
        })
        .when('/auditions/invite', {
            templateUrl: '/Assets/partials/projects-team/invite-person.php'
        })
        .otherwise({
            redirectTo: '/home'
        });
});

app.controller('HeadCtrl', function ($scope, $location) {
    $scope.isShowable = function (link) { return (link == 'home' && $location.path() != '/home'); }

    $scope.menu = ['auditions', 'tasks', 'settings'];
    $scope.isActive = function (route) {
        return '/' + route == $location.path();
    }
});

app.controller('TaskCtrl', function ($scope) {
    $scope.toggleShort = function (e) {
        (function (p) {
            p.toggleClass('short');
            $('.task-input', p).focus();
            $('.btn.d', p).html('Create');
            $scope.nTask = "";
            $scope.nPerson = "";
        })($(e.target).parent());
        if ($scope.editId) { $scope.tasks[findTaskById($scope.editId)].done = false; delete $scope.editId; }
    }

    $scope.createTask = function (e) {
        if ($scope.nTask.trim() == "") return;
        if ($scope.nPerson.trim() == "") $scope.nPerson = "Anyone";
        var task = {}, t = $scope.tasks;
        task.date = moment().format('LL');
        task.done = false;
        task.task = $scope.nTask;
        task.person = $scope.nPerson;

        if ($scope.editId) {
            var ut = $scope.tasks[findTaskById($scope.editId)];            
            ut.task = task.task;
            ut.person = task.person;
        } else {
            task.id = ++$scope.tasks[0].count;
            t.unshift(task); // prepend;
            t[0] = t.splice(1, 1, t[0])[0]; // swap 1st with count
        }
        $scope.nTask = "";
        $scope.nPerson = "";
        $scope.toggleShort(e);
        // call server
    }

    function findTaskById(id) {
        for (var t = $scope.tasks, i = 0 ; i < t.length; ++i) if (t[i].id == id) return i;
    }

    $scope.toggleDone = function (id) {
        var i = findTaskById(id);
        $scope.tasks[i].done = !$scope.tasks[i].done;
        $scope.$apply();
    }

    $scope.deleteTask = function (id) {
        var i = findTaskById(id);
        $scope.tasks.splice(i, 1);
        $scope.$apply();
    }

    $scope.editTask = function (id) {
        var t = $scope.tasks, i = findTaskById(id);
        t[i].done = -1;
        $scope.editId = id;
        $scope.nTask = t[i].task;
        $scope.nPerson = t[i].person;
        var p = $(".create .fields");
        p.removeClass('short');
        $('.task-input', p).focus();
        $(".btn.d", p).html("Update");
        $scope.$apply();
    }

    $scope.tasks = [
        { count: 3 },
        { id: 1, done: false, date: 'Apr 12, 2012', task: "You are welcome to do this task", person: "Member 1" },
        { id: 2, done: false, date: 'Apr 12, 2012', task: "You are also welcome to do this task. But beware this is very long long task. It takes lots of time to complete", person: "Anyone" },
        { id: 3, done: true, date: 'Apr 12, 2012', task: "This tasks is completed", person: "Member 2" }
    ];
});