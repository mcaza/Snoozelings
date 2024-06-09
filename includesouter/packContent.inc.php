<?php

$userId = $_SESSION['user_id'];
$itemCount = [0];
if (isset($_GET['type'])) {
    $type = $_GET['type'];
} else {
    $type = null;
}
if (isset($_SESSION['reply'])) {
    $reply = $_SESSION['reply'];
    unset($_SESSION['reply']);
}
$name = $_SESSION['bonded'];


if (!$name) {
//Get Bonded ID
$query = "SELECT bonded FROM users WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$bonded = $stmt->fetch(PDO::FETCH_ASSOC);

//Get Bonded Name
$query = 'SELECT name FROM snoozelings WHERE id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $bonded);
$stmt->execute();
$bonded = $stmt->fetch(PDO::FETCH_ASSOC);
    $name = $bonded['name'];
}

//Fetch All Items
$query = "SELECT * FROM items WHERE user_id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Fetch Item List Count
$query = "SELECT * FROM itemList";
$stmt = $pdo->prepare($query);
$stmt->execute();
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
$amount = count($items) + 1;

//Fetch Coin Counts
$query = "SELECT coinCount, kindnessCount FROM users WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$player = $stmt->fetch(PDO::FETCH_ASSOC);

for ($i=0; $i < $amount; $i++) {
    array_push($itemCount, 0);
    foreach ($results as $item) {
        $num = intval($item['list_id']);
        if ($i === $num) {
            $itemCount[$i]++;
        }
    }
}

//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="profile?id=' . $userId . '"><<</a>';
echo '</div>';


//Notification
if (isset($reply)) {
    echo '<div class="returnBar" style="margin-top: 1rem;margin-bottom: 2rem;">';
    echo '<p>' . $reply . '</p>';
    echo '</div>';
}

//Title
echo '<h3>' . $name . '\'s Fanny Pack</h3>';

//Display Coin Count Top Right
echo '<div>';
if ($player['coinCount'] === "1") {
    echo '<p><strong>Inventory: </strong>' . $player['coinCount'] . ' Gold Coin</p>';
} else {
    echo '<p><strong>Inventory: </strong>' . $player['coinCount'] . ' Gold Coins</p>';
}
echo '</div>';

//Display Coin Count Top Right
echo '<div>';
if ($player['coinCount'] === "1") {
    echo '<p><strong>Inventory: </strong>' . $player['kindnessCount'] . ' Kindness Coin</p>';
} else {
    echo '<p><strong>Inventory: </strong>' . $player['kindnessCount'] . ' Kindness Coins</p>';
}
echo '</div>';

//Filter By Type
echo '<form method="GET">';
echo '<label style="margin-top: 2rem;" for="type" class="form">Filter By Type:</label><br>';
echo '<select class="input"  name="type">';
echo '<option value="all">All</option>';
echo '<option value="clothesBottom">Clothes [Bottom]</option>';
echo '<option value="clothesTop">Clothes [Top]</option>';
echo '<option value="crafted">Crafted</option>';
echo '<option value="design">Design</option>';
echo '<option value="dropped">Dropped</option>';
echo '<option value="fabric">Fabric</option>';
echo '<option value="plant">Plant</option>';
echo '<option value="seed">Seed</option>';
echo '<option value="special">Special</option>';
echo '</select><br>';
echo '<button class="fancyButton">Filter</button>';
echo '</form>';

//Inventory System
echo "<div id='inventory'>";
$round = 0;
foreach ($itemCount as $item) {
    if ($itemCount[$round] > 0) {
        if ($items[$round -1]['type'] === $type || $type === "all" || !$type) {
        echo '<a href="item?id=' . $round  . '">';
    echo '<div class="invItem">';
        if ($itemCount[$round] > 1) {
            if ($items[$round-1]['multiples']) {
                $name = $items[$round-1]['multiples'];
            } else {
                $name = $items[$round-1]['display'];
            }
        
    } else {
        $name = $items[$round-1]['display'];
    }
        if (str_contains($items[$round-1]['type'], "clothes")) {
                echo '<img src="items/' . $items[$round-1]['name'] . '.png" style="height:100px;border-radius: 25px; border: 2px silver solid;">';
            } else {
                echo '<img src="items/' . $items[$round-1]['name'] . '.png" style="height:100px">';
            }
    
    echo '<p>' . $itemCount[$round] . ' ' . $name . '</p>';
        echo '</div></a>';
        }
    }
    $round++;
}
echo "</div>";
