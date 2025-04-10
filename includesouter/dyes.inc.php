<?php

$userId = $_COOKIE['user_id'];


//Replies
$query = "SELECT * FROM replies WHERE user_id = :id;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$reply = $stmt->fetch(PDO::FETCH_ASSOC);

//Get Dye Batch
$query = 'SELECT * FROM dyebatches WHERE user_id = :id AND finished = 0';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$dyebatch = $stmt->fetch(PDO::FETCH_ASSOC);

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
$query = 'SELECT * FROM items WHERE user_id = :id AND dye IS NULL AND (type = "clothesHoodie" OR type = "clothesTop" OR type = "clothesBottom" OR type = "clothesBoth" OR name = "DesignMothFeathers")';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="profile?id=' . $userId . '"><<</a>';
echo '</div>';

//Notification
if ($reply) {
    echo '<div class="returnBar" style="margin-top: 1rem;margin-bottom:2rem;">';
    echo '<p>' . $reply['message'] . '</p>';
    echo '</div>';
    $query = "DELETE FROM replies WHERE user_id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
}

//Desk and Snoozeling
echo '<div class="craftimages" style="align-items:flex-end;">';
echo '<img src="resources/dyePot.png" id="dyepotimage">';
displayPet($pet, "artcrafting");
echo '</div>';
echo '<hr>';

//Display Current Dye
if ($dyebatch) {
    //Get ItemName
    $query = 'SELECT * FROM itemList WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $dyebatch['item_id']);
    $stmt->execute();
    $itemid = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Get Dye Display Name
    $query = 'SELECT * FROM dyes WHERE name = :name';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $dyebatch['dye']);
    $stmt->execute();
    $dyename = $stmt->fetch(PDO::FETCH_ASSOC);
    echo '<img src="/items/' . $itemid['name'] . $dyebatch['dye'] . '.png" style="width:130px;border-radius: 25px; border: 2px silver solid;">';
    echo '<p style="font-size: 2rem"><strong>Current Dye Batch: </strong>' . $itemid['display'] . ' [' . $dyename['display'] . ']</p>';
    
    //Get Minutes Remaining
    $result = $now->format('Y-m-d H:i:s');
    $to_time = strtotime($dyebatch['endtime']);
    $from_time = strtotime($result);
    $diff = round(abs($to_time - $from_time) / 60,0);
    //Date Stuff
    $now = new DateTime("now", new DateTimezone('UTC'));
    $future_date = new DateTime($dyebatch['endtime']);
    $interval = $future_date->diff($now);
    
    if ($result > $dyebatch['endtime']) {
        echo '<form method="post" action="includes/finishDye.inc.php">';
        echo "<button class='fancyButton'>Fetch Item</button>";
        echo '</form>';
    } else {
        echo '<p><i>' . $interval->format("%h Hours, %i Minutes") . ' Remaining</i></p>';
    }
    echo '<hr>';
}


if (!$dyebatch) {
    echo '<form method="post" action="includes/applyDye.inc.php">';
}

echo '<div class="dyebox">';
echo '<h1>Available Dyes</h1>';
echo '<div style="display:flex;flex-wrap:wrap;gap:20px;justify-content:space-evenly;">';

$colorsShown = [];
foreach ($dyes as $dye) {
    if (!in_array($dye['name'], $colorsShown)) {
        echo '<div>';
        $name = str_replace(" Dye", "", $dye['display']);
        echo '<img src="items/' . $dye['name'] . '.png" style="width:100px;" id="' . $dye['name'] . '">';
        echo '<p><b>' . $name . '</b></p>';
        echo '</div>';
        array_push($colorsShown,$dye['name']);
    }
}
echo '</div>';

if (!$dyebatch) {
    //Show Dyes
    echo '<h1>Select Your Dye:</h1>';

    //Dye Selection
    echo '<select name="color" id="color">';
    echo '<option value="" default selected>Select an Option</option>';
    $colorsListed = [];
    foreach ($dyes as $dye) {
        if (!in_array($dye['name'], $colorsListed)) {
            echo '<option value="' . $dye['name'] . '">' . $dye['display'] . '</option>';
            array_push($colorsListed,$dye['name']);
        }
    }
    echo '</select>';
}
echo '</div>';

//Dyable Items Section
echo '<div class="dyebox">';
echo '<h1>Available Items</h1>';
echo '<div style="display:flex;flex-wrap:wrap;gap:20px;justify-content:space-evenly;">';

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

if (!$dyebatch) {
    echo '<h1>Select Your Item:</h1>';

    $clothesarray2 = [];
    echo '<select name="item" id="item">';
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
}

echo '</div>';

if ($dyebatch) {
    echo '<br><p><b>You already have an item in the dye pot</b></p>';
} else {
    echo "<button class='fancyButton' style='margin-top:20px;width:120px;' >Dye Item</button>";
}

echo '</div>';

if (!$dyebatch) {
    echo '</form>';
}