<?php

require_once '../includes/dbh-inc.php';
require_once '../includes/config_session.inc.php';

$address = "megan.caza@gmail.com";

$title ="Test Email";
$msg = '<h2>Test Body</h2> <p>sfff ae</p>';

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

//From
$headers .= 'From: Snoozelings <autoreply@snoozelings.com>' . "\r\n";

if (mail($address, $title, $msg, $headers)) {
    echo 'success';
} else {
    echo 'fail';
}

die();