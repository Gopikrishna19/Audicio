<div class="container audition">
    <div class="entries">
        <div class="entry ons">
            <div class="title"><a class="audition" href="#/audition/{{aud.id}}">{{a.title}}</a></div>
            <audi-meta m-post="{{toNiceDate(aud.createdate)}}" m-by="{{aud.uname}}" m-on="{{toNiceDateTime(aud.schedule)}}"
                       m-loc="{{aud.location}}" m-type="{{aud.cat}}" col="1"></audi-meta>
            <div class="description">
                <p>{{aud.desc}}</p>
            </div>
        </div>
    </div>
    <div class="sidebar filter">
        <div class="title">Actions</div>
        <button ng-class="status.status" ng-click="apply()">{{status.status}}</button>
        <a href="#/auditions" class="back">&larr; Back to List</a>
        <div class="title">Location</div>
        <a href="http://google.com/maps/search/173,%20West%204th%20Street" target="_blank" class="back">
            <img ng-src="https://maps.googleapis.com/maps/api/staticmap?size=225x170&markers={{aud.location}}"
                 alt="map"/>
        </a>
        <a class="btn" href="http://google.com/maps/dir/173,%20West%204th%20Street" target="_blank" class="back">Get Directions</a>
    </div>
</div>