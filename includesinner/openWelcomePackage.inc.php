<?php
require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $userId = $_COOKIE['user_id'];
    
    //Add Pet Bed, Bandana, Journal, Farm Plot, and Carrot Seed
    $items = [155,498,500,114,5];
    foreach ($items as $item) {
            $query = 'SELECT * FROM itemList WHERE id = :id';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $item);
            $stmt->execute();
            $iteminfo = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $query = "INSERT INTO items (list_id, user_id, name, display, description, type, rarity, canDonate) VALUES (:list, :user, :name, :display, :description, :type, :rarity, :canDonate);";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":list", $item);
            $stmt->bindParam(":user", $userId);
            $stmt->bindParam(":name", $iteminfo['name']);
            $stmt->bindParam(":display", $iteminfo['display']);
            $stmt->bindParam(":description", $iteminfo['description']);
            $stmt->bindParam(":type", $iteminfo['type']);
            $stmt->bindParam(":rarity", $iteminfo['rarity']);
            $stmt->bindParam(":canDonate", $iteminfo['canDonate']);
            $stmt->execute();
            } 
    
    //Remove Welcome Package
    $query = 'DELETE FROM items WHERE user_id = :id AND list_id = 499 LIMIT 1';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    
    //Update Tutorial to 4
    $query = 'UPDATE users SET tutorial = 4 WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    
    //Reply Message
    $greeting = "You open the Welcome Package and find:<br> 1 Pet Bed, 1 Bandana, 1 Journal, 1 Farm Planter, 1 Carrot Seed";
        $reply = $greeting;
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
    header("Location: ../pack");
    
    } else {
        header("Location: ../");
    }
    
        
