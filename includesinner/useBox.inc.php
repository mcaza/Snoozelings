<?php
require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

$userId = $_COOKIE['user_id'];

//Check How Many Boxes. Max is Currently 9
$query = 'SELECT * FROM farms WHERE user_id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$count = count($results);

//If Below, Add New Farm Plot
if ($count < 9) {
    //Delete Item
    $query = 'DELETE FROM items WHERE user_id = :id AND list_id = 114 LIMIT 1';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    
    //Install New Farm
    $query = 'INSERT INTO farms (user_id) VALUES (:id)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    
    //Variables
        $reply = "You have successfully installed a new farm plot.";
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();

    //Reroute to Pack
    header("Location: ../pack");
    
} else {
        $reply = "You already have the maximum amount of farm plots.";
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
    header("Location: ../pack");
}
