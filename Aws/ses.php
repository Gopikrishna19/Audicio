<?php
function sendEmail($to, $subject, $body) {
    include_once "sdk.php";

    $client = $aws->get('Ses');

    $msg = array();
    $msg['Source'] = "sandalblack19@gmail.com";

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