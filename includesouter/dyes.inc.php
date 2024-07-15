<?php

$userId = $_SESSION['user_id'];

//Get Pet 
$query = 'SELECT * FROM craftingtables WHERE user_id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$query = 'SELECT * FROM snoozelings WHERE id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $result['pet_id']);
$stmt->execute();
$pet = $stmt->fetch(PDO::FETCH_ASSOC);

//Select All Dyes
$query = 'SELECT * FROM items WHERE user_id = :id AND type = "dye"';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$dyes = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Select All Dyable Items
$query = 'SELECT * FROM items WHERE user_id = :id AND dye IS NULL AND (type = "clothesHoodie" OR type = "clothesTop" OR type = "clothesBottom" OR type = "clothesBoth" OR type = "design")';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="profile?id=' . $userId . '"><<</a>';
echo '</div>';

//Desk and Snoozeling
echo '<div class="craftimages" style="align-items:flex-end;">';
echo '<img src="resources/dyePot.png" style="width:200px; height: auto;transform: scaleX(-1);">';
displayPet($pet, "artcrafting");
echo '</div>';
echo '<hr>';

//Display Current Dye

echo '<hr>';
echo '<form method="post" action="includes/applyDye.inc.php">';

echo '<div style="border:#827188 2px dashed;border-radius: 20px;width:80%;padding:25px;margin: auto;margin-bottom:20px;">';
echo '<div style="display:flex;wrap:wrap;gap:20px;justify-content:space-evenly;">';
foreach ($dyes as $dye) {
    echo '<div>';
    $name = str_replace(" Dye", "", $dye['display']);
    echo '<img src="items/' . $dye['name'] . '.png" style="width:100px;" id="' . $dye['name'] . '">';
    echo '<p><b>' . $name . '</b></p>';
    echo '</div>';
}
echo '</div>';

//Show Dyes
echo '<h1>Select Your Dye:</h1>';

//Dye Selection
echo '<select name="color" id="color">';
echo '<option value="" default selected>Select an Option</option>';
foreach ($dyes as $dye) {
    echo '<option value="' . $dye['name'] . '">' . $dye['display'] . '</option>';
}
echo '</select>';
echo '</div>';

//Dyable Items Section
echo '<div style="border:#827188 2px dashed;border-radius: 20px;width:80%;padding:25px;margin: auto;">';
echo '<div style="display:flex;wrap:wrap;gap:20px;justify-content:space-evenly;">';

$clothesarray = [];
foreach ($items as $item) {
    //Select All Dyable Items
    $query = 'SELECT * FROM itemList WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $item['list_id']);
    $stmt->execute();
    $check = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($check['canDye'] == 1) {
        if (in_array($item['name'], $clothesarray)) {
            
        } else {
             echo '<div>';
            echo '<img src="items/' . $item['name'] . '.png" style="width:100px;border-radius: 25px; border: 2px silver solid;" id="' . $item['name'] . '">';
            echo '<p><b>' . $item['display'] . '</b></p>';
            echo '</div>';
            array_push($clothesarray,$item['name']);
        }
    }
}
echo '</div>';

echo '<h1>Select Your Item:</h1>';

$clothesarray2 = [];
echo '<select name="color" id="color">';
echo '<option value="" default selected>Select an Option</option>';
foreach ($items as $item) {
        //Select All Dyable Items
    $query = 'SELECT * FROM itemList WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $item['list_id']);
    $stmt->execute();
    $check = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($check['canDye'] == 1) {
            if (in_array($item['name'], $clothesarray2)) {
            
        } else {
            echo '<option value="' . $item['name'] . '">' . $item['display'] . '</option>';
            array_push($clothesarray2,$item['name']);
        }
    }
    
}
echo '</select>';
echo '</div>';

echo "<button class='fancyButton' style='margin-top:20px;width:200px;' >Dye Item</button>";
echo '</div>';


echo '</form>';