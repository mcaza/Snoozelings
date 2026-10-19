<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") { 
    $userId = $_COOKIE['user_id'];
    $trade = $_POST['trade'];
    
    //Check if Trade is Live and Check User
    $query = "SELECT * FROM plushieTrades WHERE id = :id  AND user_id = :user";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $trade);
    $stmt->bindParam(":user", $userId);
    $stmt->execute();
    $tradeCheck = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($tradeCheck) {
        
    } else {
        header("Location: ../");
        die();
    }
    
    //Letter to all Offers
    $query = "SELECT * FROM plushieOffers WHERE trade_id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $trade);
    $stmt->execute();
    $offers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $title = 'Plushie Trade Deletion';
    $sender = 5;
    $zero = 0;
    $one = 1;
    $picture = "ProfileMail";
    $now = new DateTime();
    $date = $now->format('Y-m-d H:i:s');
    foreach ($offers as $offer) {
        
        $message = 'Your plushie trade offer of <b>1x ' . $offer['displayName'] . '</b> on Trade #' . $tradeCheck['id'] . ' (<b>1x ' . $tradeCheck['displayName'] . '</b>) has been removed as the user has decided to delete the trade.

        Please don\'t let this discourage you from Plushie Trading in the future.';
        $query = 'INSERT INTO mail (sender, reciever, title, message, sent, opened, sendtime, picture) VALUES (:sender, :reciever, :title, :message, :sent, :opened, :sendtime, :picture)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":sender", $sender);
        $stmt->bindParam(":reciever", $offer['user_id']);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":message", $message);
        $stmt->bindParam(":sent", $one);
        $stmt->bindParam(":opened", $zero);
        $stmt->bindParam(":sendtime", $date);
        $stmt->bindParam(":picture", $picture);
        $stmt->execute();
    }
    
    //Delete all Offers
    $query = 'DELETE FROM plushieOffers WHERE trade_id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $trade);
    $stmt->execute();
    
    //Delete Trade
    $query = 'DELETE FROM plushieTrades WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $trade);
    $stmt->execute();
    
    //Reply Message
    $greeting = 'Trade has successfully been deleted.';
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




