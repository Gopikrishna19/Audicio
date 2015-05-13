/// <reference path='angular.js' />
/// <reference path='jquery.js' />
/// <reference path='common.js' />
/// <reference path='categories.js' />
/// <reference path="profile-index.js" />

var app = angular.module('audicio', ['ngRoute', 'ngSanitize']);

app.directive('heading', talentHeading);

app.config(function ($routeProvider) {
    $routeProvider
        .when('/news', {
            templateUrl: '/Assets/partials/profile/news.php',
            controller: 'NewsCtrl'
        })
        .when('/auditions', {
            templateUrl: '/Assets/partials/profile/auditions.php',
            controller: 'AudiCtrl',
            resolve: {
                auditions: function ($http) {
                    return $http.get('/profile/getAuditions/');
                }
            }
        })
        .when('/audition/:id', {
            templateUrl: '/Assets/partials/profile/audition.php',
            controller: 'ApplyCtrl',
            resolve: {
                audition: function ($http, $route) {
                    return $http.get('/profile/getAuditions/' + $route.current.params.id);
                }
            }
        })
        .when('/profile', {
            templateUrl: '/Assets/partials/profile/profile.php',
            controller: 'ProfileCtrl',
            resolve: {
                user: function ($http) {
                    return $http.get('/profile/userInfo');
                }
            }
        })
        .when('/profile/media', {
            templateUrl: '/Assets/partials/profile/profile-media.php',
            controller: 'MediaCtrl',
            resolve: {
                media: function ($http) {
                    return $http.get('/profile/getMedia/' + a_user_id);
                }
            }
        })
        .when('/profile/talents', {
            templateUrl: '/Assets/partials/profile/profile-talents.php',
            controller: 'ProfileTalentsCtrl',
            resolve: {
                talents: function ($http) {
                    return $http.get('/profile/talents');
                }
            }
        })
        .when('/profile/account', {
            templateUrl: '/Assets/partials/profile/profile-settings.php',
            controller: 'ProfileSettingsCtrl'
        })
        .when('/projects', {
            templateUrl: '/Assets/partials/profile/projects.php',
            controller: 'ProjectsCtrl',
            resolve: {
                created: function ($http) {
                    return $http.get('/projects/getCreated/' + a_user_id);
                },
                joined: function ($http) {
                    return $http.get('/projects/getJoined/' + a_user_id);
                }
            }
        })
        .otherwise({
            redirectTo: '/news'
        });
});

app.controller('ProfileSettingsCtrl', function ($scope, $http) {
    $scope.delete = function () {
        if (confirm("Are you sure you want delete your account? " +
            "\n Your personal files and details will be completely deleted" +
            "\n This process is irreverible !!")) {
            $http.get('/profile/deleteProfile/' + a_user_id)
                .success(function (e) {                    
                    window.location.href = "/home/logout";
                });
        }
    }
})

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

app.controller('MediaCtrl', function ($scope, $http, $sce, media) {
    window.Media.init();
    $scope.p = media.data;

    $scope.trust = function (res) { return $sce.trustAsResourceUrl("http://audicio-s3-bucket.s3.amazonaws.com/user" + res); }
    $scope.getVideo = function (id) { return $scope.trust(a_user_id + "/video/video" + id + ".mp4"); }
    $scope.getImage = function (id, ext) { return $scope.trust(a_user_id + "/image/image" + id + "." + ext); }

    function findMediaById(type, id) {
        for (var t = $scope.p[type], i = 0 ; i < t.length; ++i) if (t[i].id == id) return i;
    }

    $scope.toggleImage = function (id, visible) {
        event.stopPropagation();
        visible = visible == 1 ? 0 : 1;
        var i = findMediaById("images", id);
        $http.get('/profile/toggleMedia/image/' + id + "/" + visible)
            .success(function (e) { $scope.p.images[i].visible = visible; });
        return false;
    }

    $scope.toggleVideo = function (id, visible) {
        event.stopPropagation();
        visible = visible == 1 ? 0 : 1;
        var i = findMediaById("videos", id);
        $http.get('/profile/toggleMedia/video/' + id + "/" + visible)
            .success(function (e) { $scope.p.videos[i].visible = visible; });
        return false;
    }

    $scope.deleteImage = function (id) {
        event.stopPropagation();
        var i = findMediaById("images", id);
        $http.get('/profile/deleteMedia/image/' + id)
            .success(function (e) { $scope.p.images.splice(i, 1); });
        return false;
    }

    $scope.deleteVideo = function (id) {
        event.stopPropagation();
        var i = findMediaById("videos", id);
        $http.get('/profile/deleteMedia/video/' + id)
            .success(function (e) { $scope.p.videos.splice(i, 1); });
        return false;
    }

    $scope.previewImage = function (e) {
        var img = $(e.target).closest(".image");
        if ($(img).hasClass("full")) {
            $(img).removeClass("full");
        } else {
            $(".media-holder .images .image.full").removeClass("full");
            $(img).addClass("full");
        }
    }

    $scope.previewVideo = function (e) {
        var vid = $(e.target).closest(".video");
        $(".media-holder .videos .video.full video")
            .each(function (a) {
                $(this).removeAttr("controls");
                this.pause();
                this.currentTime = 0;
            });
        if ($(vid).hasClass("full")) {
            $(vid).removeClass("full");
            $(vid).removeAttr("controls");
        } else {
            $(".media-holder .videos .video.full").removeClass("full");
            $(vid).addClass("full");
            $("video", vid).attr("controls", "true");
        }
    }
})

