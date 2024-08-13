<?php
require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

$userId = $_SESSION['user_id'];

//Check How Many Boxes. Max is Currently 9
$query = 'SELECT * FROM farms WHERE user_id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$count = count($results);

//If Below, Add New Farm Plot
if ($count < 10) {
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
    $_SESSION['message'] = "You have successfully installed a new farm plot.";

    //Reroute to Pack
    header("Location: ../pack");
    
} else {
    $_SESSION['message'] = "You already have the maximum amount of farm plots.";
    header("Location: ../pack");
}
