<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userId = $_COOKIE['user_id'];
    
    //Get Variables
    $id = $_POST["item"];
    $price = $_POST["price"];
    $itemname = $_POST["name"];
    
    //Grab User's Coins
    $query = 'SELECT kindnessCount FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $coins = intval($result['kindnessCount']);
    
    //Check is Kindness Shop Item
    $query = 'SELECT * FROM kindnessShop WHERE item_id = :id AND daily = 1';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $check = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($check) {
        
    } else {
        header("Location: ../");
    }
    
    //Check Coins
    if ($coins < $price) {
        //If Under Price, Return to Seed Shop With Error
            $reply = "You do not have enough kindness coins.";
            $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":user_id", $userId);
            $stmt->bindParam(":message", $reply);
            $stmt->execute();
        header("Location: ../kindnessshop");
    } else {
        //Remove Coins
        $query = 'UPDATE users SET kindnessCount = kindnessCount - :price WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->bindParam(":price", $price);
        $stmt->execute();
        
        //Check Dye
        if (str_ends_with($itemname, "Gold")) {
            $color = "Gold";
        } else if (str_ends_with($itemname, "Silver")) {
            $color = "Silver";
        }
        
        //Grab Item Info
        $query = 'SELECT * FROM itemList WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $item = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($item['name'] == "Bandana") {
            $newName = 'Bandana [' . $color . ']';
        } else {
            $newName = $item['name'];
        }
        
        //Add Item to Inventory
        if ($color) {
            $query = "INSERT INTO items (list_id, user_id, name, display, description, type, rarity, canDonate, dye) VALUES (:list, :user, :name, :display, :description, :type, :rarity, :canDonate, :dye);";
        } else {
            $query = "INSERT INTO items (list_id, user_id, name, display, description, type, rarity, canDonate) VALUES (:list, :user, :name, :display, :description, :type, :rarity, :canDonate);";
        }
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":list", $id);
        $stmt->bindParam(":user", $userId);
        $stmt->bindParam(":name", $newName);
        $stmt->bindParam(":display", $item['display']);
        $stmt->bindParam(":description", $item['description']);
        $stmt->bindParam(":type", $item['type']);
        $stmt->bindParam(":rarity", $item['rarity']);
        $stmt->bindParam(":canDonate", $item['canDonate']);
        if ($color) {
            $stmt->bindParam(":dye", $color);
        }
        $stmt->execute();
        
        //Update +1 to User Records
        $query = 'UPDATE users SET itemsBought = itemsBought + 1 WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
    
        //Set Response Message
        if ($color) {
            $greeting = "You have purchased 1 " . $item['display'] . ' [' . $color . ']';
        } else {
            $greeting = "You have purchased 1 " . $item['display'];
        }
            $reply = $greeting;
        $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":message", $reply);
        $stmt->execute();
        //Reroute to Seed Shop
        header("Location: ../kindnessshop");
    }
    
    
} else {
    header("Location: ../kindnessshop");
}
