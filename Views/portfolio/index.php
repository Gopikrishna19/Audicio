<div class="header" ng-controller="HeadCtrl">
    <div class="content">
        <div class="logo special">Audicio</div>
        <div class="img"><img src="/Assets/img/user.png" alt="user"/></div>
        <div class="name">{{p.name}}</div>
        <div class="link"><a ng-href='{{hostName}}/@{{p.id}}/{{p.name}}'>{{hostName}}/@{{p.id}}/{{p.name.replace(' ','')}}</a></div>
        <div class="menu-bar">
            <ul class="menu">
                <li ng-repeat="m in menu">
                    <a href="#{{m}}" ng-class="{active:isActive(m)}">{{m}}</a>
                </li>
                <li class="img-btn"><a ng-href="/{{noLog ? '' : 'profile'}}"><span class="home"></span></a></li>
                <li class="img-btn" ng-hide="noLog"><a href="/search"><span class="search"></span></a></li>
                <li class="img-btn" ng-hide="noLog"><a href="/home/logout"><span class="logout"></span></a></li>
            </ul>
        </div>
    </div>
</div>
<div class="center">
    <ng-view></ng-view>
    <div class="wait-overlay"></div>
</div>