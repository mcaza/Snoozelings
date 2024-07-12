<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //Get Values
    $userId = $_SESSION['user_id'];
    $id = $_POST['id'];
    
    //Get Crafting Table Info
    $query = 'SELECT * FROM craftingtables WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Get Job
    $query = "SELECT job, name FROM snoozelings WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $result['pet_id']);
    $stmt->execute();
    $snooze = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Get Item Info
    $query = 'SELECT * FROM itemList WHERE name = :name';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $result['name']);
    $stmt->execute();
    $item = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Add Item
    $query = "INSERT INTO items (list_id, user_id, name, display, description, type, rarity, canDonate) VALUES (:list, :user, :name, :display, :description, :type, :rarity, :canDonate);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":list", $item['id']);
    $stmt->bindParam(":user", $userId);
    $stmt->bindParam(":name", $item['name']);
    $stmt->bindParam(":display", $item['display']);
    $stmt->bindParam(":description", $item['description']);
    $stmt->bindParam(":type", $item['type']);
    $stmt->bindParam(":rarity", $item['rarity']);
    $stmt->bindParam(":canDonate", $item['canDonate']);
    $stmt->execute();
    
    //Reset Table
    $null = "";
    $datetime = new datetime('0-0-0 0:0:0');
    $query = 'UPDATE craftingtables SET recipe_id = 0, display = :null, name = :null, finishtime = NULL WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":null", $null);
    $stmt->execute();
    
    if ($snooze['job'] === "Crafter") {
        //Add EXP to Pet
        $query = 'UPDATE snoozelings SET craftEXP = craftEXP + 1 WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $result['pet_id']);
        $stmt->execute();
    }
    
    
    //Add +1 Journal to Daily Record
    $query = 'UPDATE dailyRecords SET itemsCrafted = itemsCrafted + 1';
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    //Update +1 to User Records
    $query = 'UPDATE users SET itemsCrafted = itemsCrafted + 1 WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    
    //Reply & Reroute
    $_SESSION['reply'] = $result['display'] . ' has been added to your inventory.';
    header("Location: ../crafting");
    
} else {
    header("Location: ../index");
    die();
}
