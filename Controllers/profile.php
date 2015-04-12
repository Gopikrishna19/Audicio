<?php
    class Profile extends Lib\Controller {
        public function __construct() {
            parent::__construct();
        }
    
        public function index() {
            echo $_REQUEST['email'];
        }
    }
?>