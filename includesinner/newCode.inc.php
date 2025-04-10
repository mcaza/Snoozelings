<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

$userId = $_COOKIE['user_id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if(!$userId) {
        header("Location: ../login");
        die();
    }
    
    //Get User Info 
    $query = 'SELECT email, username FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Create New Code
    $length = 8;
    $characters = '0123456789abcdefghijklmnopqrs092u3tuvwxyzaskdhfhf9882323ABCDEFGHIJKLMNksadf9044OPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    
    //Replace with New Code
    $query = 'UPDATE users SET tempCode = :tempCode WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":tempCode", $randomString);
    $stmt->execute();
    
    //Send Email
    $address = $user['email'];

    $title ="Snoozelings Email Confirmation";
    $msg = '<h2>Email Confirmation</h2> <p>Dear ' . $user['username'] . ',<br><br>Someone using your account - hopefully you - has requested a new email verification code. This could happen if you clicked the "New Code" button, recently registered, or have recently changed your email.<br><br>You can use the link below to verify your email. If the link doesn\'t work, you can also copy & paste the code below.<br><br><a href="https://snoozelings.com/verify?code=' . $randomString . '">Click Here to Verify Email</a></p><h1>' . $randomString . '</h1><p>If you did not personally attempt to log in to your account just now, please reset your password immediately.<br><br>See you soon,<br><i>Snoozelings</i></p>';

    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    //From
    $headers .= 'From: Snoozelings <autoreply@snoozelings.com>' . "\r\n";

    if(mail($address, $title, $msg, $headers)) {
        $reply = "A new code has been sent. Please check your email.";
        $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":message", $reply);
        $stmt->execute();
        header("Location: ../verify");
    }
    
    
        
} else {
    header("Location: ../index");
}