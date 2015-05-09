<?php
    use Lib\Session as Session;

    class Home extends Lib\Controller {
        public function __construct() {
            parent::__construct();
        }
    
        public function index() {
            $this->view->css[] = "home";
            $this->view->js[] = "home";
            $this->view->renderView(__CLASS__, __FUNCTION__);
        }

        public function login() {
            if(!isset($_POST['email'])) { header("Location: /"); return; }
            $email = $_POST['email'];
            $this->view->msgs = ["email" => $email];
            $method = isset($_GET['m']) ? $_GET['m'] : "normal";
            $this->view->msgs["method"] = $method;
            switch($method) {
                case "fb":
                case "gp":
                    $user = $this->model->getUserInfo($email);
                    if($user == null) { // registration
                        $this->model->createUser($email, 1);
                        $user = $this->model->getUserInfo($email);
                    } // else login
                    break;
                case "reg": // registration
                    $this->model->createUser($email, 0, md5(sha1($_POST['upass'])));
                case "log": // login
                    $user = $this->model->getUserInfo($email);
                    break;
            }
            $user = json_decode(json_encode($user[0]));
            $this->view->msgs[] = print_r($user, true);
            if($user->verify == 0) {
                $this->view->msgs[] = "Pending Verification";
                $this->view->renderView(__CLASS__, __FUNCTION__);
            } else {
                Session::init();
                Session::set("a_user_id", $user->id);
                Session::set("a_user_email", $user->email);

                if($user->init == 0) {
                    header("Location: /profile/config");
                } else {
                    header("Location: /profile");
                }
            }
        }
    }
?>