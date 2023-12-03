<?php
require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    //Get Values
    $userId = $_SESSION['user_id'];
    $adopt = $_POST['pet'];
    $list = 27;
    
    //Get Adoption Info
    $query = 'SELECT * FROM adopts WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $adopt);
    $stmt->execute();
    $pet = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Check Coins
    $query = 'SELECT coinCount FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $coins = $stmt->fetch(PDO::FETCH_ASSOC);
    if (intval($coins['coinCount']) < intval($pet['cost'])) {
        $_SESSION['reply'] = '<p>You do not have enough coins to adopt that snoozeling.</p>';
        header("Location: ../adoption");
        die();        
    }
    
    //Check Bed
    if ($pet['bed'] === "0") {
        $query = 'SELECT * FROM items WHERE list_id = :list AND user_id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":list", $list);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
        $bed = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$bed) {
            $_SESSION['reply'] = '<p>You need a pet bed to adopt this snoozeling.</p>';
            header("Location: ../adoption");
            die();        
        }
    }
    
    //Take Coins & Bed
    $query = 'UPDATE users SET coinCount = coinCount - :coins WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":coins", $pet['cost']);
    $stmt->execute();
    if ($pet['bed'] === "0") {
        $query = 'DELETE FROM items WHERE list_id = :list AND user_id = :id LIMIT 1';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":list", $list);
        $stmt->bindParam(":id", $userId);
        $stmt->execute(); 
    }
    
    //Give Kindness Coin to Donator
    $one = 1;
    $query = 'UPDATE users SET kindnessCount = kindnessCount - :one WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":one", $one);
    $stmt->execute();
    
    //Send Letter to Donator
    
    
    //Set owner_id of pet to new owner
    $query = 'UPDATE snoozelings SET owner_id = :id WHERE id = :pet';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":pet", $pet['pet_id']);
    $stmt->execute();
    
    //Remove Adopt
    $query = "DELETE FROM adopts WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $adopt);
    $stmt->execute();
    
    //Reroute to pet page
    header("Location: ../pet?id=" . $pet['pet_id']);
    
} else {
header("Location: ../index");
    die();
}
