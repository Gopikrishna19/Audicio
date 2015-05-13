<?php
    class Portfolio_Model extends Lib\Model
    {
        public function __construct()
        {
            parent::__construct();
        }

        public function countUser($id) {
            return $this->db->select("select count(*) as c from user where id = :id", [":id" => $id])[0]["c"];
        }

        public function getEverything($id) {
            $prof = $this->db->select("select id, concat(fname, ' ', lname) as name, intro from user where id = :id", [":id" => $id])[0];
            $prof["projects"] = array_merge($this->getCreatedProjects($id), $this->getJoinedProjects($id));
            $prof["talents"] = $this->userTalents($id);
            $prof["achieves"] = $this->userAchieves($id);
            $prof["images"] = $this->db->select("select * from image where userid = :id and visible = 1", [":id" => $id]);
            $prof["videos"] = $this->db->select("select * from video where userid = :id and visible = 1", [":id" => $id]);
            return $prof;
        }

        public function userTalents($user) {
            return $this->db->select("select c.name, t.talent as talent from usertalent u ".
                "join talents t on t.id = u.talid join categories c on c.id = t.catid where u.userid = :id", [":id" => $user]);
        }
    }