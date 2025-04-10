<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") { 
    $userId = $_COOKIE['user_id'];
    $user = $_POST['userid'];
    $ticket = $_POST['ticket'];
    $reply = $_POST['information1'];
    
    //Check if Usernames Match
    if ($userId == $user) {
        //Do Nothing
    } else {
        header("Location: ../index");
    }
    
    //Check if Staff
    $query = 'SELECT staff FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $staff = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($staff['staff'] == "admin" || $staff['staff'] == "moderator") {
        //Do Nothing
    } else {
        header("Location: ../index");
    }
    
    //Get Ticket Information
    $query = 'SELECT * FROM modtickets WHERE ticketid = :ticketid';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":ticketid", $ticket);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Check if Ticket is Open
    if ($result['status'] == 2) {
        header("Location: ../index");
    }
    
    //Get Datetime
    $now = date_create('now')->format('Y-m-d H:i:s');
    
    //Submit Ticket
    $query = "INSERT INTO modtickets (ticketid, notes, datetime, replyid) VALUES (:ticketid, :notes, :datetime, :replyid);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":ticketid", $ticket);
    $stmt->bindParam(":notes", $reply);
    $stmt->bindParam(":datetime", $now);
    $stmt->bindParam(":replyid", $userId);
    $stmt->execute();
    
    //Reply Message
        $reply = "Your Notes Have Been Submitted.";
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
    
    //Redirect
    header("Location: ../ticket?ticketid=" . $ticket);
    
    
    
} else {
     header("Location: ../index");
}