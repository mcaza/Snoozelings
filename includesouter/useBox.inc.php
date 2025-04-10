<?php
require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $userId = $_COOKIE['user_id'];

    //Check How Many Boxes. Max is Currently 9
    $query = 'SELECT * FROM farms WHERE user_id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count = count($results);

    //Check if Farmer Box Item
    $query = 'SELECT * FROM items WHERE user_id = :id AND list_id = 114';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $check = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($check) {
        //If Below, Add New Farm Plot
        if ($count < 9) {
            //Delete Item
            $query = 'DELETE FROM items WHERE user_id = :id AND list_id = 114 LIMIT 1';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $userId);
            $stmt->execute();

            //Install New Farm
            $query = 'INSERT INTO farms (user_id) VALUES (:id)';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $userId);
            $stmt->execute();

            //Variables
            setcookie('reply', 'You have successfully installed a new farm plot.', 60, '/');

            //Reroute to Pack
            header("Location: ../pack");

        } else {
            setcookie('reply', 'You already have the maximum amount of farm plots.', 60, '/');
            header("Location: ../pack");
        }

    } else {
        header("Location: ../");
    }
    
        
} else {
    header("Location: ../");
}