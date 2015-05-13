<div class="header" ng-controller="HeadCtrl">
    <div class="content">
        <div class="logo">Audicio</div>
        <div class="menu-bar">
            <ul class="menu">
                <li><a href="/profile">My Profile</a></li>
                <li class="img-btn"><a href="/search"><span class="search"></span></a></li>
                <li class="img-btn"><a href="/home/logout"><span class="logout"></span></a></li>
            </ul>
        </div>
    </div>
</div>
<div class="center">
    <ng-view></ng-view>
</div>
