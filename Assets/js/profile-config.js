/// <reference path='angular.js' />

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

app.value('categories', function () {
    return {
        "On Stage": {
            "General": ["Actor", "Archimime"],
            "Stunt": ["Coordinator", "Performer"],
            "Technical": ["Stage Manager", "Lighting Designer", "Scenic Designer", "Electrician", "Director", "Location Manager", "Carpenter"]
        },
        "Management": {
            "General": ["Property Manager", "General Manager"],
            "Production": ["Sponsor", "Manager", "Assistant"],
            "Direction": ["Director", "Assistant"],
            "Talent": ["Manager", "Agent"]
        },
        "Dance": {
            "General": ["Choreographer", "Dancer"]
        },
        "Music": {
            "General": ["Director", "Organizer", "Engineer", "Producer", "Instructor", "Poet"],
            "Song": ["Writer", "Singer", "Composer"],
            "Instrument": ["Percussion", "Strings", "Keyboards", "Wind", "Brass"],
            "Other": ["Librarian"]
        },
        "Script": {
            "General": ["Line Producer", "Author", "Screen Writer", "Editor", "Technical Writer", "Linguist", "Literary Manager"]
        },
        "Art": {
            "General": ["Consultant", "Instructor", "Director", "Artisan"],
            "Animation": ["Animator", "Director"]
        },
        "Fashion": {
            "General": ["Desginer", "Model", "Makeup Artist", "Costume Designer", "Costume Director"]
        },
        "Decoration": {
            "General": ["Production  Designer", "Set Decorator", "Set Dresser"]
        },
        "Marketing": {
            "General": ["Marketing Director", "Public Relations Manager", "Audience Services Manager", "Ticketing Agent", "Publisher"]
        },
        "Advertising": {
            "General": ["Promoter", "Visualizer", "Barker", "Critic"]
        },
        "Others": {
            "General": ["Usher", "Consultant", "Pyro Technician", "Crowd Entertainer", "Illusionist"]
        }
    }
}());

app.controller('MarkCtrl', function ($scope, categories) {
    $scope.categories = categories;
})

app.config(function ($routeProvider) {
    $routeProvider
        .when('/intro', {
            templateUrl: '/Assets/partials/profile-config/intro.php',
            controller: 'MarkCtrl'
        })
        .when('/profile', {
            templateUrl: '/Assets/partials/profile-config/profile.php',
            controller: 'MarkCtrl'
        })
        .when('/media', {
            templateUrl: '/Assets/partials/profile-config/media.php',
            controller: 'MarkCtrl'
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
    console.log($location.path());

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