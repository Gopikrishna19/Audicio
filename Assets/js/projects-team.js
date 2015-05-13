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
                d = ng.ele('<div class="date">' + moment(attrs.date).format("LL") + '</div>'),
                t = ng.ele('<div class="content">' + attrs.task + '</div>');
            c.append(del, edt);
            m.bind('click', function () { scope.toggleDone(attrs.key); });
            edt.bind('click', function () { scope.editTask(attrs.key); });
            del.bind('click', function () { scope.deleteTask(attrs.key); });
            element.addClass('task');
            if (attrs.done != undefined) element.addClass('done');
            else t.append(attrs.person == "" ? "" : '<span class="person">' + attrs.person + '</span>');
            element.append(c, m, d, t);
        }
    }
});

app.filter('done', function () {
    return function (m, f) {
        var a = [], f = f == undefined ? false : f;
        for (i in m) if (m[i].done == f) a.push(m[i]);
        return a;
    }
})

app.filter('status', function () {
    return function (m, f) {
        var a = [], f = f == undefined ? 1 : f;
        for (i in m) if (m[i].status == f) a.push(m[i]);
        return a;
    }
})

var getSecTeamInfo = function ($http, sec) {
    sec = sec == undefined ? true : sec;
    if (sec && typeof a_project_owner == "undefined") return null;
    else return $http.get('/projects/getTeamInfo/' + a_team_id);
}

app.config(function ($routeProvider) {
    $routeProvider
        .when('/home', {
            templateUrl: '/Assets/partials/projects-team/home.php',
            controller: 'HomeCtrl',
            resolve: { team: function ($http) { return getSecTeamInfo($http, false); } }
        })
        .when('/tasks', {
            templateUrl: '/Assets/partials/projects-team/tasks.php',
            controller: 'TaskCtrl',
            resolve: {
                members: function ($http) {
                    return $http.get('/projects/getTeamMembers/' + a_team_id);
                },
                tasks: function ($http) {
                    return $http.get('/projects/getTeamTasks/' + a_team_id);
                },
                team: function ($http) { return getSecTeamInfo($http, false); }
            }
        })
        .when('/settings', {
            templateUrl: '/Assets/partials/projects-team/settings.php',
            controller: 'SettingsCtrl',
            resolve: {
                team: function ($http) { return getSecTeamInfo($http); },
                categories: function ($http) {
                    return $http.get('/projects/getCategories');
                }
            }
        })
        .when('/auditions', {
            templateUrl: '/Assets/partials/projects-team/auditions.php',
            controller: 'AudiCtrl',
            resolve: {
                team: function ($http) { return getSecTeamInfo($http); },
                auditions: function ($http) {
                    return $http.get('/projects/getAuditions/' + a_team_id);
                },
                invites: function ($http) {
                    return $http.get('/projects/getInvites/' + a_team_id);
                }
            }
        })
        .when('/audition/:id', {
            templateUrl: '/Assets/partials/projects-team/audition.php',
            controller: 'CandiCtrl',
            resolve: {
                team: function ($http) { return getSecTeamInfo($http); },
                audition: function ($http, $route) {
                    return $http.get('/projects/getAudition/' + $route.current.params.id);
                }
            }
        })
        .when('/auditions/new', {
            templateUrl: '/Assets/partials/projects-team/create-audition.php',
            controller: 'AudiNewCtrl',
            resolve: { team: function ($http) { return getSecTeamInfo($http); } }
        })
        .when('/audition/edit/:id', {
            templateUrl: '/Assets/partials/projects-team/create-audition.php',
            controller: 'AudiEditCtrl',
            resolve: {
                team: function ($http) { return getSecTeamInfo($http); },
                audition: function ($http, $route) {
                    return $http.get('/projects/getAudition/' + $route.current.params.id);
                }
            }
        })
        .when('/auditions/invite', {
            templateUrl: '/Assets/partials/projects-team/invite-person.php',
            controller: 'AudiInviteCtrl',
            resolve: { team: function ($http) { return getSecTeamInfo($http); } }
        })
        .otherwise({
            redirectTo: '/home'
        });
});

function closeAudition($http, id, s) {
    if (confirm("Are you sure you want close the audition? " + // id +
        "\n  This will reject the candidates who are not invited to join the team" +
        "\n  And invited candidates may still be able to join the team")) {
        $http.get('/projects/closeAudition/' + id).success(s);
    }
}

