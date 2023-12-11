<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

//Get Variables
    $userId = $_SESSION['user_id'];
    $plot = $_POST['plot'];
    $farmer = $_POST['farmer'];
    
    //Get Job + EXP
    $query = "SELECT job, farmEXP, name FROM snoozelings WHERE id = :farmer";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":farmer", $farmer);
    $stmt->execute();
    $snooze = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Check if Pet is Crafting
    if ($snooze['job'] === "jack") {
        $query = 'SELECT * FROM craftingtables WHERE pet_id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $farmer);
        $stmt->execute();
        $table = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($table) {
            $now = new DateTime(null, new DateTimezone('UTC'));
            $future_date = new DateTime($table['finishtime']);
            if ($future_date >= $now) {
                $_SESSION['reply'] = "That snoozeling is currently crafting.";
                header("Location: ../farm");
                die(); 
            }
        }
    }
    
    if(!$farmer) {
        $_SESSION['reply'] = 'You need to select a farmer';
        header("Location: ../farm");
        die();
    }
    
    //Get Information from Farms
    $query = "SELECT * FROM farms WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $plot);
    $stmt->execute();
    $farm = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Reward EXP To Pet
    if ($snooze['job'] === "Farmer") {
    $exp = $snooze['farmEXP'] + .5;
    
    $query = "UPDATE snoozelings SET farmEXP = :exp WHERE id = :id";
     $stmt = $pdo->prepare($query);
    $stmt->bindParam(":exp", $exp);
    $stmt->bindParam(":id", $farmer);
    $stmt->execute();
        
}

    
    //Grab Item Info
    $name = substr($farm['name'], 0, -4);
    $query = "SELECT * FROM itemList WHERE name = :name";
     $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $name);
    $stmt->execute();
    $itemInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Roll Amount Based on Watering
    $num = intval($farm['water']);
    if ($num === 0) {
        $amount = 1;
    } else {
        $chance = $farm['water'] * 5;
        $randomNum = rand(1, 100);
        if ($randomNum <= $chance) {
            $amount = 2;
        } else {
            $amount = 1;
        }
    }
    
    //Add Item to Inventory
    for ($i = 0; $i < $amount; $i++) {
        $query = "INSERT INTO items (list_id, user_id, name, display, description, type, rarity, canDonate) VALUES (:list, :user, :name, :display, :description, :type, :rarity, :canDonate);";
        $stmt = $pdo->prepare($query);
    $stmt->bindParam(":list", $itemInfo['id']);
    $stmt->bindParam(":user", $userId);
    $stmt->bindParam(":name", $itemInfo['name']);
    $stmt->bindParam(":display", $itemInfo['display']);
    $stmt->bindParam(":description", $itemInfo['description']);
    $stmt->bindParam(":type", $itemInfo['type']);
    $stmt->bindParam(":rarity", $itemInfo['rarity']);
    $stmt->bindParam(":canDonate", $itemInfo['canDonate']);
    $stmt->execute();
    }
    
    //Update +1 to User Records
    $query = 'UPDATE users SET cropsHarvested = cropsHarvested + 1 WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    
    //Increase Daily Records +1
    $query = 'UPDATE dailyRecords SET cropsHarvested = cropsHarvested + 1';
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    //Set Session Variables
    $_SESSION['amount'] = $amount;
    $_SESSION['item'] = $farm['plantName'];
    $_SESSION['name'] = htmlspecialchars($snooze['name']);
    
    
    //Reset Farm
        $query = 'UPDATE farms SET name = NULL, stg1 = NULL, stg2 = NULL, stg3 = NULL, amount = NULL, water= NULL, plantNAME = NULL WHERE id = :plot';
                              $stmt = $pdo->prepare($query);
                              $stmt->bindParam(":plot", $plot);
                              $stmt->execute();
                   
    //Return
    header("Location: ../farm");
    
} else {
header("Location: ../farm.php");
    die();
}
