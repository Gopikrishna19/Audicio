<?php
    class Profile extends Lib\Controller {
        public function __construct() {
            parent::__construct();
            $this->view->js[] = "angular";
            $this->view->js[] = "angular-route";
            $this->view->js[] = "common";
            $this->view->jsVar["a_user_id"] = Lib\Session::get("a_user_id");
            $this->view->jsVar["a_host_name"] = Audicio;
        }

        public function index() {
            $this->view->model = $this->model->getUserInfo(Lib\Session::get("a_user_email"))[0];
            if($this->view->model['init'] == 0) { header("Location: /profile/config"); return; }
            $this->view->css[] = "profile-index";
            $this->view->js[] = "angular-sanitize";
            $this->view->js[] = "profile-index";
            $this->view->js[] = "profile-media";
            $this->view->renderView(__CLASS__, __FUNCTION__);
        }

        public function config() {
            $this->view->css[] = "profile-config";
            $this->view->js[] = "aws-sdk";
            $this->view->js[] = "profile-media";
            $this->view->js[] = "profile-config";
            $this->view->renderView(__CLASS__, __FUNCTION__);
        }

        public function update() {
            $data = json_decode(json_encode($_POST));
            $arr = ["fname" => $data->fname, "lname" => $data->lname, "dob" => $data->dob, "intro" => $data->desc];
            if(strlen($data->upass) > 0) $arr["upass"] = md5(sha1($data->upass));
            $this->model->updateUser($arr, $data->id);
        }

        public function talents() {
            $data = $this->model->getTalents();

            $root = [];
//            echo "<pre>";
//            echo json_encode($data, JSON_PRETTY_PRINT);
            for($i = 0; $i < sizeof($data); ++$i) {
                $root[$data[$i]["name"]][$data[$i]["subcat"]][$data[$i]["id"]] = $data[$i]["talent"];
            }
            echo json_encode($root, JSON_PRETTY_PRINT);
        }

        public function addTalent($user, $talent) {
            $this->model->addTalent($user, $talent);
        }

        public function userTalents($user) {
            echo json_encode($this->model->userTalents($user));
        }

        public function removeTalent($user, $talent) {
            $this->model->removeTalent($user, $talent);
        }

        public function setInit($id) {
            $this->model->setInit($id);
        }

        public function userInfo() {
            echo json_encode($this->model->getUserInfo(Lib\Session::get("a_user_email"))[0]);
        }

        public function getAuditions($id = null) {
            echo json_encode($this->model->getAuditions($id));
        }

        public function getAuditionStatus($aud, $user) {
            echo json_encode($this->model->getAuditionStatus($aud, $user));
        }

        public function applyAudition($aud, $user) {
            echo json_encode($this->model->applyAudition($aud, $user));
        }

        public function getMedia($user) {
            echo json_encode($this->model->getMedia($user));
        }

        public function toggleMedia($type, $id, $visible) {
            $this->model->toggleVisibility($type, $id, $visible);
        }

        public function deleteMedia($type, $id) {
            $this->model->deleteMedia($type, $id);
        }

        public function deleteProfile($user) {
            $this->model->deleteProfile($user);
        }
    }
?>