<?php

require_once 'imageFunction.inc.php';

$userId = $_COOKIE['user_id'];

//Get Pet Info For Testing
if (isset($_GET['id'])) {
    $num = $_GET['id'];
} else {
    $num = 1;
}

//Snoozeling Info
$query = 'SELECT * FROM snoozelings WHERE id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $id);
$stmt->execute();
$snooze = $stmt->fetch(PDO::FETCH_ASSOC);


//Form to Update Pet Image Manually
echo '<form action="includes/updatePetImage.inc.php" method="post">';
echo '<label for="number"  class="form">Snoozeling:</label><br>';
if ($num > 1) {
    echo '<input type="text" id="number" name="number" value="' . $num . '"><br>';
} else {
    echo '<input type="text" id="number" name="number"><br>';
}
echo '<button  class="fancyButton">Update Image</button>';
echo '</form>';

//Display Image
echo '<br><br><img src="snoozeImages/' . $num . '.png?timestamp=' . $snooze['ts'] . '" style="width:400px;height:auto;">';




























