<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    //Get Values
    $id = $_POST['sender'];
    $userId = $_COOKIE['user_id'];

    
    
    
    //Delete Request
    $query = 'DELETE FROM friendRequests WHERE newFriend = :id AND sender = :sender;';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":sender", $id);
    $stmt->execute();

    //Reply & Reroute to Friend Page
    $reply = "The friend request has been deleted.";
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
    
    header("Location: ../friends");
} else {
    header("Location: ../index");
}