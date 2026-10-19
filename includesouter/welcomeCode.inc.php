<?php

$userId = $_COOKIE['user_id'];

$query = "SELECT tutorial FROM users WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$results = $stmt->fetch(PDO::FETCH_ASSOC);
$step = $results['tutorial'];


if ($step == 0) {
    echo '<div><br><br><br><img class="wideImage" src="resources/WelcomeBanner.png"></div>';
    echo '<h3 style="margin-top: 2rem;" >Welcome to Snooze Village</h3>';
    echo '<p class="description" style="margin-top: 2rem; width: 70%; margin-right: auto; margin-left: auto;">You must be weary from traveling so long.<br><br>The internet can be a scary place, but you\'re safe here.<br><br>In Snooze Village, we take pride in ourselves and our community.<br><br>The goal is to work together to make the game and our lives better.<br><Br>To Support, To Survive, To Stand Strong<br>';
    echo '</p>';
    echo '<hr>';
    echo '<div><br><br><br><img class="wideImage" src="resources/wipalt.png"></div>';
    echo '<h3 style="margin-top: 2rem;" >The Snoozeling Code</h3>';
    echo '<br><p>Whether or not you\'ve played a virtual pet game before, you belong. <br><br>Whether or not you have health journaled before, you are able.<br><br>Whether you prefer playing solo or mingling with the community, you are accepted. <br><br>Everyone has the same goal as you. Taking care of themselves and being kind.<br><br> Life is precious. Thank you for using a bit of your time to play our game.<br><br>We hope you love Snoozelings as much as we loved creating it.</p><br>';
    
    echo '<form  method="post" action="../includes/tutorialOne.inc.php">';
    echo '<div><button class="fancyButton">Click To Get Started</button></div>';
    echo "</form>";
} else if ($step == 1) {
    echo '<h3 style="margin-top: 2rem;">Adopting Your First Snoozeling</h3>';
    echo '<img src="resources/ProfileMinky.png" style="width:45%; margin-right: auto; margin-left: auto;">';
    echo '<p class="description" style="margin-top: 2rem; width: 70%; margin-right: auto; margin-left: auto;">My Name is Minky and I\'m a full time seamster.<br><br>That means I sew for a living!!!<br><Br>I\'ve actually sewn most of the snoozelings that reside in Snooze Village.<br><br>Do you want to know the secret for creating such special plushies?<br><Br><b>Minky\'s Super Special Snoozeling Recipe:</b><br><Br>A little bit of magic, A little bit of sewing, and A whole lot of love.<br></p>';
    echo '<hr>';
    echo '<h4>"Please Ignore the Mess!!"</h4>';
    echo '<p>Minky apologizes for the mess as he pulls out six blueprints for you.</p>';
    echo '<img src="resources/table5.png" style="width:35%; margin-right: auto; margin-left: auto;">';
    //Display Button
    echo '<div style="margin-top:2rem;"><button class="fancyButton" onClick="window.location.href=\'../includes/generateStarters.inc.php\'">Open Blueprints</button></div>';
} else if ($step == 2) {
    echo '<img src="resources/ProfileMinky.png" style="width:35%; margin-right: auto; margin-left: auto;">';
    echo '<h4>Snoozeling Selection Tips</h4>';
    echo '<p style="margin-top: 2rem;margin-bottom: 3.5rem;">There is no wrong or right answer.<br><br>Most users pick based on vibes alone.<br><br>Hair and Tail Styles can be changed very easily.<br><br>Colors and Markings are harder to change.<br><br>You are not stuck with this snoozeling forever.<br><br>It can be put up for Adoption once you have another snoozeling.</p>';
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