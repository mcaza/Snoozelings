<?php

require_once '../includes/dbh-inc.php';
require_once '../includes/config_session.inc.php';

$one = 1;
$query = 'SELECT * FROM users WHERE newsletter = :one';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":one", $one);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($users as $user) {
//Send Email
    $address = $user['email'];

    $title ="Newsletter Tests";
    $msg = '<h2>Newsletter Test</h2> <p>Dear ' . $user['username'] . ',<br><br>Do not be afraid. This is only a test of the Snoozelings Newsletter System.<br><br><img src="https://snoozelings.com/resources/freeitemNPC.png"><br><br>See you soon,<br><i>Snoozelings</i></p>';

    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    //From
    $headers .= 'From: Snoozelings <autoreply@snoozelings.com>' . "\r\n";

    mail($address, $title, $msg, $headers);

}

echo 'Mail Sent';