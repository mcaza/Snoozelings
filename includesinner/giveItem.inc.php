<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $account = $_POST["userid"];
    $item = $_POST["itemid"];
    
    
    $query = 'SELECT * FROM itemList WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $item);
    $stmt->execute();
    $iteminfo = $stmt->fetch(PDO::FETCH_ASSOC);
         
    $test = 1;
    $query = "INSERT INTO items (list_id, user_id, name, display, description, type, rarity, canDonate, test) VALUES (:list, :user, :name, :display, :description, :type, :rarity, :canDonate, :test);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":list", $item);
    $stmt->bindParam(":user", $account);
    $stmt->bindParam(":name", $iteminfo['name']);
    $stmt->bindParam(":display", $iteminfo['display']);
    $stmt->bindParam(":description", $iteminfo['description']);
    $stmt->bindParam(":type", $iteminfo['type']);
    $stmt->bindParam(":rarity", $iteminfo['rarity']);
    $stmt->bindParam(":canDonate", $iteminfo['canDonate']);
    $stmt->bindParam(":test", $test);
    $stmt->execute();
    
    //Return
    header("Location: ../itemImagecheck");
    
} else {
header("Location: ../index");
    die();
}