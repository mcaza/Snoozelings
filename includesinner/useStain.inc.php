<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';
require_once '../../includes/log.inc.php';

//Get Values
$pet = $_POST['pet'];
$part = $_POST['part'];
$item = $_POST['item'];

//Check if Snoozeling is Owned by Player
$query = 'SELECT * FROM snoozelings WHERE id = :id AND owner_id = :owner';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $pet);
$stmt->bindParam(":owner", $userId);
$stmt->execute();
$petCheck = $stmt->fetch(PDO::FETCH_ASSOC);
if ($petCheck) {
    
} else {
    header("Location: ../");
    die();
}

//Check if Player Owns Item
$query = 'SELECT * FROM items WHERE list_id = :id AND user_id = :owner';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $item);
$stmt->bindParam(":owner", $userId);
$stmt->execute();
$itemCheck = $stmt->fetch(PDO::FETCH_ASSOC);
if ($itemCheck) {
    
} else {
    header("Location: ../");
    die();
}

//Check Body Part Value
if ($part == "mainColor" || $part == "eyeColor" || $part == "hairColor" || $part == "tailColor" || $part == "skinColor") {
    
} else {
    header("Location: ../");
    die();
}

//Get Item Color
$string = str_replace("Stain", "", $itemCheck['name']);


//Apply Stain
if ($part == "mainColor") {
    $query = 'UPDATE snoozelings SET mainColor = :color WHERE id = :id';
} else if ($part == "eyeColor") {
    $query = 'UPDATE snoozelings SET eyeColor = :color WHERE id = :id';
} else if ($part == "hairColor") {
    $query = 'UPDATE snoozelings SET hairColor = :color WHERE id = :id';
} else if ($part == "tailColor") {
    $query = 'UPDATE snoozelings SET tailColor = :color WHERE id = :id';
} else if ($part == "skinColor") {
    $query = 'UPDATE snoozelings SET noseColor = :color WHERE id = :id';
}

$stmt = $pdo->prepare($query);
$stmt->bindParam(":color", $string);
$stmt->bindParam(":id", $pet);
$stmt->execute();

//Delete Stain
$query = 'DELETE FROM items WHERE user_id = :id AND list_id = :item LIMIT 1';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->bindParam(":item", $item);
$stmt->execute();


//Reply & Reroute
    $reply = "You have successfully applied stain to your snoozeling.";
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
header("Location: ../pack");