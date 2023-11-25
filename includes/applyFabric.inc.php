<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //Get Values
    $userId = $_SESSION['user_id'];
    $fabric = $_POST['fabric'];
    $pet = $_POST['pet'];

    
    //Get Item Name
    $query = 'SELECT name FROM items WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $fabric);
    $stmt->execute();
    $fabricid = $stmt->fetch(PDO::FETCH_ASSOC);
    $name = str_replace("Fabric", "", $fabricid['name']);
    
    //Get Pet Name
    $query = 'SELECT * FROM snoozelings WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $pet);
    $stmt->execute();
    $petname = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Apply Fabric to Snoozeling
    $query = "UPDATE snoozelings SET noseColor = :fabric WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":fabric", $name);
    $stmt->bindParam(":id", $pet);
    $stmt->execute();
    
    //Remove Item
    $query = 'DELETE FROM items WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $fabric);
    $stmt->execute(); 
    
    //Set Message and Reroute
    $_SESSION['reply'] = $petname['name'] . " loves their new fabric!!";
    header("Location: ../stitcher?page=fabric");
} else {
header("Location: ../index");
    die();
}

