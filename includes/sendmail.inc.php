<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") { 
    $userId = $_SESSION['user_id'];
    $sending = $_POST['to'];
    $title = $_POST['title'];
    $message = $_POST['reply'];
    $zero = 0;
    
    $now = new DateTime(null, new DateTimezone('UTC'));
    $result = $now->format('Y-m-d H:i:s');
    
    $query = 'INSERT INTO mail (sender, reciever, title, message, sent, opened, sendtime) VALUES (:sender, :reciever, :title, :message, :sent, :opened, :sendtime)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":sender", $userId);
    $stmt->bindParam(":reciever", $sending);
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":message", $message);
    $stmt->bindParam(":sent", $zero);
    $stmt->bindParam(":opened", $zero);
    $stmt->bindParam(":sendtime", $result);
    $stmt->execute();
    
    $_SESSION['reply'] = "Your letter is in the postbox and will be delivered soon.";
    
    header("Location: ../mailbox");

    
} else {
     header("Location: ../mailbox");
}