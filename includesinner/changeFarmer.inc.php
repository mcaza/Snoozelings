<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

//Get Variables
    $userId = $_COOKIE['user_id'];
    $id = $_POST['snoozeling'];
    
    //Get Pet Info
    $query = 'SELECT * FROM snoozelings WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $pet = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Get User Info
    $query = 'SELECT * FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Make Sure Pet is Owned by User
    if (!($pet['owner_id'] == $userId)) {
        header("Location: ../index");
        die();
    }
    
    //Change Crafter
    $query = 'UPDATE users SET farmer = :id WHERE id = :user';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":user", $userId);
    $stmt->execute();
    
    //Reply
    $reply = $pet['name'] . " is now the lead farmer at " . $user['farmName'] . '.';
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
    
    header("Location: ../farm");
    
    
} else {
header("Location: ../index");
    die();
}
