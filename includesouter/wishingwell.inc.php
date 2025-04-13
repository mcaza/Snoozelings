<?php

//Basic Info
$userId = $_COOKIE['user_id'];

$query = "SELECT * FROM replies WHERE user_id = :id;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$reply = $stmt->fetch(PDO::FETCH_ASSOC);

//Get User Info
$query = "SELECT * FROM users WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

//Check for Coins
$query = "SELECT * FROM items WHERE user_id = :id AND list_id = 73";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$coins = $stmt->fetch(PDO::FETCH_ASSOC);


//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="snoozevillage"><<</a>';
echo '</div>';

if ($reply) {
    echo '<div class="returnBar" style="margin-top: 2rem;margin-bottom:1rem;">';
    echo '<p>' . $reply['message'] . '</p>';
    echo '</div>';
    $query = "DELETE FROM replies WHERE user_id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
}

//Show Image. Change Later
echo '<img src="resources/wishingWell.png" style="width: 40%;">';

echo '<h4>Your snoozeling approaches the wishing well.</h4>';


//Prize Button
$number = 1;
if ($result['dailyPrize'] == 1) {
    echo '<p><i>You have already taken made a wish today.</i></p>';
    echo '<p><i>Please come back tomorrow.</i></p>';
} else if (!$coins) {
    echo '<p><i>You are unable to make a wish without an old coin.</i></p>';
    echo '<p><i>Please come back after you\'ve found one while exploring.</i></p>';
} else {
    echo '<p>Making a wish will cost you a single Old Coin.</p>';
    echo '<p><i>Would you like to make a wish?</i></p>';
    echo '<button class="fancyButton" style="width: 200px; margin-right: auto; margin-left: auto;margin-bottom: 1.5rem;" onClick="window.location.href=\'../includes/wishStain.inc.php\'">Wish For Stain</button>';
}

/* if ($number == 0) {
    echo '<p>I hope it makes your day a little brighter.</p>';
    echo '<button class="fancyButton" style="width: 200px; margin-right: auto; margin-left: auto;margin-bottom: 1.5rem;" onClick="window.location.href=\'../includes/dailyItem.inc.php\'">Get Free Item</button>';
} else {
    echo '<p><i>You have already taken an item today.</i></p>';
    echo '<p><i>Please come back tomorrow.</i></p>';
} */