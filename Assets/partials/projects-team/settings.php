<div class="container settings create">
    <div bread-heading="Settings" path="[['{{team.name}}', 'home']]" hash="true"></div>
    <div class="block">
        <div class="field"><span>Team Name:</span><input type="text" ng-model="team.name"></div>
        <div class="field"><span>Team Category:</span>
            <select ng-model="team.catid">
                <option ng-repeat="c in categories" value="{{c.id}}">{{c.name}}</option>
            </select>
        </div>
        <div class="field"><span>Description:</span><textarea ng-model="team.desc"></textarea></div>
        <div class="field"><span>&nbsp;</span>
            <button ng-click="update()">Update</button>
            <a class="cancel" ng-click="reset()">Cancel</a>
        </div>
    </div>
    <div class="block">
        <div class="title">Team Members</div>
        <div class="member" ng-repeat="m in team.members">
            <button class="btn r" ng-click="deleteMember($event, m.id)">Delete</button>
            <a class="btn" ng-href="/@{{m.id}}/{{m.fname + m.lname}}" target="_blank">View Profile</a>
            <img ng-src="http://audicio-s3-bucket.s3.amazonaws.com/user{{m.id}}/image/image-1.jpg" alt="{{m.id}}">
            <span class="name">{{m.fname + " " + m.lname}}</span>
        </div>
    </div>
    <div class="block">
        <div class="title" style="color: #c0392b">Danger Zone</div>
        <div class="hint">This action cannot be undone</div>
        <div class="field"><button class="delete" ng-click="delete()">Delete Team</button></div>
    </div>
</div>