<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") { 
    $userId = $_SESSION['user_id'];
    $mailID = $_POST['mail'];
    
    //Get Info
    $query = "SELECT * FROM mail WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $mailID);
    $stmt->execute();
    $mail = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Check Mail ID
    if ($mail['reciever'] == $userId) {
        
    } else {
        header("Location: ../index");
    }
    
    //Get TO + Title
    $sending = $mail['sender'];
    $title = "Re: " . $mail['title'];
    $message = htmlspecialchars($_POST['reply']);
    $zero = 0;
    $one = 1;
    
    $now = new DateTime("now", new DateTimezone('UTC'));
    $result = $now->format('Y-m-d H:i:s');
    
    if ($mail['anon'] == 1) {
        $query = 'INSERT INTO mail (sender, reciever, title, message, sent, opened, sendtime, anon, penpalid) VALUES (:sender, :reciever, :title, :message, :sent, :opened, :sendtime, :anon,:penpalid)';
    } else {
        $query = 'INSERT INTO mail (sender, reciever, title, message, sent, opened, sendtime) VALUES (:sender, :reciever, :title, :message, :sent, :opened, :sendtime)';
    }
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":sender", $userId);
    $stmt->bindParam(":reciever", $sending);
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":message", $message);
    $stmt->bindParam(":sent", $zero);
    $stmt->bindParam(":opened", $zero);
    $stmt->bindParam(":sendtime", $result);
    if ($mail['anon'] == 1) {
        $stmt->bindParam(":anon", $one);
        $stmt->bindParam(":penpalid", $mail['penpalid']);
    }
    $stmt->execute();
    
    $_SESSION['reply'] = "Your letter is in the postbox and will be delivered soon.";
    
    header("Location: ../mailbox");

    
} else {
     header("Location: ../index");
}