<div class="container tasks">
    <div bread-heading="Tasks" path="[['{{team.name}}', 'home']]" base="projects" hash="true"></div>
    <div class="tasks">
        <div class="create">
            <div class="fields short">
                <button class="btn c" ng-click="toggleShort($event)">Create Task</button>
                <input type="text" placeholder="Task content" class="task-input" ng-model="nTask">
                <div>Assigned to: </div>
                <select ng-model="nPerson">
                    <option value="" selected>Everyone</option>
                    <option ng-repeat="m in members" value="{{m.id}}">{{m.fname[0] + ". " + m.lname}}</option>
                </select>
                <button class="btn d" ng-click="createTask($event)">Create</button>
                <button class="cancel" ng-click="toggleShort($event)">Cancel</button>
            </div>
        </div>
        <div class="on-going">
            <div class="head">
                <div class="col c1">Done</div>
                <div class="col c2">Created on</div>
                <div class="col c3">Tasks</div>
            </div>
            <div ng-repeat="task in nTasks = (tasks | done)" date="{{task.createdate}}" task="{{task.task}}" person="{{task.person}}" key="{{task.id}}"></div>
            <div class="empty" ng-hide="nTasks.length">Create a new task to show here</div>
        </div>
        <div class="finished">
            <div class="head">
                <div class="col c1">&nbsp;</div>
                <div class="col c2">Finished on</div>
                <div class="col c3">&nbsp;</div>
            </div>
            <div ng-repeat="task in fTasks = (tasks | done: true)" date="{{task.finishdate}}" task="{{task.task}}" key="{{task.id}}" done></div>
            <div class="empty" ng-hide="fTasks.length">Finish tasks to show here</div>
        </div>
    </div>
</div>