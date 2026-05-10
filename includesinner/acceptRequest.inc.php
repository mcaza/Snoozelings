<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    //Get Values
    $id = $_POST['sender'];
    $userId = $_COOKIE['user_id'];

    
    //Check for Request
    $query = "SELECT * FROM friendRequests WHERE newFriend = :id AND sender = :sender;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":sender", $id);
    $stmt->execute();
    $friendRequests = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($friendRequests) {
        
    } else {
        header("Location: ../index");

    }
    
    
    
    //Check Limit
    //Check for Friend Limit
    $query = 'SELECT * FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $query = 'SELECT * FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $result2 = $stmt->fetch(PDO::FETCH_ASSOC);
    
    
    if ($result2) {
        $list = explode(" ", $result2['friendList']);
        $count = count($list);
        if ($count === 50) {
                $reply = "Your friend list is full. There is a limit of 50 friends.";
                $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":user_id", $userId);
                $stmt->bindParam(":message", $reply);
                $stmt->execute();
                header("Location: ../friends");
                die();
        }
    }
    
    if ($result) {
        $list = explode(" ", $result['friendList']);
        $count = count($list);
        if ($count === 50) {
                $reply = "The user who sent this friend request is already at the 50 friend limit.";
                $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":user_id", $id);
                $stmt->bindParam(":message", $reply);
                $stmt->execute();
                header("Location: ../friends");
                die();
        }
    }
    
    //Check if they are on friend list
    if ($result) {
        $list = explode(" ", $result['friendList']);
        if (in_array($id, $list)) {
                $query = 'DELETE FROM friendRequests WHERE newFriend = :id AND sender = :sender;';
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":id", $userId);
                $stmt->bindParam(":sender", $id);
                $stmt->execute();
            
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
    
    //Add to Friends List
    $friends = $result['friendList'] . " " . $id;
    $final = trim($friends);
    $query = 'UPDATE users SET friendList = :friends WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":friends", $final);
    $stmt->execute();
    
    //Add to Their Friend List
    $friends = $result2['friendList'] . " " . $userId;
    $final = trim($friends);

    $query = 'UPDATE users SET friendList = :friends WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":friends", $final);
    $stmt->execute();
    
    //Delete Request
    $query = 'DELETE FROM friendRequests WHERE newFriend = :id AND sender = :sender;';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":sender", $id);
    $stmt->execute();
    
    //Reply & Reroute to Friend Page
    $reply = "The friend request has been accepted.";
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();

    header("Location: ../friends");
} else {
    header("Location: ../index");
}