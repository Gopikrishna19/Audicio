<div class="header" ng-class="isMin() ? 'min':''" ng-controller="HeadCtrl">
    <div class="content">
        <div class="logo">Audicio</div>
        <div class="logo special">Audicio</div>
        <div class="img"><img src="/Assets/img/user.png" alt="user"/></div>
        <div class="name"><?php echo $this->model["fname"]." ".$this->model["lname"]; ?></div>
        <div class="link">
            <?php
                $prof = Audicio."/@".$this->model['id']."/".$this->model["fname"].$this->model["lname"];
                echo "<a href='$prof' target='_blank'>$prof</a>";
            ?>
        </div>
        <div class="menu-bar">
            <ul class="menu">
                <li ng-repeat="m in menu">
                    <a href="#{{m}}" ng-class="{active:isActive(m)}">{{m}}</a>
                </li>
                <li class="img-btn"><a href="/search"><span class="search"></span></a></li>
                <li class="img-btn"><a href="/home/logout"><span class="logout"></span></a></li>
            </ul>
        </div>
    </div>
</div>
<div class="center">
    <ng-view></ng-view>
    <div class="wait-overlay"></div>
</div>