<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userId = $_SESSION['user_id'];
    $job = $_POST['job'];
    $id = $_POST['id'];
    
    //Check if Pet is Owned by User
    $query = 'SELECT owner_id FROM snoozelings WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $snooze = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!($userId === $snooze['owner_id'])) {
        header("Location: ../petJob?id=" . $id);
        die();
    }
    
    //Check if No Custom Values are Enterred
    if(!(($job === 'jack') || ($job === "Farmer") || ($job === "Explorer") || ($job === "Crafter"))) {
        header("Location: ../petJob?id=" . $id);
        die();
    }
    
    //Check if Snoozeling is crafting
    $query = 'SELECT * FROM craftingtables WHERE pet_id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $table = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($table) {
        if ($table['display']) {
            $_SESSION['reply'] = "Your snoozeling cannot change jobs because they are currently crafting.";
            header("Location: ../crafting");
            die(); 
        }
    }
    
    //Change Job
    $query = "UPDATE snoozelings SET job = :job WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":job", $job);
    $stmt->execute();
    
    //Reroute
    header("Location: ../pet?id=" . $id);
    
} else {
header("Location: ../index");
    die();
}

