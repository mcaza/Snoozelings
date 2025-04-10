<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $tempname = $_POST['username'];
    $username = strtolower($_POST['username']);
    $pwd = $_POST['password'];
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
    
    //Check if Username is Taken
    $query = 'SELECT email FROM users WHERE usernamedata = :username';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result) {
            $reply = "That username is currently taken.";
        $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":message", $reply);
        $stmt->execute();
        header("Location: ../updateaccount");
        die();
    }
    
    //Change Username
    $query = 'UPDATE users SET username = :name, usernamedata = :data WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":name", $tempname);
    $stmt->bindParam(":data", $username);
    $stmt->execute();
        
    //Reply & Reroute
        $reply = "Your username has been changed.";
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



