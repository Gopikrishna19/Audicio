<?php
    class Profile_Model extends Lib\Model {
        public function __construct() {
            parent::__construct();
        }

        public function updateUser($data, $id) {
            $this->db->update("user", $data, "id = '$id'");
        }

        public function getTalents() {
            return $this->db->select("select t.id, c.name, t.subcat, t.talent from talents t join categories c on t.catid = c.id");
        }

        public function addTalent($user, $talent) {
            $this->db->insert("usertalent", ['userid' => $user, 'talid' => $talent]);
        }

        public function userTalents($user) {
            return $this->db->select("select talid from usertalent where userid = :userid", [":userid" => $user]);
        }

        public function removeTalent($user, $talent) {
            $this->db->delete("usertalent", "userid = '$user' and talid = '$talent'");
        }

        public function setInit($id) {
            $this->db->update("user", ['init' => 1], "id = '$id'");
        }

        public function getUserInfo($email) {
            return $this->db->select("select id, lname, fname, dob, intro, init from user where email = :email", [":email" => $email]);
        }

        public function getAuditions($id) {
            $arr = $id == null ? array() : [':aid' => $id];
            $whr = $id == null ? "" : "where a.id = :aid";
            return $this->db->select(
                "select a.id, a.title, a.desc, u.id as userid, concat(u.fname, ' ', u.lname) as uname, a.schedule, a.location, ".
                "c.name as cat, c.class from audition a join team t on t.id = a.teamid join project p ".
                "on p.id = t.prjid join user u on u.id = p.userid join categories c on c.id = t.catid ".$whr, $arr);
        }

        public function getAuditionStatus($aud, $user) {
            $ad = json_decode(json_encode($this->getAuditions($aud)[0]));
            if($ad->userid == $user) return ['status' => 'owner', 'code' => 4];
            $status = $this->db->select('select status from candidate where userid = :uid and audid = :aid', [":uid" => $user, ":aid" => $aud]);
            $stat = count($status) > 0 ? $status[0]['status'] : null;
            if($stat != null) {
                if($stat == 1) return ['status' => 'applied', 'code' => 1];
                else if($stat == 2) return ['status' => 'selected', 'code' => 2];
            }
            $invite = $this->db->select("select i.id from invite i join team t on t.id = i.teamid join audition a ".
                "on a.teamid = t.id where i.userid = :uid and a.id = :aid", [":uid" => $user, ":aid" => $aud]);
            $invite = count($invite) > 0 ? $invite[0] : null;
            if($invite != null) return ['status' => 'invited', 'code' => 3];
            return ['status' => 'apply', 'code' => 0, 'data' => print_r($stat, true)];
        }

        public function applyAudition($aud, $user) {
            $this->db->insert("candidate", ["audid" => $aud, "userid" => $user]);
            return $this->getAuditionStatus($aud, $user);
        }

        private function getVideos($user) {
            return $this->db->select("select * from video where userid = :id", [":id" => $user]);
        }

        private function getImages($user) {
            return $this->db->select("select * from image where userid = :id", [":id" => $user]);
        }

        public function getMedia($user) {
            return ['images' => $this->getImages($user), 'videos' => $this->getVideos($user)];
        }

        public function toggleVisibility($type, $id, $visible) {
            $this->db->update($type, ["visible" => $visible], "id = $id");
        }

        public function deleteMedia($type, $id) {
            $this->db->delete($type, "id = $id");
        }

        public function deleteProfile($user) {
            $this->db->delete("user", "id = $user");
        }

        public function getInvites($user) {
            return $this->db->select("select i.id, concat(u.fname, ' ', u.lname) as uname, u.id as uid, p.name as pname ".
                "from invite i join team t on t.id = i.teamid join project p on p.id = t.prjid join user u ".
                "on u.id = p.userid where i.userid = :id", [":id" => $user]);
        }

        public function acceptInvite($invite) {
            $data = $this->db->select("select teamid, userid from invite where id = :id", [":id" => $invite])[0];
            $this->db->insert("member", ["userid" => $data['userid'], "teamid" => $data['teamid']]);
            $this->declineInvite($invite);
        }

        public function declineInvite($invite) {
            $this->db->delete("invite", "id = $invite");
        }

        public function getNotifications($user) {
            return $this->db->select("select * from notification where userid is NULL or userid = :id ".
                "order by time desc limit 50", [":id" => $user]);
        }

        public function getTask($task) {
            return $this->db->select("select t.*, p.id as pid, p.name as pname from task t join team m on m.id = t.teamid ".
                "join project p on p.id = m.prjid where t.id = :id", [":id" => $task]);
        }
    }
?>