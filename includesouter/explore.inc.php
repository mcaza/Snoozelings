<?php

//Basic Info
$userId = $_SESSION['user_id'];
$jack = "jack";
$explorer = "Explorer";

//Check if Area
$query = "SELECT lastExplore FROM users WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$lastexplore = $stmt->fetch(PDO::FETCH_ASSOC);

if ($lastexplore['lastExplore']) {
$temp = $lastexplore['lastExplore'];
} else {
    $temp = "Farmland";
}

$coins = intval($_SESSION['coins']);
$items = $_SESSION['items'];
$error = $_SESSION['error'];
$name = $_SESSION['petName'];

unset($_SESSION['coins']);
unset($_SESSION['error']);
unset($_SESSION['items']);
unset($_SESSION['petName']);

$itemString = "";

$query = "SELECT * FROM snoozelings WHERE (job = :jack OR job = :explorer) && owner_id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":jack", $jack);
$stmt->bindParam(":explorer", $explorer);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Get Items
    $query = "SELECT * FROM itemList";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $itemQuery = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="snoozevillage"><<</a>';
echo '</div>';

if ($temp === "Farmland") {
    echo '<div><img id="exploreImage" class="wideImage" src="resources/Farmland.png"></div>';
    $optionone = "selected";
} elseif ($temp === "Forest") {
    echo '<div><img id="exploreImage" class="wideImage" src="resources/Forest.png"></div>';
    $optiontwo = "selected";
} elseif ($temp === "Beach") {
    echo '<div><img id="exploreImage" class="wideImage" src="resources/Beach.png"></div>';
    $optionthree = "selected";
}
echo '<div class="returnItems">';

//Item Display After
if ($items || $coins > 0) {
    echo '<div class="returnBar" style="margin-top: 1rem;">';
    if ($coins === 1) {
        echo '<p>' . $name . ' brought you 1 coin.</p>';
    } elseif ($coins > 1) {
        echo '<p>' . $name . ' brought you ' . $coins . ' coins.</p>';
    }
    if ($items) {
        if ($coins > 1) {
            echo '<p>They also brought back the following: ';
        } else {
            echo '<p>' . $name . ' brought you the following: ';
        }
        foreach ($items as $item) {
            $number = intval($item) - 1;
            $itemString .= $itemQuery[$number]['display'];
            $itemString .= ', ';
        }
        echo substr($itemString, 0, -2);
        echo '</p>';
    }
    echo '</div>';
}

if ($error) {
    echo '<div class="returnBar" style="margin-top: 1rem;">';
    echo '<p>' . $error . '</p>';
    echo '</div>';
}



//Form Details
echo '<form method="post" action="includes/startExplore.inc.php">';
echo '<label for="explorer"  class="form pushDown">Choose An Explorer:</label><br>';
echo '<select  class="input" name="explorer"><br>';

$now = new DateTime("now", new DateTimezone('UTC'));
$result = $now->format('Y-m-d H:i:s');
foreach ($results as $pet) {
    if ($result > $pet['cooldownTime']) {
        if ($pet['job'] == "Explorer") {
            echo '<option value="' . $pet['id'] . '">*' . htmlspecialchars($pet['name']) . '*</option>';
        } else {
            echo '<option value="' . $pet['id'] . '">' . htmlspecialchars($pet['name']) . '</option>';
        }
    
    }
}
echo '</select></br>';


