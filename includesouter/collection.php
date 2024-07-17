<?php

require_once 'displayPet.inc.php';

$userId = $_SESSION['user_id'];
$username = $_SESSION['user_username'];
$id = $_GET['id'];



//Query User Information
$query = "SELECT * FROM users WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

//Query All Pets
$query = "SELECT * FROM snoozelings WHERE owner_id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $id);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$extraBeds = intval($result['petBeds']) - intval(count($results));
$beds = ['BlueFree','BrownFree','GreenFree','PinkFree','RedFree'];
$nestcount = 1;


//User Navigation
            echo '<div id="onlyOne" class="leftRightButtons">';
            if ($id > 1) {
                echo '<a id="leftArrow" href="collection?id=' . ($id - 1) . '"><<</a>';
            }
    echo '<a href="collection?id=' . ($id + 1) . '">>></a>';
    echo '</div>';

if ($userId === $id) {
    echo "<h3>Your Collection</h3>";
} else {
    echo "<h3><a href='profile?id=" . $result['id'] . "'>" . $result["username"] . "</a>'s Collection</h3>";
}
echo "<div class='pets'>";


foreach ($results as $pet) {

    echo "<div class='nestpet'>";
    
    displayPet($pet, "arttwo");
    echo '<h5><a href="pet?id=' . $pet['id'] . '">'. htmlspecialchars($pet['name']) . '</a></h5>';
    echo '<p class="slogan">' . $pet['title'] . '</p>';
    echo "</div>";
    $nestcount++;
}

for ($i=$extraBeds; $i>0;$i--) {
    $rand = rand(0,4);
    echo "<div class='nestpet'>";
    echo '<img src="Layers/Beds/Back/' . $beds[$rand] . '.png" style="width: 90%;">';
    echo '<h5>Nest #' . $nestcount . '</h5>';
    echo '<p class="slogan">Empty Nest</p>';
    echo "</div>";
    $nestcount++;
}


    echo "<hr>";


/* if ((count($results) % 3) === 2) {
    echo "<div class='nestpet'><h5>Open Spot</h5></div>";
} elseif ((count($results) % 3) === 1) {
    echo "<div class='nestpet'><div class='art-container'><h5>Open Spot</h5></div></div>";
    echo "<div class='nestpet'><h5>Open Spot</h5></div>";
} */

echo "</div>";

echo '<div id="bottomSpace"><h3><a href="profile?id=' . $id . '">Go To Profile >></a></div>';
