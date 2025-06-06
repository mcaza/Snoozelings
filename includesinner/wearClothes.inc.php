<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //Grab Form Variables
    $userId = $_COOKIE['user_id'];
    $id = $_POST["item"];
    $petid = $_POST["pet"];
    if ($_POST["color"]) {
        $color = $_POST["color"];
    }
    

     
    //Fetch Type of Clothes Item
    $query = 'SELECT * FROM itemList WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $type = $result['type'];
    
    //Fetch Items
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
    if (!($type === 'clothesTop' || $type === "clothesBottom" || $type === 'clothesHoodie' || $type === 'clothesBoth')) {
            $reply = "This is not a clothing item and cannot be worn.";
        $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":message", $reply);
        $stmt->execute();
        header("Location: ../pack");
        die();
    }
      
    //Fetch Current Pet Clothes of that Type. 
    $query = 'SELECT clothesTop, clothesBottom, clothesHoodie, clothesBoth FROM snoozelings WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $petid);
    $stmt->execute();
    $pet = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Check if Pet is already wearing that item
    if ($type === 'clothesTop') {
        $clothes = $pet['clothesTop'];
    } elseif ($type === 'clothesBottom') {
        $clothes = $pet['clothesBottom'];
    } elseif ($type === 'clothesHoodie') {
        $clothes = $pet['clothesHoodie'];
    } elseif ($type === 'clothesBoth') {
        $clothes = $pet['clothesBoth'];
    }
    if (str_contains($clothes, $name)) {
            $reply = "Your pet is already wearing this item.";
        $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":message", $reply);
        $stmt->execute();
        header("Location: ../pack");
    }
    
    //Add to Clothes String. Update Clothes String of that Type
    if ($type === 'clothesTop') {
        $string = $pet['clothesTop'];
        $string .= ' ' . $name;
        $string = trim($string);
        $query = 'UPDATE snoozelings SET clothesTop = :clothes WHERE id = :id';
    } elseif ($type === 'clothesBottom') {
        $string = $pet['clothesBottom'];
        $string .= ' ' . $name;
        $string = trim($string);
        $query = 'UPDATE snoozelings SET clothesBottom = :clothes WHERE id = :id';
    } elseif ($type === 'clothesHoodie') {
        $string = $pet['clothesHoodie'];
        $string .= ' ' . $name;
        $string = trim($string);
        $query = 'UPDATE snoozelings SET clothesHoodie = :clothes WHERE id = :id';
    } 
    elseif ($type === 'clothesBoth') {
        $string = $pet['clothesBoth'];
        $string .= ' ' . $name;
        $string = trim($string);
        $query = 'UPDATE snoozelings SET clothesBoth = :clothes WHERE id = :id';
    }
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
    
    //Message & Reroute to Items
    $greeting = "Your pet is now wearing the following item: " . $display;
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















