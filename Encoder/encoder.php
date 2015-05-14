<?php
    include "Config.php";

    $msg = file_get_contents('php://input');
    $msg = json_decode($msg);

	$row = $msg->Records[0]->s3->object->key;
	$type = explode("/",$row)[1];
    $iname = explode("/",$row)[2];
    $fname = explode(".",$iname)[0];
    $fext = explode(".",$iname)[1];

    $fp = fopen("test.txt", "a"); fwrite($fp, $row." ".time()."\n"); fclose($fp);
    $farr = explode("-",$fname);

	if($type === "video" && isset($farr[1]) && $farr[1] != null){
		$file = file_get_contents("http://audicio-s3-bucket.s3.amazonaws.com/".$row);
		@mkdir("source");
		@mkdir("dest");

		file_put_contents("source/".$iname, $file);

		$cmd = "./bin/ffmpeg -y -i ./source/".$iname." -c:a libvo_aacenc -c:v libx264 -vf scale=480:'trunc((ih/iw)*240)*2' ./dest/".$fname.".mp4";
		exec($cmd);

        $db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
        $st = $db->prepare("insert into video(userid) values(:userid)");
        $st->bindValue(":userid", $farr[1]);
        $st->execute();
        $id = $db->lastInsertId();
        echo "$id";

        $upload_cmd = "aws s3 cp ./dest/".$fname.".mp4 s3://audicio-s3-bucket/user".$farr[1]."/video/video".$id.".mp4 --acl public-read-write";
        exec($upload_cmd);

        $delete_cmd = "aws s3 rm s3://audicio-s3-bucket/".$row;
        exec($delete_cmd);

        @unlink("source/".$iname);
        @unlink("dest/".$fname.".mp4");
	} else if($type == "image" && isset($farr[1]) && $farr[1] != null) {
        $db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
        $st = $db->prepare("insert into image(userid, ext) values(:userid, :ext)");
        $st->bindValue(":userid", $farr[1]);
        $st->bindValue(":ext", $fext);
        $st->execute();
        $id = $db->lastInsertId();
        echo "$id";

        $move_cmd = "aws s3 mv s3://audicio-s3-bucket/".$row.
            " s3://audicio-s3-bucket/user".$farr[1]."/image/image".$id.".".$fext." --acl public-read-write";
        exec($upload_cmd);
    }
?>


