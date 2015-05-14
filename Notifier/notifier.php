<?php
include "Config.php";
include "Database.php";
include "Aws/ses.php";

$msg = file_get_contents("php://input");
$fp = fopen('log.txt', 'a'); fwrite($fp, $msg."\n");
$msg = json_decode($msg);

$db = new Database();

switch($msg->type) {
    case "new-audition":
        $audid = $msg->id;
        $userid = $db->select("select id, email from user"); // [['id' => 1], ['id' => 2]]
        // $audition = $db->select("select title from audition where id = :audid", [":audid" => $audid]);
        for($i = 0; $i < count($userid); ++$i) {
            $email = $userid[$i]['email'];
            $body = "<h3>Announcement</h3>";
            $body .= "<p>A new audition is posted.</p>";
            $body .= "<p>Click <a href='".Audicio."/profile#audition/$audid'>here</a> to view the audition.</p>";
            $body .= "<p style='margin-top: 25px'>Best, <br>Audicio Team</p>";
            sendEmail([$email], "New Audition", $body);
        }
        $db->insert("notification", ["message" => json_encode($msg)]);
        break;
    case "audition-info g":
        $email = $db->select("select email from user where id = :userid", [":userid" => $msg->userid])[0]['email'];
        $title = $db->select("select title from audition where id = :audid", [":audid" => $msg->audid])[0]['title'];
        $audid = $msg->audid;
        $body = "<h3>Congratulations!</h3>";
        $body .= "<p>You have been shortlisted for the <b>".$title."</b> audition.</p>";
        $body .= "<p>Click <a href='".Audicio."/profile#audition/$audid'>here</a> to view the audition.</p>";
        $body .= "<p style='margin-top: 25px'>Best, <br>Audicio Team</p>";
        sendEmail([$email], "Congratulations!", $body);
        $db->insert("notification", ["message" => json_encode($msg), "userid" => $msg->userid]);
        break;
    case "audition-info r":
        $email = $db->select("select email from user where id = :userid", [":userid" => $msg->userid])[0]['email'];
        $title = $db->select("select title from audition where id = :audid", [":audid" => $msg->audid])[0]['title'];
        $audid = $msg->audid;
        $body = "<h3>Audicio Application Status Update</h3>";
        $body .= "<p>We regret to tell you that you are not the ideal candidate for the <b>".$title."</b> audition.</p>";
        $body .= "<p>Click <a href='".Audicio."/profile#audition/$audid'>here</a> to view the audition.</p>";
        $body .= "<p style='margin-top: 25px'>Best, <br>Audicio Team</p>";
        $db->insert("notification", ["message" => json_encode($msg), "userid" => $msg->userid]);
        sendEmail([$email], "Audition Status", $body);
        break;
    case "audition-info b":
        $audid = $msg->audid;
        $emails = $db->select("select userid, email from candidate c join user u on u.id = c.userid where c.audid = :audid", [":audid" => $audid]);
        $title = $db->select("select title from audition where id = :audid", [":audid" => $msg->audid])[0]['title'];
        for($i = 0; $i < count($emails); ++$i) {
            $email = $emails[$i]['email'];
            $userid = $emails[$i]['userid'];
            $body = "<h3>Audicio Update</h3>";
            $body .= "<p>A new update is available for the <b>" . $title . "</b> audition.</p>";
            $body .= "<p>Click <a href='" . Audicio . "/profile#audition/$audid'>here</a> to view the audition.</p>";
            $body .= "<p style='margin-top: 25px'>Best, <br>Audicio Team</p>";
            $db->insert("notification", ["message" => json_encode($msg), "userid" => $userid]);
            sendEmail([$email], "Audition Status", $body);
        }
        break;
    case "invite":
        $email = $db->select("select email from user where id = :userid", [":userid" => $msg->userid])[0]['email'];
        $title = $db->select("select title from audition where id = :audid", [":audid" => $msg->audid])[0]['title'];
        $team = $db->select("select name from team where id = :teamid", [":teamid" => $msg->teamid])[0]['name'];
        $body = "<h3>Congratualtions</h3>";
        $body .= "<p>From <b>".$title."</b> audition.</p>";
        $body .= "<p>You are invited to join the <b>$team</b> team. Please visit your profile to accept the invitation.</p>";
        $body .= "<p style='margin-top: 25px'>Best, <br>Audicio Team</p>";
        sendEmail([$email], "Congratulations!", $body);
        break;
    case "new-task":
        $task = $msg->id;
        $user = $msg->user;
        if($user == null) {
            $emails = $db->select("select u.id, u.email, t.task from user u ".
                "join member m on m.userid = u.id join task t on t.teamid = m.teamid where t.id = :id", [":id" => $task]);
            for($i = 0; $i < count($emails); ++$i) {
                $email = $emails[$i]['email'];
                $ttask = $emails[$i]['task'];
                $userid = $emails[$i]['id'];
                $body = "<h3>Team Update</h3>";
                $body .= "<p>A new task <b>$ttask</b> has been assigned to <b>Everyone</b> in team</p>";
                $body .= "<p>Please visit your projects for more details</p>";
                $body .= "<p style='margin-top: 25px'>Best, <br>Audicio Team</p>";
                $db->insert("notification", ["message" => json_encode($msg), "userid" => $userid]);
                sendEmail([$email], "New Task", $body);
            }
        } else {
            $email = $db->select("select email from user where id = :userid", [":userid" => $user])[0]['email'];
            $body = "<h3>Team Update</h3>";
            $body .= "<p>A new task has been assigned to you</p>";
            $body .= "<p>Please visit your projects for more details</p>";
            $body .= "<p style='margin-top: 25px'>Best, <br>Audicio Team</p>";
            $db->insert("notification", ["message" => json_encode($msg), "userid" => $user]);
            sendEmail([$email], "New Task", $body);
        }
    case "notify g":
        $video = $msg->id;
        $user = $db->select("select userid from video where id = :id", [":id" => $video])[0]['userid'];
        fwrite($fp, $user." ".$video."\n");
        $db->insert("notification", ["message" => json_encode($msg), "userid" => $user]);
}

fclose($fp);