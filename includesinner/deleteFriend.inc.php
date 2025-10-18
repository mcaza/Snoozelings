<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    //Get Values
    $id = $_POST['friend'];
    $userId = $_COOKIE['user_id'];
    
    //Gather Friend Info
    $query = 'SELECT friendList FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $list = explode(" ", $result['friendList']);

    
    if (in_array($id, $list)) {        
        
        
    } else {
        header("Location: ../friends");
        die();
    }
    
    
    //Remove from 1st User
    $key = array_search($id, $list);
    unset($list[$key]);
    $newList = array_values($list);
    
    if (count($newList) == 1) {
        $finalList = $newList[0];
    } else {
        foreach ($newList as $item) {
            $finalList = $finalList . $item . ' ';
        }
    }
    $finalList = trim($finalList);
    
    $query = 'UPDATE users SET friendList = :friends WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":friends", $finalList);
    $stmt->execute();
    
    //Remove from 2nd User
    $query = 'SELECT friendList FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $result2 = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $list2 = explode(" ", $result2['friendList']);
    $key2 = array_search($userId, $list2);
    unset($list2[$key2]);
    $newList2 = array_values($list2);
    
        if (count($newList2) == 1) {
        $finalList2 = $newList2[0];
    } else {
        foreach ($newList2 as $item) {
            $finalList2 = $finalList2 . $item . ' ';
        }
    }
    $finalList2 = trim($finalList2);
    
    $query = 'UPDATE users SET friendList = :friends WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":friends", $finalList2);
    $stmt->execute();
    
    //Reply Message
    $reply = "Your friend has been removed from your Friend List.";
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();


    header("Location: ../friends");
} else {
    header("Location: ../index");
}







