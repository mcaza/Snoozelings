<?php

//Grab Values
$userId = $_SESSION['user_id'];
if ($_SESSION['reply']) {
    $reply = $_SESSION['reply'];
    unset($_SESSION['reply']);
}

//Grab Coins
$query = 'SELECT coinCount FROM users WHERE id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$player = $stmt->fetch(PDO::FETCH_ASSOC);

//Grab Raffle Count
$query = 'SELECT * FROM rafflecount ORDER BY id DESC LIMIT 1';
$stmt = $pdo->prepare($query);
$stmt->execute();
$day = $stmt->fetch(PDO::FETCH_ASSOC);

    //Get Entries Count
    if ($day['entries']) {
        $explode = explode(" ", $day['entries']);
        $count = count($explode);
    } else {
        $count = 0;
    }


//Grab Raffle Items
$query = 'SELECT * FROM raffles ORDER BY id DESC LIMIT 3';
$stmt = $pdo->prepare($query);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Top Div
echo '<div class="topShop">';

//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="games"><<</a>';
echo '</div>';
    
//Display Coin Count Top Right
echo '<div style="text-align: right">';
if ($player['coinCount'] === "1") {
    echo '<p><strong>Inventory: </strong>' . $player['coinCount'] . ' Snooze Coin</p>';
} else {
    echo '<p><strong>Inventory: </strong>' . $player['coinCount'] . ' Snooze Coins</p>';
}
echo '</div>';
echo '</div>';

//Session Reply Area
if ($reply) {
    echo '<div class="returnBar" style="margin-top: 1rem;margin-bottom: 1rem;"><p>' . $reply . '</p></div><br>';
}

echo '<h3>Daily Raffle #' . $day['id'] . '</h3>';

echo '<div class="raffleitems" style="margin-bottom:2rem;">';
foreach ($results as $result) {
    $query = 'SELECT username FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $result['donator']);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    echo '<div class="raffleitem">';
    echo '<p><i>Donated by <br>' . $user['username'] . '</i></p>';
    echo '<a href="item?id=' . $result['list_id'] . '"><img src="items/' . $result['item'] . '.png" style="height: 100px;"></a>';
    echo '<p><strong>' . $result['display'] . '</strong></p>';
    echo '</div>';
}
echo '</div>';
if ($count === 0 || !in_array($userId, $explode)) {
     echo "<form method='POST' action='includes/enterRaffle.inc.php' onsubmit=\"return confirm('Buying a ticket will cost you 1 snooze coin.');\">";
    echo '<button  class="fancyButton">Buy Ticket</button>';
    echo '</form>';
   

} else {
        echo '<p style="margin-top: 3rem;"><strong>You have already entered the raffle today.</strong></p>';
    }

echo '<p style="font-size: 2rem; margin-top: 3rem;"><strong>Total Entries: </strong>' . $count  . '</p>';

if (!($day['id'] == "1")) {
    //Grab Raffle Count
    $query = 'SELECT * FROM rafflecount';
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $day = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $num = count($day) - 1;
    
    $query = 'SELECT * FROM rafflecount WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $num);
    $stmt->execute();
    $yesterdays = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $numbers = explode(" ", $yesterdays['entries']);
    $count = count($numbers);

    
    //Grab Raffle Items
    $query = 'SELECT * FROM raffles ORDER BY id DESC LIMIT 6';
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo '<hr>';
    echo '<h3>Yesterday\'s Winners</h3>';
    $query = 'SELECT username FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $results[3]['winner']);
    $stmt->execute();
    $winner = $stmt->fetch(PDO::FETCH_ASSOC);
    echo '<div class="raffleitems" style="margin-bottom:2rem;">';
    echo '<div class="raffleitem">';
    echo '<img src="items/' . $results[3]['item'] . '.png" style="margin-top: 1rem;height: 100px;"">';
    if ($winner) {
        echo '<p><i>' . $winner['username'] . '</i></p>';
    } else {
        echo '<p><i>No Winner</i></p>';
    }
    echo '</div>';
    $query = 'SELECT username FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $results[4]['winner']);
    $stmt->execute();
    $winner = $stmt->fetch(PDO::FETCH_ASSOC);
    echo '<div class="raffleitem">';
    echo '<img src="items/' . $results[4]['item'] . '.png" style="margin-top: 1rem;height: 100px;">';
    if ($winner) {
        echo '<p><i>' . $winner['username'] . '</i></p>';
    } else {
        echo '<p><i>No Winner</i></p>';
    }
    echo '</div>';
    $query = 'SELECT username FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $results[5]['winner']);
    $stmt->execute();
    $winner = $stmt->fetch(PDO::FETCH_ASSOC);
    echo '<div class="raffleitem">';
    echo '<img src="items/' . $results[5]['item'] . '.png" style="margin-top: 1rem;height: 100px;">';
    if ($winner) {
        echo '<p><i>' . $winner['username'] . '</i></p>';
    } else {
        echo '<p><i>No Winner</i></p>';
    }
    echo '</div>';
    echo '</div>';
    echo '<p style="font-size: 2rem; margin-top: 3rem;"><strong>Total Entries: </strong>' . $count . '</p>';
} 

echo '<hr>';
echo '<h3>Donate an Item</h3>';
echo '<p><i>Raffle items are randomly drawn from the donation pool everyday.</i></p>';
echo '<p><i>You will recieve 1 Kindness Coin if your item is used.</i></p>';

$query = 'SELECT * FROM items WHERE user_id = :id AND canDonate = 1 AND dye IS NULL GROUP BY list_id, id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);


if ($items) {
    echo "<form method='POST' action='includes/donateItem.inc.php' onsubmit=\"return confirm('Are you sure you want to donate this item?');\">";
    echo '<label for="topic"  class="form">Select an Item to Donate:</label><br>';
    echo '<select name="donation" id="donation">';
    echo '<option value="" default selected>Select an Item</option>';
    
        foreach ($items as $item) {
            echo '<option value="' . $item['list_id'] . '" default selected>' . $item['display'] . '</option>';
    }
    
    echo '</select><br><br>';
    echo '<button  class="fancyButton">Donate Item</button>';
    echo '</form>';
} else {
    echo '<h4>You don\'t have any items that can be donated.';
}

if (!$items) {
    
} else {
   
}










