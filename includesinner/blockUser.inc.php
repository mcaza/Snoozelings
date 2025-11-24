<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //Get Values
    $userId = $_COOKIE['user_id'];
    $id = $_POST['user'];
    
    //User Info #1
    $query = 'SELECT * FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $blocker = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //User Info #2
    $query = 'SELECT * FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $blocked = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Updated Info
    if ($blocker['blockList']) {
        $blocks1 = $result['blockList'] . " " . $id;
    } else {
        $blocks1 = $id;
    }
    
    if ($blocked['blockedBy']) {
        $blocked1 = $result['blockedBy'] . " " . $userId;
    } else {
        $blocked1 = $id;
    }

    //Update User #1
    $query = 'UPDATE users SET blockList = :blocks WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":blocks", $blocks1);
    $stmt->execute();
    
    //Update User #2
    $query = 'UPDATE users SET blockedBy = :blocks WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":blocks", $blocked1);
    $stmt->execute();
    
    //Reply & Reroute to Friend Page
    $reply = "You have successfully blocked user " . $id . '.';
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
    header("Location: ../friends?id=" . $userId);
    die();
    
} else {
header("Location: ../index");
    die();
}