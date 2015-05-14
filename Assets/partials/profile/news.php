<div class="container news">
    <div class="entry-holder">
        <div class="entries">
            <div class="entry prj invite" ng-repeat="i in invites">
                <div class="timestamp">New Invitation</div>
                <div class="title"><a class="author" ng-href="/@{{i.uid}}/{{i.uname}}">{{i.uname}}</a>
                    invited you to join <a>{{i.pname}}</a></div>
                <div class="options">
                    <button class="accept" ng-click="accept(i.id)">Accept</button>
                    <button class="decline" ng-click="decline(i.id)">Decline</button>
                </div>
            </div>
        </div>
        <div class="entries" ng-bind-html="notify"></div>
    </div>
    <div class="sidebar filter">
        <div class="title">Filter</div>
        <ul>
            <li ng-repeat="f in filters" ng-class="isOn[$index]" ng-click="toggleOn($index)">{{f[0]}}</li>
        </ul>
    </div>
</div>