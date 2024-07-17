<?php

$userId = $_SESSION['user_id'];

$query = 'SELECT name, id FROM snoozelings WHERE owner_id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$pets = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="adoption"><<</a>';
echo '</div>';

echo '<h3 style="margin-bottom: 1rem;">Donate a Pet</h3>';

echo '<p><b>Please make sure you select the correct pet.<br><br>Staff are unable to return your pet once submitted.<br><br></b>You will recieve 1 kindness coin when your pet is adopted.</p>';

echo '<form method="POST" action="includes/petdonation.inc.php" onsubmit=\'return confirm("Are you sure that you want to put your pet up for adoption?");\'>';
echo '<label for="petone" class="form" >Select Pet:</label><br>';
echo '<select class="input"  name="petone">';
foreach ($pets as $pet) {
    echo '<option value="' . $pet['id'] . '">#' . $pet['id'] . ' - ' . $pet['name'] . '</option>'; 
}
echo '</select><br>';
echo '<label for="pettwo" class="form" >Confirm Pet:</label><br>';
echo '<select class="input"  name="pettwo">';
foreach ($pets as $pet) {
    echo '<option value="' . $pet['id'] . '">#' . $pet['id'] . ' - ' . $pet['name'] . '</option>'; 
}
echo '</select><br>';
echo '<button  class="fancyButton">Donate Pet</button>';
echo '</form>';