<?php

//Get Values
if (isset($_GET['one'])) {
    $one = $_GET['one'];
}

$query = 'SELECT * FROM colors ORDER BY display ASC';
$stmt = $pdo->prepare($query);
$stmt->execute();
$colorList = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="gameGuides"><<</a>';
echo '</div>';

echo '<h3>Open Inspiration Search</h3>';
echo '<p><i>Currently only Searches Main Body Color</i></p>';


echo '<form action="/openInspire.php" method="get">';
echo '<div style="display:flex;justify-content:space-evenly;">';

echo '<div>';
echo '<h1>Color:</h1>';
echo '<select name="one" id="one">';
if ($one) {
    echo '<option value="' . $one . '">' . $one . '</option>';
} else {
    echo '<option value=""></option>';
}

foreach ($colorList as $color) {
    echo '<option value="' . $color['name'] . '">' . $color['display'] . '</option>';
}
echo '</select>';
echo '</div>';

echo '</div>';

echo "<br><br><button class='fancyButton'>Search Snoozelings</button>";
echo '</form><hr>';

if ($one) {
    echo '<h1>Open Results</h1>';
    
    $status = "Open";
    $query = 'SELECT * FROM snoozelings WHERE breedStatus = :status AND mainColor = :color';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":status", $status);
    $stmt->bindParam(":color", $one);
    $stmt->execute();
    $snoozes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo '<div style="display:flex;justify-content:space-evenly;flex-wrap:wrap;">';
    foreach ($snoozes as $pet) {
        //Check Traits
        $check = explode(" ",$pet['specials']);
        $count = count($check);
        echo '<div style="width:200px;border:1px solid white;border-radius:10px;margin:10px;">';
        echo '<a href="pet?id=' . $pet['id'] . '" target="_blank"><img src="snoozeImages/' . $pet['id'] . '.png" style="width:90%"></a>';
        echo '<a href="pet?id=' . $pet['id'] . '" target="_blank"><h2>#' . $pet['id'] . ' - ' . $pet['name'] . '</h2></a>';
        echo '<p style="font-size:15px;"><b>Eyes:</b> ' . $pet['eyeColor'] . '<br>⁠⁠<b>Skin:</b> ' . $pet['noseColor'] . '<br><b>Hair:</b> ' . $pet['hairColor'] . '<br><b>Tail:</b> ' . $pet['tailColor'] . '<br><br><i>' . $count . ' Special Traits</i></p>'; 
        echo '</div>';
    }
    echo '</div>';
    
    
    
    $snoozes = [];
    $status = "Friends";
    $query = 'SELECT * FROM snoozelings WHERE breedStatus = :status AND mainColor = :color';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":status", $status);
    $stmt->bindParam(":color", $one);
    $stmt->execute();
    $snoozes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($snoozes) {
        echo '<hr>';
    
    echo '<h1>Friends Only</h1>';
        
        echo '<div style="display:flex;justify-content:space-evenly;flex-wrap:wrap;">';
    foreach ($snoozes as $pet) {
        //Check if Disabled
        
        
        //Check Traits
        $check = explode(" ",$pet['specials']);
        $count = count($check);
        echo '<div style="width:200px;border:1px solid white;border-radius:10px;margin:10px;">';
        echo '<a href="pet?id=' . $pet['id'] . '" target="_blank"><img src="snoozeImages/' . $pet['id'] . '.png" style="width:90%"></a>';
        echo '<a href="pet?id=' . $pet['id'] . '" target="_blank"><h2>#' . $pet['id'] . ' - ' . $pet['name'] . '</h2></a>';
        echo '<p style="font-size:15px;"><b>Eyes:</b> ' . $pet['eyeColor'] . '<br>⁠⁠<b>Skin:</b> ' . $pet['noseColor'] . '<br><b>Hair:</b> ' . $pet['hairColor'] . '<br><b>Tail:</b> ' . $pet['tailColor'] . '<br><br><i>' . $count . ' Special Traits</i></p>'; 
        echo '</div>';
    }
    echo '</div>';
    }
    
    
}

echo '</div>';



    






















