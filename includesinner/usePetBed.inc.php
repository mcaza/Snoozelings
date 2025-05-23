<?php
require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $userId = $_COOKIE['user_id'];

    //Check How Many Beds. Max is Currently 9
    $query = 'SELECT * FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    //Check if Pet Bed Item
    $query = 'SELECT * FROM items WHERE user_id = :id AND list_id = 155';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $check = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($check) {
        //If Below, Add New Farm Plot
        if (intval($result['petBeds']) < 8) {
            //Delete Item
            $query = 'DELETE FROM items WHERE user_id = :id AND list_id = 155 LIMIT 1';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $userId);
            $stmt->execute();

            //Install New Bed
            $query = 'UPDATE users SET petBeds = petBeds + 1 WHERE id = :id';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $userId);
            $stmt->execute();

            //Variables
                $reply = "You have successfully set up a new pet bed.";
            $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":user_id", $userId);
            $stmt->bindParam(":message", $reply);
            $stmt->execute();

            //Reroute to Pack
            header("Location: ../pack");

        } else {
                $reply = "You already have the maximum number of pet beds.";
            $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":user_id", $userId);
            $stmt->bindParam(":message", $reply);
            $stmt->execute();
            header("Location: ../pack");
        }

    } else {
        header("Location: ../");
    }
    
        
} else {
    header("Location: ../");
}