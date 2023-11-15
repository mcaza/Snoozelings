<?php
function ownerRedirect($pdo) {
//Get Pet ID and Owner ID
$id = $_GET['ID'];
$userId = $_SESSION['user_id'];

//Query for Owner ID of Pet
$query = "SELECT owner_id FROM snoozelings WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

//Check if they Match. If not, redirect
if ($userId === $result['owner_id']) {
    
} else {
    header("Location: ../pet?ID=" . $id);
}
}

ownerRedirect($pdo);