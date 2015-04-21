/// <reference path='angular.js' />

var app = angular.module('audicio', []);
app.directive('heading', function () {
    return {
        link: function (scope, element, attrs) {
            element.addClass('title');
            element.html("<span>" + attrs.heading + "</span>");
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

app.controller('MainCtrl', function ($scope, categories) {
    $scope.categories = categories;
})