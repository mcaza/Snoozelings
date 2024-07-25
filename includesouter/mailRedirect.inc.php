<?php

//Get User ID & Mail ID
$id = $_GET['id'];
$userId = $_SESSION['user_id'];

//Get Reciever of Mail
$query = 'SELECT reciever FROM mail WHERE id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $id);
$stmt->execute();
$reciever = $stmt->fetch(PDO::FETCH_ASSOC);

//Check if Reciever Matches User
if ($userId == $reciever['reciever']) {

} else {
    header("Location: mailbox");
}