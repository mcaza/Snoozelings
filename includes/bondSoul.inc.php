<?php
require_once 'dbh-inc.php';
require_once 'config_session.inc.php';

if (isset($_GET['ID'])) {   
    $id = $_GET['ID'];
}

$query = "SELECT owner_id FROM snoozelings WHERE id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

             
if ($_SESSION["user_id"] === $result["owner_id"]) { 
    $query = "UPDATE users SET bonded = :id WHERE id = :ownerID";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":ownerID", $_SESSION["user_id"]);
    $stmt->execute();
    $pdo = null;
    $stmt = null;
    header("Location: ../pet?ID=" . $id);
    die();
} else {
    header("Location: ../pet?ID=" . $id);
}