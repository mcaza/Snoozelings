<?php

//Grab User ID
$userId = $_COOKIE['user_id'];
$query = "SELECT * FROM replies WHERE user_id = :id;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$reply = $stmt->fetch(PDO::FETCH_ASSOC);

//Grab All Pets
$query = "SELECT * FROM snoozelings WHERE owner_id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$snoozelings = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_COOKIE['reply']) {
    $reply = $_COOKIE['reply'];
    setcookie("reply", "", time()-3600);
}

//Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="editprofile"><<</a>';
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

//Title
echo '<h3 style="margin-bottom: .5rem;">Reorder Snoozelings</h3>';
echo '<form action="includes/reorderSnoozelings.inc.php" method="post">';


for($i=0;$i<count($snoozelings);$i++) {
    $j = $i + 1;
    echo '<label for="snoozeling' . $j . '" class="form">Snoozeling #' . $j . ':</label><br>';
    echo '<select name="snoozeling' . $j . '" id="snoozeling' . $j . '">';
    foreach ($snoozelings as $snooze) {
        echo '<option value="' . $snooze['id'] . '">' . $snooze['name'] . '</option>';
    }
    echo '</select><br><br>';
}

echo '<button  class="fancyButton">Change Order</button>';
echo '</form>';