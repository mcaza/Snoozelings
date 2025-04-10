<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userId = $_COOKIE['user_id'];
    
    //Grab All Pets
    $query = "SELECT * FROM snoozelings WHERE owner_id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $snoozelings = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    //Count Pets
    $count = count($snoozelings);
    
    //Value Array
    $pets = [];
    
    //Get Pet Ids
    for($i = 0; $i < $count; $i++) {
        $j = $i + 1;
        $word = "snoozeling" . $j;
        $petId = $_POST[$word];
        array_push($pets, $petId);
    }
    
    
    //Check if All Pets are Owned by User
    foreach ($pets as $pet) {

        $query = "SELECT * FROM snoozelings WHERE owner_id = :id AND id = :petId";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->bindParam(":petId", $pet);
        $stmt->execute();
        $petCheck = $stmt->fetch(PDO::FETCH_ASSOC);

        
        if ($petCheck['owner_id'] == $userId) {
            
        } else {
                $reply = "You have submitted a snoozeling you do not own.";
            $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":user_id", $userId);
            $stmt->bindParam(":message", $reply);
            $stmt->execute();
            header("Location: ../reorder");
            die();
        }
    }
    
    //Check for Duplicates
    $temp_array = array_unique($pets);
    $duplicates = sizeof($temp_array) != sizeof($pets);
    
    if ($duplicates) {
            $reply = "You have submitted the same snoozeling more than once.";
        $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":message", $reply);
        $stmt->execute();
        header("Location: ../reorder");
        die();
    }
    
    //Create String
    $string = "";
    foreach ($pets as $pet) {
        if (!$string) {
            $string = $pet;
        } else {
            $string = $string . " " . $pet;
        }
    }
    
    //Update User
    $query = "UPDATE users SET petOrder = :petOrder WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":petOrder", $string);
    $stmt->execute();
    
        $reply = "You have successfully changed the order of your snoozelings.";
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
    header("Location: ../reorder");
    
} else {
    header("Location: ../index");
}












