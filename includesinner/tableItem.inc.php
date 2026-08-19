<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") { 
    $userId = $_COOKIE['user_id'];
    $item = $_POST['item'];
    $quantity = $_POST['quantity'];
    $table = $_POST['table'];
    
    //Check for Item
    $query = 'SELECT * FROM items WHERE list_id = :id AND user_id = :user';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $item);
    $stmt->bindParam(":user", $userId);
    $stmt->execute();
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    //Check to make sure random item wasn't inputted
    if ($items) {
        //Do Nothing
    } else {
        header("Location: ../index");
        die();
    }
    
    //Check if Sellable
    $query = 'SELECT * FROM itemList WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $item);
    $stmt->execute();
    $check = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($check['sell'] < 1) {
        header("Location: ../index");
        die();
    } 
    
    //Check if Other Table Also has Item
    $query = 'SELECT * FROM marketTables WHERE user_id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $tableInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($tableInfo['itemOne'] == $check['name'] || $tableInfo['itemTwo'] == $check['name'] || $tableInfo['itemThree'] == $check['name'] || $tableInfo['itemFour'] == $check['name']) {
        $reply = "You are already selling that item at another table.";
        $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":message", $reply);
        $stmt->execute();
        
        $location = "Location: ../table?id=" . $table;
        header($location);
        die();
    }
    
    //If not enough, return with Quantity
    $amt = count($items);
    if ($amt < $quantity) {
        if ($amt == 1) {
            $reply = "You currently only have " . $amt . " " . $check['display'] . ' to sell.';
        } else {
            $reply = "You currently only have " . $amt . " " . $check['multiples'] . ' to sell.';
        }
        $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":message", $reply);
        $stmt->execute();
        
        $location = "Location: ../table?id=" . $table;
        header($location);
        die();
    }
    
    //If enough, change item
    if ($table == 0) {
        $query = 'UPDATE marketTables SET itemOne = :item, quantityOne = :quantity WHERE user_id = :user';
    } else if ($table == 1) {
        $query = 'UPDATE marketTables SET itemTwo = :item, quantityTwo = :quantity WHERE user_id = :user';
    } else if ($table == 2) {
        $query = 'UPDATE marketTables SET itemThree = :item, quantityThree = :quantity WHERE user_id = :user';
    } else if ($table == 3) {
        $query = 'UPDATE marketTables SET itemFour = :item, quantityFour = :quantity WHERE user_id = :user';
    }
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user", $userId);
    $stmt->bindParam(":quantity", $quantity);
    $stmt->bindParam(":item", $check['name']);
    $stmt->execute();
    
    if ($quantity == 1) {
            $reply = "You have added " . $quantity . " " . $check['display'] . ' to your market table.';
        } else {
            $reply = "You have added " . $quantity . " " . $check['multiples'] . ' to your market table.';
        }
    
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
    
    $location = "Location: ../fleaMarket";
    header($location);
    
    //Redirect
    } else {
     header("Location: ../index");
}





