echo '<label for="area"  class="form">Choose An Area:</label><br>';
echo '<select  class="input" name="area" id="exploreArea"><br>';
echo '<option value="Farmland" ' . $optionone . '>Snoozeling Ranch</option>';
echo '<option value="Forest" ' . $optiontwo . '>Wistful Woods</option>';
echo '<option value="Beach" ' . $optionthree . '>Dazzling Coast</option>';
echo '</select></br>';
echo '<button  class="fancyButton editButton">Send Exploring</button>';
echo '</form>';
//if ($temp === "Farmland") {
echo '<div id="Farmland">';
echo '<h6>Snoozeling Ranch Items</h6>';
echo '<h6></h6>';
echo '<table class="exploretable">';
echo '<tr><th colspan="4">Common Items</th></tr>';
echo '<tr>';
echo '<td>Eggshells</td>';
echo '<td>Tiny Feather</td>';
echo '<td>Dirt</td>';
echo '<td>Manure</td>';
echo '</tr>';
echo '<tr>';
echo '<td>Honey</td>';
echo '<td>Egg Carton</td>';
echo '<td>Empty Jug</td>';
echo '<td>Old Can</td>';
echo '</tr>';
echo '<tr>';
echo '<tr><th colspan="4">Uncommon Items</th></tr>';
echo '</tr>';
echo '<tr>';
echo '<td>Ram Horn</td>';
echo '<td>Horse Hair</td>';
echo '<td>Cowbell</td>';
echo '<td>Mystery Seed</td>';
echo '</tr>';
echo '<tr>';
echo '<td>Old Coin</td>';
echo '<td>Farm Chest</td>';
echo '<td>Key</td>';
echo '<td>Button</td>';
echo '</tr>';
echo '<tr>';
echo '<tr><th colspan="4">Rare Items</th></tr>';
echo '</tr>';
echo '<tr>';
echo '<td>Wooly Pattern</td>';
echo '<td>Cow Hoodie</td>';
echo '<td>Duck Hoodie</td>';
echo '<td>Horse Hoodie</td>';
echo '</tr>';
echo '<tr>';
echo '<td>Grey Cow Fabric</td>';
echo '<td>Blue Cow Fabric</td>';
echo '<td>Brown Cow Fabric</td>';
echo '<td>Pink Cow Fabric</td>';
echo '</tr>';
echo '<tr>';
echo '<tr><th colspan="4">Special Items</th></tr>';
echo '</tr>';
echo '<tr>';
echo '<td>Blueprint</td>';
echo '<td>Sewing Kit</td>';
echo '<td></td>';
echo '<td></td>';
echo '</tr>';
echo '</table>';
echo '</div>';
//} elseif ($temp === "Forest") {
echo '<div id="Forest">';
echo '<h6>Wistful Woods Items</h6>';
echo '<h6></h6>';
echo '<table class="exploretable">';
echo '<tr><th colspan="4">Common Items</th></tr>';
echo '<tr>';
echo '<td>Wood Log</td>';
echo '<td>Colorful Feather</td>';
echo '<td>Gooseberry</td>';
echo '<td>Blueberry</td>';
echo '</tr>';
echo '<tr>';
echo '<td>Leaf</td>';
echo '<td>Tree Sap</td>';
echo '<td>Plant Fiber</td>';
echo '<td>Flower</td>';
echo '</tr>';
echo '<tr>';
echo '<tr><th colspan="4">Uncommon Items</th></tr>';
echo '</tr>';
echo '<tr>';
echo '<td>Lizard Tail</td>';
echo '<td>Bug Wings</td>';
echo '<td>Mushroom</td>';
echo '<td>Mystery Seed</td>';
echo '</tr>';
echo '<tr>';
echo '<td>Old Coin</td>';
echo '<td>Woods Chest</td>';
echo '<td>Key</td>';
echo '<td>Button</td>';
echo '</tr>';
echo '<tr>';
echo '<tr><th colspan="4">Rare Items</th></tr>';
echo '</tr>';
echo '<tr>';
echo '<td>Panther Pattern</td>';
echo '<td>Deer Antlers</td>';
echo '<td>Deer Hoodie</td>';
echo '<td>Doe Hoodie</td>';
echo '</tr>';
echo '<tr>';
echo '<td>Fairy Horns</td>';
echo '<td>Acorns Fabric</td>';
echo '<td>Leaves Fabric</td>';
echo '<td>Forest Fabric</td>';
echo '</tr>';
echo '<tr>';
echo '<td>Acorn Bag</td>';
echo '<td>Squirrel Hoodie</td>';
echo '<td></td>';
echo '<td></td>';
echo '</tr>';
echo '<tr>';
echo '<tr><th colspan="4">Special Item</th></tr>';
echo '</tr>';
echo '<tr>';
echo '<td>Blueprint</td>';
echo '<td>Sewing Kit</td>';
echo '<td></td>';
echo '<td></td>';
echo '</tr>';
echo '</table>';
echo '</div>';
//} elseif ($temp === "Beach") {
echo '<div id="Beach">';
echo '<h6>Dazzling Coast Items</h6>';
echo '<h6></h6>';
echo '<table class="exploretable">';
echo '<tr><th colspan="4">Common Items</th></tr>';
echo '<tr>';
echo '<td>Copper Wire</td>';
echo '<td>Silver Earring</td>';
echo '<td>Gold Ring</td>';
echo '<td>Seagull Feather</td>';
echo '</tr>';
echo '<tr>';
echo '<td>Sand</td>';
echo '<td>Water</td>';
echo '<td>Nail</td>';
echo '<td>Moss</td>';
echo '</tr>';
echo '<tr>';
echo '<tr><th colspan="4">Uncommon Items</th></tr>';
echo '</tr>';
echo '<tr>';
echo '<td>Sewing Needle</td>';
echo '<td>Shark Fang</td>';
echo '<td>Old Lock</td>';
echo '<td>Mystery Seed</td>';
echo '</tr>';
echo '<tr>';
echo '<td>Old Coin</td>';
echo '<td>Beach Chest</td>';
echo '<td>Key</td>';
echo '<td>Button</td>';
echo '</tr>';
echo '<tr>';
echo '<tr><th colspan="4">Rare Items</th></tr>';
echo '</tr>';
echo '<tr>';
echo '<td>Mermaid Pattern</td>';
echo '<td>Shark Towel</td>';
echo '<td>Frog Towel</td>';
echo '<td>Fox Towel</td>';
echo '</tr>';
echo '<tr>';
echo '<td>Wetsuit</td>';
echo '<td>Beach Hat</td>';
echo '<td>Sunscreen</td>';
echo '<td>Ocean Fabric</td>';
echo '</tr>';
echo '<tr>';
echo '<tr><th colspan="4">Special Items</th></tr>';
echo '</tr>';
echo '<tr>';
echo '<td>Blueprint</td>';
echo '<td>Sewing Kit</td>';
echo '<td></td>';
echo '<td></td>';
echo '</tr>';
echo '</table>';
echo '</div>';
//}
echo '<p>**All biomes can also drop currency and seeds</p>';
echo '</div>';
