<?php
$userId = $_COOKIE['user_id'];

//Replies
$query = "SELECT * FROM replies WHERE user_id = :id;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$reply = $stmt->fetch(PDO::FETCH_ASSOC);

//Date Stuff
$now = new DateTime("now", new DateTimezone('UTC'));
$result = $now->format('Y-m-d H:i:s');

//Rollover Time Stuff
$query = 'SELECT * FROM times';
$stmt = $pdo->prepare($query);
$stmt->execute();
$times = $stmt->fetch(PDO::FETCH_ASSOC);

//Sales Time Diff
$future_date2 = new DateTime($times['fleaMarkets']);
$interval2 = $future_date2->diff($now);

//Get Market Info
$query = "SELECT * FROM marketTables WHERE user_id = :id;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$table = $stmt->fetch(PDO::FETCH_ASSOC);

//Get Pet Info
$query = "SELECT * FROM snoozelings WHERE id = :id;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $table['pet_id']);
$stmt->execute();
$pet = $stmt->fetch(PDO::FETCH_ASSOC);

//Get User Info
$query = "SELECT * FROM users WHERE id = :id;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$exp = $pet['sellingEXP'];
if ($exp < 50) {
    $level = "Level 1 Merchant";
} elseif ($exp < 150) {
    $level = "Level 2 Merchant";
} elseif ($exp < 325) {
    $level = "Level 3 Merchant";
} elseif ($exp < 600) {
    $level = "Level 4 Merchant";
} elseif ($exp < 1000) {
    $level = "Level 5 Merchant";
} else {
    $level = "Trade Goblin";
}

//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="snoozevillage"><<</a>';
echo '<p><strong>Next Sale: </strong>' . $interval2->format("%h hours, %i minutes, %s seconds") . '</p>';
echo '</div>';

//Reply Box
if ($reply) {
    echo '<div class="returnBar" style="margin-top: 1rem;margin-bottom:2rem;">';
    echo '<p>' . $reply['message'] . '</p>';
    echo '</div>';
    $query = "DELETE FROM replies WHERE user_id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
}

