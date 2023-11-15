<?php

$userId = $_SESSION['user_id'];

$query = "SELECT * FROM blueprints WHERE owner_id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$count = count($results);

if ($count == 0) {
    //Display Button
    echo '<div><button class="fancyButton" onClick="window.location.href=\'../includes/generateStarters.inc.php\'">Generate Snoozelings</button></div>';
} else {
    //Display Snoozelings + Pick Button
    echo '<form method="post" action="../includes/firstSnoozeling.inc.php">';
    require_once 'displayStarters.inc.php';
    echo '<label for="name">Name Your Snoozeling:</label><br>';
    echo '<input type="text" name="name"><br>';
    echo '<label for="pronouns">Snoozeling\'s Pronouns</label><br>';
    echo '<select name="pronouns">';
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