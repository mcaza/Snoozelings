<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $userId = $_SESSION['user_id'];
    $snoozeling = $_POST["snoozelingid"];
    $marking = $_POST["marking"];
    
    //Check Still have Wish Token
    $query = 'SELECT * FROM items WHERE user_id = :id AND list_id = 225';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $check = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($check) {
        
    } else {
        header("Location: ../index");
        die();
    }
    
    //Check if Pet is owned by them
    $query = 'SELECT * FROM snoozelings WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $snoozeling);
    $stmt->execute();
    $petcheck = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($petcheck['owner_id'] == $userId) {
        
    } else {
        header("Location: ../index");
        die();
    }
    
    //Check if they have marking already
    if(str_contains($petcheck['specials'],$marking) !== false) {
        $_SESSION['reply'] = "Your snoozeling already has this marking.";
        header("Location: ../pack");
        die();
    }
    
    //Add Marking
    $newmarkings = $petcheck['specials'] . ' ' . $marking;
    $query = 'UPDATE snoozelings SET specials = :specials WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $snoozeling);
    $stmt->bindParam(":specials", $newmarkings);
    $stmt->execute();
    
    //Delete Wish Token
    $query = 'DELETE FROM items WHERE user_id = :id AND list_id = 225 LIMIT 1';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    
    
    //Return
    $_SESSION['reply'] = "Your wish has come true!";
    header("Location: ../pack");
    die();
} else {
    header("Location: ../index");
    die();
}