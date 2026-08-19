<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") { 
    $userId = $_COOKIE['user_id'];

//Check How Many Boxes. Max is Currently 4
$query = 'SELECT * FROM marketTables WHERE user_id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$results = $stmt->fetch(PDO::FETCH_ASSOC);
$count = $results['unlocked'];;

//If Zero, Throw Error
if ($count == null) {
    //Variables
    $reply = "You have not yet set up a Flea Market stall.";
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
    
    //Reroute to Pack
    header("Location: ../pack");
    die();
} else if ($count < 4) {
    //Delete Item
    $query = 'DELETE FROM items WHERE user_id = :id AND list_id = 484 LIMIT 1';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    
    //Install New Farm
    $new = $count + 1;
    $query = 'UPDATE marketTables SET unlocked = :num WHERE user_id = :user';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user", $userId);
    $stmt->bindParam(":num", $new);
    $stmt->execute();
    
    //Variables
    $reply = "You have successfully set up a new market table.";
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();

    //Reroute to Pack
    header("Location: ../pack");
    die();
} else {
        $reply = "You already have the maximum amount of market tables.";
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
    header("Location: ../pack");
    die();
}

 //Redirect
    } else {
     header("Location: ../index");
}