<div class="container home">
    <div class="title-w">
        <a href="#/create">Create New Team</a>
        <div bread-heading="{{projectName}}" path="['All Projects']" base="projects"></div>
    </div>
    <div class="teams">
        <div ng-repeat="t in teams" class="team">
            <div class="content">
                <div class="title"><a ng-href="/projects/team/{{t.id}}">{{t.name}}</a></div>
                <p class="desc">{{t.desc}}</p>
                <ul>
                    <li ng-repeat="m in t.members">
                        <a ng-href="/@{{m.id}}/{{m.fname + m.lname}}" target="_blank"
                            ng-style="{'background-image': 'url(http://audicio-s3-bucket.s3.amazonaws.com/user{{m.id}}/image/image-1.jpg)'}"></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
<!--    <div class="milestone">-->
<!--        <div class="title">Milestones</div>-->
<!--        <div class="meter"><div class="ind"></div></div>-->
<!--        <div class="stones">-->
<!--            <stone ng-repeat="m in milestones" date="{{m.date}}" name="{{m.name}}" state="{{m.status}}" id="{{m.id}}"></stone>-->
<!--        </div>-->
<!--    </div>-->
</div>