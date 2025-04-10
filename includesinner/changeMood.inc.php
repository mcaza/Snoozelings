<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

//Get Variables
    $userId = $_COOKIE['user_id'];
    $mood = $_POST['mood'];
    
    //Check for Fake Moods 
    if(!($mood === "Happy" || $mood === "Sleepy" || $mood === "Overwhelmed" || $mood === "Anxious" || $mood === "Cheeky")) {
        header("Location: ../index");
        die();
    }
    
    //Grab Bonded ID
    $query = "SELECT bonded FROM users WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Apply Mood
    $query = "UPDATE snoozelings SET mood = :mood WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $result['bonded']);
    $stmt->bindParam(":mood", $mood);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Redirect to Profile
    header("Location: ../profile?id=" . $userId);
    
    
    } else {
     header("Location: ../index");
}