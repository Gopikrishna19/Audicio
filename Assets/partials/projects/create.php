<div class="container create">
    <div bread-heading="Create New Project" path="[['All Projects', 'list']]" hash="true"></div>
    <div class="block">
        <div class="field"><span>Project Name:</span><input type="text" ng-model="title" autofocus></div>
        <div class="field"><span>Description:</span><textarea ng-model="desc"></textarea></div>
        <div class="field"><span>&nbsp;</span>
            <button ng-click="create()">Create</button>
            <a class="cancel" href="#/">Cancel</a>
        </div>
    </div>
</div>