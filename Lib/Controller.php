<?php
    namespace Lib;

    class Controller{
        public function __construct($login = true){
            if($login == true) {
                if(!Session::get("a_user_id")) {
                    header("Location: /");
                    die;
                }
            }

            $this->view = new View();
            $this->view->css[] = "master";
            $this->view->js[] = "jquery";
            $this->view->js[] = "moment";
            $this->view->jsVar = [];
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
