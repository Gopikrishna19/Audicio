<div class="container home">
    <div class="block" ng-show="p.intro.length">
        <div class="title">About Me</div>
        <p class="intro">{{p.intro}}</p>
    </div>
    <div class="block" ng-show="p.talents.length">
        <div class="title">My Talents</div>
        <div class="talents">
            <div ng-repeat="t in p.talents" class="talent">{{t.name}}: <span class="h">{{t.talent}}</span></div>
        </div>
    </div>
    <div class="block" ng-show="p.achieves.length">
        <div class="title">My Achievements</div>
        <div class="talents">
            <div ng-repeat="a in p.achieves" class="talent">{{a.year}}: <span class="h">{{a.achievement}}</span></div>
        </div>
    </div>
    <div class="block" ng-show="p.projects.length">
        <div class="title">My Projects</div>
        <div class="talents">
            <div ng-repeat="r in p.projects" class="talent"><span class="h">{{r.name}}</span></div>
        </div>
    </div>
</div>