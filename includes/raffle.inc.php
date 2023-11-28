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
$explode = explode(" ", $day['entries']);
if (strlen($day['entries']) === 0) {
    $count = 0;
} else {
     $count = count($explode);
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
    echo '<p><strong>Inventory: </strong>' . $player['coinCount'] . ' Gold Coin</p>';
} else {
    echo '<p><strong>Inventory: </strong>' . $player['coinCount'] . ' Gold Coins</p>';
}
echo '</div>';
echo '</div>';

//Session Reply Area
if ($reply) {
    echo '<div class="returnBar" style="margin-top: 1rem;margin-bottom: 1rem;"><p>' . $reply . '</p></div>';
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
    echo '<p><i>Donated by ' . $user['username'] . '</i></p>';
    echo '<a href="item?id=' . $result['list_id'] . '"><img src="items/' . $result['item'] . '.png" ></a>';
    echo '<p><strong>' . $result['display'] . '</strong></p>';
    echo '</div>';
}
echo '</div>';
if (in_array($userId, $explode)) {
    echo '<p style="margin-top: 3rem;"><strong>You have already enterred the raffle today.</strong></p>';
} else {
    echo "<form method='POST' action='includes/enterRaffle.inc.php' onsubmit=\"return confirm('Buying a ticket will cost you 1 gold coin.');\">";
    echo '<button  class="fancyButton">Buy Ticket</button>';
    echo '</form>';
}

echo '<p style="font-size: 2rem; margin-top: 3rem;"><strong>Total Entries: </strong>' . $count . '</p>';

if (!($day['id'] === "1")) {
    //Grab Raffle Count
    $id = intval($day['id']) - 1;
    $query = 'SELECT * FROM rafflecount WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $day = $stmt->fetch(PDO::FETCH_ASSOC);

    //Get Entries Count
    $explode = explode(" ", $day['entries']);
    $count = count($explode);
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
    echo '<img src="items/' . $results[3]['item'] . '.png" style="margin-top: 1rem">';
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
    echo '<img src="items/' . $results[4]['item'] . '.png" style="margin-top: 1rem">';
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
    echo '<img src="items/' . $results[5]['item'] . '.png" style="margin-top: 1rem">';
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
$one = 1;
$query = 'SELECT * FROM items WHERE user_id = :id AND canDonate = :one GROUP BY list_id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->bindParam(":one", $one);
$stmt->execute();
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<form method='POST' action='includes/donateItem.inc.php' onsubmit=\"return confirm('Are you sure you want to donate this item?');\">";
foreach ($items as $item) {
    echo '<div style="margin-bottom:1rem;"><input type="radio" id="' . $item['name'] . '" name="donation" value="' . $item['list_id'] . '" required><label style="font-size: 1.8rem;" for="' . $item['name'] . '">' . $item['display'] . '</label><br></div>';
}

echo '<button  class="fancyButton">Donate Item</button>';
echo '</form>';








