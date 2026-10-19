<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userId = $_COOKIE['user_id'];
    
    //Check Tutorial Level
    $query = "SELECT * FROM users WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user['tutorial'] == 13) { 
        $query = 'UPDATE users SET tutorial = 14 WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
    } else {
        header("Location: ../");
    }
    
    //Add Pet Bed
    $bed = 155;
    $zero = 0;
    
    $query = 'SELECT * FROM itemList WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $bed);
    $stmt->execute();
    $item = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $query = "INSERT INTO items (list_id, user_id, name, display, description, type, rarity, canDonate) VALUES (:list, :user, :name, :display, :description, :type, :rarity, :canDonate);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":list", $bed);
    $stmt->bindParam(":user", $userId);
    $stmt->bindParam(":name", $item['name']);
    $stmt->bindParam(":display", $item['display']);
    $stmt->bindParam(":description", $item['description']);
    $stmt->bindParam(":type", $item['type']);
    $stmt->bindParam(":rarity", $item['rarity']);
    $stmt->bindParam(":canDonate", $zero);
    $stmt->execute();
    
    //Add Farm Plot
    $bed = 114;
    $zero = 0;
    
    $query = 'SELECT * FROM itemList WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $bed);
    $stmt->execute();
    $item = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $query = "INSERT INTO items (list_id, user_id, name, display, description, type, rarity, canDonate) VALUES (:list, :user, :name, :display, :description, :type, :rarity, :canDonate);";
        $stmt = $pdo->prepare($query);
    $stmt->bindParam(":list", $bed);
    $stmt->bindParam(":user", $userId);
    $stmt->bindParam(":name", $item['name']);
    $stmt->bindParam(":display", $item['display']);
    $stmt->bindParam(":description", $item['description']);
    $stmt->bindParam(":type", $item['type']);
    $stmt->bindParam(":rarity", $item['rarity']);
    $stmt->bindParam(":canDonate", $zero);
    $stmt->execute();
        
    header("Location: ../");
    
} else {
    header("Location: ../");
}



