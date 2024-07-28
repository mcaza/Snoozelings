<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") { 
    $userId = $_SESSION['user_id'];
    $name = $_POST['type'];
    
    if ($name === "FarmChest") {
        $small = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 28, 29,30,31,32,33,34,35,36,37,38,39,113,127,214,64,65,66];
        $large = [74,78,79,80,92,93,94,95,98,101,102,103,104,105,114,115,116,117,118,119,120,121,122,123,137,155,158,209];
    } else if ($name === "BeachChest") {
        $small = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13,14,40,41,42,43,44,45,46,47,48,49,50,51,168,214,71,72,73,70];
        $large = [74,86,87,88,89,90,91,97,100,101,102,103,104,105,114,115,116,117,118,119,120,121,122,123,137,155,158,209];
    } else if ($name === "WoodsChest") {
        $small = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14,52,53,54,55,56,57,58,59,60,61,62,63,124,214,67,68,69];
        $large = [74,81,82,83,84,85,96,99,101,102,103,104,105,114,115,116,117,118,119,120,121,122,123,137,155,158,209,220,221];
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
        $word = " Coin, 1 ";
    } else {
        $word = " Coins, 1 ";
    }
    $_SESSION['reply'] = "You open the chest and find: " . $coins . $word . $prizes[0] . ', 1 ' . $prizes[1];
    header("Location: ../pack");
    
} else {
     header("Location: ../");
}
