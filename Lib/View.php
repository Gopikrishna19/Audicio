<?php
    namespace Lib;
        
    class View {
        public $css = array();
        public $js = array();
    
        private $header = "Views/master/header.php";
        private $footer = "Views/master/footer.php";
    
        public function renderView($controller, $filename='index', $masterpage = TRUE){
            $this->controller = $controller;
            $view = "Views/".$controller."/".$filename.".php";
            if(!file_exists($view)){
                $error = new \Error(503);
                $error->index();
                return;
            } elseif($masterpage) {
                require $this->header;
                require $view;
                require $this->footer;
            } else {
                require $view;
            }
        }
    
        public function setHeader($file) {
            $this->header = "Views/master/$file.php";
        }

        public function setFooter($file) {
            $this->footer = "Views/master/$file.php";
        }
    }
?>
