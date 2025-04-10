<?php

$userId = $_COOKIE['user_id'];
$petName = $_COOKIE['bonded'];


//Replies
$query = "SELECT * FROM replies WHERE user_id = :id;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$reply = $stmt->fetch(PDO::FETCH_ASSOC);


//Get Farmname
$query = "SELECT * FROM users WHERE id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $farmName = $stmt->fetch(PDO::FETCH_ASSOC);

//Get Farms
$query = "SELECT * FROM farms WHERE user_id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $farms = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Get Last Water
$query = "SELECT lastWater FROM users WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $water = $stmt->fetch(PDO::FETCH_ASSOC);

//Get Pet Name
$query = "SELECT * FROM snoozelings WHERE id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $farmName['bonded']);
    $stmt->execute();
    $petName = $stmt->fetch(PDO::FETCH_ASSOC);


//Date Stuff
$now = new DateTime("now", new DateTimezone('UTC'));
$result = $now->format('Y-m-d H:i:s');

//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="profile?id=' . $userId . '"><<</a>';
echo '</div>';

//Farm Name
echo '<h3 style="margin-bottom: 2rem;">' . $farmName['farmName'] . '</h3>';
if ($item) {
        echo '<div class="returnBar" style="margin-bottom: 2rem;">';
        
        echo '</div>';
    }

if ($reply) {
    echo '<div class="returnBar" style="margin-top: 1rem;margin-bottom:2rem;">';
    echo '<p>' . $reply['message'] . '</p>';
    echo '</div>';
    $query = "DELETE FROM replies WHERE user_id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
}

//Water Pop Up
if ($result > $water['lastWater']) {
        echo '<div class="returnBar" style="margin-bottom: 2rem;">';
    echo '<h4 style=" margin-top: 0;">Time to Hydrate</h4>';
    if ($petName['pronouns'] == "She/Her") {
        echo '<p>' . $petName['name'] . ' would like you to drink some water while she waters the plants.</p>';
    } else if ($petName['pronouns'] == "He/Him") {
        echo '<p>' . $petName['name'] . ' would like you to drink some water while he waters the plants.</p>';
    } else {
        echo '<p>' . $petName['name'] . ' would like you to drink some water while they water the plants.</p>';
    }
    
    echo '<button class="fancyButton" onClick="window.location.href=\'includes/waterPlants.inc.php\'">Click Here After You Drink</button>';
    echo '</div>';
}

//Display Farm Boxes
echo '<div class="farmBoxes">';
foreach ($farms as $farm) {
    echo '<a class="farm" href="plot?id=' . $farm['id'] . '"><div >';
    if (!$farm['name'] || $result < $farm['stg1']) {
        echo '<img src="resources/emptyBox.png" class="farmBox">';
        if ($farm['name']) {
            if ($farm['mystery'] == 1) {
            echo '<h4 style="margin-top:0;">Mystery Plant</h4>';
        } else {
            echo '<h4 style="margin-top:0;">' . $farm['plantName'] . ' Plant</h4>';
        }
        } else {
            echo '<h4 style="margin-top:0;">Empty Plot</h4>';
        }
    } else if ($result < $farm['stg2']) {
    echo '<img src="resources/stg1.png" class="farmBox">';
        if ($farm['name']) {
            if ($farm['mystery'] == 1) {
            echo '<h4 style="margin-top:0;">Mystery Plant</h4>';
        } else {
            echo '<h4 style="margin-top:0;">' . $farm['plantName'] . ' Plant</h4>';
        } }
} else if ($result < $farm['stg3']) {
    echo '<img src="resources/stg2.png" class="farmBox">';
        if ($farm['name']) {
            if ($farm['mystery'] == 1) {
            echo '<h4 style="margin-top:0;">Mystery Plant</h4>';
        } else {
            echo '<h4 style="margin-top:0;">' . $farm['plantName'] . ' Plant</h4>';
        } }
} else {
    echo '<img src="resources/stg3.png" class="farmBox">';
        echo '<h4  style="margin-top:0;">Ready To Harvest</h4>';
}
    echo '</div></a>';
}
echo '</div>';

//Add New Farm Button

