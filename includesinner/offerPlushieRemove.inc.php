<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") { 
    $userId = $_COOKIE['user_id'];
    $trade = $_POST['plushieOffer'];
    $id = $_POST['trade'];
    
    //Check for Trade
    $query = "SELECT * FROM plushieTrades WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $tradeCheck = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($tradeCheck) {
        
    } else {
        header("Location: ../");
        die();
    }
    
    //Check for Offer
    $query = "SELECT * FROM plushieOffers WHERE id = :id AND user_id = :user";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $trade);
    $stmt->bindParam(":user", $userId);
    $stmt->execute();
    $offerCheck = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($offerCheck) {
        
    } else {
        header("Location: ../");
        die();
    }
    
    //Remove Offer
    $query = 'DELETE FROM plushieOffers WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $trade);
    $stmt->execute();
    
    //Reply Message
    $greeting = 'You have removed your offer on ' . $tradeCheck['displayName'] . '.';
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