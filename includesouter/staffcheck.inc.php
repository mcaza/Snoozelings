<?php

$userId = $_COOKIE['user_id'];

$query = 'SELECT staff FROM users WHERE id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$status = $stmt->fetch(PDO::FETCH_ASSOC);

if ($status['staff'] == "admin" || $status['status'] == "mod") {
    
} else {
    header("Location: ../login");
    die();
}