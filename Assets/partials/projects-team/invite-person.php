<div class="container create invite s2">
    <div bread-heading="Invite People" path="[['{{team.name}}', 'home'],['Auditions', 'auditions']]" hash="true"></div>
    <div class="block">
        <div class="field" style="margin-bottom: 25px">
            <span>Send Invitation to:</span>
            <input type="text" ng-model="key" ng-change="getUninvited()" placeholder="Start typing for suggestions" autofocus>
        </div>
        <div ng-repeat="u in uninvited" class="invite">
            <button class="btn" ng-click="invite(u.id)">Invite</button>
            <a ng-href="/@{{u.id}}/{{u.name}}" target="_blank" class="name">{{u.name}}</a>
        </div>
    </div>
</div>