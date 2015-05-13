<div class="container list">
    <div class="c c1">
        <a href="#/create" class="btn">Create New Project</a>
        <div>
            View <a href="/profile#/auditions">Auditions</a> to get more projects
        </div>
    </div>
    <div class="c c2">
        <div heading="My Projects"></div>
        <div ng-repeat="c in created" class="p">
            <a ng-href="/projects/p/{{c.id}}">{{c.name}}</a>
            <p class="desc">{{c.desc}}</p>
        </div>
    </div>
    <div class="c c2">
        <div heading="Committed to"></div>
        <div ng-repeat="c in joined" class="p">
            <a ng-href="/projects/p/{{c.id}}">{{c.name}}</a>
            <p class="desc">{{c.desc}}</p>
        </div>
    </div>
</div>