app.controller('AudiInviteCtrl', function ($scope, $http, team) {
    $scope.team = team.data;
    $scope.uninvited = [];
    $scope.key = "";
    $scope.getUninvited = function () {
        if ($scope.key.length > 2) {
            $http.get('/projects/getUninvited/' + a_team_id + "?key=" + $scope.key)
                .success(function (e) {
                    $scope.uninvited = e;
                });
        }
    }
    $scope.invite = function (id) {
        var i = findUserById(id);
        $http.get('/projects/inviteCandidate/' + id + '/' + a_team_id)
            .success(function (e) {
                $scope.uninvited.splice(i, 1);
            });
    }

    function findUserById(id) {
        for (var t = $scope.uninvited, i = 0 ; i < t.length; ++i) if (t[i].id == id) return i;
    }
})

app.controller('CandiCtrl', function ($scope, $http, $location, team, audition) {
    if (typeof a_project_owner == "undefined") { $location.path('/').replace(); return; }
    $scope.audition = audition.data;
    $scope.candidates = audition.data.candidates;
    $scope.team = team.data

    function findCandidateById(id) {
        for (var t = $scope.candidates, i = 0 ; i < t.length; ++i) if (t[i].id == id) return i;
    }

    $scope.updateAll = function (s, n) {
        var t = deepCopy($scope.candidates);
        for (var i = 0 ; i < t.length; ++i) $scope.update(t[i].id, s, n);
    }

    $scope.update = function (id, s, n) {
        var i = findCandidateById(id);
        var c = $scope.candidates[i];
        if (c.status == n)
            $http.post('/projects/updateCandidate', { candidate: id, status: s, team: $scope.team.id, user: c.userid })
                .success(function (e) {
                    if (s == 0 || s == 3) $scope.candidates.splice(i, 1);
                    else c.status = s;
                });
    }

    $scope.close = function (id) {
        closeAudition($http, id, function (e) {
            $location.path('/auditions').replace()
        });
    };
});

app.controller('AudiEditCtrl', function ($scope, $http, $location, team, audition) {
    if (typeof a_project_owner == "undefined") { $location.path('/').replace(); return; }
    $scope.team = team.data;
    $scope.audition = (function (a) {
        a.scheduleo = moment(a.schedule)._d;
        delete a.candidates;
        return a;
    })(audition.data);
    $scope.title = "Edit Audition: " + audition.data.title;
    $scope.button = "Update";
    $scope.create = function () {
        var audi = $scope.audition;
        if (audi.title == undefined || audi.title.trim() == "") return;
        if (audi.scheduleo == undefined || audi.scheduleo == "") return;
        if (audi.location == undefined || audi.location.trim() == "") return;
        if (audi.desc == undefined || audi.desc.trim() == "") return;

        audi.teamid = a_team_id;

        audi.schedule = moment(audi.scheduleo).format("YYYY-MM-DD HH:mm:ss");
        delete audi.scheduleo;

        $http.post('/projects/updateAudition', audi)
            .success(function (e) {
                $location.path("/auditions").replace()
            })
    }
});

app.controller('AudiNewCtrl', function ($scope, $http, $location, team) {
    if (typeof a_project_owner == "undefined") { $location.path('/').replace(); return; }
    $scope.team = team.data;
    $scope.title = "Create New Audition";
    $scope.button = "Open";
    $scope.audition = {};
    $scope.create = function () {
        var audi = $scope.audition;
        if (audi.title == undefined || audi.title.trim() == "") return;
        if (audi.scheduleo == undefined || audi.scheduleo == "") return;        
        if (audi.location == undefined || audi.location.trim() == "") return;
        if (audi.desc == undefined || audi.desc.trim() == "") return;

        audi.teamid = a_team_id;
        audi.createdate = moment().format("YYYY-MM-DD");

        audi.schedule = moment(audi.scheduleo).format("YYYY-MM-DD HH:mm:ss");
        delete audi.scheduleo;

        $http.post('/projects/createAudition', audi)
            .success(function (e) {
                $location.path("/auditions").replace()
            })
    }
});

app.controller('AudiCtrl', function ($scope, $http, $location, team, auditions, invites) {
    if (typeof a_project_owner == "undefined") { $location.path('/').replace(); return; }
    $scope.team = team.data;
    $scope.auditions = auditions.data;
    $scope.close = function (id) {
        closeAudition($http, id, function (e) {
            $scope.auditions.splice(findInvitationById(id), 1);
        });
    };
    $scope.invites = invites.data;
    $scope.delete = function (id) {
        $http.get('/projects/deleteInvite/' + id)
            .success(function (e) {
                $scope.invites.splice(findInvitationById(id), 1);
            });
    }

    function findInvitationById(id) {
        for (var t = $scope.invites, i = 0 ; i < t.length; ++i) if (t[i].id == id) return i;
    }
});

