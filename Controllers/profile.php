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

        public function getInvites($user) {
            echo json_encode($this->model->getInvites($user));
        }

        public function acceptInvite($invite) {
            $this->model->acceptInvite($invite);
        }

        public function declineInvite($invite) {
            $this->model->declineInvite($invite);
        }

        public function getNotifications($user) {
            $nots = ($this->model->getNotifications($user)); $op = "";
            for($i = 0; $i < count($nots); ++$i) {
                $not = json_decode(json_encode($nots[$i]));
                $time = date("d M, Y h:i a", strtotime($not->time));
                $msg = json_decode($not->message);

                switch($msg->type) {
                    case "new-audition":
                        $aud = json_decode(json_encode($this->model->getAuditions($msg->id)[0]));

                        $op .= '<div class="entry aud new-audition">
                                    <div class="timestamp">on '.$time.'</div>
                                    <div class="title">
                                        New audition <a class="audition" href="/profile#audition/'.$aud->id.'">'.$aud->title.'</a>
                                        by <a class="author" href="/@'.$aud->userid.'/'.$aud->uname.'">'.$aud->uname.'</a>
                                        scheduled on '.date("d M, Y h:i a", strtotime($aud->schedule)).'
                                    </div>
                                </div>';
                        break;
                    case "audition-info g":
                        $aud = json_decode(json_encode($this->model->getAuditions($msg->audid)[0]));

                        $op .= '<div class="entry aud audition-info g">
                                    <div class="timestamp">on '.$time.'</div>
                                    <div class="title">
                                        New update from <a class="audition" href="/profile#audition/'.$aud->id.'">'.$aud->title.'</a>
                                    </div>
                                    <div class="content">
                                        Congratulations! You have been shortlisted for the audition.</div>
                                    </div>';
                        break;
                    case "audition-info b":
                        $aud = json_decode(json_encode($this->model->getAuditions($msg->audid)[0]));

                        $op .= '<div class="entry aud audition-info b">
                                    <div class="timestamp">on '.$time.'</div>
                                    <div class="title">
                                        New update from <a class="audition" href="/profile#audition/'.$aud->id.'">'.$aud->title.'</a>
                                    </div>
                                    <div class="content">
                                        The audition has been updated. Please view the new information from the link above.
                                    </div>
                                </div>';
                        break;
                    case "audition-info r":
                        $aud = json_decode(json_encode($this->model->getAuditions($msg->audid)[0]));

                        $op .= '<div class="entry aud audition-info r">
                                    <div class="timestamp">on '.$time.'</div>
                                    <div class="title">
                                        New update from <a class="audition" href="/profile#audition/'.$aud->id.'">'.$aud->title.'</a>
                                    </div>
                                    <div class="content">
                                        We regret to tell you that the audition has found you as not an ideal candidate at the time.
                                    </div>
                                </div>';
                        break;
                    case "new-task":
                        $task = json_decode(json_encode($this->model->getTask($msg->id)[0]));

                        $op .= '<div class="entry prj new-task">
                                    <div class="timestamp">on '.$time.'</div>
                                    <div class="title">
                                        A new task from
                                        <a class="author" href="/projects/p/'.$task->pid.'">Project</a>
                                        for '.($msg->user ? 'you' : 'everyone' ).'
                                    </div>
                                    <div class="content">'.$task->task.'</div>
                                </div>';
                        break;
                    case "notify g":
                        $op .= '<div class="entry not notify g">
                                    <div class="timestamp">on '.$time.'</div>
                                    <div class="title">Your <a href="/profile#profile/media">video</a> was successfully uploaded,
                                    optimized and ready for public</div>
                                </div>';
                        break;
                }
            }

            echo $op;
        }
    }
?>