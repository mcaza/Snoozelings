<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //Get Values
    $userId = $_SESSION['user_id'];
    $design = $_POST['design'];
    $pet = $_POST['pet'];

    
    //Get Item Name
    $query = 'SELECT name FROM items WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $design);
    $stmt->execute();
    $designid = $stmt->fetch(PDO::FETCH_ASSOC);
    $name = str_replace("Design", "", $designid['name']);
    $name = str_replace("Tail", "", $name);
    
    //Get Pet Name
    $query = 'SELECT * FROM snoozelings WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $pet);
    $stmt->execute();
    $petname = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Apply Fabric to Snoozeling
    $query = "UPDATE snoozelings SET tailType = :design WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":design", $name);
    $stmt->bindParam(":id", $pet);
    $stmt->execute();
    
    //Remove Item
    $query = 'DELETE FROM items WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $design);
    $stmt->execute(); 
    
    //Set Message and Reroute
    $_SESSION['reply'] = $petname['name'] . " loves their new tail!!";
    header("Location: ../stitcher?page=design");
} else {
header("Location: ../index");
    die();
}

