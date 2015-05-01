<?php
    class Projects extends Lib\Controller {
        public function __construct() {
            parent::__construct();
            $this->view->js[] = "angular";
            $this->view->js[] = "angular-route";
            $this->view->js[] = 'common';
            $this->view->css[] = "projects";
        }

        public function index() {
            $this->view->css[] = 'projects-index';
            $this->view->js[] = 'projects-index';
            $this->view->renderView(__CLASS__,__FUNCTION__);
        }

        public function p($id = null) {
            if($id=='') { header('Location: /projects'); return; }
            $this->view->css[] = 'projects-p';
            $this->view->js[] = 'projects-p';
            $this->view->renderView(__CLASS__,__FUNCTION__);
        }

        public function team($id = null) {
            if($id=='') { header('Location: /projects'); return; }
            $this->view->css[] = 'projects-team';
            $this->view->js[] = 'projects-team';
            $this->view->renderView(__CLASS__,__FUNCTION__);
        }
    }
?>