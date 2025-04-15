<?php

$userId = $_COOKIE['user_id'];

$query = "SELECT * FROM replies WHERE user_id = :id;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$reply = $stmt->fetch(PDO::FETCH_ASSOC);

$query = "SELECT * FROM users WHERE id = :id;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

//Get Items In Money Order By Cost
$query = "SELECT * FROM clothingShop ORDER BY price";
$stmt = $pdo->prepare($query);
$stmt->execute();
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Top Div
echo '<div class="topShop">';

//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="shops"><<</a>';
echo '</div>';
    
//Display Coin Count Top Right
echo '<div>';
if ($player['kindnessCount'] === "1") {
    echo '<p><strong>Inventory: </strong>' . $user['coinCount'] . ' Snooze Coin</p>';
} else {
    echo '<p><strong>Inventory: </strong>' . $user['coinCount'] . ' Snooze Coins</p>';
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
echo '<img src="resources/clothingShopCocoa.png" style="width: 35%;">';

//Get Plant Puns (Auto Set Valentine's Day or Birthday)
echo '<p><i>"Part time mayor. Part time clothing model. Full time busy."</i></p>';

//Show All Items
echo '<div class="seedRows">';
foreach ($items as $item) {
    echo '<div class="seedItem">';
    if (str_contains($item['type'], "clothes")) {
        echo '<img style="margin-top:3rem; height: 100px;border-radius:25px;border: 2px silver solid;" src="items/' . $item['name'] . '.png" title="' . $item['description'] . '">';
    } else {
        echo '<img style="margin-top:3rem; height: 100px;" src="items/' . $item['name'] . '.png" title="' . $item['description'] . '">';
    }
    echo '<p><strong>' . $item['display'] . '</strong></p>';
    if ($item['price'] < 2) {
        echo '<p>' . $item['price'] . ' Snooze Coin</p>';
        echo "<form method='POST' action='includes/buyClothing.inc.php' onsubmit=\"return confirm('This will cost " . $item['price'] . " snooze coin.');\">";   
    } else {
        echo '<p>' . $item['price'] . ' Snooze Coins</p>';
        echo "<form method='POST' action='includes/buyClothing.inc.php' onsubmit=\"return confirm('This will cost " . $item['price'] . " snooze coins.');\">";   
    }
    echo '<input type="hidden" name="item" value="' . $item['item_id'] . '">';
    echo '<input type="hidden" name="price" value="' . $item['price'] . '">';
    echo '<input type="hidden" name="name" value="' . $item['name'] . '">';
    echo '<button style="margin-bottom: .7rem; width: 50%;" class="fancyButton">Buy</button>';
    echo '</form>';
    echo '</div>';
}
echo '</div>';