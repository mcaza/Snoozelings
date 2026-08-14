<?php

//Get Values
$id = $_GET['id'];
$userId = $_COOKIE['user_id'];


//Check if There is a Breeding
$query = 'SELECT * FROM breedings WHERE id = :id AND completed = 0 AND status = 1';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);



if (!$result) {
    header("Location: ../");
    die();
}





//Check if User_id matches session id
if ($result['user_id'] == $userId) {
    
} else {
    
    header("Location: ../");
    die();
}

//Check if it has already been selected
if (!empty($result['blueprint'])) {
    $reply = "You have already selected a blueprint for this breeding.";
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
    header("Location: ../stitcher");
    die();
} 