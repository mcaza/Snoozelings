<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") { 
    $userId = $_COOKIE['user_id'];
    $plush = $_POST['plushieOffer'];
    $id = $_POST['trade'];
    
    //Check Trade is Live
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
    
    //Check that user has plushie
    $query = "SELECT * FROM items WHERE name = :name AND user_id = :user";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $plush);
    $stmt->bindParam(":user", $userId);
    $stmt->execute();
    $itemCheck = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($itemCheck) {
        
    } else {
        header("Location: ../");
        die();
    }
    
    //Check That Plushie Isn't Being Offered Else Where (Count Minus Offers)
    $query = "SELECT * FROM plushieOffers WHERE plushie = :name AND user_id = :user";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $plush);
    $stmt->bindParam(":user", $userId);
    $stmt->execute();
    $offersCheck = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($itemCheck) > count($offersCheck)) {
        
    } else {
        $reply = "You have already offered this plushie on another trade.";
        $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":message", $reply);
        $stmt->execute();
        header("Location: ../plushMarket");
        die();
    }
    
    //Check Rarity
    $query = "SELECT * FROM plushies WHERE name = :name";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $plush);
    $stmt->execute();
    $rarityCheck = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($rarityCheck['rarity'] < $tradeCheck['type']) {
        header("Location: ../");
        die();
    }
    
    //Check for Block
    $query = "SELECT * FROM users WHERE id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $blockCheck = $stmt->fetch(PDO::FETCH_ASSOC);
    $blockList = explode(" ", $blockCheck["blockList"]);
    $blockedBy = explode(" ", $blockCheck["blockedBy"]);
    $block = 0;
     if (in_array($note['user_id'],$blockList)) {
         $block = 1;
     }
     if (in_array($note['user_id'],$blockedBy)) {
         $block = 1;
     }
    
    if ($block == 1) {
        $reply = "You are unable to make an offer on this plushie.";
        $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":message", $reply);
        $stmt->execute();
        header("Location: ../plushMarket");
        die();
    }
    
    
    //Item Info
    $query = "SELECT * FROM itemList WHERE name = :name";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $plush);
    $stmt->execute();
    $itemInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Post Offer
    $query = "INSERT INTO plushieOffers (trade_id, user_id, plushie, displayName) VALUES (:trade, :user, :plushie, :display);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":trade", $id);
    $stmt->bindParam(":user", $userId);
    $stmt->bindParam(":plushie", $plush);
    $stmt->bindParam(":display", $itemInfo['display']);
    $stmt->execute();
    
    
    //Reply Message
    $greeting = "You have successfully offered " . $itemInfo['display'] . ' for ' . $tradeCheck['displayName'] . '.';
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