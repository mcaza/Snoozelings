<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    //Get User Info
    $userId = $_COOKIE['user_id'];
    $query = "SELECT * FROM users WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Count Beds
    $query = "SELECT * FROM items WHERE user_id = :id AND list_id = 155";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $beds = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $total = $user['petBeds'] + count($beds);
    
//Calculate Bed Cost
if ($total == 2) {
    $amount = 5;
} else if ($total == 3) {
    $amount = 10;
} else if ($total == 4) {
    $amount = 20;
} else if ($total == 5) {
    $amount = 30;
} else if ($total == 6) {
    $amount = 40;
} else if ($total == 7) {
    $amount = 50;
} else if ($total == 8) {
    $amount = 75;
} 

//Coin Cost
if ($total == 2) {
    $coinAmount = 50;
} else if ($total == 3) {
    $coinAmount = 100;
} else if ($total == 4) {
    $coinAmount = 200;
} else if ($total == 5) {
    $coinAmount = 400;
} else if ($total == 6) {
    $coinAmount = 800;
} else if ($total == 7) {
    $coinAmount = 1600;
} else if ($total == 8) {
    $coinAmount = 3200;
} 
    
    //Check Feathers & Coins
    $query = "SELECT * FROM items WHERE user_id = :id AND list_id = 29";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $tiny = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $query = "SELECT * FROM items WHERE user_id = :id AND list_id = 41";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $colorful = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $query = "SELECT * FROM items WHERE user_id = :id AND list_id = 59";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $seagull = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($tiny) < $amount || count($colorful) < $amount || count($seagull) < $amount || $user['coinCount'] < $coinAmount || $total > 8) {
        header("Location: ../index");
        die();
    }
    
    //Create Pet Bed
    $item = 155;
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
    
    //Remove Items
    for ($i = 0; $i < $amount; $i++) {
        $query = "DELETE FROM items WHERE user_id = :id AND list_id = 29 LIMIT 1";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();

        $query = "DELETE FROM items WHERE user_id = :id AND list_id = 41 LIMIT 1";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();

        $query = "DELETE FROM items WHERE user_id = :id AND list_id = 59 LIMIT 1";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
    }
    
    $newCount = $user['coinCount'] - $coinAmount;
    $query = 'UPDATE users SET coinCount = :new WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":new", $newCount);
    $stmt->execute();
    
    //Set Message and Reroute
        $reply = '"So many feathers!!! Oh also your new bed is in your inventory."';
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
    header("Location: ../bedShop");
} else {
    header("Location: ../index");
    die();
}
