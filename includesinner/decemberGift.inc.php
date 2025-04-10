<?php
require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

$userId = $_COOKIE['user_id'];
date_default_timezone_set('America/Los_Angeles');
$weekday = date('d');

//Get User Info
$query = "SELECT decGift FROM users WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

//Check if Gotten Gift
if ($result['decGift']) {
    $day = $result['decGift'];
} else {
    $day = 0;
}

if ($day < $weekday) {
    
} else {
        $reply = "You have already recieved today\'s gift.";
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
    header("Location: ../decemberGifts");
    die();
}

if ($weekday > 24 && $weekday < 31) {
    if ($day > 24) {
            $reply = "You have already recieved today\'s gift.";
        $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":message", $reply);
        $stmt->execute();
        header("Location: ../decemberGifts");
        die();
    }
}


//Get Gift info
$query = "SELECT * FROM decGifts WHERE id = :id";
$stmt = $pdo->prepare($query);
if ($weekday < 25) {
    $stmt->bindParam(":id", $weekday);
} else if ($weekday == 31) {
    $day = 26;
    $stmt->bindParam(":id", $day);
} else {
    $day = 25;
    $stmt->bindParam(":id", $day);
}
$stmt->execute();
$gift = $stmt->fetch(PDO::FETCH_ASSOC);

//Give Gift
$query = 'SELECT * FROM itemList WHERE id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $gift['item_id']);
$stmt->execute();
$iteminfo = $stmt->fetch(PDO::FETCH_ASSOC);

for ($i = 0; $i < $gift['quantity']; $i++) {
    $query = "INSERT INTO items (list_id, user_id, name, display, description, type, rarity, canDonate) VALUES (:list, :user, :name, :display, :description, :type, :rarity, :canDonate);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":list", $gift['item_id']);
    $stmt->bindParam(":user", $userId);
    $stmt->bindParam(":name", $iteminfo['name']);
    $stmt->bindParam(":display", $iteminfo['display']);
    $stmt->bindParam(":description", $iteminfo['description']);
    $stmt->bindParam(":type", $iteminfo['type']);
    $stmt->bindParam(":rarity", $iteminfo['rarity']);
    $stmt->bindParam(":canDonate", $iteminfo['canDonate']);
    $stmt->execute();
}


//Change Gifter's Number
$query = 'UPDATE users SET decGift = :date WHERE id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->bindParam(":date", $weekday);
$stmt->execute(); 

//Return
if (intval($gift['quantity']) > 1) {
    $greeting = $gift['quantity'] . " " . $iteminfo['multiples'] . " have been added to your pack.";
        $reply = $greeting;
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();

} else {
    $greeting = $gift['quantity'] . " " . $iteminfo['display'] . " has been added to your pack.";
        $reply = $greeting;
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();

}
header("Location: ../decemberGifts");
die();




