<div class="container auditions">
    <div class="entries">
        <div class="entry ons">
            <div class="timestamp">on 03 Mar, 2015 12:00 pm</div>
            <div class="title"><a class="audition" href="#/auditions/1">Actor needed</a></div>
            <audi-meta on="12 Mar, 2015 10:00 am" by="So and So" loc="173, West 4th Street" type="On Stage" />
        </div>
        <div class="entry mgm rec">
            <div class="timestamp">on 03 Mar, 2015 12:00 pm</div>
            <div class="title"><a class="audition">Audition for Music Director</a></div>
            <audi-meta on="12 Mar, 2015 10:00 am" by="Someone" loc="169, West 42nd St" type="Management" />
        </div>
        <div class="more">Load More</div>
    </div>
    <div class="sidebar filter">
        <div class="title">Filter</div>
        <ul>
            <li ng-repeat="f in filters" ng-class="isOn[$index]" ng-click="toggleOn($index)">{{f[0]}}</li>
        </ul>
        <div class="title">Sort</div>
        <ul>
            <li>Recommended</li>
            <li>By Date</li>
            <li>By Popularity</li>
        </ul>
    </div>
</div>