<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

//Get Variables
    $userId = $_COOKIE['user_id'];
    $type = $_POST['type'];
    $entries = 0;
    $premium = 0;
    
    //Get Date
    $now = new DateTime("now", new DateTimezone('UTC'));
    $formatted = $now->format('Y-m-d');
    
    //Insert New Journal into type of journal
    $query = 'INSERT INTO journals (user_id, type, dateStarted, entries, premium) VALUES (:userId, :type, :date, :entries, :premium)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":type", $type);
    $stmt->bindParam(":userId", $userId);
    $stmt->bindParam(":date", $formatted);
    $stmt->bindParam(":entries", $entries);
    $stmt->bindParam(":premium", $premium);
    $stmt->execute();
    
        //Update Tutorial
    $query = 'UPDATE users SET tutorial = 4 WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    
    header("Location: ../journal.php");
} else {
header("Location: ../journal.php");
    die();
}
