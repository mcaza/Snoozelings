<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") { 
    $userId = $_SESSION['user_id'];
    $user = $_POST['userid'];
    $ticket = $_POST['ticket'];
    
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
    
    //Check if Ticket is Open
    if ($result['status'] == 2) {
        header("Location: ../index");
    }
    
    //Escalate Ticket
    $query = "UPDATE modtickets SET status = 1 WHERE ticketid = :ticket";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":ticket", $ticket);
    $stmt->execute();
    
    //Reply Message
    $_SESSION['reply'] = "Ticket has been escalated.";
    
    //Redirect
    header("Location: ../stafftickets");
    
} else {
     header("Location: ../index");
}