app.controller('ProjectsCtrl', function ($scope, joined, created) {
    var c = created.data, j = joined.data;
    $scope.created = c || [];
    $scope.joined = j || [];
});

app.value('categories', talentCategories());

function showWait() { $(".wait-overlay").addClass("on"); }
function hideWait() { $(".wait-overlay").removeClass("on"); }

app.controller('ProfileCtrl', function ($scope, user) {
    $scope.user = user.data;
    $scope.fname = $scope.user.fname;
    $scope.lname = $scope.user.lname;
    $scope.dob = new Date($scope.user.dob.replace('-', '/'));
    $scope.desc = $scope.user.intro;

    var photo = $(".block .photo");
    var photoPick = $(".profile-pic", photo);

    var profileimg = "http://audicio-s3-bucket.s3.amazonaws.com/user" + a_user_id + "/image/image-1.jpg";
    var img = new Image(); img.onload = function () { photo.css({ "background-image": "url(" + profileimg + ")" }); }
    img.src = profileimg;

    photoPick.change(function (e) {
        var file = e.target.files[0];
        var fr = new FileReader();
        fr.onload = function (e) {
            photo.css({ "background-image": "url(" + e.target.result + ")" });
        }
        fr.readAsDataURL(file);
    })

    $scope.doSave = function () {
        var file = photoPick[0].files.length > 0 ? photoPick[0].files[0] : null;
        if (file) {
            showWait();
            var ext = "." + file.name.split(".").slice(-1);
            uploadFile(file, 'image-1' + ext, function (p) {
                if (p >= 100) {
                    hideWait();
                    console.log('uploaded');
                    var fr = new FileReader();
                    fr.onload = function (e) {
                        $(".header .content .img img")[0].src = e.target.result;
                    }
                    fr.readAsDataURL(file);
                }
            }, hideWait);
        }

        var perr = [false, false, false, false];
        var form = $(".container.profile > .container.profile");
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
                    $(".header .content .name").html(fname.val() + " " + lname.val());
                    var prof = a_host_name + "/@" + a_user_id + "/" + fname.val() + lname.val();
                    $(".header .content .link a").html(prof);
                    $(".header .content .link a").attr("href", prof);
                    console.log("updated");
                }
            })
        }
    }

    window.onscroll = function (e) {
        var savew = $(".center .save-wrap");
        var save = $(".save", savew);
        if (savew.length > 0) {
            if (savew.offset().top < window.scrollY) {
                save.addClass("fix");
            } else {
                save.removeClass("fix");
            }
        }
    }
})

app.controller('ProfileTalentsCtrl', function ($scope, talents) {
    $scope.categories = talents.data;
    $.ajax({
        url: '/profile/userTalents/' + a_user_id,
        success: function (e) {
            e = JSON.parse(e.trim());
            for (i in e) {
                $(".container.mark .item#" + e[i].talid).addClass("mark");
            }
        }
    })
});

app.controller('HeadCtrl', function ($scope, $location) {
    $scope.menu = ['news', 'auditions', 'projects', 'profile'];
    $scope.isMin = function () { return "/profile" != $location.path().slice(0, 8); };
    $scope.isActive = function (route) { return '/' + route == $location.path(); }
    var img = new Image();
    var profileimg = "http://audicio-s3-bucket.s3.amazonaws.com/user" + a_user_id + "/image/image-1.jpg";
    img.onload = function () {
        $(".header .content .img img")[0].src = profileimg;
    }
    img.src = profileimg;
})

