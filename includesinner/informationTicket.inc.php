<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") { 
    $userId = $_COOKIE['user_id'];
    $user = $_POST['userid'];
    $ticket = $_POST['ticket'];
    
    //Check if Usernames Match
    if ($userId == $user) {
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
    
    //Check if Ticket is Open
    if ($result['status'] == 2) {
        header("Location: ../index");
    }
    
    //Get Ticket Information & Update
    if($_POST['user']) {
        $useridnew = $_POST['user'];
        $query = "UPDATE modtickets SET userid = :userid WHERE ticketid = :ticket";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":userid", $useridnew);
        $stmt->bindParam(":ticket", $ticket);
        $stmt->execute();
    }
    if($_POST['pet']) {
        $petidnew = $_POST['pet'];
        $query = "UPDATE modtickets SET petid = :petid WHERE ticketid = :ticket";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":petid", $petidnew);
        $stmt->bindParam(":ticket", $ticket);
        $stmt->execute();
    }
    if($_POST['transfer']) {
        $transferidnew = $_POST['transfer'];
        $query = "UPDATE modtickets SET transferid = :transferid WHERE ticketid = :ticket";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":transferid", $transferidnew);
        $stmt->bindParam(":ticket", $ticket);
        $stmt->execute();
    }
    if($_POST['purchase']) {
        $purchaseidnew = $_POST['purchase'];
        $query = "UPDATE modtickets SET purchaseid = :purchaseid WHERE ticketid = :ticket";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":purchaseid", $purchaseidnew);
        $stmt->bindParam(":ticket", $ticket);
        $stmt->execute();
    }
    
    //Reply Message
        $reply = "Ticket Information Has Been Submitted.";
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














