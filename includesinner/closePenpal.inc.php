<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $userId = $_SESSION['user_id'];
    $id = $_POST['request'];
    
    //Make sure user matches request poster
    $query = 'SELECT * FROM penpalRequests WHERE id = :ticketid';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":ticketid", $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result['id'] == $userId) {
        
    } else {
        header("Location: ../index");
    }
    
    //Cancel Request
    $query = 'UPDATE penpalRequests SET expired = 1, closed = 1 WHERE id = :ticketid';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":ticketid", $id);
    $stmt->execute();
    
    //Redirect with Reply
    $_SESSION['reply'] = "Your Request Has Been Cancelled";
    header("Location: ../penpals");
    
    
} else {
     header("Location: ../index");
}
