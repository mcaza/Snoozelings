<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") { 
    $userId = $_SESSION['user_id'];
    $id = $_POST['request'];
    
    //Get Request Information
    $query = "SELECT * FROM requests WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $request = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Check that Request is open
    if ($request['fulfilled'] == 1 || $request['expired'] == 1) {
        header("Location: ../index");
    }
    
    //Double check user is owner of ticket
    if ($userId == $request['user_id']) {
        
    } else {
        header("Location: ../index");
    }
    
    //Close ticket
    $query = "UPDATE requests SET expired = 1 WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    
    //Redirect with Reply
    $_SESSION['reply'] = "Your Request Has Been Cancelled";
    header("Location: ../requests");
    
    
} else {
     header("Location: ../index");
}



