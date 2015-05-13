<div class="container create s3">
    <div bread-heading="{{title}}" path="[['{{team.name}}', 'home'], ['Auditions', 'auditions']]" hash="true"></div>
    <div class="block">
        <div class="hint">All the fields are required</div>
        <div class="field"><span>Audition Title:</span><input type="text" ng-model="audition.title" autofocus></div>
        <div class="field"><span>Scheduled On:</span>
            <input type="date" ng-model="audition.scheduleo" style="width: 190px">
            <input type="time" ng-model="audition.scheduleo" style="width: 150px">
        </div>
        <div class="field"><span>Location:</span><input type="text" ng-model="audition.location"></div>
        <div class="field"><span>Description:</span><textarea ng-model="audition.desc"></textarea></div>
        <div class="field">
            <span>&nbsp;</span>
            <button class="btn" ng-click="create()">{{button}} Audition</button>
            <a class="cancel" href="#/auditions">Cancel</a>
        </div>
    </div>
</div>