<div class="container settings create">
    <div bread-heading="Settings" path="[['{{projectName}}', 'home']]" hash="true"></div>
    <div class="block">
        <div class="field"><span>Project Name:</span><input type="text" ng-model="project.name"></div>
        <div class="field"><span>Description:</span><textarea ng-model="project.desc"></textarea></div>
        <div class="field"><span>&nbsp;</span>
            <button ng-click="update()">Update</button>
            <a class="cancel" ng-click="reset()">Cancel</a>
        </div>
    </div>
    <div class="block">
        <div class="title" style="color: #c0392b">Danger Zone</div>
        <div class="hint">This action cannot be undone</div>
        <div class="field"><button class="delete" ng-click="delete()">Delete Project</button></div>
    </div>
</div>