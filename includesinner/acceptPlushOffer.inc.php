<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") { 
    $userId = $_COOKIE['user_id'];
    $trade = $_POST['plushieOffer'];
    $id = $_POST['trade'];
    
    //Check Trade is Live and User is Correct
    $query = "SELECT * FROM plushieTrades WHERE id = :id AND user_id = :user";
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
    
    //Check Trade Item in Inventory
    $query = "SELECT * FROM items WHERE name = :name AND user_id = :user";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $tradeCheck['plushie']);
    $stmt->bindParam(":user", $userId);
    $stmt->execute();
    $itemCheckOne = $stmt->fetch(PDO::FETCH_ASSOC);
    
    
    if ($itemCheckOne) {
        
    } else {
        $query = 'DELETE FROM plushieTrades WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        
        //Letter to all Offers
        $query = "SELECT * FROM plushieOffers WHERE trade_id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $tradeCheck['id']);
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
        $stmt->bindParam(":id", $tradeCheck['id']);
        $stmt->execute();
        
        $greeting = 'The item you are offering in this trade is no longer available.<br><br>The trade has been deleted.';
        $reply = $greeting;
        $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":message", $reply);
        $stmt->execute();
        header("Location: ../plushMarket");
        die();
    }
    
    //Check Offer Item in Inventory
    $query = "SELECT * FROM items WHERE name = :name AND user_id = :user";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $offerCheck['plushie']);
    $stmt->bindParam(":user", $offerCheck['user_id']);
    $stmt->execute();
    $itemCheckTwo = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($itemCheckTwo) {
        
    } else {
        $query = 'DELETE FROM plushieOffers WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $offerCheck['id']);
        $stmt->execute();
        
        $greeting = 'The item in this offer is no longer available.<br><br>The offer has been deleted.';
        $reply = $greeting;
        $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":message", $reply);
        $stmt->execute();
        header("Location: ../plushMarket");
        die();
    }
    
    //Update User for Trade Item
    $query = "UPDATE items SET user_id = :new WHERE user_id = :old AND name = :name LIMIT 1";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":new", $offerCheck['user_id']);
    $stmt->bindParam(":old", $userId);
    $stmt->bindParam(":name", $tradeCheck['plushie']);
    $stmt->execute();
    
    //Update User for Offer Item
    $query = "UPDATE items SET user_id = :new WHERE user_id = :old AND name = :name LIMIT 1";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":new", $userId);
    $stmt->bindParam(":old", $offerCheck['user_id']);
    $stmt->bindParam(":name", $offerCheck['plushie']);
    $stmt->execute();
    
    //Send Acceptance Letter
    $title = 'Plushie Offer Accepted';
    $sender = 5;
    $zero = 0;
    $one = 1;
    $picture = "ProfileMail";
    $now = new DateTime();
    $date = $now->format('Y-m-d H:i:s');
    $message = 'Congratulations! Your plushie trade offer of <b>1x ' . $offerCheck['displayName'] . '</b> on Trade #' . $tradeCheck['id'] . ' (<b>1x ' . $tradeCheck['displayName'] . '</b>) has been accepted.
    
    The ' . $tradeCheck['displayName'] . ' should now be in your inventory.';
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
    
    //Remove Accepted Offer
    $query = 'DELETE FROM plushieOffers WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $trade);
    $stmt->execute();
    
    //Grab Rejected Offers amd Send Letters
    $query = "SELECT * FROM plushieOffers WHERE trade_id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
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
        
        $message = 'Your plushie trade offer of <b>1x ' . $offer['displayName'] . '</b> on Trade #' . $tradeCheck['id'] . ' (<b>1x ' . $tradeCheck['displayName'] . '</b>) has been removed as the user has chosen another offer.

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
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    
    //Delete Trade
    $query = 'DELETE FROM plushieTrades WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    
    //Reply Message
    $greeting = 'You have accepted an offer of ' . $offerCheck['displayName'] . ' for your '. $tradeCheck['displayName'] . '.';
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