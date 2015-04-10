<?php
    namespace Lib;

    class ActionLink{
        public static function create($link, $controller, $action = NULL, $param = NULL, $query = NULL, $class = "", $id = "", $style = ""){
            $action = $action != NULL ? "/$action" : "";
            $param = $param != NULL ? ($action != NULL ? "/$param" : "/index/$param") : "";
            $query = $query != NULL ? "?".http_build_query($query) : "";

            echo "<a href='/$controller$action$param$query'".($class != NULL ? " class='$class'":"")
                    .($id != NULL ? " id='$id'":"").($style != NULL ? " style='$style'":"").">$link</a>";
        }

        public static function external($link, $href = "#", $class = NULL, $id = NULL, $style = NULL) {
            echo "<a href='$href'".($class != NULL ? " class='$class'":"")
                    .($id != NULL ? " id='$id'":"").($style != NULL ? " style='$style'":"").">$link</a>";
        }
    }
?>