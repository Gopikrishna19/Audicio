<div class="container auditions">
    <div class="title-w">
        <a href="#/auditions/invite">Invite People</a>
        <a href="#/auditions/new">Create Audition</a>
        <div bread-heading="Auditions" path="[['{{team.name}}', 'home']]" hash="true"></div>
    </div>
    <div class="block">
        <div class="title">Auditions</div>
        <div ng-repeat="a in auditions" class="audition">
            <button class="btn r" ng-click="close(a.id)">Close</button>
            <a class="btn" href="#/audition/edit/{{a.id}}">Edit</a>
            <span class="count">{{a.cnum}} candidate{{a.cnum < 2 ? "" : "s" }}</span>
            <a ng-href="#/audition/{{a.id}}" class="name">{{a.title}}</a>
        </div>
    </div>
    <div class="block">
        <div class="title">Invited Candidates/Pending Commitment</div>
        <div ng-repeat="i in invites" class="invite">
            <button class="cancel" ng-click="delete(i.id)"><i class="x"></i><i class="xx"></i></button>
            <a ng-href="/@{{i.userid}}/{{i.name}}" target="_blank" class="name">{{i.name}}</a>
            <span class="status"> - Waiting acceptance</span>
        </div>
    </div>
</div>