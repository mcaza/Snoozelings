<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

$userId = $_SESSION['user_id'];

//Get All Farms
$query = "SELECT * FROM farms WHERE user_id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $farms = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Add Water to Each Farm
foreach ($farms as $farm) {
    if ($farm['plantName']) {
        $newNum = $farm['water'] + 1;
        $query = "UPDATE farms SET water = :water WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":water", $newNum);
        $stmt->bindParam(":id", $farm['id']);
        $stmt->execute();
        
    }
}

//Update Water User Time to Time + 2 Hours
    $now = new DateTime("now", new DateTimezone('UTC'));
    $hours = 2;
    $modified = (clone $now)->add(new DateInterval("PT{$hours}H")); 
    $formatted = $modified->format('Y-m-d H:i:s');

    $query = "UPDATE users SET lastWater = :time WHERE id = :id";
    $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->bindParam(":time", $formatted);
        $stmt->execute();

//Redirect
    header("Location: ../farm.php");