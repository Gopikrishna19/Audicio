<div class="header" ng-class="isMin() ? 'min':''" ng-controller="HeadCtrl">
    <div class="content">
        <div class="logo">Audicio</div>
        <div class="logo special">Audicio</div>
        <div class="img"><img src="/Assets/img/user.png" alt="user"/></div>
        <div class="name">This is My Name</div>
        <div class="menu-bar">
            <ul class="menu">
                <li ng-repeat="m in menu">
                    <a href="#{{m}}" ng-class="{active:isActive(m)}">{{m}}</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="center">
    <ng-view></ng-view>
</div>