<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") { 
    $userId = $_COOKIE['user_id'];
    $table = $_POST['table'];
    
    //Check for Coins
    $query = 'SELECT * FROM marketTables WHERE user_id = :user';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user", $userId);
    $stmt->execute();
    $check = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($table == 0) {
        if ($check['itemOne'] == "Coins") {
            $coins = intval($check['coinsOne']);
        } else {
            header("Location: ../index");
            die();
        }
    } else if ($table == 1) {
        if ($check['itemTwo'] == "Coins") {
            $coins = intval($check['coinsTwo']);
        } else {
            header("Location: ../index");
            die();
        }
    } else if ($table == 2) {
        if ($check['itemThree'] == "Coins") {
            $coins = intval($check['coinsThree']);
        } else {
            header("Location: ../index");
            die();
        }
    } else if ($table == 3) {
        if ($check['itemFour'] == "Coins") {
            $coins = intval($check['coinsFour']);
        } else {
            header("Location: ../index");
            die();
        }
    }
    
    //Add Coins to User
    $query = "UPDATE users SET coinCount = coinCount + :coins WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":coins", $coins);
    $stmt->execute();
    
    //Remove Coins from Table
    $item = "";
    if ($table == 0) {
        $query = 'UPDATE marketTables SET itemOne = NULL, quantityOne = NULL, coinsOne = NULL WHERE user_id = :user';
    } else if ($table == 1) {
        $query = 'UPDATE marketTables SET itemTwo = NULL, quantityTwo = NULL, coinsTwo = NULL WHERE user_id = :user';
    } else if ($table == 2) {
        $query = 'UPDATE marketTables SET itemThree = NULL, quantityThree = NULL, coinsThree = NULL WHERE user_id = :user';
    } else if ($table == 3) {
        $query = 'UPDATE marketTables SET itemFour = NULL, quantityFour = NULL, coinsFour = NULL WHERE user_id = :user';
    }
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user", $userId);
    $stmt->execute();
    
    
    //Redirect to Table
    $reply = $coins . " Snooze Coins have been added to your backpack.";
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
    
    $location = "Location: ../table?id=" . $table;
    header($location);
    die();
        
} else {
     header("Location: ../index");
}










