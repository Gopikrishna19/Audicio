<?php
    require_once "Controllers/error.php";

    function __autoload($class) {
        require_once str_replace('\\', '/', $class).".php";
    }

    new Lib\Boot();
?>