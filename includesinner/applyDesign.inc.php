<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //Get Values
    $userId = $_SESSION['user_id'];
    $design = $_POST['design'];
    $pet = $_POST['pet'];

    //Get Item Name
    $query = 'SELECT * FROM items WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $design);
    $stmt->execute();
    $designid = $stmt->fetch(PDO::FETCH_ASSOC);

    
    //Get Pet Name
    $query = 'SELECT * FROM snoozelings WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $pet);
    $stmt->execute();
    $petname = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (str_contains($designid['name'], "Tail")) {
        
        $name = str_replace("Design", "", $designid['name']);
        $name = str_replace("Tail", "", $name);
        //Apply Fabric to Snoozeling
        $query = "UPDATE snoozelings SET tailType = :design WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":design", $name);
        $stmt->bindParam(":id", $pet);
        $stmt->execute();
        $_SESSION['reply'] = $petname['name'] . " loves their new tail!!";
        
    } else if (str_contains($designid['name'], "Hair") || str_contains($designid['name'], "Spikes")) {
        $name = str_replace("Design", "", $designid['name']);
        if (str_contains($designid['name'], "Hair")) {
            $name = str_replace("Hair", "", $name);
        } else if (str_contains($designid['name'], "Spikes")) {
            
        }
        
        //Apply Fabric to Snoozeling
        $query = "UPDATE snoozelings SET hairType = :design WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":design", $name);
        $stmt->bindParam(":id", $pet);
        $stmt->execute();
        $_SESSION['reply'] = $petname['name'] . " loves their new hair!!";
    } else {
        //Get Specials String
        $specials = $petname['specials'];
        
        //Add to String
        $wings = str_replace("Design", "", $designid['name']);
        $string = " " . $wings;
        $specials .= $string;
        
        //Clean String
        $clean = trim($specials);
        
        //Update Specials
        $query = "UPDATE snoozelings SET specials = :design WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":design", $clean);
        $stmt->bindParam(":id", $pet);
        $stmt->execute();
        
        $_SESSION['reply'] = $petname['name'] . " loves their new look!!";
    }
    
    
    //Remove Item
    $query = 'DELETE FROM items WHERE id = :id AND user_id = :userId';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $design);
    $stmt->bindParam(":userId", $userId);
    $stmt->execute(); 
    
    //Set Message and Reroute
    
    header("Location: ../stitcher?page=design");
} else {
header("Location: ../index");
    die();
}

