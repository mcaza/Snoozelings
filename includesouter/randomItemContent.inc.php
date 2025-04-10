<?php

$userId = $_COOKIE['user_id'];

$query = "SELECT * FROM replies WHERE user_id = :id;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$reply = $stmt->fetch(PDO::FETCH_ASSOC);

//Get User Info
$query = "SELECT dailyPrize FROM users WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="games"><<</a>';
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

//Will have cute snoozeling for alpha. Custom art later. Confused face if already took item.
echo '<div><img style="width: 40%;" src="resources/freeitemNPC.png"></div>';
    echo '<h4>Feeling Down? Have a free item.</h4>';



$number = intval($result['dailyPrize']);
if ($number === 0) {
    echo '<p>I hope it makes your day a little brighter.</p>';
    echo '<button class="fancyButton" style="width: 200px; margin-right: auto; margin-left: auto;margin-bottom: 1.5rem;" onClick="window.location.href=\'../includes/dailyItem.inc.php\'">Get Free Item</button>';
} else {
    echo '<p><i>You have already taken an item today.</i></p>';
    echo '<p><i>Please come back tomorrow.</i></p>';
}