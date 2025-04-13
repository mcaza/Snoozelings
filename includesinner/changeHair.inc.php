<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userId = $_COOKIE['user_id'];
    
    //Get Variables
    $hair = $_POST["hair"];
    $id = $_POST["snoozeling"];
    
   //Get Pet Name
    $query = "SELECT name, pronouns FROM snoozelings WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $name = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Pronouns
    if ($name['pronouns'] === "He/Him") {
        $pronouns = "his";
    } elseif ($name['pronouns'] === "She/Her") {
        $pronouns = "her";
    } else {
        $pronouns = "their";
    }
    
    //Check Selection
    if ($hair == "Braid" || $hair == "Mane" || $hair == "Floof" || $hair == "Forelock" || $hair == "Mohawk" || $hair == "Wave") {
        
    } else {
        header("Location: ../");
        die()
    }
    
    //Check for Coins. If no coins, reroute to trendytails with error message
    $query = "SELECT coinCount FROM users WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $coins = $stmt->fetch(PDO::FETCH_ASSOC);
    $count = intval($coins['coinCount']);
    
    if ($count < 10) {
            $reply = "You do not have enough snooze coins.";
            $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":user_id", $userId);
            $stmt->bindParam(":message", $reply);
            $stmt->execute();
        header("Location: ../trendytails");
        die();
    } else {
        
    //Remove 10 coins
    $query = 'UPDATE users SET coinCount = coinCount - 10 WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
        
    //Change Hairstyle
    $query = 'UPDATE snoozelings SET hairType = :hair WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":hair", $hair);
    $stmt->execute();
        
    //Update Session message
    $greeting = '<p>' . htmlspecialchars($name['name']) . ' loves ' . $pronouns . ' new hairstyle!!!</p>';
    $reply = $greeting;
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
    
    //Reroute to trendytails
    header("Location: ../trendytails");
    }
    
    
    
} else {
    header("Location: ../trendytails");
}
