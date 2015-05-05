function talentCategories() {
    return {
        "On Stage": {
            "General": ["Actor", "Archimime"],
            "Stunt": ["Coordinator", "Performer"],
            "Technical": ["Stage Manager", "Lighting Designer", "Scenic Designer", "Electrician", "Director", "Location Manager", "Carpenter"],
            "class": "ons"
        },
        "Management": {
            "General": ["Property Manager", "General Manager"],
            "Production": ["Sponsor", "Manager", "Assistant"],
            "Direction": ["Director", "Assistant"],
            "Talent": ["Manager", "Agent"],
            "class": "mgm"
        },
        "Dance": {
            "General": ["Choreographer", "Dancer"],
            "class": "dnc"
        },
        "Music": {
            "General": ["Director", "Organizer", "Engineer", "Producer", "Instructor", "Poet"],
            "Song": ["Writer", "Singer", "Composer"],
            "Instrument": ["Percussion", "Strings", "Keyboards", "Wind", "Brass"],
            "Other": ["Librarian"],
            "class": "mus"
        },
        "Script": {
            "General": ["Line Producer", "Author", "Screen Writer", "Editor", "Technical Writer", "Linguist", "Literary Manager"],
            "class": "scr"
        },
        "Art": {
            "General": ["Consultant", "Instructor", "Director", "Artisan"],
            "Animation": ["Animator", "Director"],
            "class": "art"
        },
        "Fashion": {
            "General": ["Desginer", "Model", "Makeup Artist", "Costume Designer", "Costume Director"],
            "class": "fsh"
        },
        "Decoration": {
            "General": ["Production  Designer", "Set Decorator", "Set Dresser"],
            "class": "dec"
        },
        "Marketing": {
            "General": ["Marketing Director", "Public Relations Manager", "Audience Services Manager", "Ticketing Agent", "Publisher"],
            "class": "mkt"
        },
        "Advertising": {
            "General": ["Promoter", "Visualizer", "Barker", "Critic"],
            "class": "adv"
        },
        "Others": {
            "General": ["Usher", "Consultant", "Pyro Technician", "Crowd Entertainer", "Illusionist"],
            "class": "oth"
        }
    }
}

function talentHeading() {
    return {
        link: function (scope, element, attrs) {
            element.addClass('title');
            element.html("<span>" + attrs.heading + "</span>");
        }
    }
}

function breadCrumbHeading() {
    return {
        link: function (scope, element, attrs) {
            var base = "/" + (attrs.base ? attrs.base : "");
            base = (attrs.hash ? "#" : base);
            var path = JSON.parse(attrs.path.replace(/\'/g, "\""));
            var string = "";

            for (var i = 0; i < path.length; ++i) {                
                if (path[i] instanceof Array) {
                    if (!path[i][1]) path[i][1] = "";
                    string += "<a href='" + base + "/" + path[i][1] + "'>" + path[i][0] + "</a>";
                } else if (!(path[i] instanceof Array) && typeof path[i] == "string") {
                    string += "<a href='" + base + "'>" + path[i] + "</a>";
                } else {
                    throw new TypeError("invalid type: " + typeof path);
                }
            }
            string += "<span>" + attrs.breadHeading + "</span>";
            element.addClass('title');
            element.html(string);
        }
    }
}