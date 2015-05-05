<div class="container tasks">
    <div bread-heading="Tasks" path="[['Advertisement Team', 'home']]" base="projects" hash="true"></div>
    <div class="tasks">
        <div class="create">
            <div class="fields short">
                <button class="btn c" ng-click="toggleShort($event)">Create Task</button>
                <input type="text" placeholder="Task content" class="task-input" ng-model="nTask">
                <div>Assigned to: </div>
                <input type="text" placeholder="Anyone" class="task-assign" ng-model="nPerson">
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
            <div ng-repeat="task in nTasks = (tasks | done)" date="{{task.date}}" task="{{task.task}}" person="{{task.person}}" key="{{task.id}}"></div>
            <div class="empty" ng-hide="nTasks.length">Create a new task to show here</div>
        </div>
        <div class="finished">
            <div class="head">
                <div class="col c1">&nbsp;</div>
                <div class="col c2">Finished on</div>
                <div class="col c3">&nbsp;</div>
            </div>
            <div ng-repeat="task in fTasks = (tasks | done: true)" date="{{task.date}}" task="{{task.task}}" key="{{task.id}}" done></div>
            <div class="empty" ng-hide="fTasks.length">Finish tasks to show here</div>
        </div>
    </div>
</div>