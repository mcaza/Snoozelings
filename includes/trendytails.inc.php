<?php

//Grab User ID
$userId = $_SESSION['user_id'];

//Grab Coins
$query = 'SELECT coinCount FROM users WHERE id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$player = $stmt->fetch(PDO::FETCH_ASSOC);

//Grab All Pets
$query = 'SELECT * FROM snoozelings WHERE owner_id = :id ORDER BY name';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$snoozelings = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SESSION['reply']) {
    $reply = $_SESSION['reply'];
    unset($_SESSION['reply']);
}

//Top Div
echo '<div class="topShop">';

//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="snoozeland"><<</a>';
echo '</div>';
    
//Display Coin Count Top Right
echo '<div style="text-align: right">';
if ($player['coinCount'] === "1") {
    echo '<p><strong>Inventory: </strong>' . $player['coinCount'] . ' Gold Coin</p>';
} else {
    echo '<p><strong>Inventory: </strong>' . $player['coinCount'] . ' Gold Coins</p>';
}
echo '</div>';
echo '</div>';

//Session Reply Area
if ($reply) {
    echo '<div class="returnBar" style="margin-top: 1rem;margin-bottom:2rem;"><p>' . $reply . '</p></div>';
}


//Will have cute snoozeling for alpha. Custom art later
echo '<div class="art-container">';
    echo "<div class='artlarge'>";
    echo "<img src='resources/trendyNPC.png' id='Base'>";
    echo "</div>";
    echo "<div class='artlarge'>";
    echo "<img src='resources/Trendypoof.png' id='HairLayer'>";
    echo "</div>";
echo "<div class='artlarge'>";
    echo "<img src='resources/Trendydragon.png' id='TailLayer'>";
    echo "</div>";
echo "</div>";
//echo '<div><img style="width: 50%;" src="resources/trendyNPC.png"></div>';
//echo "<img src='Layers/MainLines/Amethyst.png' id = 'Mainlinesdesigner'>";

//Text. Her talking or something
 echo '<p><i>Fancy a New Look?</i></p>';


echo '<div class="trendytails">';
echo '<div class="trendybox">';
 echo '<h4 style="margin-top: .5rem;">New Hairstyle</h4>';
echo '<p>5 Coins</p>';

//Form. Warning it costs 5 coins
echo "<form method='POST' action='includes/changeHair.inc.php' onsubmit=\"return confirm('This will cost 5 coins. If your previous hair style is rare, you will not be able to change back.');\">";    


//List All Pets
echo '<label for="snoozeling" class="form">Snoozeling:</label><br>';
echo '<select class="input"  name="snoozeling">';
foreach ($snoozelings as $pet) {
    echo '<option value="' . $pet['id'] . '">' . htmlspecialchars($pet['name']) . '</option>';
}
echo '</select><br>';

//List All Hairstyles
echo '<label for="hair" class="form">Hairstyle:</label><br>';
echo '<select class="input"  name="hair" id="hairChoice">';
echo '<option value="Floof">No Hair</option>';
echo '<option value="Forelock">Forelock</option>';
echo '<option value="Mane">Mane</option>';
echo '<option value="Mohawk">Mohawk</option>';
echo '<option value="Wave">Wave</option>';
echo '</select><br>';

//Button
echo '<button  class="fancyButton">Change Hair</button>';

echo '</form>';
echo '</div>';
echo '<div class="trendybox">';
echo '<h4 style="margin-top: .5rem;">New Tailstyle</h4>';
echo '<p>5 Coins</p>';

//Form. Warning it costs 5 coins
echo "<form method='POST' action='includes/changeTail.inc.php' onsubmit=\"return confirm('This will cost 5 coins. If your previous tail style is rare, you will not be able to change back.');\">";    



//List All Pets
echo '<label for="snoozeling" class="form">Snoozeling:</label><br>';
echo '<select class="input"  name="snoozeling">';
foreach ($snoozelings as $pet) {
    echo '<option value="' . $pet['id'] . '">' . htmlspecialchars($pet['name']) . '</option>';
}
echo '</select><br>';

//List All Hairstyles
echo '<label for="tails" class="form">Tailstyle:</label><br>';
echo '<select class="input"  name="tails" id="TailChoice">';
echo '<option value="Dragon">Dragon</option>';
echo '<option value="Long">Long</option>';
echo '<option value="Nub">Nub</option>';
echo '<option value="Pom">Pom</option>';
echo '</select><br>';

//Button
echo '<button  class="fancyButton">Change Tail</button>';
echo '</form>';
echo '</div>';
echo '</div>';
