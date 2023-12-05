<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $status = $_POST['status'];
    $userId = $_SESSION['user_id'];
    
    //Change
    $query = 'UPDATE users SET newsletter = :news WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":news", $status);
    $stmt->execute();
    
    //Reply & Reroute
    $_SESSION['reply'] = "Your newsletter choice has been changed.";
    header("Location: ../updateaccount");
    die();
    
} else {
header("Location: ../index");
    die();
}
