<div class="container auditions">
    <div class="entries">
        <div ng-repeat="a in auditions" ng-class="a.class" class="entry">
            <div class="timestamp">on {{toNiceDate(a.createdate)}}</div>
            <div class="title"><a class="audition" ng-href="#/audition/{{a.id}}">{{a.title}}</a></div>
            <audi-meta m-on="{{toNiceDate(a.schedule)}}" m-by="{{a.uname}}" m-loc="{{a.location}}" m-type="{{a.cat}}"></audi-meta>
        </div>
<!--        <div class="more">Load More</div>-->
    </div>
    <div class="sidebar filter">
        <div class="title">Filter</div>
        <ul>
            <li ng-repeat="f in filters" ng-class="isOn[$index]" ng-click="toggleOn($index)">{{f[0]}}</li>
        </ul>
    </div>
</div>