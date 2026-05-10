<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

//Get Variables
    $userId = $_COOKIE['user_id'];
    
    //Get Crafting Table Info
    $query = 'SELECT * FROM craftingtables WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Get Dye Batch
    $query = 'SELECT * FROM dyebatches WHERE user_id = :id AND finished = 0';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $dyebatch = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($dyebatch) {
        
    } else {
        header("Location: ../");
    }
    
    //Add EXP to Pet
    $query = 'UPDATE snoozelings SET craftEXP = craftEXP + 1 WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $result['pet_id']);
    $stmt->execute();
    
    //Get Item Information
    $query = "SELECT * FROM itemList WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $dyebatch['item_id']);
    $stmt->execute();
    $itemInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Add Item
    $query = "INSERT INTO items (list_id, user_id, name, display, description, type, rarity, canDonate, dye) VALUES (:list, :user, :name, :display, :description, :type, :rarity, :canDonate, :dye);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":list", $itemInfo['id']);
    $stmt->bindParam(":user", $userId);
    $stmt->bindParam(":name", $itemInfo['name']);
    $stmt->bindParam(":display", $itemInfo['display']);
    $stmt->bindParam(":description", $itemInfo['description']);
    $stmt->bindParam(":type", $itemInfo['type']);
    $stmt->bindParam(":rarity", $itemInfo['rarity']);
    $stmt->bindParam(":canDonate", $itemInfo['canDonate']);
    $stmt->bindParam(":dye", $dyebatch['dye']);
    $stmt->execute();
    
    //Set Dye Batch to Finished
    $query = "UPDATE dyebatches SET finished = 1 WHERE user_id = :id AND finished = 0";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    
    //Reply & Reroute
    $greeting = $itemInfo['display'] . ' [' . $dyebatch['dye'] . '] has been added to your inventory.';
    $reply = $greeting;
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
    
    //Return
    header("Location: ../dyes");
    
} else {
header("Location: ../");
    die();
}
