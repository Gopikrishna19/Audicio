<?php
    class Projects extends Lib\Controller {
        public function __construct() {
            parent::__construct();
            $this->view->js[] = "angular";
            $this->view->js[] = "angular-route";
            $this->view->js[] = 'common';
            $this->view->css[] = "projects";
            $this->view->jsVar["a_user_id"] = Lib\Session::get("a_user_id");
        }

        public function index() {
            $this->view->css[] = 'projects-index';
            $this->view->js[] = 'projects-index';
            $this->view->renderView(__CLASS__,__FUNCTION__);
        }

        public function p($id = null) {
            if($id=='') { header('Location: /projects'); return; }
            $this->view->css[] = 'projects-p';
            $this->view->js[] = 'projects-p';
            $this->securedNav($id, $this->model->verifyProjectUser(Lib\Session::get("a_user_id"), $id), __FUNCTION__);
        }

        private function securedNav($project, $perm, $view) {
            switch($perm) {
                case 2:
                    $this->view->jsVar["a_project_owner"] = true;
                case 1:
                    $this->view->jsVar["a_project_id"] = $project;
                    $this->view->jsVar["a_project_name"] = $this->model->getProjectName($project);
                    $this->view->renderView(__CLASS__,$view);
                    break;
                case 0:
                default:
                    header("Location: /projects");
            }
        }

        public function team($id = null) {
            if($id=='') { header('Location: /projects'); return; }
            $this->view->css[] = 'projects-team';
            $this->view->js[] = 'projects-team';

            $project = $this->model->getProjectID($id);
            if($project):
                $this->view->jsVar['a_team_id'] = $id;
                $this->securedNav($project, $this->model->verifyProjectUser(Lib\Session::get("a_user_id"), $project), __FUNCTION__);
            else:
                header("Location: /projects");
            endif;
        }

        public function createProject() {
            $data = json_decode(file_get_contents("php://input"));
            $user = $data->user;
            $title = $data->title;
            $desc = $data->desc;

            $this->model->createProject($user, $title, $desc);
        }

        public function updateProject() {
            $data = json_decode(file_get_contents("php://input"));
            $id = $data->id;
            $name = $data->name;
            $desc = $data->desc;
            $this->model->updateProject($id, $name, $desc);
        }

        public function deleteProject($project) {
            $this->model->deleteProject($project);
        }

        public function getCreated($user){
            echo json_encode($this->model->getCreatedProjects($user));
        }

        public function getJoined($user){
            echo json_encode($this->model->getJoinedProjects($user));
        }

        public function getTeams($project) {
            echo json_encode($this->model->getTeams($project));
        }

        public function getMilestones($project) {
            echo json_encode($this->model->getMilestones($project));
        }

        public function getCategories() {
            echo json_encode($this->model->getCategories());
        }

        public function createTeam() {
            $data = json_decode(file_get_contents("php://input"));
            $project = $data->project;
            $name = $data->name;
            $desc = $data->desc;
            $catid = $data->catid;

            $this->model->createTeam($project, $name, $desc, $catid);
        }

        public function getProjectInfo($project) {
            echo json_encode($this->model->getProjectInfo($project));
        }

        public function getTeamInfo($team) {
            echo json_encode($this->model->getTeamInfo($team));
        }

        public function updateTeam() {
            $data = json_decode(file_get_contents("php://input"));
            $id = $data->id;
            $name = $data->name;
            $desc = $data->desc;
            $catid = $data->catid;
            $this->model->updateTeam($id, $name, $desc, $catid);
        }

        public function deleteTeam($team) {
            $this->model->deleteTeam($team);
        }

        public function deleteMember($team, $user) {
            $this->model->deleteTeamMember($team, $user);
        }

        public function getTeamMembers($team) {
            echo json_encode($this->model->getTeamMembers($team));
        }

        public function createTask() {
            $data = json_decode(file_get_contents("php://input"), true);
            unset($data['done']);
            unset($data['person']);
            echo $this->model->createtask($data);
        }

        public function getTeamTasks($team) {
            echo json_encode($this->model->getTasks($team));
        }

        public function updateTask() {
            $data = json_decode(file_get_contents("php://input"), true);
            $id = $data['id'];
            unset($data['id']);
            $this->model->updateTask($id, $data);
        }

        public function deleteTask($task) {
            $this->model->deleteTask($task);
        }

        public function createAudition() {
            $data = json_decode(file_get_contents("php://input"), true);
            echo $this->model->createAudition($data);
        }

        public function updateAudition() {
            $data = json_decode(file_get_contents("php://input"), true);
            $id = $data['id'];
            unset($data['id']);
            $this->model->updateAudition($id, $data);
        }

        public function getAuditions($team) {
            echo json_encode($this->model->getAuditions($team));
        }

        public function getAudition($audition) {
            echo json_encode($this->model->getAudition($audition));
        }

        public function updateCandidate() {
            $data = json_decode(file_get_contents("php://input"));
            $status = $data->status;
            $candidate = $data->candidate;
            $team = $data->team;
            $user = $data->user;

            switch($status) {
                case 3:
                    $this->inviteCandidate($user, $team);
                case 0:
                    $this->model->deleteCandidate($candidate);
                    break;
                default:
                    $this->model->updateCandidate($candidate, $status);
            }
        }

        public function closeAudition($audition) {
            $this->model->deleteAudition($audition);
        }

        public function getInvites($team) {
            echo json_encode($this->model->getInvites($team));
        }

        public function deleteInvite($invite) {
            $this->model->deleteInvite($invite);
        }

        public function getUninvited($team) {
            echo json_encode($this->model->getUninvited($team, $_GET['key']));
        }

        public function inviteCandidate($user, $team) {
            $this->model->inviteCandidate($user, $team);
        }
    }
?>