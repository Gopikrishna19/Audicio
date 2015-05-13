<div class="header" ng-controller="HeadCtrl">
    <div class="content">
        <div class="controls">
            <button class="next" ng-click="next()">{{btnNext}}</button>
        </div>
        <div class="logo">Audicio</div>
        <ul>
            <li class="title">Configuration</li>
            <li ng-repeat="step in steps" step="{{step}}" ng-class="{on:onPage(step)}"></li>
            <li step="Finish"><span class="sep"></span></li>
        </ul>
    </div>
</div>
<div ng-view></div>
<div class="wait-overlay"></div>
