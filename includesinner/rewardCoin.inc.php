<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //Get Values
    $userId = $_COOKIE['user_id'];
    $id = $_POST['user'];
    $reason = $_POST['reason'];
    
    //Make sure Slothie
    if (!($userId == "1")) {
        header("Location: ../index");
        die();
    }
    
    //Give Coin
    $query = 'UPDATE users SET kindnessCount = kindnessCount + 1 WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    
    //Send Mail
    $message = 'A special gift for you as thanks for:
    
    ' . $reason . '
    
    Enjoy your coin!!
    
    ~Melody the Kindness Keeper';
    $title = "You've been rewarded a Kindness Coin";
    $from = 8;
    $one = 1;
    $zero = 0;
    $picture = "kindnessNPC";
    $now = new DateTime("now", new DateTimezone('UTC'));
    $date = $now->format('Y-m-d H:i:s');
    $query = "INSERT INTO mail (sender, reciever, title, message, sent, opened, sendtime, picture) VALUES (:from, :to, :title, :message, :sent, :opened, :datetime, :picture)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":from", $from);
    $stmt->bindParam(":to", $id);
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":message", $message);
    $stmt->bindParam(":sent", $one);
    $stmt->bindParam(":opened", $zero);
    $stmt->bindParam(":datetime", $date);
    $stmt->bindParam(":picture", $picture);
    $stmt->execute();
    
    //Daily Records
    $query = 'UPDATE dailyRecords SET kindnessCoins = kindnessCoins + 1 ORDER BY id DESC LIMIT 1';
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    //Reroute
        $reply = "Your letter has been sent.";
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
    header("Location: ../mailbox");
    
} else {
header("Location: ../index");
    die();
}