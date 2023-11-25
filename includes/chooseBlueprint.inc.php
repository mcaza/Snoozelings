<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //Get Values
    $userId = $_SESSION['user_id'];
    $bp = $_POST['snoozeling'];
    
    //Grab Breeding ID
    $query = "SELECT * FROM breedings WHERE user_id = :id ORDER BY id DESC LIMIT 1";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$bp) {
        $_SESSION['reply'] = "You must pick a snoozeling.";
        header("Location: ../blueprints?id=" . $result['id']);
    }
    
    $query = 'UPDATE breedings SET blueprint = :blueprint WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $result['id']);
    $stmt->bindParam(":blueprint", $bp);
    $stmt->execute();
    
    //Send Mail
    $title = 'Your Snoozeling Delivery';
    $sender = 6;
    $zero = 0;
    $picture = "sewingNPC";
    $now = new DateTime();
    $date = $now->format('Y-m-d H:i:s');
    $message = 'I\'ve finished your new snoozeling.
    
    You can use the link below to bring your new friend home.
    
    <strong style="font-size: 2.5rem"><a href="delivery?id=' . $bp . '">Click Here to Claim your Snoozeling</a></strong>';
    $query = 'INSERT INTO mail (sender, reciever, title, message, sent, opened, sendtime, picture) VALUES (:sender, :reciever, :title, :message, :sent, :opened, :sendtime, :picture)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":sender", $sender);
    $stmt->bindParam(":reciever", $userId);
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":message", $message);
    $stmt->bindParam(":sent", $zero);
    $stmt->bindParam(":opened", $zero);
    $stmt->bindParam(":sendtime", $date);
    $stmt->bindParam(":picture", $picture);
    $stmt->execute();
    
    $_SESSION['reply'] = 'I\'ll send your new snoozeling in the mail as soon as I\'m finished.';
    header("Location: ../stitcher?page=new");
    
} else {
header("Location: ../index");
    die();
}
