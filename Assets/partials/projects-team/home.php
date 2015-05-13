<div class="container home">
    <div class="title-w">
        <a href="#/tasks">View Team Tasks</a>
        <div bread-heading="{{team.name}}" path="['All Projects',['{{projectName}}', 'p/{{projectId}}']]" base="projects"></div>
    </div>
    <div class="block">
        <div class="title">Team Description</div>
        <p>{{team.desc}}</p>
    </div>
    <div class="block">
        <div class="title">Team Members</div>
        <ul>
            <li ng-repeat="m in team.members">
                <a ng-href="/@{{m.id}}/{{m.fname + m.lname}}" title="{{m.fname + ' ' + m.lname}}" target="_blank">
                    <span class="img"
                          ng-style="{'background-image': 'url(http://audicio-s3-bucket.s3.amazonaws.com/user{{m.id}}/image/image-1.jpg)'}">
                    </span>
                    <span class="name">{{m.fname + " " + m.lname}}</span>
                </a>
            </li>
        </ul>
    </div>
</div>