app.controller('NewsCtrl', function ($scope) {
    var all = true, m;
    $scope.filters = [['All'], ['Audition', 'aud'], ['User', 'usr'], ['Project', 'prj'], ['General', 'not']];
    $scope.isOn = [];
    $scope.updateOn = function (i) {
        if (i == 0) {
            angular.element('.news .entries .entry').removeClass('hide');
        } else {
            angular.element('.news .entries .entry').addClass('hide');
            for (m = 1; m < $scope.filters.length; ++m)
                if ($scope.isOn[m] == 'on') {
                    angular.element('.entries .entry.' + $scope.filters[m][1]).removeClass('hide');
                }
        }
    }
    $scope.toggleOn = function (i) {
        if (i == 0) for (all = true, m = 0; m < $scope.filters.length; $scope.isOn[m++] = 'on');
        else {
            if (all == true) {
                all = false;
                for (m = 0; m < $scope.filters.length; $scope.isOn[m++] = '');
            }
            $scope.isOn[i] = $scope.isOn[i] == 'on' ? '' : 'on';
            if ($scope.isOn.indexOf('on') < 0) $scope.isOn[i] = 'on';
        }
        $scope.updateOn(i);
    }
    $scope.toggleOn(0);
});

app.controller('ApplyCtrl', function ($scope, $http, audition) {
    $scope.aud = audition.data[0];
    $scope.toNiceDate = function (d) { return moment(d).format('LL HH:mm a') }
    $http.get('/profile/getAuditionStatus/' + $scope.aud.id + '/' + a_user_id)
        .success(function (e) {
            $scope.status = e;
        })
    $scope.apply = function () {
        if ($scope.status.code == 0) {
            $http.get('/profile/applyAudition/' + $scope.aud.id + '/' + a_user_id)
                .success(function (e) {
                    $scope.status = e;
                });
        }
    }
})

app.controller('AudiCtrl', function ($scope, categories, auditions) {
    $scope.auditions = auditions.data;
    $scope.toNiceDate = function (d) { return moment(d).format('LL HH:mm a') }
    var all = true, m;
    $scope.filters = function () {
        var arr = [['All']]
        for (cat in categories) arr.push([cat, categories[cat].class]);
        return arr;
    }();
    $scope.updateOn = function (i) {
        if (i == 0) {
            angular.element('.auditions .entries .entry').removeClass('hide');
        } else {
            angular.element('.auditions .entries .entry').addClass('hide');
            for (m = 1; m < $scope.filters.length; ++m)
                if ($scope.isOn[m] == 'on') {
                    angular.element('.auditions .entries .entry.' + $scope.filters[m][1]).removeClass('hide');
                }
        }
        if (localStorage) localStorage.isOnAudi = JSON.stringify($scope.isOn);
    }
    $scope.toggleOn = function (i) {
        if (i == undefined);
        else if (i == 0) for (all = true, m = 0; m < $scope.filters.length; $scope.isOn[m++] = 'on');
        else {
            if (all == true) {
                all = false;
                for (m = 0; m < $scope.filters.length; $scope.isOn[m++] = '');
            }
            $scope.isOn[i] = $scope.isOn[i] == 'on' ? '' : 'on';
            if ($scope.isOn.indexOf('on') < 0) $scope.isOn[i] = 'on';
        }
        $scope.updateOn(i);
    }
    if (localStorage && localStorage.isOnAudi) { $scope.isOn = JSON.parse(localStorage.isOnAudi); $scope.toggleOn(); }
    else { $scope.isOn = []; $scope.toggleOn(0); }
});

app.directive('audiMeta', function () {
    return {
        restrict: 'E',
        link: function (scope, element, attr) {
            var tds = [];
            var col = attr.col || 2;
            var keys = { post: 'Posted on', by: 'Posted By', on: 'Scheduled on', loc: 'Location', type: 'Position type' };
            for (a in attr) {
                if (/^m/.test(a)) {
                    var k = a.slice(1).toLowerCase();
                    tds.push(angular.element('<td class="key">' + keys[k] + ':</td><td class="value">' + attr[a] + '</td>'));
                }
            }
            var tr, trs = [];
            for (var i = 0; i < tds.length; ++i) {
                if (i % col == 0) {
                    tr = angular.element('<tr>');
                    trs.push(tr);
                }
                tr.append(tds[i]);
            }
            var table = angular.element('<table>');
            for (var i = 0; i < trs.length; table.append(trs[i++]));
            if (element[0].id) table[0].id = element[0].id;
            if (element[0].classList.length)
                for (i in element[0].classList)
                    table[0].classList.add(element[0].classList.item(i));
            element.replaceWith(table);
            element = table;
        }
    }
})