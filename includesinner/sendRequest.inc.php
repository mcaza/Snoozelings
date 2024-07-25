<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") { 
    $userId = $_SESSION['user_id'];
    
    //Check if selection is empty. If so redirect.
    if ($_POST['item']) {
        $item = $_POST['item'];
    } else {
        $_SESSION['reply'] = "Ticket Information Has Been Submitted";
        header("Location: ../requests");
    }
    
    //Double Check the Item is not manually entered
    $query = "SELECT * FROM itemList WHERE name = :name";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $item);
    $stmt->execute();
    $itemcheck = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($itemcheck) {
        
    } else {
        header("Location: ../index");
    }
    
    
    //Double check less than 5 posts. If not redirect.
    //Get Total Requests
    $query = "SELECT * FROM requests WHERE user_id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count = count($results);
    if ($count > 5) {
        $_SESSION['reply'] = "You have already submitted the max number of requests possible.";
        header("Location: ../requests");
    }
    
    //Double check less than 2 posts today. If not redirect
    $query = "SELECT * FROM users WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($requests > 1) {
        $_SESSION['reply'] = "You have already submitted the max number of requests today.";
        header("Location: ../requests");
    }
    
    //Get Datetime

    $now = new DateTime("now", new DateTimezone('UTC'));
    $hours = 168;
    $modified = (clone $now)->add(new DateInterval("PT{$hours}H")); 
    $formatted = $modified->format('Y-m-d H:i:s');
    
    
    //Post Request
    $query = "INSERT INTO requests (user_id, item_id, name, displayname, points, datetime) VALUES (:userid, :itemid, :name, :displayname, :points, :datetime)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":userid", $userId);
    $stmt->bindParam(":itemid", $itemcheck['id']);
    $stmt->bindParam(":name", $itemcheck['name']);
    $stmt->bindParam(":displayname", $itemcheck['display']);
    $stmt->bindParam(":points", $itemcheck['points']);
    $stmt->bindParam(":datetime", $formatted);
    $stmt->execute();
    
    //Update Daily Requests for User
    $newTotal = intval($result['requests']) + 1;
    $query = "UPDATE users SET requests = :requests WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":requests", $newTotal);
    $stmt->execute();
    
    //Redirect with Reply
    $_SESSION['reply'] = "Your Request Has Been Submitted";
    header("Location: ../requests");
    
    
} else {
     header("Location: ../index");
}



