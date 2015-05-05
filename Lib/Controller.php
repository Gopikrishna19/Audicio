<?php
    namespace Lib;

    class Controller{
        public function __construct(){
            $this->view = new View();
            $this->view->css[] = "master";
            $this->view->js[] = "jquery";
            $this->view->js[] = "moment";
        }

        public function loadModel($controller){
            $file = "models/".$controller."_model.php";
            $class = $controller."_Model";
            if(file_exists($file)){
                require $file;
                $this->model = new $class();
            }
        }
    }
?>
