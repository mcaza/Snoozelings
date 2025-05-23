<?php
//Get Values
$userId = $_COOKIE['user_id'];

$query = "SELECT * FROM replies WHERE user_id = :id;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$reply = $stmt->fetch(PDO::FETCH_ASSOC);

//Grab Coins
$query = 'SELECT coinCount FROM users WHERE id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$player = $stmt->fetch(PDO::FETCH_ASSOC);

//Grab Adoption Pets
$query = 'SELECT * FROM adopts';
$stmt = $pdo->prepare($query);
$stmt->execute();
$pets = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Top Div
echo '<div class="topShop">';

//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="shops"><<</a>';
echo '</div>';
    
//Display Coin Count Top Right
echo '<div style="text-align: right">';
if ($player['coinCount'] === "1") {
    echo '<p><strong>Inventory: </strong>' . $player['coinCount'] . ' Snooze Coin</p>';
} else {
    echo '<p><strong>Inventory: </strong>' . $player['coinCount'] . ' Snooze Coins</p>';
}
echo '</div>';
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

//Title & Photo
echo '<div><img style="width: 35%;" src="resources/adoptshopNPC.png"></div>';

//Text
$check = 0;
foreach ($pets as $pet) {
    if ($pet['available'] == 1) {
        $check = 1;
    }
}
if ($pets && $check == 0) {
    echo '<p><i>"Thank you for considering adoption. Here are the snoozelings looking for homes."</i></p>';
    echo '<hr>';
} else if ($pets) {
    echo '<p><i>"Check back soon. New snoozelings will be posted after their spa day is finished."</i></p>';
} else {
    echo '<p><i>"There are currently no snoozelings looking for homes. Check back soon."</i></p>';
}


if ($pets) {
//Pet Displays
echo '<div class="adoptionPets">';
$count = 1;
foreach ($pets as $pet) {
    if ($pet['available'] == "1" && !($pet['owner_id'] == $userId)) {
        $query = 'SELECT * FROM snoozelings WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $pet['pet_id']);
        $stmt->execute();
        $petinfo = $stmt->fetch(PDO::FETCH_ASSOC);
        $query = 'SELECT username FROM users WHERe id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $pet['owner_id']);
        $stmt->execute();
        $name = $stmt->fetch(PDO::FETCH_ASSOC);
        echo '<div class="adoptPet">';
        displayPet($petinfo, "art");
        echo '<p style="font-size:1.6rem;"><b>' . $pet['name'] . ' - ' . $pet['cost'] . ' Snooze Coins' . $bed . '</b></p>';
        echo '<p style="font-size: 1.6rem;">Donated By ' . $name['username'] . '</p>';
        echo '<form method="POST" action="includes/adoptSnoozeling.inc.php" onsubmit=\'return confirm("Are you sure that you want to adopt this pet for ' . $pet['cost'] . ' snooze coins?");\'>';
        echo '<input type="hidden" name="pet" value="' . $pet['id'] . '">';
        echo '<button  class="fancyButton">Adopt Pet</button>';
        echo '</form>';
        echo '</div>';
        if ($count % 3 === 0) {
            echo '<hr>';
        }
        $count++;
    }
}
echo '</div>';

//Donate a Pet
$count--;
if (!($count % 3 === 0)) {
    echo '<hr>';
}
 echo '<a href="donatepet"><h4>"I would like to donate a snoozeling."</h4></a>';

} else {
    echo '<hr>';
    echo '<a href="donatepet"><h4>"I would like to donate a snoozeling."</h4></a>';
}