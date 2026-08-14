<?php

$userId = $_COOKIE['user_id'];

//Replies
$query = "SELECT * FROM replies WHERE user_id = :id;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$reply = $stmt->fetch(PDO::FETCH_ASSOC);

//Date Stuff
$now = new DateTime("now", new DateTimezone('UTC'));
$result = $now->format('Y-m-d H:i:s');

//Get Market Info
$query = "SELECT * FROM marketTables WHERE user_id = :id;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$table = $stmt->fetch(PDO::FETCH_ASSOC);

//Get Pet Info
$query = "SELECT * FROM snoozelings WHERE id = :id;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $table['pet_id']);
$stmt->execute();
$pet = $stmt->fetch(PDO::FETCH_ASSOC);

//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="snoozevillage"><<</a>';
echo '</div>';

//Reply Box
if ($reply) {
    echo '<div class="returnBar" style="margin-top: 1rem;margin-bottom:2rem;">';
    echo '<p>' . $reply['message'] . '</p>';
    echo '</div>';
    $query = "DELETE FROM replies WHERE user_id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
}

//Market Name
echo '<h3 style="margin-bottom: 2rem;">Flea Market</h3>';

//Snoozeling Image
echo '<img src="snoozeImages/' . $table['pet_id'] . '.png?timestamp=' . $pet['timestamp'] . '" style="width:35%">';

//Display Table Boxes
echo '<div class="farmBoxes">';

//Display Tables
$items = ['itemOne', 'itemTwo', 'itemThree', 'itemFour'];
$num = ['quantityOne', 'quantityTwo', 'quantityThree', 'quantityFour'];
for($x = 0; $x < $table['unlocked'];$x++) {
    //Grab Display for item
    $query = "SELECT * FROM itemList WHERE name = :name;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $table[$items[$x]]);
    $stmt->execute();
    $item = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Calculate Worth
    $worth = $item['sell'] * $table[$num[$x]];
    
    echo '<a class="farm" href="table?id=' . $x . '"><div >';
    
    //Layer Image
    echo '<div class="artcontainertwo">';
    echo "<div class='imageTwo'>";
    echo "<img src='resources/marketOne.png'>";
    echo "</div>";
    echo "<div class='imageTwo' style='width:45%;margin-left:auto;margin-right:auto;margin-top:20px;'>";
    echo "<img src='items/" . $table[$items[$x]] . ".png'>";
    echo "</div>";
    echo "</div>";
    
    //echo '<img src="resources/marketOne.png" class="farmBox">';
    if ($table[$num[$x]] > 1) {
        echo '<h4  style="margin-top:0;">' . $table[$num[$x]] . 'x ' . $item['multiples'] . '</h4>';
    } else {
        echo '<h4  style="margin-top:0;">' . $table[$num[$x]] . 'x ' . $item['display'] . '</h4>';
    }
    echo '<p><b>Sell Price:</b> ' . $worth . ' Snooze Coins</p><br>';
    
    echo '</div></a>';
}
echo '</div>';

//Change Vendor
echo '<br><hr>';
$query = "SELECT * FROM snoozelings WHERE owner_id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo '<div><h3 style="margin-bottom: 1rem;">Change Vendor</div>';
echo '<form method="POST" action="includes/changeMarket.inc.php">';
echo '<label for="status"  class="form">Main Vendor:</label><br>';
echo '<select  class="input" name="snoozeling" id="snoozeling"><br>';
foreach ($results as $snooze) {
    echo '<option value="' . $snooze['id'] . '">#' . $snooze['id'] . ' - ' . htmlspecialchars($snooze['name']) . '</option>';
}
echo '</select><br>';
echo '<button  class="fancyButton">Change Pet</button>';
echo '</form>';

