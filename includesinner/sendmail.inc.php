<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") { 
    $userId = $_COOKIE['user_id'];
    $sending = $_POST['to'];
    $title = $_POST['title'];
    $message = $_POST['reply'];
    $express = $_POST['speedSend'];
    $zero = 0;
    $one = 1;
    
    $now = new DateTime("now", new DateTimezone('UTC'));
    $result = $now->format('Y-m-d H:i:s');
    
    $query = 'INSERT INTO mail (sender, reciever, title, message, sent, opened, sendtime) VALUES (:sender, :reciever, :title, :message, :sent, :opened, :sendtime)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":sender", $userId);
    $stmt->bindParam(":reciever", $sending);
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":message", $message);
    if ($express) {
        $stmt->bindParam(":sent", $one);
    } else {
        $stmt->bindParam(":sent", $zero);
    }
    $stmt->bindParam(":opened", $zero);
    $stmt->bindParam(":sendtime", $result);
    $stmt->execute();
    
    //Take 2 Coins if Express Post
    if ($express) {
        $price = 2;
        $query = 'UPDATE users SET coinCount = coinCount - :price WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->bindParam(":price", $price);
        $stmt->execute();
    }
    
    $reply = "Your letter is in the postbox and will be delivered soon.";
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
    
    header("Location: ../mailbox");

    
} else {
     header("Location: ../mailbox");
}