<?php

$userId = $_COOKIE['user_id'];
$shop = "ss";

$query = "SELECT * FROM replies WHERE user_id = :id;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$reply = $stmt->fetch(PDO::FETCH_ASSOC);

//Get Seeds In Alphabet Order
$query = "SELECT * FROM seeds WHERE shop = :shop ORDER BY name";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":shop", $shop);
$stmt->execute();
$seeds = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Get Date
$now = new DateTime("now", new DateTimezone('UTC'));
$formatted = $now->format('m-d');

//Get Player Birthdate & Coins
$query = "SELECT birthdate, coinCount FROM users WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$player = $stmt->fetch(PDO::FETCH_ASSOC);

//Convert Player Birthday
$date = strtotime($player['birthdate']);
$birthday = date('m-d', $date);

//Valentines Day
$date = strtotime(2/14);
$valentines = date('m-d', $date);

//Top Div
echo '<div class="topShop">';

//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="shops"><<</a>';
echo '</div>';
    
//Display Coin Count Top Right
echo '<div>';
if ($player['coinCount'] === "1") {
    echo '<p><strong>Inventory: </strong>' . $player['coinCount'] . ' Snooze Coin</p>';
} else {
    echo '<p><strong>Inventory: </strong>' . $player['coinCount'] . ' Snooze Coins</p>';
}

echo '</div>';

//End Top Div
echo '</div>';

//Session Reply Area
if ($reply) {
    echo '<div class="returnBar" style="margin-top: 1rem;margin-bottom:2rem;">';
    echo '<p>' . $reply['message'] . '</p>';
    echo '</div>';
    $query = "DELETE FROM replies WHERE user_id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
}

//Show Image. Change Later
echo '<img src="resources/seedshop2NPC.png" style="width: 35%;">';

//Get Plant Puns (Auto Set Valentine's Day or Birthday)
if ($formatted === $birthday) {
    echo '<p><i>Ha-pea Birthday!!</i></p>';
} elseif ($formatted === $valentines) {
    echo '<p><i>Will you peas be my Valentine?</i></p>';
} else {
    $query = 'SELECT * FROM seedPuns';
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $puns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count = count($puns) -1;
    $randomNum = rand(1, $count) -1;
    echo '<p style="width: 60%;margin-left: auto;margin-right: auto;"><i>"' . $puns[$randomNum]['pun'] . '"</i></p>';
}

//Show All Seeds
echo '<div class="seedRows">';
foreach ($seeds as $seed) {
    echo '<div class="seedItem">';
    echo '<img style="margin-top:.3rem;height:100px;" src="items/' . $seed['name'] . '.png" title="' . $seed['description'] . '">';
    echo '<p><strong>' . $seed['plantName'] . ' Seed</strong></p>';
    echo '<p>' . $seed['price'] . ' Snooze Coins</p>';
    echo "<form method='POST' action='includes/buySeed.inc.php' onsubmit=\"return confirm('This will cost " . $seed['price'] . " snooze coins.');\">";   
    echo '<input type="hidden" name="seed" value="' . $seed['item_id'] . '">';
    echo '<input type="hidden" name="price" value="' . $seed['price'] . '">';
    echo '<button style="margin-bottom: .7rem; width: 50%;" class="fancyButton">Buy</button>';
    echo '</form>';
    echo '</div>';
}
echo '</div>';



















