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

//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="pet?id=' . $id . '"><<</a>';
echo '</div>';

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
    case "She/Him":
        $sheHim = "selected";
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
echo '<option value="She/Him"' . $sheHim . '>She/Him</option>';
echo '</select><br>';

//Title
echo '<label for="title"  class="form">Snoozeling\'s Title:</label><br>';
echo '<select  class="input" name="title"><br>';
echo '<option value=""></option>';
foreach ($titles as $title) {
    echo '<option value="' . $title['title'] . '">' . $title['title'] . '</option>';
}
if ($result['farmEXP']  > 1000) {
    echo '<option value="Crop Whisper">Crop Whisperer</option>';
}
if ($result['explorerEXP '] > 1000) {
    echo '<option value="Grand Adventurer">Grand Adventurer</option>';
}
if ($result['farmEXP '] > 1000) {
    echo '<option value="Hooked on Crafts">Hooked on Crafts</option>';
}
echo "</select><br>";

//Bed Color
echo '<label for="bed"  class="form">Bed Color:</label><br>';
echo '<select  class="input" name="bed"><br>';
echo '<option value=""></option>';
echo '<option value="BrownFree">Brown</option>';
echo '<option value="BlueFree">Blue</option>';
echo '<option value="GreenFree">Green</option>';
echo '<option value="PinkFree">Pink</option>';
echo '<option value="RedFree">Red</option>';
echo '</select><br>';

//Show Bed
echo '<label for="showbed"  class="form">Bed on Pet Page:</label><br>';
echo '<select  class="input" name="showbed"><br>';
echo '<option value=""></option>';
echo '<option value="1">Yes</option>';
echo '<option value="2">No</option>';
echo '</select><br>';

//List of Current Clothes (Adding Later)
echo '<label for="status"  class="form">Remove Clothes:</label><br>';
if ($result['clothesTop'] || $result['clothesBottom'] || $result['clothesHoodie'] || $result['clothesBoth']) {
if ($result['clothesTop']) {
    $clothes = explode(" ", $result['clothesTop']);
    foreach ($clothes as $clothing) {
        $query = 'SELECT * FROM itemList WHERE name = :name';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":name", $clothing);
        $stmt->execute();
        $clothe = $stmt->fetch(PDO::FETCH_ASSOC);
        echo '<input type="checkbox" id="' . $clothe['id'] . '" name="' . $clothe['id'] . '" value="' . $clothe['id'] . '"><label style="font-size: 1.7rem;" for="' . $clothe['id'] . '">   ' . $clothe['display'] . '</label><br><br>';
    }
}
if ($result['clothesBottom']) {
    $clothes = explode(" ", $result['clothesBottom']);
    foreach ($clothes as $clothing) {
        $query = 'SELECT * FROM itemList WHERE name = :name';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":name", $clothing);
        $stmt->execute();
        $clothe = $stmt->fetch(PDO::FETCH_ASSOC);
        echo '<input type="checkbox" id="' . $clothe['id'] . '" name="' . $clothe['id'] . '" value="' . $clothe['id'] . '"><label style="font-size: 1.7rem;" for="' . $clothe['id'] . '">   ' . $clothe['display'] . '</label><br><br>';
    }
}
if ($result['clothesHoodie']) {
    $clothes = explode(" ", $result['clothesHoodie']);
    foreach ($clothes as $clothing) {
        $query = 'SELECT * FROM itemList WHERE name = :name';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":name", $clothing);
        $stmt->execute();
        $clothe = $stmt->fetch(PDO::FETCH_ASSOC);
        echo '<input type="checkbox" id="' . $clothe['id'] . '" name="' . $clothe['id'] . '" value="' . $clothe['id'] . '"><label style="font-size: 1.7rem;" for="' . $clothe['id'] . '">   ' . $clothe['display'] . '</label><br><br>';
    }
}
if ($result['clothesBoth']) {
    $clothes = explode(" ", $result['clothesBoth']);
    foreach ($clothes as $clothing) {
        $query = 'SELECT * FROM itemList WHERE name = :name';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":name", $clothing);
        $stmt->execute();
        $clothe = $stmt->fetch(PDO::FETCH_ASSOC);
        echo '<input type="checkbox" id="' . $clothe['id'] . '" name="' . $clothe['id'] . '" value="' . $clothe['id'] . '"><label style="font-size: 1.7rem;" for="' . $clothe['id'] . '">   ' . $clothe['display'] . '</label><br><br>';
    }
}

echo '<br>';
} else {
    echo '<p>Your snoozeling is not wearing any clothes</p><br>';
}

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
echo '<select  class="input" name="status" id="status"><br>';
echo '<option value="Closed"' . $closed . '>Closed</option>';
echo '<option value="Open"' . $open . '>Open</option>';
//echo '<option value="Friends"' . $friends . '>Friends Only</option>';
echo '</select><br>';

//Breeding Status Javascript
if ($closed === "selected") {
    echo '<div id="breedingInfoDiv"><p id="breedingInfo" style="margin-top: 0" >Only you can use this pet as inspiration.</p></div>';
} elseif ($open === "selected") {
    echo '<div id="breedingInfoDiv"><p id="breedingInfo" style="margin-top: 0" >Any users can use this pet as inspiration.</p></div>';
}





//Submit Button
echo '<div>';

echo '<button  class="fancyButton">Update Pet</button>';
echo '</div>';
echo '</form>';