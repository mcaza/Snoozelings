<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //Values
    $userId = $_SESSION['user_id'];
    
    //Make sure they have 1 coin
    $query = 'SELECT coinCount FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $coincount = $stmt->fetch(PDO::FETCH_ASSOC);
    $coins = intval($coincount['coinCount']);
    if ($coins < 1) {
        $_SESSION['reply'] = 'You do not have enough coins to do this.';
        header("Location: ../raffle");
        die();
    }
    
    //Add Name to Raffle Tickets
    $query = 'SELECT * FROM rafflecount ORDER BY id DESC LIMIT 1';
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $entries = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($entries) {
        $array = explode(" ", $entries['entries']);
        $count = count($array) - 1;
    } else {
        $count = 0;
    }
    
    $temp = $entries['entries'] . ' ' . $userId;
    $temp = trim($temp);
    
    $query = 'UPDATE rafflecount SET entries = :temp WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $entries['id']);
    $stmt->bindParam(":temp", $temp);
    $stmt->execute();
    

    
    //Minus 1 Coin
    $price = 1;
    $query = 'UPDATE users SET coinCount = coinCount - :price WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":price", $price);
    $stmt->execute();
    
    $_SESSION['reply'] = 'You have entered today\'s raffle.';
        header("Location: ../raffle");
    
} else {
    header("Location: ../index");
}
