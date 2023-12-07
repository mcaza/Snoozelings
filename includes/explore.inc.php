<?php

$userId = $_SESSION['user_id'];
$jack = "jack";
$explorer = "Explorer";

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
echo '<a href="snoozeland"><<</a>';
echo '</div>';

echo '<div><img id="exploreImage" class="wideImage" src="resources/Farmland.png"></div>';
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

$now = new DateTime();
$result = $now->format('Y-m-d H:i:s');
foreach ($results as $pet) {
    if ($result > $pet['cooldownTime']) {
    echo '<option value="' . $pet['id'] . '">' . htmlspecialchars($pet['name']) . '</option>';
    }
}
echo '</select></br>';


echo '<label for="area"  class="form">Choose An Area:</label><br>';
echo '<select  class="input" name="area" id="exploreArea"><br>';
echo '<option value="Farmland">Snoozeling Ranch</option>';
echo '<option value="Forest">Wistful Woods</option>';
echo '<option value="Beach">Dazzling Coast</option>';
echo '</select></br>';
echo '<button  class="fancyButton editButton">Send Exploring</button>';
echo '</form>';

echo '<div id="Farmland">';
echo '<h6>Snoozeling Ranch Items</h6>';
echo '<h6></h6>';
echo '<table>';
echo '<tr><th colspan="5">Common Items - 55%</th></tr>';
echo '<tr>';
echo '<td>1 Coin</td>';
echo '<td>Eggshell</td>';
echo '<td>Dirt</td>';
echo '<td>Manure</td>';
echo '<td>Feather</td>';
echo '</tr>';
echo '<tr>';
echo '<td>Wool</td>';
echo '<td>Water</td>';
echo '<td></td>';
echo '<td></td>';
echo '<td></td>';
echo '</tr>';
echo '<tr>';
echo '<tr><th colspan="5">Uncommon Items - 20%</th></tr>';
echo '</tr>';
echo '<tr>';
echo '<td>Yarn</td>';
echo '<td>Honey</td>';
echo '<td>Fabric: Cow</td>';
echo '<td>Design: Wooly Tail</td>';
echo '<td></td>';
echo '</tr>';
echo '<tr>';
echo '<tr><th colspan="5">Rare Items - 5%</th></tr>';
echo '</tr>';
echo '<tr>';
echo '<td>Cow Hoodie</td>';
echo '<td></td>';
echo '<td></td>';
echo '<td></td>';
echo '<td></td>';
echo '</tr>';
echo '<tr>';
echo '<tr><th colspan="5">Special Items - .5%</th></tr>';
echo '</tr>';
echo '<tr>';
echo '<td>Blueprint</td>';
echo '<td>Sewing Kit</td>';
echo '<td></td>';
echo '<td></td>';
echo '<td></td>';
echo '</tr>';
echo '</table>';
echo '</div>';

echo '<div id="Forest">';
echo '<h6>Wistful Woods Items</h6>';
echo '<h6></h6>';
echo '<table>';
echo '<tr><th colspan="5">Common Items - 55%</th></tr>';
echo '<tr>';
echo '<td>1 Coin</td>';
echo '<td>Wood Log</td>';
echo '<td>Dirt</td>';
echo '<td>Tiny Feather</td>';
echo '<td>Plant Fiber</td>';
echo '</tr>';
echo '<tr>';
echo '<td>Leaf</td>';
echo '<td>Water</td>';
echo '<td></td>';
echo '<td></td>';
echo '<td></td>';
echo '</tr>';
echo '<tr>';
echo '<tr><th colspan="5">Uncommon Items - 20%</th></tr>';
echo '</tr>';
echo '<tr>';
echo '<td>Fur Tuft</td>';
echo '<td>Wood Pulp</td>';
echo '<td>Fabric: Jungle</td>';
echo '<td>Design: Panther Tail</td>';
echo '<td></td>';
echo '</tr>';
echo '<tr>';
echo '<tr><th colspan="5">Rare Items - 5%</th></tr>';
echo '</tr>';
echo '<tr>';
echo '<td>Deer Antlers</td>';
echo '<td></td>';
echo '<td></td>';
echo '<td></td>';
echo '<td></td>';
echo '</tr>';
echo '<tr>';
echo '<tr><th colspan="5">Special Items - .5%</th></tr>';
echo '</tr>';
echo '<tr>';
echo '<td>Blueprint</td>';
echo '<td>Sewing Kit</td>';
echo '<td></td>';
echo '<td></td>';
echo '<td></td>';
echo '</tr>';
echo '</table>';
echo '</div>';

echo '<div id="Beach">';
echo '<h6>Dazzling Coast Items</h6>';
echo '<h6></h6>';
echo '<table>';
echo '<tr><th colspan="5">Common Items - 55%</th></tr>';
echo '<tr>';
echo '<td>3 Coins</td>';
echo '<td>Copper Wire</td>';
echo '<td>Sand</td>';
echo '<td>Nail</td>';
echo '<td>Shark Fang</td>';
echo '</tr>';
echo '<tr>';
echo '<td>Button</td>';
echo '<td>Water</td>';
echo '<td></td>';
echo '<td></td>';
echo '<td></td>';
echo '</tr>';
echo '<tr>';
echo '<tr><th colspan="5">Uncommon Items - 20%</th></tr>';
echo '</tr>';
echo '<tr>';
echo '<td>Key</td>';
echo '<td>Sewing Needle</td>';
echo '<td>Fabric: Ocean</td>';
echo '<td>Design: Mermaid Tail</td>';
echo '<td></td>';
echo '</tr>';
echo '<tr>';
echo '<tr><th colspan="5">Rare Items - 5%</th></tr>';
echo '</tr>';
echo '<tr>';
echo '<td>Wetsuit</td>';
echo '<td></td>';
echo '<td></td>';
echo '<td></td>';
echo '<td></td>';
echo '</tr>';
echo '<tr>';
echo '<tr><th colspan="5">Special Items - .5%</th></tr>';
echo '</tr>';
echo '<tr>';
echo '<td>Blueprint</td>';
echo '<td>Sewing Kit</td>';
echo '<td></td>';
echo '<td></td>';
echo '<td></td>';
echo '</tr>';
echo '</table>';
echo '</div>';
echo '<p>**Remaining Percentage For All Biomes is Seeds</p>';
echo '</div>';