//Create Table
if ($user['marketSetup'] == 0) {
    echo '<h3 style="margin-bottom: 2rem;">Flea Market Setup</h3>';
    echo '<img src="resources/sproutShop.png" style="width:35%">';
    echo '<p><i>"Hold it right there!! Before you open a Flea Market stall, you\'ll need more items to sell."</i></p>';
    echo '<hr>';
    echo '<p><b>Unlock "Flea Market" After Finishing the Following Tasks:</b></p><br>';
    echo '<div class="stitcherDivs">';
    if ($user['journalEntries'] > 4) {
            echo '<div class="stitcherBoxes"><img src="items/Journal.png"><p><b>5x Journal Entries</b></p><p style="font-size:20px;margin-top:-5px;">✅</p></div>';
        } else {
            echo '<div class="stitcherBoxes"><img src="items/Journal.png"><p><b>5x Journal Entries</b></p><p style="font-size:20px;margin-top:-5px;">❌</p></div>';
        }
    if ($user['cropsHarvested'] > 9) {
            echo '<div class="stitcherBoxes centerBox"><img src="items/Carrot.png"><p><b>10x Crops Harvested</b></p><p style="font-size:20px;margin-top:-5px;">✅</p></div>';
        } else {
            echo '<div class="stitcherBoxes centerBox"><img src="items/Journal.png"><p><b>10x Crops Harvested</b></p><p style="font-size:20px;margin-top:-5px;">❌</p></div>';
        }
    if ($user['itemsCrafted'] > 9) {
            echo '<div class="stitcherBoxes"><img src="items/BambooYarn.png"><p><b>10x Items Crafted</b></p><p style="font-size:20px;margin-top:-5px;">✅</p></div>';
        } else {
            echo '<div class="stitcherBoxes"><img src="items/BambooYarn.png"><p><b>10x Items Crafted</b></p><p style="font-size:20px;margin-top:-5px;">❌</p></div>';
        }
    echo '</div>';
    echo '<br><p><b><i>Once you have completed all Three Tasks, please return after rollover.</i></b></p>';
    
    
} else if ($user['marketSetup'] == 1) {
    echo '<h3 style="margin-bottom: 2rem;">Flea Market Setup</h3>';
    echo '<img src="resources/sproutShop.png" style="width:35%">';
    echo '<p><i>"You did it! Let\'s get your Flea Market stall set up now."</i></p>';
    echo '<hr>';
    
    //Get Backpack Names
    $query = "SELECT * FROM shopNames ORDER BY name";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $shopNames = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo '<form method="post" action="includes/openShop.inc.php">';
    echo '<label for="shopName" class="form">Shop Name:</label><br>';
    echo '<p ><i>Snoozeling\'s</i></p><select class="input" name="shopName">';
    echo '<option value=""></option>';
    foreach ($shopNames as $name) {
        echo '<option value="' . $name['name'] . '">' . $name['name'] . '</option>';
    }
    echo '</select><br>';
        echo "<button class='fancyButton'>Open Shop</button>";
        echo '</form>';
    
} else {
    //Market Name
    if ($table['name']) {
        echo '<h3 style="margin-bottom: 2rem;">'. $pet['name'] . '\'s ' . $table['name'] . '</h3>';
    } else {
        echo '<h3 style="margin-bottom: 2rem;">Flea Market</h3>';
    }
    
    //Snoozeling Image
    echo '<img src="snoozeImages/' . $table['pet_id'] . '.png?timestamp=' . $pet['timestamp'] . '" style="width:35%">';
    echo '<h4 id="marketTitle">' . $level . '</h4>';
    if ($table['unlocked'] > 1) {
        echo '<hr><p>Leave items for ' . $pet['name'] . ' to sell during the next sales period.</p><br>';
    } else {
        echo '<hr><p>Leave an item for ' . $pet['name'] . ' to sell during the next sales period.</p><br>';
    }
    

    //Display Table Boxes
    echo '<div class="farmBoxes">';

    //Display Tables
    $items = ['itemOne', 'itemTwo', 'itemThree', 'itemFour'];
    $num = ['quantityOne', 'quantityTwo', 'quantityThree', 'quantityFour'];
    $amt = ['coinsOne','coinsTwo','coinsThree','coinsFour'];
    for($x = 0; $x < $table['unlocked'];$x++) {
        //Grab Display for item
        $query = "SELECT * FROM itemList WHERE name = :name;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":name", $table[$items[$x]]);
        $stmt->execute();
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        //Calculate Worth
        $worth = $item['sell'] * $table[$num[$x]];

        echo '<a class="farm" href="table?id=' . $x . '"><div >';

        //Layer Image
        echo '<div class="artcontainertwo">';
        echo "<div class='imageTwo'>";
        echo "<img src='resources/marketOne.png'>";
        echo "</div>";
        echo "<div class='imageTwo' style='width:45%;margin-left:auto;margin-right:auto;margin-top:20px;'>";
        if ($table[$items[$x]]) {
            echo "<img src='items/" . $table[$items[$x]] . ".png'>";
        }
        echo "</div>";
        echo "</div>";

        //echo '<img src="resources/marketOne.png" class="farmBox">';
        if ($table[$items[$x]] == "Coins") {
            echo '<h4  style="margin-top:0;">Ready for Pickup</h4>';
        } else if ($table[$num[$x]] > 1) {
            echo '<h4  style="margin-top:0;">' . $table[$num[$x]] . 'x ' . $item['multiples'] . '</h4>';
        } else if ($table[$num[$x]] == 1) {
            echo '<h4  style="margin-top:0;">' . $table[$num[$x]] . 'x ' . $item['display'] . '</h4>';
        } else {
            echo '<h4  style="margin-top:0;">Empty Table</h4>';
        }
        if ($table[$items[$x]] == "Coins") {
            echo '<p>' . $table[$amt[$x]] . ' Snooze Coins</p><br>';
        } else if ($table[$num[$x]] > 0) {
            echo '<p><b>Sell Price:</b> ' . $worth . ' Snooze Coins</p><br>';
        } else {
            echo '<p><i>Click to Add Item</i><br>';
        }


        echo '</div></a>';

        if ($x == 1) {
            echo '</div><br><Br><div class="farmBoxes">';
        }
    }
    echo '</div>';

    //Change Vendor
    echo '<br><hr>';
    $query = "SELECT * FROM snoozelings WHERE owner_id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<div><h3 style="margin-bottom: 1rem;">Change Vendor</div>';
    echo '<form method="POST" action="includes/changeMarket.inc.php">';
    echo '<label for="status"  class="form">Main Vendor:</label><br>';
    echo '<select  class="input" name="snoozeling" id="snoozeling"><br>';
    foreach ($results as $snooze) {
        echo '<option value="' . $snooze['id'] . '">#' . $snooze['id'] . ' - ' . htmlspecialchars($snooze['name']) . '</option>';
    }
    echo '</select><br>';
    echo '<button  class="fancyButton">Change Pet</button>';
    echo '</form>';


    
}


