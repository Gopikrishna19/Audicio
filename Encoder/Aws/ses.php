<?php

include "autoload.php";

use Aws\Common\Aws;

function sendEmail($to, $subject, $body) {
    $aws = Aws::factory('Aws/aws-config.php');

    $client = $aws->get('Ses');

    $msg = "<h1 style='color:#3498db'>";
    $msg .= "<img src='http://audicio-s3-bucket.s3.amazonaws.com/assets/logo.png' alt='Audicio'></h1>";
    $body = $msg.$body;

    $msg = array();
    $msg['Source'] = "Audicio <sandalblack19@gmail.com>";

    $msg['Destination']['ToAddresses'] = $to;

    $msg['Message']['Subject']['Data'] = $subject;
    $msg['Message']['Subject']['Charset'] = "UTF-8";

    $msg['Message']['Body']['Html']['Data'] = $body;
    $msg['Message']['Body']['Html']['Charset'] = "UTF-8";

    try {
        $result = $client->sendEmail($msg);
        return $result->get('MessageId');
    } catch (Exception $e) {
        echo($e->getMessage());
    }
}