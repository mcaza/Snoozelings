<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $status = $_POST['status'];
    $userId = $_COOKIE['user_id'];
    
    //Change
    $query = 'UPDATE users SET newsletter = :news WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":news", $status);
    $stmt->execute();
    
    //Reply & Reroute
        $reply = "Your newsletter choice has been changed.";
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
    header("Location: ../updateaccount");
    die();
    
} else {
header("Location: ../index");
    die();
}
