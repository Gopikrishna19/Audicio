<?php
    class Home extends Lib\Controller {
        public function __construct() {
            parent::__construct();
        }
    
        public function index() {
            $this->view->css[] = "home";
            $this->view->js[] = "home";
            $this->view->renderView(__CLASS__, __FUNCTION__);            
        }
    }
?>
