<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    //Get Variables
    $userId = $_COOKIE['user_id'];
    $id = $_POST["item"];
    $price = $_POST["price"];
    
    
    //Grab User's Coins
    $query = 'SELECT coinCount FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $coins = intval($result['coinCount']);
    
    if ($coins < $price) {
        //If Under Price, Return to Seed Shop With Error
            $reply = "You do not have enough snooze coins.";
            $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":user_id", $userId);
            $stmt->bindParam(":message", $reply);
            $stmt->execute();
        header("Location: ../clothingshop");
        die();
    } else {
        //Remove Coins
        $query = 'UPDATE users SET coinCount = coinCount - :price WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->bindParam(":price", $price);
        $stmt->execute();
        
        //Grab Item Info
        $query = 'SELECT * FROM itemList WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $item = $stmt->fetch(PDO::FETCH_ASSOC);
        
        //Add Item to Inventory
        $query = "INSERT INTO items (list_id, user_id, name, display, description, type, rarity, canDonate) VALUES (:list, :user, :name, :display, :description, :type, :rarity, :canDonate);";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":list", $id);
        $stmt->bindParam(":user", $userId);
        $stmt->bindParam(":name", $item['name']);
        $stmt->bindParam(":display", $item['display']);
        $stmt->bindParam(":description", $item['description']);
        $stmt->bindParam(":type", $item['type']);
        $stmt->bindParam(":rarity", $item['rarity']);
        $stmt->bindParam(":canDonate", $item['canDonate']);
        $stmt->execute();
        
        //Update +1 to User Records
        $query = 'UPDATE users SET itemsBought = itemsBought + 1 WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
        
        //Set Response Message
        $greeting = "You have purchased 1 " . $item['display'] . '.';
        $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":message", $greeting);
        $stmt->execute();
    }
    
     //Reroute to Clothing Shop
     header("Location: ../clothingshop");
    
    
} else {
    header("Location: ../clothingshop");
}
