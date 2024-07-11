<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") { 
    $userId = $_SESSION['user_id'];
    $user = $_POST['userid'];
    $ticket = $_POST['ticket'];
    $reply = htmlspecialchars($_POST['information1']);
    
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
    
    //Check if Staff Or Original User
    $query = 'SELECT staff FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $staff = $stmt->fetch(PDO::FETCH_ASSOC);
    if (($staff['staff'] == "admin" || $staff['staff'] == "moderator") || $userId == $result['submitter']) {
        //Do Nothing
    } else {
        header("Location: ../index");
    }
    
    //Check if Ticket is Open
    if ($result['status'] == 2) {
        header("Location: ../index");
    }
    
    //Get Datetime
    $now = date_create('now')->format('Y-m-d H:i:s');
    
    //Submit Ticket
    $query = "INSERT INTO modtickets (ticketid, information, datetime, replyid) VALUES (:ticketid, :information, :datetime, :replyid);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":ticketid", $ticket);
    $stmt->bindParam(":information", $reply);
    $stmt->bindParam(":datetime", $now);
    $stmt->bindParam(":replyid", $userId);
    $stmt->execute();
    
    //Mark Ticket as Replied
    if ($staff['staff'] == "admin" || $staff['staff'] == "moderator") {
        $query = "UPDATE modtickets SET waitingreply = 1 WHERE ticketid = :ticket";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":ticket", $ticket);
        $stmt->execute();
    } else {
        $query = "UPDATE modtickets SET waitingreply = 0 WHERE ticketid = :ticket";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":ticket", $ticket);
        $stmt->execute();
    }
    
    //Reply Message
    $_SESSION['reply'] = "Your Reply Has Been Submitted";
    
    //Redirect
    header("Location: ../ticket?ticketid=" . $ticket);
    
} else {
     header("Location: ../index");
}