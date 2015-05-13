<div class="container profile">
    <ul class="sidebar">
        <li><a href="#/profile">Profile</a></li>
        <li><a href="#/profile/media" class="active">Media</a></li>
        <li><a href="#/profile/talents">Talents</a></li>
        <li><a href="#/profile/account">Account</a></li>
    </ul>
    <?php $save = true;
    include "../profile-config/media.php" ?>
    <div class="media-holder">
        <div class="block images" ng-show="p.images.length">
            <div class="title">Images</div>
            <div class="image" ng-repeat="i in p.images" ng-click="previewImage($event)"
                 ng-class="{'hide': i.visible == 0}">
                <img ng-src="{{getImage(i.id, i.ext)}}">
                <ul class="controls">
                    <li class="eye" ng-click="toggleImage(i.id, i.visible)"></li>
                    <li class="del" ng-click="deleteImage(i.id)"></li>
                </ul>
            </div>
        </div>
        <div class="block videos" ng-show="p.videos.length">
            <div class="title">Videos</div>
            <div class="video" ng-repeat="v in p.videos" ng-click="previewVideo($event)"
                 ng-class="{'hide': v.visible == 0}">
                <video>
                    <source ng-src="{{getVideo(v.id)}}" type="video/mp4">
                </video>
                <ul class="controls">
                    <li class="eye" ng-click="toggleVideo(v.id, v.visible)"></li>
                    <li class="del" ng-click="deleteVideo(v.id)"></li>
                </ul>
            </div>
        </div>
    </div>
</div>