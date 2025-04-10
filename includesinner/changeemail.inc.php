<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = strtolower($_POST["email"]);
    $password = $_POST['password'];
    $userId = $_COOKIE['user_id'];
    
    //Get Hash
    $query = 'SELECT password FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Check Password
    if(!password_verify($pwd, $result['password'])) {
            $reply = "Password entered is not correct.";
        $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":message", $reply);
        $stmt->execute();
        header("Location: ../updateaccount");
        die();
    }
    
    //Verify Email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $reply = "This email could not be validated.";
        $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":message", $reply);
        $stmt->execute();
        header("Location: ../updateaccount");
        die();
    }
    
    //Check if Email Exists
    $query = 'SELECT username FROM users WHERE email = :email';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result) {
            $reply = "That email is currently associated with another account.";
        $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":message", $reply);
        $stmt->execute();
        header("Location: ../updateaccount");
        die();
    }
    
    //Change Email & Reset emailVerified
    $zero = 0;
    $query = 'UPDATE users SET email = :email, emailVerified = :zero WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":zero", $zero);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    
    //Send Email
    $address = $user['email'];

    $title ="Snoozelings Email Confirmation";
    $msg = '<h2>Email Confirmation</h2> <p>Dear ' . $user['username'] . ',<br><br>Someone using your account - hopefully you - has changed the email. Therefore, we are sending you this code to verify your new email.<br><br>You can use the link below to verify your email. If the link doesn\'t work, you can also copy & paste the code below.<br><br><a href="https://snoozelings.com/verify?code=' . $randomString . '">Click Here to Verify Email</a></p><h1>' . $randomString . '</h1><p>If you did not personally attempt to log in to your account just now, please contact us.<br><br>See you soon,<br><i>Snoozelings</i></p>';

    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    //From
    $headers .= 'From: Snoozelings <autoreply@snoozelings.com>' . "\r\n";

    mail($address, $title, $msg, $headers);
    
    
    //Reroute
        $reply = "Please check your email account to verify your new email.";
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
    header("Location: ../updateaccount");
    die();
} else {
header("Location: ../index");
    die();
}

















