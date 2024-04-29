<?php

$id = $_GET['id'];
$userId = $_SESSION['user_id'];

//Get Farm User
$query = "SELECT * FROM farms WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $id);
$stmt->execute();
$farm = $stmt->fetch(PDO::FETCH_ASSOC);

$one = intval($farm['user_id']);
$two = intval($userId);

if ($one === $two) {
    
} else {
    header("Location: ../farm");
} 