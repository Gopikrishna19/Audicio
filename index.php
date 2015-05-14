<?php
    require_once "Config.php";
    require_once "Controllers/error.php";
    require_once "Aws/sqs.php";

    function __autoload($class) {
        require_once str_replace('\\', '/', $class).".php";
    }

    new Lib\Boot();
?>