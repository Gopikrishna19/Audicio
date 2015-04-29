<div class="container news">
    <div class="entries">
        <div class="entry aud new-audition">
            <div class="timestamp">on 03 Mar, 2015 12:00 pm</div>
            <div class="title">
                <a class="audition">New Audition</a> by <a class="author">So and So</a>
                scheduled on 12 Mar, 2015 10:00 am
            </div>
        </div>
        <div class="entry aud audition-info b">
            <div class="timestamp">on 03 Mar, 2015 12:00 pm</div>
            <div class="title">New update from <a class="audition">Audition</a> on 12 Mar, 2015 10:00 am</div>
            <div class="content">The audition is rescheduled to new date</div>
        </div>
        <div class="entry aud audition-info g">
            <div class="timestamp">on 03 Mar, 2015 12:00 pm</div>
            <div class="title">New update from <a class="audition">Audition</a> on 12 Mar, 2015 10:00 am</div>
            <div class="content">Congratulation. You have been selected by the audition/project</div>
        </div>
        <div class="entry aud audition-info r">
            <div class="timestamp">on 03 Mar, 2015 12:00 pm</div>
            <div class="title">New update from <a class="audition">Audition</a> on 12 Mar, 2015 10:00 am</div>
            <div class="content">The audition has found your profile not an ideal candidate at this time</div>
        </div>
        <div class="entry usr user-update">
            <div class="timestamp">on 03 Mar, 2015 12:00 pm</div>
            <div class="title"><a class="author">Someone</a> uploaded a picture/video on 12 Mar, 2015 10:00 am</div>
            <div class="content"></div>
        </div>
        <div class="entry prj new-task">
            <div class="timestamp">on 03 Mar, 2015 12:00 pm</div>
            <div class="title">A new task, <a>Task</a> from <a class="author">Project</a> on 12 Mar, 2015 10:00 am</div>
            <div class="content">Do something as a part of tomorrow's cast</div>
        </div>
        <div class="entry prj invite">
            <div class="timestamp">on 03 Mar, 2015 12:00 pm</div>
            <div class="title"><a class="author">Someone</a> invited you to join <a class="project">Project</a> on 12 Mar, 2015 10:00 am</div>
            <div class="options">
                <button class="accept">Accept</button>
                <button class="decline">Decline</button>
            </div>
        </div>
        <div class="entry not notify b">
            <div class="timestamp">on 03 Mar, 2015 12:00 pm</div>
            <div class="title">Common Notification</div>
        </div>
        <div class="entry not notify g">
            <div class="timestamp">on 03 Mar, 2015 12:00 pm</div>
            <div class="title">Your pictures were successfully uploaded</div>
        </div>
        <div class="entry not notify r">
            <div class="timestamp">on 03 Mar, 2015 12:00 pm</div>
            <div class="title">Your videos were failed to convert</div>
        </div>
        <div class="more">Load More</div>
    </div>
    <div class="sidebar filter">
        <div class="title">Filter</div>
        <ul>
            <li ng-repeat="f in filters" ng-class="isOn[$index]" ng-click="toggleOn($index)">{{f[0]}}</li>
        </ul>
    </div>
</div>