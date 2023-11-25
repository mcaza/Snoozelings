<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userId = $_SESSION['user_id'];
    
    //Get Variables
    $id = $_POST["item"];
    $price = $_POST["price"];
    
    //Grab User's Coins
    $query = 'SELECT kindnessCount FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $coins = intval($result['kindnessCount']);
    
    //Check Coins
    if ($coins < $price) {
        //If Under Price, Return to Seed Shop With Error
        $_SESSION['reply'] = "You do not have enough kindness coins.";
        header("Location: ../kindnessshop");
    } else {
        //Remove Coins
        $query = 'UPDATE users SET kindnessCount = kindnessCount - :price WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->bindParam(":price", $price);
        $stmt->execute();
        
        //Grab Seed Info
        $query = 'SELECT * FROM itemList WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $item = $stmt->fetch(PDO::FETCH_ASSOC);
        
        //Add Seed to Inventory
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
        $_SESSION['reply'] = "You have purchased 1 " . $item['display'] . '.';
    
        //Reroute to Seed Shop
        header("Location: ../kindnessshop");
    }
    
    
} else {
    header("Location: ../kindnessshop");
}
