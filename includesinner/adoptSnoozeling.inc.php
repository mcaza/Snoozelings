<?php
require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    //Get Values
    $userId = $_SESSION['user_id'];
    $adopt = $_POST['pet'];
    $list = 27;
    $maxpets = 3;
    
    //Get Adoption Info
    $query = 'SELECT * FROM adopts WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $adopt);
    $stmt->execute();
    $pet = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Check Max Pets
    $query = 'SELECT * FROM snoozelings WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $allpets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($allpets) >= $maxpets) {
        $_SESSION['reply'] = 'You already have the max number of snoozelings.';
        header("Location: ../adoption");
        die(); 
    }
    
    //Check Coins
    $query = 'SELECT coinCount FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $coins = $stmt->fetch(PDO::FETCH_ASSOC);
    if (intval($coins['coinCount']) < intval($pet['cost'])) {
        $_SESSION['reply'] = 'You do not have enough coins to adopt that snoozeling.';
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
            $_SESSION['reply'] = 'You need a pet bed to adopt this snoozeling.';
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
    $query = 'UPDATE users SET kindnessCount = kindnessCount + 1 WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $pet['owner_id']);
    $stmt->execute();
    
    //Daily Records
    $query = 'UPDATE dailyRecords SET kindnessCoins = kindnessCoins + 1';
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    //Send Letter to Donator
    $message = "What a beautiful day for an adoption!!!
    
    I'm just writing you this letter quick to let you know the snoozeling that you left in my care, " . $pet['name'] . ', has found a new home.
    
    They are adored and very well taken care of. One might even say they are a bit spoiled.
    
    As thanks for your kind gesture, I\'ve deposited a kindness coin into your bank.
    
    With lots of love,
    ~Miss Lulu';
    $title = $pet['name'] . " has found a home";
    $from = 5;
    $one = 1;
    $zero = 0;
    $picture = "adoptNPC";
    $now = new DateTime();
    $date = $now->format('Y-m-d H:i:s');
    $query = "INSERT INTO mail (sender, reciever, title, message, sent, opened, sendtime, picture) VALUES (:from, :to, :title, :message, :sent, :opened, :datetime, :picture)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":from", $from);
    $stmt->bindParam(":to", $pet['owner_id']);
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":message", $message);
    $stmt->bindParam(":sent", $one);
    $stmt->bindParam(":opened", $zero);
    $stmt->bindParam(":datetime", $date);
    $stmt->bindParam(":picture", $picture);
    $stmt->execute();
    
    //Set owner_id of pet to new owner & Gotcha Date
    $todaysDate = date("Y-m-d");
    $query = 'UPDATE snoozelings SET owner_id = :id, gotchaDate = :date WHERE id = :pet';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":pet", $pet['pet_id']);
    $stmt->bindParam(":date", $todaysDate);
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
