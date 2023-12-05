<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

//Get Values
$id = $_GET['id'];
$userId = $_SESSION['user_id'];

//Check if they have Friends Open
$query = 'SELECT blockRequests FROM users WHERE id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if ($result['blockRequests'] === 1) {
    $_SESSION['reply'] = "This user does not allow friend requests.";
    header("Location: ../friends?id=" . $userId);
    die();
}

//Check for Friend Limit
$query = 'SELECT friendList FROM users WHERE id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if ($result) {
    $list = explode(" ", $result['friendList']);
    $count = count($list);
    if ($count === 50) {
        $_SESSION['reply'] = "Your friend list is full. There is a limit of 50 friends.";
        header("Location: ../friends?id=" . $userId);
        die();
    }
}
    
//Check if they are same user
if ($id === $userId) {
    header("Location: ../index");
    die();
}

//Check if they are on friend list
if ($result) {
    $list = explode(" ", $result['friendList']);
    if (in_array($id, $list)) {
        $_SESSION['reply'] = "This user is already in your friend list.";
        header("Location: ../friends?id=" . $userId);
        die();
    }
}

//Add Friend
if ($result) {
    $friends = $result['friendList'] . " " . $id;
} else {
    $friends = $id;
}
$query = 'UPDATE users SET friendList = :friends WHERE id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->bindParam(":friends", $friends);
$stmt->execute();

//Reply & Reroute to Friend Page
$_SESSION['reply'] = "Your new friend has been successfully added.";
header("Location: ../friends?id=" . $userId);
die();