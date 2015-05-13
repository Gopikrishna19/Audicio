<?php
    use Lib\Session as Session;

    class Home extends Lib\Controller {
        public function __construct() {
            parent::__construct(false);
            $this->view->css[] = "home";
        }
    
        public function index() {
            $email = Session::get('a_user_email');
            if($email) {
                $user = $this->model->getUserInfo($email);
                $user = json_decode(json_encode($user[0]));
                $this->doLogin($user);
                return;
            }

            $this->view->css[] = "home-index";
            $this->view->js[] = "home-index";
            $this->view->renderView(__CLASS__, __FUNCTION__);
        }

        public function logout() {
            Session::stop();
            header("Location: /");
        }

        public function login() {
            $this->view->css[] = "home-login";
            $this->view->js[] = "home-login";
            if(!isset($_POST['email'])) { header("Location: /"); return; }
            $email = $_POST['email'];
            $this->view->msgs = ["email" => base64_encode($email)];
            $method = isset($_REQUEST['m']) ? $_REQUEST['m'] : "normal";
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
                default:
                    //header("Location: /");
                    $error = new Error(503);
                    $error->index();
                    return;
            }
            $user = json_decode(json_encode($user[0]));
            if($user->verify == 0) {
                $this->view->renderView(__CLASS__, __FUNCTION__);
            } else {
                $this->doLogin($user);
            }
        }

        private function doLogin($user) {
            Session::set("a_user_id", $user->id);
            Session::set("a_user_email", $user->email);

            echo $user->init;
            print_r($_SESSION);

            if($user->init == 0) {
                header("Location: /profile/config");
            } else {
                header("Location: /profile");
            }
        }

        public function verify($email) {
            $email = base64_decode($email);
            $this->model->verifyUser($email);
            $user = $this->model->getUserInfo($email);
            if(count($user) > 0) {
                $user = json_decode(json_encode($user[0]));
                $this->doLogin($user);
            } else {
                $error = new Error(410);
                $error->index();
            }
        }

        public function emailExists($email, $login = 1, $password = "") {
            $email = base64_decode($email);
            if($login == 1) {
                $password = base64_decode($password);
                $user = $this->model->getUserLogin($email, md5(sha1($password)));
            }
            else $user = $this->model->getUserInfo($email);
            if(count($user) > 0) echo "true";
            elseif(count($user) == 0) echo "false";
            else http_response_code(400);
        }

        public function sendVerifyMail($email) {
            $email = base64_decode($email);
            include_once "Aws/ses.php";
            $link = Audicio."/home/verify/".base64_encode($email);
            $msg  = "";
            $msg .= "<h1 style='color:#3498db'>";
            $msg .= "<img src='http://audicio-s3-bucket.s3.amazonaws.com/assets/logo.png' alt='Audicio'></h1>";
            $msg .= "<h3>Welcome to Audicio</h3>";
            $msg .= "<p>We welcome you to experience Audicio. You are one click away.</p>";
            $msg .= "<p>Please click <a href='$link'>here</a> to verify your email address";
            $msg .= "<p>Or paste the following link in your browser: <p>";
            $msg .= "<a href='$link'>$link</a>";
            $msg .= "<p>If you are not the intended recipient please ignore this.</p>";

            sendEmail([$email], "Audicio - verify email", $msg);
            echo "Success.";
        }
    }
?>