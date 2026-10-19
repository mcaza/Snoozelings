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
if ($bonded['tutorial'] == 3) { } else {
echo '<img src="resources/ShortcutBackpack' . $backpackColor . '.png" style="width:100px;" id="backpackImage">'; }
echo '</div>';

//Tutorial Pop Up
if ($bonded['tutorial'] == 3) {
    echo '<div class="tutorialHeader"><div class="tutorialDiv"><img src="snoozeImages/' . $bondedNumber . '.png?timestamp=' . $ts['timestamp'] . '" class="tutorialImage"></div><div style="text-align:center;width:100%"><br><Br><p style="width:90%">This is your in game <b>Pack [Inventory]</b>.<br><br>It holds all the items you\'ve collected while playing Snoozelings. Like seeds and clothing.<br><Br>On Desktop, you can find this in the dropdown menu under <b>' . $bonded['username'] . '\'s Abode</b>.<br><br>On Mobile, you\'ll need to click <b>' . $bonded['username'] . '\'s Abode</b>. Then click the Backpack image.<br><Br>To continue, click the <b>Welcome Package</b> below.<br><br></p></div></div><br><Br>';
} else if ($bonded['tutorial'] == 4) {
    echo '<div class="tutorialHeader"><div class="tutorialDiv"><img src="snoozeImages/' . $bondedNumber . '.png?timestamp=' . $ts['timestamp'] . '" class="tutorialImage"></div><div style="text-align:center;width:100%"><br><Br><p style="width:90%">Wow! So many cool new items!<br><br>I think the next most important thing is the <b>Pet Bed</b>.<br><br>Each snoozeling needs a soft, warm bed of their own to rest their fuzzy head at night.<br><Br>The more <b>Pet Beds</b> you have on your account, the more snoozelings you can collect.<br><br>To continue, click the <b>Pet Bed</b> below.<br><br></p></div></div><br><Br>';
} else if ($bonded['tutorial'] == 5) {
    echo '<div class="tutorialHeader"><div class="tutorialDiv"><img src="snoozeImages/' . $bondedNumber . '.png?timestamp=' . $ts['timestamp'] . '" class="tutorialImage"></div><div style="text-align:center;width:100%"><br><Br><p style="width:90%">The next thing a snoozeling needs is a proper farm area to grow crops and flowers in.<br><br>Did you know that studies show farming is super good for our mental health?<br><br>It\'s true. I read it in a book at the library.<br><br>There\'s nothing like the feeling of dirty paws. Working to grow carrots and pumpkins and kale.<br><br>To start farming, click the <b>Planter Box</b> below.<br><br></p></div></div><br><Br>';
} else if ($bonded['tutorial'] == 11) {
    echo '<div class="tutorialHeader"><div class="tutorialDiv"><img src="snoozeImages/' . $bondedNumber . '.png?timestamp=' . $ts['timestamp'] . '" class="tutorialImage"></div><div style="text-align:center;width:100%"><br><Br><p style="width:90%">You\'re doing so great ' . $bonded['username'] . '!<br><br>I promise we are almost finished learning the basics.<br><br>The final thing I\'m going to show you is how to add and remove clothing from your snoozeling.<br><br>There\'s a wide variety of accessories on Snoozelings. With more being added with every update.<br><br>Your imagination really is the limit.<br><br>To continue, click the <b>Welcome Bandana</b> below.<br><br></p></div></div><br><Br>';
} else if ($bonded['tutorial'] == 12) {
    echo '<div class="tutorialHeader"><div class="tutorialDiv"><img src="snoozeImages/' . $bondedNumber . '.png?timestamp=' . $ts['timestamp'] . '" class="tutorialImage"></div><div style="text-align:center;width:100%"><br><Br><p style="width:90%">For the final step of the tutorial, I will show you how to remove the clothing items from snoozelings.<br><br>On Desktop or mobile, you can find navigate to your profile page by clicking <b>' . $bonded['username'] . '\'s Abode</b>.<br><br>Then you click on the snoozeling image.<br><br>You can also click your snoozeling in the left sidebar as a shortcut. Scroll down to find them on mobile.<br><br>To continue, open either your Profile page or Snoozeling\'s information page.<br><br></p></div></div><br><Br>';
}

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
echo '<option value="clothes">Clothes</option>';
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
                        echo '<img src="items/' . $items[$round-1]['name'] . '.png" style="border-radius:10px;">';
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
