<?php
    class Search_Model extends \Lib\Model {
        public function __construct() {
            parent::__construct();
        }

        public function getResults($key) {
            $people = $this->db->select("select id, concat(fname, ' ', lname) as name from user ".
                "where fname regexp :key or lname regexp :key or intro regexp :key", [":key" => $key]);
            $auditions = $this->db->select(
                "select a.id, a.title from audition a join team t on t.id = a.teamid join project p ".
                "on p.id = t.prjid join user u on u.id = p.userid join categories c on c.id = t.catid ".
                "where a.title regexp :key or a.location regexp :key or a.desc regexp :key ".
                "or u.fname regexp :key or u.lname regexp :key", [":key" => $key]);
            return ["users" => $people, "auditions" => $auditions];
        }
    }