app.controller('HeadCtrl', function ($scope, $location) {
    $scope.isShowable = function (link) { return (link == 'home' && $location.path() != '/home'); }

    $scope.menu = ['auditions', 'tasks', 'settings'];
    if (typeof a_project_owner == "undefined") {
        $scope.menu.splice($scope.menu.indexOf('settings'), 1);
        $scope.menu.splice($scope.menu.indexOf('auditions'), 1);
    }
    $scope.isActive = function (route) {
        return '/' + route == $location.path();
    }
});

app.controller('SettingsCtrl', function ($scope, $http, $location, team, categories) {
    if (typeof a_project_owner == "undefined") { $location.path('/').replace(); return; }
    $scope.team = team.data;
    $scope.projectName = a_project_name;
    $scope.original = deepCopy(team.data)
    $scope.categories = categories.data;
    $(".create .block .field select").val($scope.team.catid);

    $scope.reset = function () { $scope.team = deepCopy($scope.original); }
    $scope.update = function () {
        $http.post('/projects/updateTeam/', $scope.team)
            .success(function (e) {
                // console.log(e);
                window.location.reload();
            });
    }
    $scope.delete = function () {
        if (confirm("Are you sure you want to delete the team? \nThis operation is irreversible!")) {
            $http.get('/projects/deleteTeam/' + a_team_id)
                .success(function (e) {
                    window.location.reload();
                });
        }
    }
    $scope.deleteMember = function ($event, $id) {
        if (confirm("Are you sure you want to delete the member?")) {
            $http.get('/projects/deleteMember/' + a_team_id + "/" + $id)
            .success(function (e) {
                angular.element($event.target).parent().remove();
            });
        }
    }
})

app.controller('HomeCtrl', function ($scope, team) {
    $scope.projectName = a_project_name;
    $scope.projectId = a_project_id;
    $scope.team = team.data;
});

app.controller('TaskCtrl', function ($scope, $http, team, members, tasks) {
    $scope.members = members.data;
    $scope.team = team.data;
    $scope.tasks = (function (ts) {
        for (i in ts) {
            t = ts[i];
            t.done = t.finishdate != null;
            t.person = findMemberName(t.assignid);
        }
        return ts;
    })(tasks.data)

    function findMemberName(id) {
        if (id == "") return "";
        for (i in $scope.members) if ($scope.members[i].id == id)
            return $scope.members[i].fname + " " + $scope.members[i].lname;
    }

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
        if ($scope.nPerson.trim() == "") $scope.nPerson = "";
        var task = {}, t = $scope.tasks;

        task.task = $scope.nTask;
        task.teamid = a_team_id;
        task.assignid = $scope.nPerson == "" ? null : $scope.nPerson;
        task.createid = a_user_id;
        task.createdate = moment().format('YYYY-MM-DD');
        task.finishdate = null;
        task.done = false;
        task.person = findMemberName(task.assignid);

        if ($scope.editId) {
            console.log(task);
            var ut = $scope.tasks[findTaskById($scope.editId)];
            ut.task = task.task;
            ut.person = task.person;
            ut.assignid = task.assignid;
            $http.post('/projects/updateTask', { id: ut.id, task: ut.task, assignid: ut.assignid });
        } else {
            t.unshift(task); // prepend;

            $http.post('/projects/createTask', task)
                .success(function (e) {
                    task.id = e.trim();
                })
        }
        $scope.nTask = "";
        $scope.nPerson = "";
        $scope.toggleShort(e);
    }

    function findTaskById(id) {
        for (var t = $scope.tasks, i = 0 ; i < t.length; ++i) if (t[i].id == id) return i;
    }

    $scope.toggleDone = function (id) {
        var i = findTaskById(id);
        var ut = $scope.tasks[i];
        ut.done = !ut.done;
        if (ut.finishdate == null) ut.finishdate = moment().format("YYYY-MM-DD");
        else ut.finishdate = null;
        $http.post('/projects/updateTask', { id: ut.id, finishdate: ut.finishdate });
        $scope.$apply();
    }

    $scope.deleteTask = function (id) {
        var i = findTaskById(id);
        $http.get('/projects/deleteTask/' + id)
            .success(function (e) {
                $scope.tasks.splice(i, 1);
                $scope.$apply();
            });
    }

    $scope.editTask = function (id) {
        var t = $scope.tasks, i = findTaskById(id);
        if ($scope.editId) {
            var e = findTaskById($scope.editId);
            t[e].done = false;
        }
        t[i].done = -1;
        $scope.editId = id;
        $scope.nTask = t[i].task;
        $scope.nPerson = t[i].assignid == null ? "" : t[i].assignid;

        var p = $(".create .fields");
        p.removeClass('short');
        $('.task-input', p).focus();
        $(".btn.d", p).html("Update");
        $scope.$apply();
    }

    // { id: 1, done: false, date: 'Apr 12, 2012', task: "You are welcome to do this task", person: "Member 1" },
});