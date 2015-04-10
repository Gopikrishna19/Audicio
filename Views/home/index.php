<div class="flex">
    <div class="p2"></div>
    <div class="p3">
        <div class="form">
            <form class="login">
                <div class="title">Log In</div>
                <input class="txt" type="text" placeholder="Username">
                <input class="txt" type="password" placeholder="Password">
                <span class="reg link">Register</span>
                <input class="btn" type="submit" value="Log In">
            </form>

            <form class="register">
                <div class="title">Register</div>
                <input class="txt" type="text" placeholder="Email">
                <input class="txt" type="password" placeholder="Password">
                <input class="txt" type="password" placeholder="Confirm">
                <span class="log link">Log In</span>
                <input class="btn" type="submit" value="Register">
            </form>
        </div>
    </div>
    <script>
        $(function () {
            $(".link.reg").click(function () {
                $("form").addClass("alt");
                setTimeout(function () {
                    $(".login").css({ "z-index": "0" });
                    $(".register").css({ "z-index": "1" });
                }, 300);
            });
            $(".link.log").click(function () {
                $("form").removeClass("alt");
                setTimeout(function () {
                    $(".login").css({ "z-index": "1" });
                    $(".register").css({ "z-index": "0" });
                }, 300);
            });
            $("form").submit(false);
        })
    </script>
</div>
<div class="h1"></div>