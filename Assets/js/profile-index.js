/// <reference path='angular.js' />
/// <reference path='categories.js' />

var app = angular.module('audicio', ['ngRoute']);

app.config(function ($routeProvider) {
    $routeProvider
        .when('/news', {
            templateUrl: '/Assets/partials/profile/news.php',
            controller: 'NewsCtrl'
        })
        .when('/auditions', {
            templateUrl: '/Assets/partials/profile/auditions.php',
            controller: 'AudiCtrl'
        })
        .when('/auditions/:id', {
            templateUrl: '/Assets/partials/profile/audition.php',
        })
        .when('/profile', {
            templateUrl: '/Assets/partials/profile/profile.php'
        })
        .when('/projects', {
            templateUrl: '/Assets/partials/profile/projects.php'
        })
        .otherwise({
            redirectTo: '/news'
        });
});

app.value('categories', talentCategories());

app.controller('HeadCtrl', function ($scope, $location) {
    $scope.menu = ['news', 'auditions', 'projects', 'profile'];
    $scope.isMin = "/profile" != $location.path();
    $scope.isActive = function (route) {
        return '/' + route == $location.path();
    }
    $scope.updateMin = function (route) {
        $scope.isMin = (route != "profile");
    }
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
        }
        $scope.updateOn(i);
    }
    $scope.toggleOn(0);
});

app.controller('AudiCtrl', function ($scope, categories) {
    var all = true, m;
    $scope.filters = function () {
        var arr = [['All']]
        for (cat in categories) arr.push([cat, categories[cat].class]);
        return arr;
    }();
    $scope.isOn = [];
    $scope.updateOn = function (i) {
        if (i == 0) {
            angular.element('.auditions .entries .entry').removeClass('hide');
            console.log(1);
        } else {
            angular.element('.auditions .entries .entry').addClass('hide');
            console.log(2, angular.element('.auditions .entries .entry'));
            for (m = 1; m < $scope.filters.length; ++m)
                if ($scope.isOn[m] == 'on') {
                    angular.element('.auditions .entries .entry.' + $scope.filters[m][1]).removeClass('hide');
                    console.log(3, m, $scope.filters[m][1], angular.element('.auditions .entries .entry.' + $scope.filters[m][1]));
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
        }
        $scope.updateOn(i);
    }
    $scope.toggleOn(0);
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
                    tds.push(angular.element('<td class="key">'+keys[k]+':</td><td class="value">' + attr[a] + '</td>'));
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