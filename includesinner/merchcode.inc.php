<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $userId = $_SESSION['user_id'];
    $code = htmlspecialchars($_POST['code']);

    //Turn Code to Uppercase & Remove End Spaces
    $uppercode =  strtoupper($code);
    $cleancode = trim($uppercode);
    
    //Search itemCodes for Code
    $query = 'SELECT * FROM itemCodes WHERE code = :code';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":code", $cleancode);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //If results
    if ($result) {
        if ($result['redeemed'] == 0) {
            //Add Item to Inventory
            $query = 'SELECT * FROM itemList WHERE name = :name';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":name", $result['item']);
            $stmt->execute();
            $iteminfo = $stmt->fetch(PDO::FETCH_ASSOC);

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

            //Mark code as redeemed
            $query = 'UPDATE itemCodes SET redeemed = 1 WHERE code = :code';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":code", $cleancode);
            $stmt->execute();
            $iteminfo = $stmt->fetch(PDO::FETCH_ASSOC);

            //Redirect
            $_SESSION['reply'] = "Code successfully redeemed. Your item has been added to your fanny pack.";
            header("Location: ../coderedemption");

        } else {
            //Code already redeemed
            $_SESSION['reply'] = "That code has already been redeemed.";
            header("Location: ../coderedemption");

        }
    } else {
        //If no results, throw error and redirect
        $_SESSION['reply'] = "You have enterred an incorrect code. Please try again.";
        header("Location: ../coderedemption");

    }
    
} else {
    header("Location: ../");
    die();
}