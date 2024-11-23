<?php

$userId = $_SESSION['user_id'];

if ($_SESSION['reply']) {
    $reply = $_SESSION['reply'];
    unset($_SESSION['reply']);
}

//Count All Beds
$query = "SELECT * FROM users WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$query = "SELECT * FROM items WHERE user_id = :id AND list_id = 155";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$beds = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = $user['petBeds'] + count($beds);

//Calculate Bed Cost
if ($total == 2) {
    $amount = 5;
} else if ($total == 3) {
    $amount = 10;
} else if ($total == 4) {
    $amount = 20;
} else if ($total == 5) {
    $amount = 30;
} else if ($total == 6) {
    $amount = 40;
} else if ($total == 7) {
    $amount = 50;
} else if ($total == 8) {
    $amount = 75;
} 

//Coin Cost
if ($total == 2) {
    $coinAmount = 50;
} else if ($total == 3) {
    $coinAmount = 100;
} else if ($total == 4) {
    $coinAmount = 200;
} else if ($total == 5) {
    $coinAmount = 400;
} else if ($total == 6) {
    $coinAmount = 800;
} else if ($total == 7) {
    $coinAmount = 1600;
} else if ($total == 8) {
    $coinAmount = 3200;
} 

//Future Updates -> 150, 250, 400, 600, 800, 1000
//Top Div
echo '<div class="topShop">';

//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="shops"><<</a>';
echo '</div>';
    
//Display Coin Count Top Right
echo '<div>';
if ($player['coinCount'] === "1") {
    echo '<p><strong>Inventory: </strong>' . $user['coinCount'] . ' Snooze Coin</p>';
} else {
    echo '<p><strong>Inventory: </strong>' . $user['coinCount'] . ' Snooze Coins</p>';
}

echo '</div>';
echo '</div>';

//Session Reply Area
if ($reply) {
    echo '<div class="returnBar" style="margin-top: 1rem;"><p>' . $reply . '</p></div>';
}

//Show Image. Change Later
echo '<img src="resources/bedNPC.png" style="width: 45%;">';

if ($total < 9) {
    
    //Check Feather Counts
    $query = "SELECT * FROM items WHERE user_id = :id AND list_id = 29";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $tiny = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $query = "SELECT * FROM items WHERE user_id = :id AND list_id = 41";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $colorful = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $query = "SELECT * FROM items WHERE user_id = :id AND list_id = 59";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $seagull = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo '<p><i>"Bring me the following items and I\'ll craft you a new pet bed."</i></p>';
    echo '<hr>';
    
    if (count($tiny) >= $amount) {
        echo '<p>✔️ ' . $amount . '/' . $amount . ' Tiny Feathers';
    } else {
        echo '<p>❌ ' . count($tiny) . '/' . $amount . ' Tiny Feathers';
    }
    
    if (count($colorful) >= $amount) {
        echo '<p>✔️ ' . $amount . '/' . $amount . ' Colorful Feathers';
    } else {
        echo '<p>❌ ' . count($colorful) . '/' . $amount . ' Colorful Feathers';
    }
    
    if (count($seagull) >= $amount) {
        echo '<p>✔️ ' . $amount . '/' . $amount . ' Seagull Feathers';
    } else {
        echo '<p>❌ ' . count($seagull) . '/' . $amount . ' Seagull Feathers';
    }
    
    if ($user['coinCount'] >= $coinAmount) {
        echo '<p>✔️ ' . $coinAmount . '/' . $coinAmount . ' Snooze Coins';
    } else {
        echo '<p>❌ ' . $user['coinCount'] . '/' . $coinAmount . ' Snooze Coins';
    }
    
    if (count($tiny) >= $amount && count($colorful) >= $amount && count($seagull) >= $amount && $user['coinCount'] >= $coinAmount) {
        $triple = $amount * 3;
        echo "<form method='POST' action='includes/createBed.inc.php' onsubmit=\"return confirm('Are you sure you want to trade him " . $triple . " feathers and " .  $coinAmount . " snooze coins?');\">";   
        echo '<button style="margin-bottom: .7rem;" class="fancyButton">Create Pet Bed</button>';
        echo '<form>';
    }

} else {
        echo '<p><i><b>"You already have the maximum amount of pet beds."</b></i></p>';
}

