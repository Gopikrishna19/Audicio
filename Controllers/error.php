<?php
    class Error extends Lib\Controller {
        private $error_list = array(
            400 => "Bad Request",
            401 => "Unauthorized",            
            404 => "Resource Not Found",
            408 => "Request Timeout",
            410 => "Resouce no longer exists",
            420 => "Method Failure",
            500 => "Internal Server Error",
            503 => "Service Unavailable"
        );

        public function __construct($num = 404) {
            parent::__construct();
            $this->num = $num;
        }

        public function index() {
            //$this->view->title = "Error"; 
            //$this->view->num = $this->num;
            //$this->view->message = $this->error_list[$this->num];

            //$this->view->css[] = "error";
            //
            //if(!User::name()) $this->view->setHeader("header-home");

            //$this->view->renderView(__CLASS__,__FUNCTION__);

            echo $this->num.", ".$this->error_list[$this->num];
        }
    }
?>
