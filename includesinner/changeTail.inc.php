<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userId = $_SESSION['user_id'];
    
    //Get Variables
    $tail = $_POST["tails"];
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
    
    //Check for Coins. If no coins, reroute to trendytails with error message
    $query = "SELECT coinCount FROM users WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $coins = $stmt->fetch(PDO::FETCH_ASSOC);
    $count = intval($coins['coinCount']);
    
    if ($count < 10) {
        $_SESSION['reply'] = "You do not have enough snooze coins.";
        header("Location: ../trendytails");
        die();
    } else {
        
    //Remove 10 coins
    $query = 'UPDATE users SET coinCount = coinCount - 10 WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
        
    //Change Tailstyle
    $query = 'UPDATE snoozelings SET tailType = :tail WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":tail", $tail);
    $stmt->execute();
        
    //Update Session message
    $_SESSION['reply'] = htmlspecialchars($name['name'] . ' loves ' . $pronouns . ' new tailstyle!!!');
    
    //Reroute to trendytails
    header("Location: ../trendytails");
    }
    
    
    
} else {
    header("Location: ../trendytails");
}

