<?php

    require_once 'dbh-inc.php';

$query = 'SELECT * FROM earlyaccess';
$stmt = $pdo->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($users as $user) {
    //Send Email
    $address = $user['email'];
    $title ="Snoozelings Early Access Reminder";
    
    $msg = '<h2>Email Confirmation</h2> <p>Hey there ' . $user['email'] . '!!!<br><br>This is your reminder that Early Access launches September 1st at 3PM EST!!! <br><br>Here is a link to our official countdown: <a href="https://www.timeanddate.com/countdown/launch?iso=20240901T15&p0=250&msg=Snoozelings+Early+Access+Launch&font=cursive&csz=1">Click Here!!!</a><br><br>Below is your Early Access Code. You will need this to log in. Please copy/paste it into the registration box to avoid any errors during registration.<br><br><b>Account ID:</b> ' . $user['chosenID'] . '<br><br><b>Early Access Code: </b>' . $user['code'] . '<br><br>See you soon,<br><i>Snoozelings</i></p>';

     // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    //From
    $headers .= 'From: Snoozelings <autoreply@snoozelings.com>' . "\r\n";

    mail($address, $title, $msg, $headers);
    
    //Reply and Reroute
    $reply = "Email Sent.";
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
}