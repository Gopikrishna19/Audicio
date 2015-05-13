<div class="header">
    <div class="content">
        <div class="logo">Audicio</div>
        <div class="menu-bar">
            <ul class="menu">
                <li><a href="/profile">My Profile</a></li>
                <li class="img-btn"><a href="/home/logout"><span class="logout"></span></a></li>
            </ul>
        </div>
    </div>
</div>
<div class="center" ng-controller="SearchCtrl">
    <div class="container search">
        <div class="row row1">
            <span>Find People and Auditions:</span>
            <input type="text" class="key" ng-model="key" placeholder="Search" ng-change="getResults()">
            <i></i>
        </div>
        <div class="row row2" ng-show="results.auditions.length">
            <div class="title">Auditions</div>
            <a ng-repeat="a in results.auditions" ng-href="/profile#audition/{{a.id}}" target="_blank">{{a.title}}</a>
        </div>
        <div class="row row3" ng-show="results.users.length">
            <div class="title">People</div>
            <a ng-repeat="u in results.users" ng-href="/@{{u.id}}/{{u.name}}" target="_blank">{{u.name}}</a>
        </div>
    </div>
</div>