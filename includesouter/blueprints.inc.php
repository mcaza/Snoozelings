<?php

$userId = $_SESSION['user_id'];
$reply = $_SESSION['reply'];
unset($_SESSION['reply']);

//Grab all the Blueprints From User
$query = "SELECT * FROM blueprints WHERE owner_id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Notification
if ($reply) {
    echo '<div class="returnBar" style="margin-top: 1rem;margin-bottom: 2rem;">';
    echo '<p>' . $reply . '</p>';
    echo '</div>';
}

//Stitcher Image
echo '<img src="resources/sewingNPC.png" style="width: 40%;">';
echo '<h4 style="margin-bottom: 1.5rem;">Pick Your Next Snoozeling</h4>';

echo '<form method="POST" action="includes/chooseBlueprint.inc.php">';
echo '<div class="radioStarter">';
$count = 1;
foreach ($results as $result) {
    echo '<div id="section' . $count . '" class="boxStarter">';
    echo '<input onClick="changeColour(\'' . $count . '\')" type="radio" id ="button' . $count . '" name="snoozeling" value="' . $result["id"] . '" style="margin-top: 1rem"  />';
    echo '<label for="button' . $count . '">';
    //Display Images
    displayPet($result, "artStarter");
    echo '</label>';
    echo '</div>';
    $count++;
}
echo '</div>';

echo '<button  class="fancyButton" style="margin-top: 2rem;">Choose Blueprint</button>';
    echo '</form>';





//Display Blueprints

//Select Button

//