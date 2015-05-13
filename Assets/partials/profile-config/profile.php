<div class="container profile">
    <?php if(isset($save)): ?>
        <div class="save-wrap">
            <div class="save">
                <button class="save-btn" ng-click="doSave()">Save</button>
            </div>
        </div>
    <?php endif; ?>
    <ul class="block error">
        <li class="fn">Invalid First Name</li>
        <li class="ln">Invalid Last Name</li>
        <li class="db">Invalid Date of Birth</li>
        <li class="sp">Password must contain 6 characters or more</li>
        <li class="ip">Password must be alphanumeric</li>
        <li class="cp">Passwords do not match</li>
    </ul>
    <div class="block">
        <div class="title">Personal Information</div>
        <div class="photo">
            <div class="overlay">
                <div class="upload">Change Picture
            <input type="file" class="profile-pic" accept="image/jpeg">
                </div>
            </div>
        </div>
        <div class="field"><span>First Name:</span><input type="text" class="fname" autofocus ng-model="fname"></div>
        <div class="field"><span>Last Name:</span><input type="text" class="lname" ng-model="lname"></div>
        <div class="field"><span>Date of Birth:</span><input type="date" class="dob" ng-model="dob"></div>
    </div>
    <div class="block">
        <div class="title">Self Intro</div>
        <ul class="hint">
            <li>Describe yourself in few words</li>
        </ul>
        <textarea class="desc" ng-model="desc"></textarea>
    </div>
    <ul class="block error">
        <li class="sp">Password must contain 6 characters or more</li>
        <li class="ip">Password must be alphanumeric</li>
        <li class="cp">Passwords do not match</li>
    </ul>
    <div class="block">
        <div class="title">Password</div>
        <ul class="hint">
            <li>Change, if you are logging in using Google or Facebook and want to log in directly in future</li>
            <li>Change, if you registered normally and want to update the password</li>
        </ul>
        <div class="field"><span>New Password:</span><input type="password" class="upass"></div>
        <div class="field"><span>Confirm:</span><input type="password" class="cpass"></div>
    </div>
</div>
