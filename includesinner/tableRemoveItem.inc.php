<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") { 
    $userId = $_COOKIE['user_id'];
    $table = $_POST['table'];
    $item = "";
    $num = 0;
    
    $query = 'SELECT * FROM marketTables WHERE user_id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $tableInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($table == 0) {
        $name = "itemOne";
    } else if ($table == 1) {
        $name = "itemTwo";
    } else if ($table == 2) {
        $name = "itemThree";
    } else if ($table == 3) {
        $name = "itemFour";
    }
    
    $query = 'SELECT * FROM itemList WHERE name = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $tableInfo[$name]);
    $stmt->execute();
    $check = $stmt->fetch(PDO::FETCH_ASSOC);
    
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
    $stmt->bindParam(":quantity", $num);
    $stmt->bindParam(":item", $item);
    $stmt->execute();
    
        $reply = "You have removed " . $check['multiples'] . ' from your market table.';
        $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":message", $reply);
        $stmt->execute();
        
        $location = "Location: ../table?id=" . $table;
        header($location);
        die();
    
    
    //Redirect
    } else {
     header("Location: ../index");
}










