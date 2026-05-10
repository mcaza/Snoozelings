<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") { 
    $userId = $_COOKIE['user_id'];
    $name = $_POST['type'];
    
    $large = [75,76,77,153,154,197,198,199,200,201,209,222,227,228,229,234,235,236,237,238,239,244,245,246,248,249,250,251,252,253,254,255,256,257,258,259,260,261,263,421,422,423,424,425,426,427,428,429,430,431,432,433,434,435,436,437,438,439];
    
    if ($name === "FarmChest") {
        $small = [14,28,29,30,31,65,74,101,102,103,104,105,106,113,115,116,117,118,119,120,121,122,123,137,138,139,140,141,158,159,160,161,242,243];
    } else if ($name === "BeachChest") {
        $small = [14,40,41,47,48,69,74,101,102,103,104,105,106,113,115,116,117,118,119,120,121,122,123,137,138,139,140,141,158,159,160,161,242,243];
    } else if ($name === "WoodsChest") {
        $small = [14,52,53,54,59,70,74,101,102,103,104,105,106,113,115,116,117,118,119,120,121,122,123,137,138,139,140,141,158,159,160,161,242,243];
    }
    
    //Check for Chest
    $query = "SELECT * FROM items WHERE user_id = :id AND name = :name";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":name", $name);
    $stmt->execute();
    $chestcheck = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($chestcheck) {
        
    } else {
        header("Location: ../");
        die();
    }
    
    //Check for Key
    $query = 'SELECT * FROM items WHERE user_id = :id AND name = "Key"';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $keycheck = $stmt->fetch(PDO::FETCH_ASSOC);
    
    
    
    if ($keycheck == false) {
        header("Location: ../");
        die ();
    } 
    
    //Roll for Coins
    $rand = rand(1,100);
    if ($rand < 60) {
        $coins = 1;
    } else if ($rand < 90) {
        $coins = 2;
    } else {
        $coins = 3;
    }
    
    //Roll for Items (1 Minor, 1 Large)
    $count1 = count($small) - 1;
    $rand1 = rand(0, $count1);
    $count2 = count($large) - 1;
    $rand2 = rand(0, $count2);
    $itemsWon = [];
    array_push($itemsWon, $small[$rand1], $large[$rand2]);
    
    
    //Remove Chest
    $query = 'DELETE FROM items WHERE user_id = :id AND name = :name LIMIT 1';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":name", $name);
    $stmt->execute(); 
    
    //Remove Key
    $query = 'DELETE FROM items WHERE user_id = :id AND name = "Key" LIMIT 1';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    
    //Add Coins
    $query = "UPDATE users SET coinCount = coinCount + :coins WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":coins", $coins);
    $stmt->execute();
    
    //Insert Items Into Player's Table
    $prizes = [];
    foreach ($itemsWon as $item) {
        $query = 'SELECT * FROM itemList WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $item);
        $stmt->execute();
        $iteminfo = $stmt->fetch(PDO::FETCH_ASSOC);
        
        array_push($prizes,$iteminfo['display']);
         
        $query = "INSERT INTO items (list_id, user_id, name, display, description, type, rarity, canDonate) VALUES (:list, :user, :name, :display, :description, :type, :rarity, :canDonate);";
        $stmt = $pdo->prepare($query);
    $stmt->bindParam(":list", $item);
    $stmt->bindParam(":user", $userId);
    $stmt->bindParam(":name", $iteminfo['name']);
    $stmt->bindParam(":display", $iteminfo['display']);
    $stmt->bindParam(":description", $iteminfo['description']);
    $stmt->bindParam(":type", $iteminfo['type']);
    $stmt->bindParam(":rarity", $iteminfo['rarity']);
    $stmt->bindParam(":canDonate", $iteminfo['canDonate']);
    $stmt->execute();
    } 
    
    //Redirect
    if ($coins == 1) {
        $word = " Snooze Coin, 1 ";
    } else {
        $word = " Snooze Coins, 1 ";
    }
    $greeting = "You open the chest and find: " . $coins . $word . $prizes[0] . ', 1 ' . $prizes[1];
        $reply = $greeting;
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
    header("Location: ../pack");
    
} else {
     header("Location: ../");
}
