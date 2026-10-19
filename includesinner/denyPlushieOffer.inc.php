<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") { 
    $userId = $_COOKIE['user_id'];
    $trade = $_POST['plushieOffer'];
    $id = $_POST['trade'];
    if ($_POST['notes']) {
        $notes = $_POST['notes'];
    } else {
        $notes = "<i>No Notes Provided</i>";
    }
    
    
    //Check Trade is Still Live. Check Trade Owner
    //Check for Trade
    $query = "SELECT * FROM plushieTrades WHERE id = :id  AND user_id = :user";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":user", $userId);
    $stmt->execute();
    $tradeCheck = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($tradeCheck) {
        
    } else {
        header("Location: ../");
        die();
    }
    
    //Check Offer is Still Live
    $query = "SELECT * FROM plushieOffers WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $trade);
    $stmt->execute();
    $offerCheck = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($offerCheck) {
        
    } else {
        header("Location: ../");
        die();
    }
    
    //Rejection Letter
    $title = 'Plushie Offer Rejection';
    $sender = 5;
    $zero = 0;
    $one = 1;
    $picture = "ProfileMail";
    $now = new DateTime();
    $date = $now->format('Y-m-d H:i:s');
    $message = 'Your plushie trade offer of <b>1x ' . $offerCheck['displayName'] . '</b> on <a href="plushPost?id=' . $tradeCheck['id'] . '">Trade #' . $tradeCheck['id'] . ' (<b>1x ' . $tradeCheck['displayName'] . '</b>)</a> has been rejected. It is also possible that the user has selected another offer.
    
    Please don\'t let this discourage you from Plushie Trading in the future.
    
    If there are any notes, I have included them below:
    
    <i>' . $notes . '</i>';
    $query = 'INSERT INTO mail (sender, reciever, title, message, sent, opened, sendtime, picture) VALUES (:sender, :reciever, :title, :message, :sent, :opened, :sendtime, :picture)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":sender", $sender);
    $stmt->bindParam(":reciever", $offerCheck['user_id']);
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":message", $message);
    $stmt->bindParam(":sent", $one);
    $stmt->bindParam(":opened", $zero);
    $stmt->bindParam(":sendtime", $date);
    $stmt->bindParam(":picture", $picture);
    $stmt->execute();
    
    
    //Delete Offer
    $query = 'DELETE FROM plushieOffers WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $trade);
    $stmt->execute();
    
    //Reply Message
    $greeting = 'You have removed an offer of ' . $offerCheck['displayName'] . ' from your trade.';
    $reply = $greeting;
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
    header("Location: ../plushMarket");
    
    } else {
        header("Location: ../");
    }









