<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") { 
    $userId = $_COOKIE['user_id'];
    $plushie = $_POST['plushie'];
    $type = $_POST['type'];
    $anon = $_POST['anon'];
    if ($_POST['notes']) {
        $notes = $_POST['notes'];
    } else {
        $notes = null;
    }
    if ($_POST['private']) {
        $private = $_POST['private'];
    } else {
        $private = null;
    }
    
    
    //Check for Post That Day Already
    $query = "SELECT * FROM users WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result['plushTrades'] == 1) {
        $greeting = 'You have already posted a Plushie Trade today.';
        $reply = $greeting;
        $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":message", $reply);
        $stmt->execute();
        header("Location: ../plushMarket");
    }
    
    //Check that user has plushie
    $query = "SELECT * FROM items WHERE name = :name AND user_id = :user";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $plushie);
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
    
    $query = "SELECT * FROM plushieTrades WHERE plushie = :name AND user_id = :user";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $plush);
    $stmt->bindParam(":user", $userId);
    $stmt->execute();
    $offersCheck = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($itemCheck) > count($offersCheck)) {
        
    } else {
        $reply = "You have already listed this plushie in another trade.";
        $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":message", $reply);
        $stmt->execute();
        header("Location: ../plushMarket");
        die();
    }
    
    //Date
    $now = new DateTime("now", new DateTimezone('UTC'));
    $hours = 168;
    $modified = (clone $now)->add(new DateInterval("PT{$hours}H")); 
    $formatted = $modified->format('Y-m-d H:i:s');
    
    //Post Trade
    $query = 'INSERT INTO plushieTrades (user_id, plushie, displayName, type, anon, expiry, description, private) VALUES (:user_id, :plushie, :displayName, :type, :anon, :expiry, :description, :private)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":plushie", $plushie);
    $stmt->bindParam(":displayName", $itemCheck[0]['display']);
    $stmt->bindParam(":type", $type);
    $stmt->bindParam(":anon", $anon);
    $stmt->bindParam(":expiry", $formatted);
    $stmt->bindParam(":description", $notes);
    $stmt->bindParam(":private", $private);
    $stmt->execute();
    
    
    //Edit Trade Status
    $query = "UPDATE users SET requests = 1 WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    
    //Reply Message
    $greeting = 'Your trade has successfully been posted.';
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




















