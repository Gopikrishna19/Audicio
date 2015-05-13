<div class="flex">
    <div class="p2"></div>
    <div class="p3">
        <div class="form">
            <form class="login" action="/home/login" method="post">
                <div class="title">Log In</div>
                <input type="hidden" name="m" value="log">
                <div class="wrap">
                    <input class="txt email" name="email" type="text" placeholder="Email" autofocus="true">
                    <div class="error email"><div class="msg"></div></div>
                </div>
                <div class="wrap">
                    <input class="txt upass" name="upass" type="password" placeholder="Password">
                    <div class="error upass"><div class="msg"></div></div>
                </div>
                <div class="lbtn gp log"></div>
                <div class="lbtn fb log"></div>
                <span class="reg link">Register</span>
                <input class="btn" type="submit" value="Log In">
                <div class="link forgot">Forgot username or password</div>
            </form>
            <form class="register" action="/home/login" method="post">
                <div class="title">Register</div>
                <input type="hidden" name="m" value="reg">
                <div class="wrap">
                    <input class="txt email" name="email" type="text" placeholder="Email">
                    <div class="error email"><div class="msg"></div></div>
                </div>
                <div class="wrap">
                    <input class="txt upass" name="upass" type="password" placeholder="Password">
                    <div class="error upass"><div class="msg"></div></div>
                </div>
                <div class="wrap">
                    <input class="txt cpass" type="password" placeholder="Confirm">
                    <div class="error cpass"><div class="msg"></div></div>
                </div>
                <div class="lbtn gp reg"></div>
                <div class="lbtn fb reg"></div>
                <span class="log link">Log In</span>
                <input class="btn" type="submit" value="Register">
            </form>
        </div>
    </div>
    <script>
    </script>
</div>
<div class="header">
    <div class="container">
        <span class="logo">Audicio</span>
        <ul class="nav">
        <li>About</li>
        <li>Team</li>
    </ul>
    </div>
</div>
