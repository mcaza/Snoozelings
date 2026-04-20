<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';
require_once '../../includes/imageFunction.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //Grab Form Variables
    $userId = $_COOKIE['user_id'];
    $id = $_POST["item"];
    $petid = $_POST["pet"];
    if ($_POST["color"]) {
        $color = $_POST["color"];
    }
    
    //Fetch Color
    if ($color == "Basic") {
        
        $query = 'SELECT * FROM items WHERE list_id = :id AND user_id = :user AND dye IS NULL';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":user", $userId);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $name = $result['name'];
        
        $display = $result['display'];

    } else if ($color) {
        $query = 'SELECT * FROM items WHERE list_id = :id AND user_id = :user AND dye = :dye';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":user", $userId);
        $stmt->bindParam(":dye", $color);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $name = $result['name'] . $color;
        
        if ($color == "Gold" || $color == "Silver") {
            $display = $result['display'] . ' [' . $color . ']';
        } else {
            $query = 'SELECT * FROM dyes WHERE name = :name';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":name", $color);
        $stmt->execute();
        $dyedisplay = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $display = $result['display'] . ' [' . $dyedisplay['display'] . ']';
        }
        
        
    } else {
        $query = 'SELECT * FROM items WHERE list_id = :id AND user_id = :user';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":user", $userId);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $name = $result['name'];
        
        $display = $result['display'];
    }
    
    
    //Make sure item is in user inventory
    if (!$results) {
            $reply = "You do not own any of this item.";
        $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":message", $reply);
        $stmt->execute();
        header("Location: ../pack");
        die();
    }
    
    //Make sure item is clothing type
    $query = 'SELECT * FROM clothes WHERE list_id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $clothingCheck = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $itemName = $clothingCheck['name'] . $color;
    
    if(!$clothingCheck) {
        $reply = "This is not a clothing item.";
        $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":message", $reply);
        $stmt->execute();
        header("Location: ../pack");
        die();
    }
      
    //Fetch Current Pet Clothes of that Type. 
    $query = 'SELECT * FROM snoozelings WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $petid);
    $stmt->execute();
    $pet = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Check if Pet is already wearing that item
    $clothes = $pet['clothes'];
    if (str_contains($clothes, $itemName)) {
        $reply = "Your pet is already wearing this item.";
        $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":message", $reply);
        $stmt->execute();
        header("Location: ../pack");
        die();
    }
    
    //Fetch Items
    
    //Add to Clothes String.
    $string = $pet['clothes'];
    $string .= ' ' . $itemName;
    $string = trim($string);
    $query = 'UPDATE snoozelings SET clothes = :clothes WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $petid);
    $stmt->bindParam(":clothes", $string);
    $stmt->execute();
    
    
    //Remove Item from Inventory
    if ($color && $color != "Basic") {
        $query = 'DELETE FROM items WHERE list_id = :id AND user_id = :user AND dye = :color LIMIT 1'; 
    } else {
        $query = 'DELETE FROM items WHERE list_id = :id AND user_id = :user AND dye IS NULL LIMIT 1'; 
    }
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":user", $userId);
    if ($color && $color != "Basic") {
        $stmt->bindParam(":color", $color);
    }
    $stmt->execute(); 
    
    //Update Image
    resetImage($petid, $pdo);
    
    //Message & Reroute to Items
    if ($color) {
        $query = 'SELECT * FROM dyes WHERE name = :name';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":name", $color);
        $stmt->execute();
        $colorDisplay = $stmt->fetch(PDO::FETCH_ASSOC);
        $greeting = "Your pet is now wearing the following item: " . $clothingCheck['display'] . ' [' . $colorDisplay['display'] . ']';
    } else {
        $greeting = "Your pet is now wearing the following item: " . $clothingCheck['display'];
    }
    
        $reply = $greeting;
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
    header("Location: ../pack");
    
} else {
    header("Location: ../boards.php");
}















