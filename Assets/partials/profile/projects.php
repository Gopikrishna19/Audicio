<div class="container portfolio">
    <div class="c c1">
        <a href="/projects" class="btn">View all Projects</a>
        <div>View <a href="#/auditions">Auditions</a> to get more projects 
        or go to <a href="/projects">Projects</a> page to create you own.</div>
    </div>
    <div class="c c2">
        <div heading="My Projects"></div>
        <div ng-repeat="c in created" class="p"><a ng-href="/projects/p/{{c.id}}">{{c.name}}</a></div>
    </div>
    <div class="c c2">
        <div heading="Committed to"></div>
        <div ng-repeat="c in joined" class="p"><a ng-href="/projects/p/{{c.id}}">{{c.name}}</a></div>
    </div>
</div>