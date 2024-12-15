<?php
$id = $_GET['id'];
$userId = $_SESSION['user_id'];
$farmer = "Farmer";
$jack = "jack";
$seed = "seed";
$plot = $_GET['id'];
date_default_timezone_set('UTC');


//Get All Seeds
$query = "SELECT * FROM items WHERE user_id = :id AND type = :seed ORDER BY display";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->bindParam(":seed", $seed);
$stmt->execute();
$seeds = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Get Snoozelings
$query = "SELECT * FROM farms WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $plot);
$stmt->execute();
$farm = $stmt->fetch(PDO::FETCH_ASSOC);

//Get Farmers & Jacks
$query = "SELECT * FROM snoozelings WHERE (job = :jack OR job = :farmer) && owner_id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":jack", $jack);
    $stmt->bindParam(":farmer", $farmer);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Back to Pack Arrows
 echo '<div class="leftRightButtons">';
echo '<a href="farm"><<</a>';
echo '</div>';

//Div for Farm
echo '<div class="itemPageRow" id="plottop">';
echo '<div class="itemPage">';

//Post Plant Image
$now = new DateTime("now", new DateTimezone('UTC'));
$result = $now->format('Y-m-d H:i:s');
$int = intval($farm['amount']);
if ($result < $farm['stg1'] || !$int ) {
    echo '<img style="width: 250px;" src="resources/emptyBox.png">';
} elseif ($result < $farm['stg2']) {
    echo '<img style="width: 250px;" src="resources/stg1.png">';
} elseif ($result < $farm['stg3']) {
    echo '<img style="width: 250px;" src="resources/stg2.png">';
} else {
    echo '<img style="width: 250px;" src="resources/stg3.png">';
}

//Get Minutes Remaining
$to_time = strtotime($farm['stg3']);
$from_time = strtotime($result);
$diff = round(abs($to_time - $from_time) / 60,0);
//Date Stuff
$now = new DateTime("now", new DateTimezone('UTC'));
$future_date = new DateTime($farm['stg3']);
$interval = $future_date->diff($now);


//Post Plant Name & Info
if ($int === 0) {
    echo '<h4 style="margin-top: 0; margin-bottom:0;">Empty Plot</h4>';
    //Form With Choose Planter and Choose Seed
    echo '<form method="POST" action="includes/plantCrop.inc.php">';
    echo '<input type="hidden" name="plot" value="' . $plot . '">';
    
    //Pick Farmer
    echo '<label for="farmer"  class="form pushDown">Choose A Farmer:</label><br>';
    echo '<select  class="input" name="farmer"><br>';
    foreach ($results as $pet) {
        if ($pet['job']== "Farmer") {
                echo '<option value="' . $pet['id'] . '">*' . htmlspecialchars($pet['name']) . '*</option>';
            } else {
                echo '<option value="' . $pet['id'] . '">' . htmlspecialchars($pet['name']) . '</option>';
            }
    }
    echo '</select></br>';
    
    //Pick Seed
    echo '<label for="seed"  class="form">Choose A Seed:</label><br>';
    echo '<select  class="input" name="seed"><br>';
    foreach ($seeds as $seed) {
        echo '<option value="' . $seed['name'] . '">' . $seed['display'] . '</option>';
    }
    echo '</select></br>';
    
    //Button
    echo "<button class='fancyButton'>Plant Seed</button>";
    echo '</form>';
    
} else {
    
    if ($diff === 0 || $result > $farm['stg3']) {
        if ($farm['mystery'] == 1) {
            echo '<h4>Mystery Plant</h4>';
        } else {
            echo '<h4>' . $farm['plantName'] . ' Plant</h4>';
        }
        echo '<p>Ready To Harvest</p>';
        //Harvest Plant
        echo '<form method="POST" action="includes/harvestCrop.inc.php">';
        echo '<label for="farmer"  class="form pushDown">Choose A Farmer:</label><br>';
        echo '<input type="hidden" name="plot" value="' . $plot . '">';
        echo '<select  class="input" name="farmer"><br>';
        foreach ($results as $pet) {
            if ($pet['job']== "Farmer") {
                echo '<option value="' . $pet['id'] . '">*' . htmlspecialchars($pet['name']) . '*</option>';
            } else {
                echo '<option value="' . $pet['id'] . '">' . htmlspecialchars($pet['name']) . '</option>';
            }
        
        
    }
    echo '</select></br>';
        echo "<button class='fancyButton'>Harvest</button>";
        echo '</form>';
        
    } else {
        if ($farm['mystery'] == 1) {
            echo '<h4>Mystery Plant</h4>';
        } else {
            echo '<h4>' . $farm['plantName'] . ' Plant</h4>';
        }
        
        echo '<p><i>' . $interval->format("%h Hours, %i Minutes") . ' Remaining</i></p>';
    }
}

echo '</div>';
echo '</div>';

