<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userId = $_SESSION['user_id'];
    $one = $_POST['petone'];
    $two = $_POST['pettwo'];
    $bed = $_POST['bed'];
    
    //Check Pet Confirmation
    if (!($one == $two)) {
        $_SESSION['reply'] = '<p>You have selected two different pets. Please try again.</p>';
        header("Location: ../adoption");
        die(); 
    }
    
    //Check if Pet is Bonded
    $query = 'SELECT bonded FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $bonded = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($bonded['bonded'] == $one) {
        $_SESSION['reply'] = '<p>You can not donate the pet you are currently bonded to.</p>';
        header("Location: ../adoption");
        die(); 
    }
    
    //Check if pet is owned by them
    $check = 0;
    $query = "SELECT * FROM snoozelings WHERE owner_id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $pets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($pets as $pet) {
        if ($one === $pet['id']) {
            $check = 1;
        }
    }
    if ($check === 0) {
        $_SESSION['reply'] = '<p>You have selected a pet you do not own.</p>';
        header("Location: ../adoption");
        die(); 
    }
    
    
    
    //Check if Pet is crafter
    $query = 'SELECT pet_id FROM craftingtables WHERE user_id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $crafter = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($crafter['pet_id'] === $one) {
        $_SESSION['reply'] = '<p>You can not donate the pet currently assigned to your crafting table.</p>';
        header("Location: ../adoption");
        die(); 
    }
    
    //Set Adoption Release Time
    $now = new DateTime(null, new DateTimezone('UTC'));
    $hours = rand(8, 24);
    $modified = (clone $now)->add(new DateInterval("PT{$hours}H")); 
    $formatted = $modified->format('Y-m-d H:i:s');
    
    //Calculate Coin Cost
    $query = "SELECT * FROM snoozelings WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $one);
    $stmt->execute();
    $pet = $stmt->fetch(PDO::FETCH_ASSOC);
    $colors = [];
    $coins = 0;
    array_push($colors, $pet['mainColor'], $pet['hairColor'], $pet['tailColor'], $pet['eyeColor'], $pet['noseColor']);
    foreach ($colors as $color) {
        $query = 'SELECT rarity FROM colors WHERE name = :name';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":name", $color);
        $stmt->execute();
        $rarity = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($rarity['rarity'] === "Common") {
            $coins += 3;
        } elseif ($rarity['rarity'] === "Uncommon") {
            $coins += 5;
        } elseif ($rarity['rarity'] === "Rare") {
            $coins += 10;
        } else {
            $coins += 6;
        }
    }
    if ($pet['specials']) {
        $specials = explode(" ", $pet['specials']);
        $add = count($specials) * 5;
        $coins += $add;
    }
    
    //Add to Adoption
    $zero = 0;
    $query = 'INSERT INTO adopts (pet_id, owner_id, cost, bed, datetime, name, available) VALUES (:pet, :owner, :cost, :bed, :date, :name, :available)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":pet", $pet['id']);
    $stmt->bindParam(":owner", $pet['owner_id']);
    $stmt->bindParam(":cost", $coins);
    $stmt->bindParam(":bed", $bed);
    $stmt->bindParam(":date", $formatted);
    $stmt->bindParam(":name", $pet['name']);
    $stmt->bindParam(":available", $zero);
    $stmt->execute();
    
    //Return Bed
    if ($bed === "0") {
        $list = 27;
        $name = "PetBed";
        $display = "Pet Bed";
        $description = "This bed allows you to have another snoozeling.";
        $type = "crafted";
        $rarity = "special"; 
        $canDonate = 1;
        $query = 'INSERT INTO items (list_id, user_id, name, display, description, type, rarity, canDonate) VALUES (:list, :user, :name, :display, :description, :type, :rarity, :canDonate)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":list", $list);
        $stmt->bindParam(":user", $userId);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":display", $display);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":type", $type);
        $stmt->bindParam(":rarity", $rarity);
        $stmt->bindParam(":canDonate", $canDonate);
        $stmt->execute();
    } 
    
    
    
    //Remove & Return all Clothes
    if ($pet['clothesBottom']) {
        $clothes = explode(" ", $pet['clothesBottom']);
        foreach ($clothes as $clothing) {
            $query = 'SELECT * FROM itemList WHERE name = :name';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":name", $clothing);
            $stmt->execute();
            $item = $stmt->fetch(PDO::FETCH_ASSOC);
            $query = "INSERT INTO items (list_id, user_id, name, display, description, type, rarity, canDonate) VALUES (:list, :user, :name, :display, :description, :type, :rarity, :canDonate);";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":list", $item['id']);
            $stmt->bindParam(":user", $userId);
            $stmt->bindParam(":name", $item['name']);
            $stmt->bindParam(":display", $item['display']);
            $stmt->bindParam(":description", $item['description']);
            $stmt->bindParam(":type", $item['type']);
            $stmt->bindParam(":rarity", $item['rarity']);
            $stmt->bindParam(":canDonate", $item['canDonate']);
            $stmt->execute();
        }
    }
    if ($pet['clothesTop']) {
        $clothes = explode(" ", $pet['clothesTop']);
        foreach ($clothes as $clothing) {
            $query = 'SELECT * FROM itemList WHERE name = :name';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":name", $clothing);
            $stmt->execute();
            $item = $stmt->fetch(PDO::FETCH_ASSOC);
            $query = "INSERT INTO items (list_id, user_id, name, display, description, type, rarity, canDonate) VALUES (:list, :user, :name, :display, :description, :type, :rarity, :canDonate);";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":list", $item['id']);
            $stmt->bindParam(":user", $userId);
            $stmt->bindParam(":name", $item['name']);
            $stmt->bindParam(":display", $item['display']);
            $stmt->bindParam(":description", $item['description']);
            $stmt->bindParam(":type", $item['type']);
            $stmt->bindParam(":rarity", $item['rarity']);
            $stmt->bindParam(":canDonate", $item['canDonate']);
            $stmt->execute();
        }
    }
    if ($pet['clothesHoodie']) {
        $clothes = explode(" ", $pet['clothesHoodie']);
        foreach ($clothes as $clothing) {
            $query = 'SELECT * FROM itemList WHERE name = :name';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":name", $clothing);
            $stmt->execute();
            $item = $stmt->fetch(PDO::FETCH_ASSOC);
            $query = "INSERT INTO items (list_id, user_id, name, display, description, type, rarity, canDonate) VALUES (:list, :user, :name, :display, :description, :type, :rarity, :canDonate);";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":list", $item['id']);
            $stmt->bindParam(":user", $userId);
            $stmt->bindParam(":name", $item['name']);
            $stmt->bindParam(":display", $item['display']);
            $stmt->bindParam(":description", $item['description']);
            $stmt->bindParam(":type", $item['type']);
            $stmt->bindParam(":rarity", $item['rarity']);
            $stmt->bindParam(":canDonate", $item['canDonate']);
            $stmt->execute();
        }
    }
    if ($pet['clothesBoth']) {
        $clothes = explode(" ", $pet['clothesBoth']);
        foreach ($clothes as $clothing) {
            $query = 'SELECT * FROM itemList WHERE name = :name';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":name", $clothing);
            $stmt->execute();
            $item = $stmt->fetch(PDO::FETCH_ASSOC);
            $query = "INSERT INTO items (list_id, user_id, name, display, description, type, rarity, canDonate) VALUES (:list, :user, :name, :display, :description, :type, :rarity, :canDonate);";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":list", $item['id']);
            $stmt->bindParam(":user", $userId);
            $stmt->bindParam(":name", $item['name']);
            $stmt->bindParam(":display", $item['display']);
            $stmt->bindParam(":description", $item['description']);
            $stmt->bindParam(":type", $item['type']);
            $stmt->bindParam(":rarity", $item['rarity']);
            $stmt->bindParam(":canDonate", $item['canDonate']);
            $stmt->execute();
        }
    }
    
    //Fix Pet Values
    $erase = "";
    $closed = "Closed";
    $jack = "jack";
    $zero = 0;
    $title = "Up for Adoption";
    $query = 'UPDATE snoozelings SET owner_id = :erase, breedStatus = :closed, job = :jack, farmEXP = :zero, craftEXP = :zero, exploreEXP = :zero, title = :title, clothesbottom = :erase, clothesTop = :erase, clothesBoth = :erase, clothesHoodie = :erase WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":erase", $erase);
    $stmt->bindParam(":closed", $closed);
    $stmt->bindParam(":jack", $jack);
    $stmt->bindParam(":zero", $zero);
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":id", $one);
    $stmt->execute(); 
    
    $_SESSION['reply'] = '<p>Your pet has been donated and will be available after their spa day.</p>';
        header("Location: ../adoption");

} else {
header("Location: ../index");
    die();
}






















