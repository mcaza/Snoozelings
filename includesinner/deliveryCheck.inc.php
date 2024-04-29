<?php

//Get Values
$id = $_GET['id'];
$userId = $_SESSION['user_id'];


$query = 'SELECT * FROM blueprints WHERE id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

//Check if There is a blueprint under that id
if (!$result) {
    header("Location: ../index.php");
}

//Check if user id matches blueprint id
if (!($userId === $result['owner_id'])) {
    header("Location: ../index.php");
}

//Check if mail has been delivered
$sender = 6;
$title = 'Your Snoozeling Delivery';
$query = 'SELECT * FROM mail WHERE reciever = :id AND sender = :idtwo AND title = :title ORDER BY id DESC LIMIT 1';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->bindParam(":idtwo", $sender);
$stmt->bindParam(":title", $title);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

//Make sure page id matches breeding id
$query = 'SELECT * FROM breedings WHERE user_id = :id ORDER BY id DESC LIMIT 1';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!($id === $result['blueprint'])) {
    header("Location: ../index.php");
}