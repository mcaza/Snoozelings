<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
//Grab Form Variables
    $pronouns = $_POST["pronouns"];
    $status = $_POST["status"];
    $friends = $_POST["friends"];
    $messages = $_POST["messages"];
    $bonded = $_POST["bonded"];
    $userId = $_SESSION['user_id'];
    $farmName = $_POST['farm'];
    $mailbox = $_POST['mailbox'];
    
    //Update Pronouns, Friend Requests, and Message Requests
    $query = "UPDATE users SET pronouns = :pronouns, blockRequests = :friends, blockMessages = :messages WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":pronouns", $pronouns);
    $stmt->bindParam(":messages", $messages);
    $stmt->bindParam(":friends", $friends);
    $stmt->execute();
    
    //Updated Bonded Pet
    if ($bonded) {
        $query = "UPDATE users SET bonded = :bonded WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":bonded", $bonded);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
        
        $query = "SELECT name FROM snoozelings WHERE id = :bonded";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":bonded", $bonded);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $_SESSION['bonded'] = htmlspecialchars($result['name']);
    }
    
    //Update Mailbox Color
    if ($mailbox) {
        $query = 'UPDATE users SET mailbox = :mailbox WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":mailbox", $mailbox);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
    }
    
    //Update Status
    if ($status) {
        $query = "UPDATE users SET status = :status WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
    }
    
    //Update Farm Name
    if ($farmName) {
        $query = "UPDATE users SET farmName = :farmName WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":farmName", $farmName);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
    }
    
    header("Location: ../profile?id=" . $userId);
    
    
    
} else {
    header("Location: ../index.php");
}
