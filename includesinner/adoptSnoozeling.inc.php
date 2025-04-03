<?php
require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    //Get Values
    if ($_SESSION['user_id']) {
        $userId = $_SESSION['user_id'];
    } else {
        header("Location: ../login");
        die();
    }
    $adopt = $_POST['pet'];
    $maxpets = 7;
    
    
    
    //Get Adoption Info
    $query = 'SELECT * FROM adopts WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $adopt);
    $stmt->execute();
    $pet = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Check if Owner ID is 0
    $query = 'SELECT * FROM snoozelings WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $pet['pet_id']);
    $stmt->execute();
    $ownerCheck = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Check if User has Blueprints Waiting
    $query = 'SELECT * FROM blueprints WHERE owner_id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $bpCheck = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($bpCheck) {
        $_SESSION['reply'] = "You are unable to adopt until Minky delivers your finished snoozeling.";
        header("Location: ../adoption");
        die();
    }
    
    if ($ownerCheck['owner_id'] == 0) {
        
    } else {
        //Reply & Reroute
        $_SESSION['reply'] = "This snoozeling has already been adopted. Please report this bug to Moderator Mail";
        header("Location: ../adoption");
        die();
    }
    
    //Check Coins
    $query = 'SELECT coinCount, petBeds, petOrder FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $coins = $stmt->fetch(PDO::FETCH_ASSOC);
    if (intval($coins['coinCount']) < intval($pet['cost'])) {
        $_SESSION['reply'] = 'You do not have enough snooze coins to adopt that snoozeling';
        header("Location: ../adoption");
        die();        
    }

    //Check Empty Beds
    $query = 'SELECT * FROM snoozelings WHERE owner_id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $petcheck = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $emptybeds = intval($coins['petBeds']) - count($petcheck);
    if ($emptybeds < 1) {
        $_SESSION['reply'] = 'You do not have an empty bed available';
        header("Location: ../adoption");
        die();
    }
    
    //Take Coins & Bed
    $query = 'UPDATE users SET coinCount = coinCount - :coins WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":coins", $pet['cost']);
    $stmt->execute();
    
    //Give Kindness Coin to Donator
    $query = 'UPDATE users SET kindnessCount = kindnessCount + 1 WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $pet['owner_id']);
    $stmt->execute();
    
    //Daily Records
    $query = 'UPDATE dailyRecords SET kindnessCoins = kindnessCoins + 1 ORDER BY id DESC LIMIT 1';
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
    $title = "Recently Adopted";
    $query = 'UPDATE snoozelings SET owner_id = :id, gotchaDate = :date, title = :title WHERE id = :pet';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":pet", $pet['pet_id']);
    $stmt->bindParam(":date", $todaysDate);
    $stmt->bindParam(":title", $title);
    $stmt->execute();
    
    //Add to Custom Order
    if ($coins['petOrder']) {
        $newOrder = $coins['petOrder'] . " " . $pet['pet_id'];
        $query = 'UPDATE users SET petOrder = :petOrder WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->bindParam(":petOrder", $newOrder);
        $stmt->execute();
    }
    
    //Remove Adopt
    $query = "DELETE FROM adopts WHERE pet_id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $pet['pet_id']);
    $stmt->execute();
    
    //Reroute to pet page
    header("Location: ../pet?id=" . $pet['pet_id']);
    
} else {
header("Location: ../index");
    die();
}
