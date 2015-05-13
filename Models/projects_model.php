<?php
    class Projects_Model extends Lib\Model {
        public function __construct() {
            parent::__construct();
        }

        public function createProject($user, $title, $desc) {
            date_default_timezone_set('America/New_York');
            $prjid = $this->db->insert("project", ["userid" => $user, "name" => $title, "desc" => $desc]);
            $this->db->insert("milestone", ["prjid" => $prjid, "status" => 1, "date" => date("Y-m-d")]);
        }

        public function getProjectName($id) {
            return $this->db->select("select name from project WHERE id = :id", [":id" => $id])[0]["name"];
        }

        public function getProjectID($team) {
            $prj =$this->db->select("select p.id from project p join team t on t.prjid = p.id ".
                "WHERE t.id = :id", [":id" => $team]);
            if(isset($prj[0])) return $prj[0]["id"];
            else return NULL;
        }

        public function updateProject($id, $name, $desc) {
            $this->db->update("project", ["name" => $name, "desc" => $desc], "id = $id");
        }

        public function deleteProject($project) {
            $this->db->delete("project", "id = $project");
        }

        public function verifyProjectUser($user, $project) {
            $usr = $this->db->select("select id from project where userid = :uid and id = :pid",
                [":uid" => $user, ":pid" => $project]);
            if(count($usr) == 0) {
                $usr = $this->db->select("select t.id from team t join member m on t.id = m.teamid ".
                    "where t.prjid = :pid and m.userid = :uid", [":uid" => $user, ":pid" => $project]);
                if(count($usr) == 0) return 0;
                else return 1;
            }
            return 2;
        }

        public function getTeams($project) {
            $teams = $this->db->select("select id, name, `desc` from team where prjid = :prjid", [":prjid" => $project]);
            for($i = 0; $i < count($teams); ++$i) {
                $id = $teams[$i]['id'];
                $teams[$i]['members'] = $this->getTeamMembers($id);
            }
            return $teams;
        }

        public function getTeamMembers($team) {
            return $this->db->select("select u.id, u.fname, u.lname from member m ".
                "join user u on m.userid = u.id where m.teamid = :id", [":id" => $team]);
        }

        public function getMilestones($project) {
            return $this->db->select("select * from milestone where prjid = :prjid", [":prjid" => $project]);
        }

        public function getCategories() {
            return $this->db->select("select * from categories");
        }

        public function createTeam($project, $name, $desc, $catid) {
            $this->db->insert("team", ["prjid" => $project, "name" => $name, "desc" => $desc, "catid" => $catid]);
        }

        public function getProjectInfo($project) {
            return $this->db->select("select * from project where id = :id", [":id" => $project])[0];
        }

        public function getTeamInfo($team) {
            $t = $this->db->select("select * from team where id = :id", [":id" => $team])[0];
            $t['members'] = $this->getTeamMembers($team);
            return $t;
        }

        public function updateTeam($id, $name, $desc, $catid) {
            $this->db->update("team", ["name" => $name, "desc" => $desc, "catid" => $catid], "id = $id");
        }

        public function deleteTeam($team) {
            $this->db->delete("team", "id = $team");
        }

        public function deleteTeamMember($team, $user) {
            $this->db->delete("member", "userid = $user and teamid = $team");
        }

        public function createTask($data) {
            return $this->db->insert("task", $data);
        }

        public function getTasks($team) {
            return $this->db->select("select * from task where teamid = :team order by id desc", [":team" => $team]);
        }

        public function updateTask($id, $data) {
            $this->db->update("task", $data, "id = $id");
        }

        public function deleteTask($task) {
            $this->db->delete("task", "id = $task");
        }

        public function createAudition($data) {
            return $this->db->insert("audition", $data);
        }

        public function updateAudition($id, $data) {
            $this->db->update("audition", $data, "id = $id");
        }

        public function getAuditions($team) {
            return $this->db->select("select id, title, (SELECT COUNT(*) from candidate where audid = a.id) as cnum ".
                "from audition a where teamid = :teamid", [":teamid" => $team]);
        }

        public function getAudition($audition) {
            $a =  $this->db->select("select * from audition where id = :id", [":id" => $audition]);
            if(count($a) > 0) {
                $a = $a[0];
                $a["candidates"] = $this->db->select("select c.*, concat(u.fname, ' ', u.lname) as name from candidate c ".
                    "join user u on u.id = c.userid where audid = :id", [":id" => $audition]);
                return $a;
            }
            return NULL;
        }

        public function deleteCandidate($candidate) {
            $this->db->delete("candidate", "id = $candidate");
        }

        public function updateCandidate($candidate, $status) {
            $this->db->update("candidate", ["status" => $status], "id = $candidate");
        }

        public function inviteCandidate($user, $team) {
            $this->db->insert("invite", ["userid" => $user, "teamid" => $team]);
        }

        public function deleteAudition($audition) {
            $this->db->delete("audition", "id = $audition");
        }

        public function getInvites($team) {
            return $this->db->select("select i.*, concat(u.fname, ' ', u.lname) as name from invite i ".
                "join user u on i.userid = u.id where teamid = :team", [":team" => $team]);
        }

        public function deleteInvite($invite) {
            $this->db->delete("invite", "id = $invite");
        }

        public function getUninvited($team, $key) {
            return $this->db->select("select id, concat(fname, ' ', lname) as name from user ".
                "WHERE id not in (SELECT userid from invite WHERE teamid = :tid) ".
                "and (lname regexp :key or fname regexp :key)", [":key" => $key, ":tid" => $team]);
        }
    }