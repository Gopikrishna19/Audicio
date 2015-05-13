<?php
    class Portfolio extends Lib\Controller
    {
        public function __construct()
        {
            parent::__construct(false);
        }

        public function index($id)
        {
            if($this->model->countUser($id) != 1) { $e = new Error(); $e->index(); return; }
            if(Lib\Session::get("a_user_id"))
                $this->view->jsVar["a_user_id"] = Lib\Session::get("a_user_id");
            $this->view->css[] = "portfolio";
            $this->view->js[] = "angular";
            $this->view->js[] = "angular-route";
            $this->view->js[] = "angular-sanitize";
            $this->view->js[] = "portfolio";
            $this->view->jsVar['a_host_name'] = Audicio;
            $this->view->jsVar['a_profile_id'] = $id;
            $this->view->renderView(__CLASS__, __FUNCTION__);
        }

        public function getEverything($user) {
            echo json_encode($this->model->getEverything($user));
        }
    }
