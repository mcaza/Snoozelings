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
    
    //Make Sure Pet is Owned by User
    if (!($pet['owner_id'] == $userId)) {
        header("Location: ../index");
        die();
    }
    
    //Make Sure Pet has Correct Job
    if (!($pet['job'] === "jack" || $pet['job'] === "Crafter")) {
        header("Location: ../index");
        die();
    }
    
    //Make Sure Pet isn't Crafting
    $query = 'SELECT * FROM craftingtables WHERE user_id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $table = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!($table['display'] == NULL)) {
            $reply = "You cannot change pets while crafting.";
            $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":user_id", $userId);
            $stmt->bindParam(":message", $reply);
            $stmt->execute();
        header("Location: ../crafting");
        die();
    }
    
    //Change Crafter
    $query = 'UPDATE craftingtables SET pet_id = :id WHERE user_id = :user';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":user", $userId);
    $stmt->execute();
    header("Location: ../crafting");
    
    
} else {
header("Location: ../index");
    die();
}
