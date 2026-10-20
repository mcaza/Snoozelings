<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //Get Values
    $userId = $_COOKIE['user_id'];
    $name = $_POST['shopName'];
    
    //Check for Shop
    $query = "SELECT * FROM marketTables WHERE user_id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $table = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($table) {
        header("Location: ../");
        die();
    }
    
    //Check Requirements
    $query = "SELECT * FROM users WHERE id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user['marketSetup'] > 1 || $user['marketSetup'] < 1) { 
        header("Location: ../");
        die();
    }
    
    //Check Name is in List
    $query = "SELECT * FROM shopNames WHERE name = :name;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $name);
    $stmt->execute();
    $nameCheck = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($nameCheck) {
        
    } else {
        header("Location: ../");
        die();
    }
    
    //Open Shop
    $query = "INSERT INTO marketTables (user_id, pet_id, name) VALUES (:user, :pet, :name)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user", $userId);
    $stmt->bindParam(":pet", $user['bonded']);
    $stmt->bindParam(":name", $name);
    $stmt->execute();
                                                               
    //Market to 2
    $query = 'UPDATE users SET marketSetup = 2 WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute(); 
    
    //Reply and Reroute
    $query = "SELECT * FROM snoozelings WHERE id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $user['bonded']);
    $stmt->execute();
    $pet = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $greeting = $pet['name'] . '\'s ' . $name . ' is officially open for business.';
    $reply = $greeting;
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
    header("Location: ../fleaMarket");
    
} else {
    header("Location: ../");
}
