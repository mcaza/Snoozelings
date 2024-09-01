<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") { 
    $userId = $_SESSION['user_id'];
    
    //Update Emails
    $query = "UPDATE users SET newsletter = 1 WHERE newsletter = 0 AND emailVerified = 1";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    //Redirect
    header("Location: ../secretemailpage");
    
} else {
     header("Location: ../index");
}

