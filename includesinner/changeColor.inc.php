<?php
require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $userId = $_COOKIE['user_id'];
    $snoozeling = $_POST["snoozelingid"];
    $color = $_POST["colorid"];
    $part = $_POST["bodypart"];
    
    //Check Still have Wish Token
    $query = 'SELECT * FROM items WHERE user_id = :id AND list_id = 225';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $check = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($check) {
        
    } else {
        header("Location: ../index");
        die();
    }
    
    //Check if Pet is owned by them
    $query = 'SELECT * FROM snoozelings WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $snoozeling);
    $stmt->execute();
    $petcheck = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($petcheck['owner_id'] == $userId) {
        
    } else {
        header("Location: ../index");
        die();
    }
    
    //Update Color
    if ($part == "Main") {
        $query = 'UPDATE snoozelings SET mainColor = :color WHERE id = :id';
    } else if ($part == "Skin") {
        $query = 'UPDATE snoozelings SET noseColor = :color WHERE id = :id';
    } else if ($part == "Eye") {
        $query = 'UPDATE snoozelings SET eyeColor = :color WHERE id = :id';
    } else if ($part == "Hair") {
        $query = 'UPDATE snoozelings SET hairColor = :color WHERE id = :id';
    } else if ($part == "Tail") {
        $query = 'UPDATE snoozelings SET tailColor = :color WHERE id = :id';
    }
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $snoozeling);
    $stmt->bindParam(":color", $color);
    $stmt->execute();
    
    //Delete Wish Token
    $query = 'DELETE FROM items WHERE user_id = :id AND list_id = 225 LIMIT 1';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    
    $reply = "Your wish has come true!";
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
    header("Location: ../pack");
    die();
} else {
    header("Location: ../index");
    die();
}