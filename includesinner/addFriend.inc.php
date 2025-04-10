<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

//Get Values
$id = $_GET['id'];
$userId = $_COOKIE['user_id'];

//Check if they have Friends Open
$query = 'SELECT blockRequests FROM users WHERE id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if ($result['blockRequests'] === 1) {
    $reply = "This user does not allow friend requests.";
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
    header("Location: ../friends?id=" . $userId);
    die();
}

//Check if they exist
if(!$result) {
    $reply = "There is no account with this user id.";
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
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
            $reply = "Your friend list is full. There is a limit of 50 friends.";
            $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":user_id", $userId);
            $stmt->bindParam(":message", $reply);
            $stmt->execute();
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
            $reply = "This user is already in your friend list.";
            $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":user_id", $userId);
            $stmt->bindParam(":message", $reply);
            $stmt->execute();
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
    $reply = "A friend request has been successfully sent.";
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
header("Location: ../friends?id=" . $userId);
die();