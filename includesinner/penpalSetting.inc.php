<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';



if ($_SERVER["REQUEST_METHOD"] === "POST") {
//Grab Form Variables
    $penpal = $_POST['penpal'];
    $userId = $_COOKIE['user_id'];
    
    //Penpal Intensity
    if ($penpal) {
        if (!($penpal === "Easy" || $penpal === "Moderate" || $penpal === "Stressful")) {
            header("Location: ../editprofile?id=" . $userId);
            die();
        }
    }
    
    //Update Penpal Setting
    if ($penpal) {
        $query = "UPDATE users SET penpal = :penpal WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->bindParam(":penpal", $penpal);
        $stmt->execute();
    }
    
    //Reply Message
    $greeting = "Your penpal filter setting has been adjusted to " . $penpal;
        $reply = $greeting;
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
    
    header("Location: ../penpals");
    
    
    
} else {
    header("Location: ../");
}
