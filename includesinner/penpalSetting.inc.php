<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';



if ($_SERVER["REQUEST_METHOD"] === "POST") {
//Grab Form Variables
    $penpal = $_POST['penpal'];
    $userId = $_SESSION['user_id'];
    
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
    $_SESSION['reply'] = "Your penpal filter setting has been adjusted to " . $penpal;
    
    header("Location: ../penpals");
    
    
    
} else {
    header("Location: ../");
}
