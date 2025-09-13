<?php
require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") { 

    //Get Values
    $userId = $_COOKIE['user_id'];
    $id = $_POST['item'];

    //Check if Owner Owns that Item
    $query = "SELECT * FROM items WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $itemCheck = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($itemCheck == false) {
        header("Location: ../index");
        die();
    } 

    if ($itemCheck['user_id'] == $userId) {

    } else {
        header("Location: ../index");
        die();
    }
    
    if ($id == 213) {
        $greeting = 'This item cannot be bleached.';
        $reply = $greeting;
        $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":message", $reply);
        $stmt->execute();
        header("Location: ../pack");
    }

    //Remove Dye
    $query = "UPDATE items SET dye = NULL WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $request = $stmt->fetch(PDO::FETCH_ASSOC);

    //Remove Bleach from Items
    $query = 'DELETE FROM items WHERE user_id = :id AND list_id = 263 LIMIT 1';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();

    //Message and Return
    $greeting = 'You have successfully removed the dye from '. $itemCheck['display'] . '.';
        $reply = $greeting;
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
    header("Location: ../pack");

} else {
    header("Location: ../index");
}
