<?php
    namespace Lib;

    class Model {
        public function __construct() {
            $this->db = new Database();
        }

        public function getCreatedProjects($user) {
            return $this->db->select("select * from project where userid = :userid", [":userid" => $user]);
        }

        public function getJoinedProjects($user) {
            return $this->db->select("select p.* from member m join team t on m.teamid = t.id ".
                "join project p on p.id = t.prjid where m.userid = :uid", [":uid" => $user]);
        }

        public function userAchieves($user) {
            return $this->db->select("select * from achievement where userid = :userid", [":userid" => $user]);
        }
    }