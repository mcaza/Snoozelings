<?php
require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

$id = $_GET['id'];


$query = "SELECT owner_id, name FROM snoozelings WHERE id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

             
if ($_SESSION["user_id"] == $result["owner_id"]) { 
    $query = "UPDATE users SET bonded = :id WHERE id = :ownerID";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":ownerID", $_SESSION["user_id"]);
    $stmt->execute();
    $pdo = null;
    $stmt = null;
    $_SESSION['bonded'] = htmlspecialchars($result['name']);
    header("Location: ../pet?id=" . $id);
    die();
} else {
    header("Location: ../pet?id=" . $id);
}