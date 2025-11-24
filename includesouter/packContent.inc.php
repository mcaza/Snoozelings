<?php

$userId = $_COOKIE['user_id'];
$itemCount = [0];
if (isset($_GET['type'])) {
    $type = $_GET['type'];
} else {
    $type = null;
}

$query = "SELECT * FROM replies WHERE user_id = :id;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$reply = $stmt->fetch(PDO::FETCH_ASSOC);



//Get Bonded ID
$query = "SELECT * FROM users WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$bonded = $stmt->fetch(PDO::FETCH_ASSOC);

//Get Backpack Name
if ($bonded['backpackName']) {
    $backpackName = $bonded['backpackName'];
} else {
    $backpackName = "Backpack";
}

if ($bonded['backpackColor']) {
    $backpackColor = $bonded['backpackColor'];
} else {
    $backpackColor = "Sprout";
}

//Get Bonded Name
$query = 'SELECT * FROM snoozelings WHERE id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $bonded['bonded']);
$stmt->execute();
$bondedname = $stmt->fetch(PDO::FETCH_ASSOC);

//Fetch All Items
$query = "SELECT * FROM items WHERE user_id = :id AND test = 0";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Get all Item Categories
$categories = [];
foreach ($results as $item) {
    if (in_array($item['type'], $categories)) {
        
    } else {
        array_push($categories, $item['type']);
    }
}

rsort($categories);

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
echo '<img src="resources/ShortcutBackpack' . $backpackColor . '.png" style="width:100px;" id="backpackImage">';
echo '</div>';


//Notification
if ($reply) {
    echo '<div class="returnBar" style="margin-top: 1rem;margin-bottom:2rem;">';
    echo '<p>' . $reply['message'] . '</p>';
    echo '</div>';
    $query = "DELETE FROM replies WHERE user_id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
}

//Title
echo '<h3>' . $bondedname['name'] . '\'s ' . $backpackName . '</h3>';

//Display Coin Count Top Right
echo '<div>';
if ($player['coinCount'] === "1") {
    echo '<h1>Currency:</h1><p>' . $player['coinCount'] . ' Snooze Coin</p>';
} else {
    echo '<h1>Currency:</h1><p>' . $player['coinCount'] . ' Snooze Coins</p>';
}
echo '</div>';

//Display Coin Count Top Right
echo '<div>';
if ($player['coinCount'] === "1") {
    echo '<p><strong></strong>' . $player['kindnessCount'] . ' Kindness Coin</p>';
} else {
    echo '<p><strong></strong>' . $player['kindnessCount'] . ' Kindness Coins</p>';
}
echo '</div>';

//Filter By Type
echo '<form method="GET">';
echo '<label style="margin-top: 2rem;" for="type" class="form">Filter By Type:</label><br>';
echo '<select class="input"  name="type">';
echo '<option value="all">All</option>';
echo '<option value="clothesBoth">Clothes [Both]</option>';
echo '<option value="clothesBottom">Clothes [Bottom]</option>';
echo '<option value="clothesHoodie">Clothes [Hoodie]</option>';
echo '<option value="clothesTop">Clothes [Top]</option>';
echo '<option value="crafted">Crafted</option>';
echo '<option value="design">Design</option>';
echo '<option value="dropped">Dropped</option>';
echo '<option value="dye">Dyes</option>';
echo '<option value="fabric">Fabric</option>';
echo '<option value="plant">Plant</option>';
echo '<option value="seed">Seed</option>';
echo '<option value="special">Special</option>';
echo '<option value="stain">Stain</option>';
echo '</select><br>';
echo '<button class="fancyButton">Filter</button>';
echo '</form>';
echo '</div>';


//Display as Categories
echo "<div id='inventory'>";
foreach ($categories as $cat) {

    //Inventory System
    $round = 0;
    foreach ($itemCount as $item) {
        if ($cat == $items[$round -1]['type']) {
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
                        echo '<img src="items/' . $items[$round-1]['name'] . '.png" style="border-radius: 25px; border: 2px silver solid;">';
                    } else {
                        echo '<img src="items/' . $items[$round-1]['name'] . '.png" >';
                    }

            echo '<p>' . $itemCount[$round] . ' ' . $name . '</p>';
                echo '</div></a>';
                }
            }
        }
        $round++;
    }
}

echo "</div>";
