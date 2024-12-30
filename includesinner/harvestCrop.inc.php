<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

//Get Variables
    if ($_SESSION['user_id']) {
        $userId = $_SESSION['user_id'];
    } else {
        header("Location: ../login");
        die();
    }
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
            $now = new DateTime("now", new DateTimezone('UTC'));
            $future_date = new DateTime($table['finishtime']);
            if ($table['finishtime']) {
                if ($future_date >= $now) {
                    $_SESSION['reply'] = "That snoozeling is currently crafting.";
                    header("Location: ../farm");
                    die(); 
                }
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
    
    //Log to Find harvestLogs
    $query = "INSERT INTO harvestLogs SET user_id = :user, plot = :plot, farmer = :farmer, itemInfoId = :cropId, itemInfoName = :cropName, stg1 = :stg1, stg2 = :stg2, stg3 = :stg3, amount = :amount, water = :water, mystery = :mystery";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user", $userId);
    $stmt->bindParam(":plot", $plot);
    $stmt->bindParam(":farmer", $farmer);
    $stmt->bindParam(":cropId", $itemInfo['id']);
    $stmt->bindParam(":cropName", $itemInfo['name']);
    $stmt->bindParam(":stg1", $farm['stg1']);
    $stmt->bindParam(":stg2", $farm['stg2']);
    $stmt->bindParam(":stg3", $farm['stg3']);
    $stmt->bindParam(":amount", $farm['amount']);
    $stmt->bindParam(":water", $farm['water']);
    $stmt->bindParam(":mystery", $farm['mystery']);
    $stmt->execute();

    
    //Roll Amount Based on Watering
    $num = intval($farm['water']);
    if ($num == 0) {
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
    
    
    
    
    
    
    if ($itemInfo['id']) {
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
    } else {
         $_SESSION['reply'] = "There was a small glitch in the snoozeling internet, but we promise your plant was harvested.";
        header("Location: ../farm");
        die();
    }
    
    //Roll for Seed Drop
    $seedRoll = rand(0,100);
    if ($seedRoll < 20) {
        $seed = 1;
        
        //Grab Seed Item Information
        //Grab Item Info
        $query = "SELECT * FROM itemList WHERE name = :name";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":name", $farm['name']);
        $stmt->execute();
        $itemInfo = $stmt->fetch(PDO::FETCH_ASSOC);
        
        //Add Seed to Inventory
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
    } else {
        $seed = 0;
    }
    
    
    //Update +1 to User Records
    $query = 'UPDATE users SET cropsHarvested = cropsHarvested + 1 WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    
    //Increase Daily Records +1
    $query = 'UPDATE dailyRecords SET cropsHarvested = cropsHarvested + 1 ORDER BY id DESC LIMIT 1';
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    
    //Reset Farm
    $query = 'UPDATE farms SET name = NULL, stg1 = NULL, stg2 = NULL, stg3 = NULL, amount = NULL, water= NULL, plantNAME = NULL, mystery = 0 WHERE id = :plot';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":plot", $plot);
    $stmt->execute(); 
    
    //Set Session Variables
    $_SESSION['amount'] = $amount;
    $_SESSION['item'] = $farm['plantName'];
    $_SESSION['name'] = htmlspecialchars($snooze['name']);
    $_SESSION['seed'] = $seed;
                   
    //Return
    header("Location: ../farm");
    
} else {
header("Location: ../farm.php");
    die();
}
