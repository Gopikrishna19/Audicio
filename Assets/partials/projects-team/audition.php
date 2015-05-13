<div class="container audition">
    <div class="title-w">
        <a ng-click="close(audition.id)">Close Audition</a>
        <div bread-heading="{{audition.title}}: Candidates" path="[['{{team.name}}', 'home'], ['Auditions', 'auditions']]" hash="true"></div>
    </div>
    <div class="block">
        <div class="title">Applied Candidates</div>
        <div class="gact">
            <button ng-click="updateAll(2, 1)">Select All</button>
            <button ng-click="updateAll(0, 1)">Reject All</button>
        </div>
        <div ng-repeat="c in candidates | status: 1" class="candidate">
            <button class="cancel" ng-click="update(c.id, 0, 1)"><i class="x"></i><i class="xx"></i></button>
            <button class="btn" ng-click="update(c.id, 2, 1)">Select</button>
            <a ng-href="/@{{c.userid}}/{{c.name}}" target="_blank" class="name">{{c.name}}</a>
        </div>
    </div>
    <div class="block">
        <div class="title">Selected for Audition</div>
        <div class="gact">
            <button ng-click="updateAll(3, 2)">Invite All</button>
            <button ng-click="updateAll(0, 2)">Reject All</button>
        </div>
        <div ng-repeat="c in candidates | status: 2" class="candidate">
            <button class="cancel" ng-click="update(c.id, 0, 2)"><i class="x"></i><i class="xx"></i></button>
            <button class="btn" ng-click="update(c.id, 3, 2)">Invite</button>
            <a ng-href="/@{{c.userid}}/{{c.name}}" target="_blank" class="name">{{c.name}}</a>
        </div>
    </div>
</div>