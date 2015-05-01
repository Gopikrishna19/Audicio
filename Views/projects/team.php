<div class="header" ng-controller="HeadCtrl">
    <div class="content">
        <div class="logo">Audicio</div>
        <div class="menu-bar">
            <ul class="menu">
                <li ng-show="isShowable('home')"><a href="#/home">Team Home</a></li>
                <li ng-repeat="m in menu">
                    <a href="#{{m}}" ng-class="{active:isActive(m)}" ng-click="updateMin(m)">{{m}}</a>
                </li>
                <li><a href="/projects/p/1">Project Home</a></li>
                <li><a href="/projects">All Projects</a></li>
                <li><a href="/profile">My Profile</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="center">
    <ng-view></ng-view>
</div>