<?php

//Grab User ID
$userId = $_SESSION['user_id'];
$id = $_GET['id'];

//Grab Pet Info from Database
$query = "SELECT * FROM snoozelings WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

//Grab All Titles in Alphebetical Order
$query = "SELECT * FROM titles ORDER BY title";
$stmt = $pdo->prepare($query);
$stmt->execute();
$titles = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo '<h3 style="margin-bottom: 2rem">Edit ' . htmlspecialchars($result['name']) . "'s Information</h3>";
echo '<form action="../includes/editPet.inc.php" method="post">';
echo '<input type="hidden" name="id" value="' . $id . '">';

//Form "Name"
echo '<label class="form" for="name">New Name:</label><br>';
echo '<input class="input" name="name" type="text" value="' . htmlspecialchars($result['name']) . '"><br>';

//Pronouns Check
switch ($result['pronouns']) {
    case "Any":
        $any = "selected";
        break;
    case "She/Them":
        $sheThem = "selected";
        break;
    case "She/Her":
        $sheHer = "selected";
        break;
    case "He/Him":
        $heHim = "selected";
        break;
    case "He/Them":
        $heThem = "selected";
        break;
    case "They/Them":
        $theyThem = "selected";
        break;
}
//Form "Pronouns"
echo '<label for="pronouns"  class="form">Snoozeling\'s Pronouns:</label><br>';
echo '<select  class="input" name="pronouns"><br>';
echo '<option value="Any"' . $any . '>Any</option>';
echo '<option value="She/Her"' . $sheHer . '>She/Her</option>';
echo '<option value="He/Him"' . $heHim . '>He/Him</option>';
echo '<option value="They/Them"' . $theyThem . '>They/Them</option>';
echo '<option value="She/Them"' . $sheThem . '>She/Them</option>';
echo '<option value="He/Them"' . $heThem . '>He/Them</option>';
echo '</select><br>';

//Title
echo '<label for="title"  class="form">Snoozeling\'s Title:</label><br>';
echo '<select  class="input" name="title"><br>';
foreach ($titles as $title) {
    echo '<option value="' . $title['title'] . '">' . $title['title'] . '</option>';
}
if ($result['farmEXP > 1000']) {
    echo '<option value="Crop Whisper">Crop Whisperer</option>';
}
if ($result['explorerEXP > 1000']) {
    echo '<option value="Grand Adventurer">Grand Adventurer</option>';
}
if ($result['farmEXP > 1000']) {
    echo '<option value="Hooked on Crafts">Hooked on Crafts</option>';
}
echo "</select><br>";

//Breeding Status Check
switch ($result['breedStatus']) {
    case "Closed":
        $closed = "selected";
        break;
    case "Open":
        $open = "selected";
        break;
    case "Friends":
        $friends = "selected";
        break;
}

//Form Breeding Status
echo '<label for="status"  class="form">Pet Inspiration:</label><br>';
echo '<select  class="input" name="status"><br>';
echo '<option value="Closed"' . $closed . '>Closed</option>';
echo '<option value="Open"' . $open . '>Open</option>';
//echo '<option value="Friends"' . $friends . '>Friends Only</option>';
echo '</select><br>';

//Breeding Status Javascript
echo '<div id="breedingInfoDiv"><p id="breedingInfo">Test Test</p></div>';

//List of Current Clothes (Adding Later)

//Submit Button
echo '<div>';

echo '<button  class="fancyButton">Update Pet</button>';
echo '</div>';
echo '</form>';