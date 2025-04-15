<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    //Basic Info
    $userId = $_COOKIE['user_id'];

    //Check if Already Wished
    //Get User Info
    $query = "SELECT * FROM users WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['dailyWish'] == 1) {
        $reply = "You have already made a wish today.";
        $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":message", $reply);
        $stmt->execute();
        header("Location: ../wishingwell");
        die();
    }
    
    //Check for Old Coin
    $query = "SELECT * FROM items WHERE list_id = 73 AND user_id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $coinCheck = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$coinCheck) {
        $reply = "You don't have any Old Coins to throw into the well.";
        $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":message", $reply);
        $stmt->execute();
        header("Location: ../wishingwell");
        die();
    }
    
    //Delete Old Coin
    $query = "DELETE FROM items WHERE list_id = 73 AND user_id = :id LIMIT 1";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();

    //Get all Common Colors
    $query = 'SELECT * FROM colors WHERE rarity = "Common"';
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count = count($results) - 1;

    //Randomize Color
    $num = rand(0, $count);
    $name = 'Stain' . $results[$num]['name'];
        
    $query = 'SELECT * FROM itemList WHERE name = :name';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $name);
    $stmt->execute();
    $iteminfo = $stmt->fetch(PDO::FETCH_ASSOC);

    //Add Item
    $query = "INSERT INTO items (list_id, user_id, name, display, description, type, rarity, canDonate) VALUES (:list, :user, :name, :display, :description, :type, :rarity, :canDonate);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":list", $iteminfo['id']);
    $stmt->bindParam(":user", $userId);
    $stmt->bindParam(":name", $iteminfo['name']);
    $stmt->bindParam(":display", $iteminfo['display']);
    $stmt->bindParam(":description", $iteminfo['description']);
    $stmt->bindParam(":type", $iteminfo['type']);
    $stmt->bindParam(":rarity", $iteminfo['rarity']);
    $stmt->bindParam(":canDonate", $iteminfo['canDonate']);
    $stmt->execute();

    //Change dailyWish
    $one = 1;
    $query = "UPDATE users SET dailyWish = :num WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":num", $one);
    $stmt->execute();

    //Reply
    $reply = 'You drop your old coin into the well.<br><br>Stain: ' . $results[$num]['display'] . ' appears magically at your paws.';
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();

        //Return
        header("Location: ../wishingwell");
    
} else {
header("Location: ../wishingwell");
    die();
}
