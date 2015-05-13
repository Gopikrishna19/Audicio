/// <reference path='angular.js' />
/// <reference path='jquery.js' />
/// <reference path='common.js' />

var app = angular.module('audicio', ['ngRoute']);

app.directive('heading', talentHeading);

app.directive('step', function ($compile) {
    return {
        link: function (scope, element, attrs) {
            element.html("<span class='sep'/><span class='content'>" + attrs.step + "</span>");
        }
    }
});

app.directive('item', function ($http) {
    return {
        link: function (scope, element, attrs) {
            element.addClass('item');
            element.bind('click', function () {
                element.toggleClass('mark');
                if (element.hasClass('mark')) {
                    $http.get('/profile/addTalent/' + a_user_id + "/" + attrs.id);
                } else {
                    $http.get('/profile/removeTalent/' + a_user_id + "/" + attrs.id);
                }
            });
        }
    }
});

app.config(function ($routeProvider) {
    $routeProvider
        .when('/intro', {
            templateUrl: '/Assets/partials/profile-config/intro.php'
        })
        .when('/profile', {
            templateUrl: '/Assets/partials/profile-config/profile.php',
            controller: 'ProfileCtrl'
        })
        .when('/media', {
            templateUrl: '/Assets/partials/profile-config/media.php'
        })
        .when('/talents', {
            templateUrl: '/Assets/partials/profile-config/talents.php',
            controller: 'MarkCtrl',
            resolve: {
                categories: function ($http) {
                    return $http.get('/profile/talents');
                }
            }
        })
        .otherwise({
            redirectTo: '/intro'
        })
});

app.controller('MarkCtrl', function ($scope, categories) {
    $scope.categories = categories.data;
});

function showWait() { $(".wait-overlay").addClass("on"); }
function hideWait() { $(".wait-overlay").removeClass("on"); }

app.controller('ProfileCtrl', function ($scope, $rootScope) {
    var photo = $(".block .photo");
    var photoPick = $(".profile-pic", photo);
    photoPick.change(function (e) {
        var file = e.target.files[0];
        var fr = new FileReader();
        fr.onload = function (e) {
            photo.css({ "background-image": "url(" + e.target.result + ")" });
        }
        fr.readAsDataURL(file);
    })
    $rootScope.onNext(function (i, cb) {
        if (i != 1) return;

        var steps = [false, false];
        var stepsFunc = function () {
            for (var i = 0; i < steps.length; ++i) if (!steps[i]) return;
            finalFunc();
        }
        var finalFunc = function () { console.log("saved profile"); if (cb) cb(); }

        // step 0
        var file = photoPick[0].files.length > 0 ? photoPick[0].files[0] : null;
        if (file) {
            showWait();
            var ext = file.name.split(".").slice(-1);
            uploadFile(file, 'image-1' + ext, function (p) {
                if (p >= 100) {
                    steps[0] = true;
                    stepsFunc();
                    console.log('uploaded');
                    hideWait();
                }
            });
        } else {
            steps[0] = true;
            stepsFunc();
        }

        // step 1
        var perr = [false, false, false, false];
        var form = $(".container.profile");
        var fname = $(".fname", form), lname = $(".lname", form), dob = $(".dob", form),
            desc = $(".desc", form), upass = $(".upass", form), cpass = $(".cpass", form);
        var errb = $(".block.error", form);

        if (fname.val().trim() == "") {
            perr[0] = true;
            $(".fn", errb).addClass("on");
        } else {
            perr[0] = false;
            $(".fn", errb).removeClass("on");
        }

        if (lname.val().trim() == "") {
            perr[1] = true;
            $(".ln", errb).addClass("on");
        } else {
            perr[1] = false;
            $(".ln", errb).removeClass("on");
        }

        if (dob.val().trim() == "") {
            perr[2] = true;
            $(".db", errb).addClass("on");
        } else {
            perr[2] = false;
            $(".db", errb).removeClass("on");
        }

        if (upass.val().trim() != "" || cpass.val().trim() != "") {
            var up = upass.val(), cp = cpass.val();
            if (up.length > 6) {
                $(".sp", errb).removeClass("on");
                if (/(?=\S*?[A-Za-z])(?=\S*?[0-9])\S{6,}/.test(up)) {
                    $(".ip", errb).removeClass("on");
                    if (cp == up) {
                        $(".cp", errb).removeClass("on");
                        perr[3] = false;
                    } else {
                        perr[3] = true;
                        $(".cp", errb).addClass("on");
                    }
                } else {
                    perr[3] = true;
                    $(".ip", errb).addClass("on");
                }
            } else {
                perr[3] = true;
                $(".sp", errb).addClass("on");
            }
        } else {
            perr[3] = false;
            $(".sp", errb).removeClass("on");
            $(".ip", errb).removeClass("on");
            $(".cp", errb).removeClass("on");
        }

        for (var i = 0, f = false; i < perr.length; ++i) if (perr[i]) f = true;
        if (!f) {
            $.ajax({
                url: "/profile/update",
                method: "post",
                data: {
                    fname: fname.val(),
                    lname: lname.val(),
                    dob: dob.val(),
                    desc: desc.val(),
                    upass: upass.val(),
                    id: a_user_id
                },
                success: function (e) {
                    steps[1] = true;
                    stepsFunc();
                    console.log("success");
                }
            })
        }
    })
});

app.controller('HeadCtrl', function ($scope, $location, $rootScope) {
    $scope.steps = ['intro', 'profile', 'talents', 'media'];
    $scope.index = 0;

    $scope.btnNext = "Next";
    $scope.last = false;

    var save = null;
    $rootScope.onNext = function (e) { save = e; };

    var nextStep = function () {
        var i = $scope.index + 1;
        if (i < $scope.steps.length) {
            $scope.index += 1;
            $location.path($scope.steps[$scope.index]).replace();
            $scope.$apply();
        } else {
            window.location.href = '/profile';
        }
    }

    $scope.next = function () {
        switch ($scope.index) {
            case 1:
                if (save) save($scope.index, function () {
                    nextStep();
                });
                break;
            case 3:
                $.ajax({
                    url: '/profile/setInit/' + a_user_id,
                    success: function () {
                        nextStep();
                    }
                });
                break;
            default: nextStep();
        }
    }

    $scope.skip = nextStep;

    $scope.onPage = function (loc) {
        if ($location.path() == "/media") window.Media.init();
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