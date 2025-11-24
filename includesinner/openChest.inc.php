<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") { 
    $userId = $_COOKIE['user_id'];
    $name = $_POST['type'];
    
    $large = [137,187,188,189,190,191,192,193,194,195,196,209,224,227,228,229,234,235,236,237,238,239,244,245,246,247,248,249,250,251,252,253,254,255,256,257,258,259,260,261,264,265,266,267,268,269,270,271,272,273,274,275,276,277,278,279,280,281,282,283,284,285,286,287,288,289,290,291,292,293,294,295,296,297,298,299,300,301,302,303,304,305,306,307,308,309,310,311,312,313,314,315,316,317,318,319,320,321,322,323,324,325,326,327,328,329,330,331,332,333,334,335,336,337,338,339,340,341,342,343,344,345,346,347,348,349,350,351,352,353,354,355,356,357,358,359,360,361,362,363,364,365,366,367,368,369,370,371,418];
    
    if ($name === "FarmChest") {
        $small = [3,5,11,13,9,14,28,29,30,31,32,33,34,35,36,37,38,39,64,65,66,101,102,103,104,105,106,113,124,125,126,127,143,159,160,161,162,240,241];
    } else if ($name === "BeachChest") {
        $small = [12,6,10,4,14,52,53,54,55,56,57,58,59,60,61,62,63,60,71,73,101,102,103,104,105,106,113,124,125,126,127,143,159,160,161,162,240,241];
    } else if ($name === "WoodsChest") {
        $small = [2,214,8,1,7,14,40,41,42,43,44,45,46,47,48,49,50,51,67,68,69,101,102,103,104,105,106,113,124,125,126,127,143,159,160,161,162,240,241];
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
