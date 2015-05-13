<?php
    class Search extends Lib\Controller
    {
        public function __construct()
        {
            parent::__construct();
        }

        public function index()
        {
            $this->view->css[] = "search";
            $this->view->js[] = "angular";
            $this->view->js[] = "search";
            $this->view->renderView(__CLASS__, __FUNCTION__);
        }

        public function getResults($key) {
            echo json_encode($this->model->getResults($key));
        }
    }
