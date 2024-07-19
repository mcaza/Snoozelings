<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

//Get Variables
    $userId = $_SESSION['user_id'];
    
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
    
    //Return
    header("Location: ../dyes");
    
} else {
header("Location: ../");
    die();
}
