<?php

$userId = $_COOKIE['user_id'];

$query = "SELECT tutorial FROM users WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$results = $stmt->fetch(PDO::FETCH_ASSOC);
$step = $results['tutorial'];


if ($step == 0) {
    echo '<div><img class="wideImage" src="resources/wideBarPlaceholder.png"></div>';
    echo '<h3 style="margin-top: 2rem;" >Welcome to Snooze Village</h3>';
        echo '<br><br><img src="resources/adoptshopNPC.png" style="width:300px;">';
    echo '<p class="description" style="margin-top: 2rem; width: 70%; margin-right: auto; margin-left: auto;">"I am Miss Lulu. I run the Snoozeling Adoption House.<br><br>I apoligize about the super sticky sticker mess.<br><br>The pups have been quite excited for your visit since I announced it.<br><br>Lets just say the stickers are their way of saying hello."<br>';

    echo '</p>';
    
    echo '<form  method="post" action="../includes/tutorialOne.inc.php">';
    echo '<div><button class="fancyButton">Get Started</button></div>';
    echo "</form>";
} else if ($step == 1) {
    echo '<h3 style="margin-top: 2rem;" >The Snoozeling Code</h3>';
    echo '<br><p>Whether or not you\'ve played a virtual pet game before, you belong. <br><br>Whether or not you have health journaled before, you are able.<br><br>Whether you prefer playing solo or mingling with the community, you are accepted. <br><br>Everyone has the same goal as you. Taking care of themselves and being kind.<br><br> Life is precious. Thank you for using a bit of your time to play our game.<br><br>We hope you love Snoozelings as much as we loved creating it.</p>';
    echo '<hr>';
    echo '<h4>Your First Step is to Adopt a Snoozeling</h4>';
    //Display Button
    echo '<div style="margin-top:2rem;"><button class="fancyButton" onClick="window.location.href=\'../includes/generateStarters.inc.php\'">Visit Miss Lulu</button></div>';
} else if ($step == 2) {
    echo '<img src="resources/adoptNPC.png" style="width:35%; margin-right: auto; margin-left: auto;">';
    echo '<h4>Welcome to the Snoozeling Adoption House</h4>';
    echo '<p style="margin-top: 2rem;margin-bottom: 3.5rem;">"These are the snoozeling pups currently looking for homes.<br><br>Don\'t worry about adoption fees or payment.<br><br>Today we are just focusing on finding them loving homes."</p>';
    //Display Snoozelings + Pick Button
    echo '<form  method="post" action="../includes/firstSnoozeling.inc.php">';
    require_once 'displayStarters.inc.php';
    echo '<label style="margin-top:2rem" class="form" for="name" required>Name Your Snoozeling:</label><br>';
    echo '<input class="form" type="text" name="name"><br>';
    echo '<label class="form" for="pronouns" required>Snoozeling\'s Pronouns</label><br>';
    echo '<select class="input" name="pronouns">';
    echo '<option value="Any">Any</option>';
    echo '<option value="He/Him">He/Him</option>';
    echo '<option value="She/Her">She/Her</option>';
    echo '<option value="They/Them">They/Them</option>';
    echo '<option value="She/Them">She/Them</option>';
    echo '<option value="He/Them">He/Them</option>';
    echo '</select>';
    echo '<div><button class="fancyButton">Choose Snoozeling</button></div>';
    echo "</form>";
    if ($userId === "2") {
        echo '<div style="margin-top:2rem;"><button class="fancyButton" onClick="window.location.href=\'../includes/resetStarters.inc.php\'">Reset Starters</button></div>';
    }
}