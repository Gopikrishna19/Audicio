<?php
    class Home_Model extends Lib\Model {
        public function __construct() {
            parent::__construct();
        }

        public function getUserInfo($email) {
            return $this->db->select("select id, email, init, verify from user where email = :email", [":email" => $email]);
        }

        public function getUserLogin($email, $upass) {
            return $this->db->select("select id, email, init, verify from user where email = :email and upass = :upass",
                [":email" => $email, ":upass" => $upass]);
        }

        public function createUser($email, $verify = 0, $password = null) {
            return $this->db->insert("user", ["email" => $email, "verify" => $verify, "upass" => $password]);
        }

        public function verifyUser($email) {
            $this->db->update("user", ["verify" => 1], "email = '$email'");
        }
    }