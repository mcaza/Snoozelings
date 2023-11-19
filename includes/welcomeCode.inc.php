<?php

$userId = $_SESSION['user_id'];

$query = "SELECT * FROM blueprints WHERE owner_id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$count = count($results);



if ($count == 0) {
    echo '<div><img class="wideImage" src="resources/wideBarPlaceholder.png"></div>';
    echo '<h3 style="margin-top: 2rem;" >Welcome to Snooze Land</h3>';
    echo '<p class="description" style="margin-top: 2rem; width: 70%; margin-right: auto; margin-left: auto;">Great things await you here. <br><br>Whether or not you\'ve played a pet game like this before, you belong. <br><br>Whether or not you have health journaled before, you are able.<br><br>Whether you play solo or interact with others, you are accepted. <br><br>Everyone has the same goal as you. Taking care of themselves and being kind.<br><br> Life is precious. Thank you for using a bit of your time to play our game.<br><br>We hope you love it as much as we loved making it.</p>';
    echo '<h4>Click the Button Below to See Some Snoozelings</h4>';
    //Display Button
    echo '<div style="margin-top:2rem;"><button class="fancyButton" onClick="window.location.href=\'../includes/generateStarters.inc.php\'">Get Started</button></div>';
} else {
    echo '<img src="resources/adoptNPC.png" style="width:35%; margin-right: auto; margin-left: auto;">';
    echo '<h4>Welcome to the Snoozeling Adoption Center</h4>';
    echo '<p style="margin-top: 2rem;margin-bottom: 3.5rem;">These are the snoozelings currently looking for homes.<br><br>Don\'t worry about fees. We just want them to find a loving home.</p>';
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
}