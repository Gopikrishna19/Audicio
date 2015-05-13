<div class="container media">
    <div class="block images" ng-show="p.images.length">
        <div class="title">Images</div>
        <div class="strip">
            <div class="image" ng-repeat="i in p.images" ng-click="previewImage($event)">
                <img ng-src="{{getImage(i.id, i.ext)}}">
                <div class="overlay"></div>
            </div>
        </div>
        <div class="preview">
            <div class="img"></div>
        </div>
    </div>
    <div class="block videos" ng-show="p.videos.length">
        <div class="title">Videos</div>
        <div class="strip">
            <div class="video" ng-repeat="v in p.videos" ng-click="previewVideo($event)">
                <video width="150">
                    <source ng-src="{{getVideo(v.id)}}" type="video/mp4">
                </video>
                <div class="overlay"></div>
            </div>
        </div>
        <div class="preview">
            <div class="img"></div>
        </div>
    </div>
</div>