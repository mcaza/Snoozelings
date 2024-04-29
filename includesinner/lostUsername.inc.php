<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    
    //Check if Email Exists
    $query = 'SELECT username, email FROM users WHERE email = :email';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Check if Email Exists
    if(!$user) {
        $_SESSION["reply"] = "There is no account associated with that email.";
        header("Location: ../helpme");
        die();
    }
    
    //Send Email
    $address = $user['email'];

    $title ="Snoozelings Lost Username";
    $msg = '<h2>Lost Username</h2> <p>Dear ' . $user['username'] . ',<br><br>Someone using your account - hopefully you - has requested your username. As such, we are providing your username in an email. Hope this helps you log back in.<h1>' . $user['username'] . '</h1><p>If you did not personally request your username, please reset your password immediately.<br><br>See you soon,<br><i>Snoozelings</i></p>';

    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    //From
    $headers .= 'From: Snoozelings <autoreply@snoozelings.com>' . "\r\n";

    mail($address, $title, $msg, $headers);
    
    //Reply & Redirect
    $_SESSION["reply"] = "An email has been sent containing your username.";
    header("Location: ../helpme");
} else {
    header("Location: ../index");
}