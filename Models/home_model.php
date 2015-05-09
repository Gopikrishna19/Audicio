<?php
    class Home_Model extends Lib\Model {
        public function __construct() {
            parent::__construct();
        }

        public function getUserInfo($email) {
            return $this->db->select("select id, email, init, verify from user");
        }

        public function createUser($email, $verify = 0, $password = null) {
            return $this->db->insert("user", ["email" => $email, "verify" => $verify, "upass" => $password]);
        }
    }