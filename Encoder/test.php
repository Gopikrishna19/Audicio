<?php
	$fp = fopen('test.txt','r');
	$msg = file_get_contents("test.txt");
	$msg = json_decode($msg);
	$row = $msg->Records[0]->s3->object->key;
	echo $row;
	$row = explode("/",$row);
	$fname = explode(".",$row[1])[0];
	if($row[0]==="video"){
		$file = file_get_contents("http://audicio-s3-bucket.s3.amazonaws.com/".implode("/",$row));
		@mkdir("source");
		@mkdir("dest");
		file_put_contents("source/".$row[1],$file);
		$cmd = "./bin/ffmpeg -i ./source/".$row[1]." -c:a libvo_aacenc -c:v libx264 -vf scale=480:'trunc((ih/iw)*240)' ./dest/".$fname.".mp4";
		echo $cmd;
		exec($cmd);
		}
	fclose($fp);
	

?>
