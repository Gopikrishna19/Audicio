<div class="container create s1">
    <div bread-heading="Create New Team" path="[['{{projectName}}', 'home']]" hash="true"></div>
    <div class="block">
        <div class="field"><span>Team Name:</span><input type="text" autofocus ng-model="name"></div>
        <div class="field"><span>Team Category:</span>
            <select ng-model="catid">
                <option ng-repeat="c in categories" value="{{c.id}}">{{c.name}}</option>
            </select>
        </div>
        <div class="field"><span>Description:</span><textarea ng-model="desc"></textarea></div>
        <div class="field">
            <span>&nbsp;</span>
            <button ng-click="doCreate()">Create</button>
            <a class="cancel" href="#/home">Cancel</a>
        </div>
    </div>
</div>