<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //Values
    $userId = $_SESSION['user_id'];
    $id = $_POST['donation'];
    
    //Check if Item is owned by person
    $query = 'SELECT * FROM items WHERE list_id = :id AND user_id = :user';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":user", $userId);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($results) {
        
    } else {
        header("Location: ../");
    }
    
    //Check if Item can be Donated (And grab item info)
    $query = 'SELECT * FROM itemList WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $item = $stmt->fetch(PDO::FETCH_ASSOC);
    if (intval($item['canDonate']) === 0) {
        $_SESSION['reply'] = 'That item cannot be donated';
        header("Location: ../raffle");
    }
    
    //Donate Item
    $query = 'INSERT INTO raffleitems (donator_id, list_id, item, display) VALUES (:donator, :list, :item, :display)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":donator", $userId);
    $stmt->bindParam(":list", $item['id']);
    $stmt->bindParam(":item", $item['name']);
    $stmt->bindParam(":display", $item['display']);
    $stmt->execute();
    
    //Remove item from inventory
    $query = 'DELETE FROM items WHERE list_id = :id AND user_id = :user LIMIT 1';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":user", $userId);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    //Redirect
    $_SESSION['reply'] = 'Your item has been donated';
        header("Location: ../raffle");
    
} else {
    header("Location: ../index");
}