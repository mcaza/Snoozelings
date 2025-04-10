<?php
function ownerRedirect($pdo) {
//Get Pet ID and Owner ID
$id = $_GET['id'];
$userId = $_COOKIE['user_id'];

//Query for Owner ID of Pet
$query = "SELECT owner_id FROM snoozelings WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

//Check if they Match. If not, redirect
if ($userId == $result['owner_id']) {
    
} else {
    header("Location: ../pet?id=" . $id);
}
}

ownerRedirect($pdo);