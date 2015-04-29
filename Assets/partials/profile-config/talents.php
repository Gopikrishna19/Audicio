<div class="container mark">
    <h1>Mark Your Talents</h1>
    <p>Select the talents from the following list that applies to you</p>

    <div>
        <div ng-repeat="(key, cat) in categories">
            <div heading="{{key}}"></div>
            <div class="block">
                <div ng-repeat="(sub, items) in cat" ng-if="sub != 'class'">
                    <div class="sub-title">{{sub}}</div>
                    <div class="entries">
                        <div ng-repeat="item in items" class="col">
                            <div item>{{item}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
