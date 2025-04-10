<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userId = $_COOKIE['user_id'];
    $color = $_POST["color"];
    $item = $_POST["item"];
    
    //Search for Dye Batch
    $query = 'SELECT * FROM dyebatches WHERE user_id = :id AND finished = 0';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $opencheck = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($opencheck) {
        header("Location: ../");
        die();
    } else {
        
    }
    
    //Double check if they have that item and dye
    $query = 'SELECT * FROM items WHERE name = :id AND user_id = :owner AND dye IS NULL';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $item);
    $stmt->bindParam(":owner", $userId);
    $stmt->execute();
    $itemcheck = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($itemcheck) {
        
    } else {
        header("Location: ../");
        die();
    }
    
    $query = 'SELECT * FROM items WHERE name = :id AND user_id = :owner';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $color);
    $stmt->bindParam(":owner", $userId);
    $stmt->execute();
    $dyecheck = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($dyecheck) {
        
    } else {
        header("Location: ../");
        die();
    }
    
    //Check if Item Can be Dyed
    $query = 'SELECT * FROM itemList WHERE name = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $item);
    $stmt->execute();
    $canDye = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($canDye) {
        
    } else {
        header("Location: ../");
        die();
    }
    
    //Check if Dye is White
    if ($color == "WhiteDye") {
         if ($canDye['white'] == 1) {
        
         } else {
                 $reply = "White dye cannot be used with that item.";
                $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":user_id", $userId);
                $stmt->bindParam(":message", $reply);
                $stmt->execute();
             header("Location: ../");
             die();
        }
    }
    
    //Set Dye Batch
    $hours = 4;
    $now = new DateTime('now', new DateTimezone('UTC'));
    $modified = (clone $now)->add(new DateInterval("PT{$hours}H")); 
    $time = $modified->format('Y-m-d H:i:s');
    
    //Insert Dye Batch
    $newcolor = str_replace("Dye","",$color);
    $query = 'INSERT INTO dyebatches (user_id, item_id, dye, endtime) VALUES (:user, :item, :dye, :time)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user", $userId);
    $stmt->bindParam(":item", $itemcheck['list_id']);
    $stmt->bindParam(":dye", $newcolor);
    $stmt->bindParam(":time", $time);
    $stmt->execute();
    
    //Remove Item & Dye
    $query = 'DELETE FROM items WHERE user_id = :id AND name = :item AND dye IS NULL LIMIT 1';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":item", $item);
    $stmt->execute();
    
    $query = 'DELETE from items WHERE user_id = :id AND name = :name LIMIT 1';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":name", $color);
    $stmt->execute();
    
    //Reply and Reroute
    $greeting = "Your " . $itemcheck['display'] . " will be ready in 4 hours.";
        $reply = $greeting;
            $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":user_id", $userId);
            $stmt->bindParam(":message", $reply);
            $stmt->execute();
    header("Location: ../dyes");
    
} else {
    header("Location: ../");
}


