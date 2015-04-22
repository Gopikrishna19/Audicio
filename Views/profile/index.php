<div class="header" ng-class="isMin ? 'min':''" ng-controller="HeadCtrl">
    <div class="content">
        <div class="img"></div>
        <div class="name">This is My Name</div>
        <div class="menu-bar">
            <ul class="menu">
                <li ng-repeat="m in menu">
                    <a href="#{{m}}" ng-class="{active:isActive(m)}" ng-click="updateMin(m)">{{m}}</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="center">
    <ng-view></ng-view>
</div>