<?php

function sendMessage($msg) {
    include_once "sdk.php";

    $sqs = $aws->get("Sqs");

    $sqs->sendMessage([
            'QueueUrl' => 'https://sqs.us-west-2.amazonaws.com/379064688154/notifier-queue',
            'MessageBody' => $msg
        ]);
}