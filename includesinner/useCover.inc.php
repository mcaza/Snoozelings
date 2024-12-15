<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

//Get User Info
if ($_SESSION['user_id']) {
    $userId = $_SESSION['user_id'];
} else {
    header("Location: ../login");
    die();
}

$query = 'SELECT * FROM users WHERE id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

//Check if They Have Item
$item = $_POST['item'];
$query = 'SELECT * FROM items WHERE list_id = :id AND user_id = :user';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $item);
$stmt->bindParam(":user", $userId);
$stmt->execute();
$results = $stmt->fetch(PDO::FETCH_ASSOC);

$string = str_replace("BedCover", "", $results['name']);

if (!$results) {
    header("Location: ../index");
    die();
}


//Break Covers into Array + Check if Applied Already
if ($user['covers']) {
    $covers = $user['covers'];
    if (str_contains($covers, $string)) {
        $_SESSION['reply'] = "Your account already has that bed cover.";
        header("Location: ../pack");
        die();
    } else {
        $final = $covers . ' ' . $string;
    }
} else {
    $final = $string;
}

//Update Account
$query = 'UPDATE users SET covers = :covers where id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":covers", $final);
$stmt->bindParam(":id", $userId);
$stmt->execute();

//Delete Cover
$query = 'DELETE FROM items WHERE user_id = :id AND list_id = :item LIMIT 1';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->bindParam(":item", $item);
$stmt->execute();

//Reply & Reroute
$_SESSION['reply'] = "You have successfully added a new bed cover to your account.";
header("Location: ../pack");