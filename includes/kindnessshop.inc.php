<?php

$userId = $_SESSION['user_id'];
$name = $_SESSION['petName'];
$shop = "ss";

if ($_SESSION['reply']) {
    $reply = $_SESSION['reply'];
    unset($_SESSION['reply']);
}

//Get Items In Money Order By Cost
$query = "SELECT * FROM kindnessShop ORDER BY price";
$stmt = $pdo->prepare($query);
$stmt->execute();
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Get Kindness Coins
$query = "SELECT kindnessCount FROM users WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$player = $stmt->fetch(PDO::FETCH_ASSOC);

//Top Div
echo '<div class="topShop">';

//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="shops"><<</a>';
echo '</div>';
    
//Display Coin Count Top Right
echo '<div>';
if ($player['coinCount'] === "1") {
    echo '<p><strong>Inventory: </strong>' . $player['kindnessCount'] . ' Kindness Coin</p>';
} else {
    echo '<p><strong>Inventory: </strong>' . $player['kindnessCount'] . ' Kindness Coins</p>';
}

echo '</div>';

//End Top Div
echo '</div>';

//Session Reply Area
if ($reply) {
    echo '<div class="returnBar" style="margin-top: 1rem;"><p>' . $reply . '</p></div>';
}

//Show Image. Change Later
echo '<img src="resources/kindnessNPC.png" style="width: 35%;">';

//Get Plant Puns (Auto Set Valentine's Day or Birthday)
echo '<p><i>"I know being kind is its own reward, but it doesn\'t hurt to spoil yourself every so often."</i></p>';

//Show All Seeds
echo '<div class="seedRows">';
foreach ($items as $item) {
    echo '<div class="seedItem">';
    echo '<img style="margin-top:.3rem;" src="items/' . $item['name'] . '.png" alt="' . $item['description'] . '">';
    echo '<p><strong>' . $item['display'] . '</strong></p>';
    if ($item['price'] < 2) {
        echo '<p>' . $item['price'] . ' Kindness Coin</p>';
        echo "<form method='POST' action='includes/buyKindness.inc.php' onsubmit=\"return confirm('This will cost " . $item['price'] . " coin.');\">";   
    } else {
        echo '<p>' . $item['price'] . ' Kindness Coins</p>';
        echo "<form method='POST' action='includes/buyKindness.inc.php' onsubmit=\"return confirm('This will cost " . $item['price'] . " coins.');\">";   
    }
    echo '<input type="hidden" name="item" value="' . $item['item_id'] . '">';
    echo '<input type="hidden" name="price" value="' . $item['price'] . '">';
    echo '<button style="margin-bottom: .7rem; width: 50%;" class="fancyButton">Buy</button>';
    echo '</form>';
    echo '</div>';
}
echo '</div>';



















