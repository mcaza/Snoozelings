<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $username = $_POST["username"];
    
    if(!$email || !$username) {
        $_SESSION["reply"] = "You must enter both your email and username to change your password.";
        header("Location: ../helpme");
        die();
    }
    
    //Grab User Info
    $query = 'SELECT username, email, id FROM users WHERE email = :email';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Check if Email Exists
    if (!$user) {
        $_SESSION["reply"] = "There is no account associated with that email.";
        header("Location: ../helpme");
        die();
    }
    
    //Check if Email Matches Username
    if (!($username === $user['username'])) {
        $_SESSION["reply"] = "That username and email do not match. Please try again.";
        header("Location: ../helpme");
        die();
    }
    
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
    $stmt->bindParam(":id", $user['id']);
    $stmt->bindParam(":tempCode", $randomString);
    $stmt->execute();
    
    //Send Email
    $address = $user['email'];

    $title ="Snoozelings Password Reset";
    $msg = '<h2>Password Reset</h2> <p>Dear ' . $user['username'] . ',<br><br>Someone using your account - hopefully you - has requested a code to reset the password.<br><br>You can use the link below to change your password. If the link doesn\'t work, you can also copy & paste the code on the <a href="https://snoozelings.com/helpme">Help Me Page</a>.<br><br><a href="https://snoozelings.com/helpme?code=' . $randomString . '">Click Here to Change Password</a></p><h1>' . $randomString . '</h1><p>If you did not personally request a password change, please reset your password immediately.<br><br>See you soon,<br><i>Snoozelings</i></p>';

    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    //From
    $headers .= 'From: Snoozelings <autoreply@snoozelings.com>' . "\r\n";

    mail($address, $title, $msg, $headers);
    
    $_SESSION["reply"] = "A password reset code has been sent to the email on file.";
        header("Location: ../helpme");
    
} else {
    header("Location: ../index");
}