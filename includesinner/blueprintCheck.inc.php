<?php

//Get Values
$id = $_GET['id'];
$userId = $_COOKIE['user_id'];

//Check if There is a Breeding
$query = 'SELECT * FROM breedings WHERE id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$result) {
    header("Location: ../index.php");
}

//Check if User_id matches session id
if ($result['user_id'] == $userId) {
    
} else {
    header("Location: ../index.php");
}


//Check if Blueprint has Been Selected
if (!($result['blueprint'] === "0")) {
    header("Location: ../index.php");
}

//Check if Mail has been Delivered
$sender = 6;
$title = 'Your Blueprints are Ready!!!';
$query = 'SELECT * FROM mail WHERE reciever = :id AND sender = :idtwo AND title = :title ORDER BY id DESC LIMIT 1';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->bindParam(":idtwo", $sender);
$stmt->bindParam(":title", $title);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result['sent'] === "0") {
        header("Location: ../index.php");
}