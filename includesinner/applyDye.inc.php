<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userId = $_SESSION['user_id'];
    $color = $_POST["color"];
    $item = $_POST["item"];
    
    //Search for Dye Batch
    $query = 'SELECT * FROM dyebatches WHERE user_id = :id AND finished = 0';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $opencheck = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($opencheck) {
        
    } else {
        header("Location: ../");
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
    $_SESSION["reply"] = "Your " . $itemcheck['display'] . " will be ready in 4 hours.";
    header("Location: ../dyes");
    
} else {
    header("Location: ../");
}

