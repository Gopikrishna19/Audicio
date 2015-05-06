<?php
    class Profile extends Lib\Controller {
        public function __construct() {
            parent::__construct();
            $this->view->js[] = "angular";
            $this->view->js[] = "angular-route";
            $this->view->js[] = "common";
        }

        public function index() {
            $this->view->css[] = "profile-index";
            $this->view->js[] = "profile-index";
            $this->view->renderView(__CLASS__, __FUNCTION__);
        }

        public function config() {
            $this->view->css[] = "profile-config";
            $this->view->js[] = "aws-sdk";
            $this->view->js[] = "profile-media";
            $this->view->js[] = "profile-config";
            $this->view->renderView(__CLASS__, __FUNCTION__);
        }

        public function of($id = null){
            if($id=='') { header('Location: /profile'); return; }
            $this->view->renderView(__CLASS__, __FUNCTION__);
        }
    }
?>