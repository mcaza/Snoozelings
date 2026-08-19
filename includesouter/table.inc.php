<?php

$userId = $_COOKIE['user_id'];
$id = $_GET['id'];

//Replies
$query = "SELECT * FROM replies WHERE user_id = :id;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$reply = $stmt->fetch(PDO::FETCH_ASSOC);

//Date Stuff
$now = new DateTime("now", new DateTimezone('UTC'));
$result = $now->format('Y-m-d H:i:s');

//Get Market Info
$query = "SELECT * FROM marketTables WHERE user_id = :id;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$table = $stmt->fetch(PDO::FETCH_ASSOC);

//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="fleaMarket"><<</a>';
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

//Farm Name
echo '<h3 style="margin-bottom: 2rem;">Flea Market Table #' . $id + 1 . '</h3>';

//Display Tables
$items = ['itemOne', 'itemTwo', 'itemThree', 'itemFour'];
$num = ['quantityOne', 'quantityTwo', 'quantityThree', 'quantityFour'];

//Check if Coins
$coinCheck = 0;
if ($table[$items[$id]] == "Coins") {
    $coinCheck = 1;
}

//Grab Display for item
echo '<div class="farmBoxes">';
    $query = "SELECT * FROM itemList WHERE name = :name;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $table[$items[$id]]);
    $stmt->execute();
    $item = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Calculate Worth
    $worth = $item['sell'] * $table[$num[$id]];
    
    echo '<div class="farm">';
    
    //Layer Image
    echo '<div class="artcontainertwo">';
    echo "<div class='imageTwo'>";
    echo "<img src='resources/marketOne.png'>";
    echo "</div>";
    echo "<div class='imageTwo' style='width:45%;margin-left:auto;margin-right:auto;margin-top:20px;'>";
    if ($table[$items[$id]]) {
        echo "<img src='items/" . $table[$items[$id]] . ".png'>";
    } 
    
    echo "</div>";
    echo "</div>";
    
    //echo '<img src="resources/marketOne.png" class="farmBox">';
    if ($table[$items[$id]] == "Coins") {
        echo '<h4  style="margin-top:0;">Ready for Pickup</h4>';
    } else if ($table[$num[$id]] > 1) {
        echo '<h4  style="margin-top:0;">' . $table[$num[$id]] . 'x ' . $item['multiples'] . '</h4>';
    } else if ( $table[$num[$id]] == 1) {
        echo '<h4  style="margin-top:0;">' . $table[$num[$id]] . 'x ' . $item['display'] . '</h4>';
    } else {
        echo '<h4  style="margin-top:0;">Empty Table</h4>';
    }
    if ($table[$items[$id]] == "Coins") {
        echo '<p>' . $table[$num[$id]] . ' Snooze Coins</p><br>';
        
    } else {
        echo '<p><b>Sell Price:</b> ' . $worth . ' Snooze Coins</p><br>';
    }
    
    
    echo '</div>';
echo '</div><hr>';

if ($coinCheck == 0) {
//Change and Place Items
$query = "SELECT * FROM items WHERE user_id = :id ORDER BY name";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
$itemsList = [];

$query = "SELECT * FROM itemList WHERE sell > 0";
$stmt = $pdo->prepare($query);
$stmt->execute();
$itemPrices = $stmt->fetchAll(PDO::FETCH_ASSOC);



$sellCheck = [];

foreach ($itemPrices as $y) {
    array_push($sellCheck,$y['id']);
}


echo '<div><h3 style="margin-bottom: 1rem;">Change Item</div>';
echo '<form method="POST" action="includes/tableItem.inc.php">';
echo '<label for="status"  class="form">Choose Item:</label><br>';
echo '<select  class="input" name="item" id="item"><br>';
echo '<option value=""></option>';
foreach ($items as $x) {
    $sellPrice = "";
    if (in_array($x['name'],$itemsList)) {
        
    } else {
        
            if (in_array($x['list_id'],$sellCheck)) {
                
                foreach ($itemPrices as $p) {
                    if ($x['list_id'] == $p['id']) {
                        $sellPrice = $p['sell'];
                        break;
                    } else {
                        
                    }
                }
                
                echo '<option value="' . $x['list_id'] . '">' . $x['display'] . ' - ' . $sellPrice . ' Each</option>';
                array_push($itemsList,$x['name']);
        } else {
                array_push($itemsList,$x['name']);
        }
    }
    
}
echo '</select><br>';
echo '<label for="status"  class="form">Choose Quantity:</label><br>';
echo '<select  class="input" name="quantity" id="quantity"><br>';
$numbers = [1,2,3,5,10,15];
echo '<option value=""></option>';
foreach ($numbers as $number) {
    echo '<option value="' . $number . '">' . $number . '</option>';
}
echo '</select><br>';
echo ' <input type="hidden" id="table" name="table" value="' . $id . '">';
echo '<button  class="fancyButton">Change Item</button>';
echo '</form>';


if ($table[$num[$id]]) {
    echo '<hr>';
    echo '<div><h3 style="margin-bottom: 1rem;">Remove Item</div>';
    echo '<form method="POST" action="includes/tableRemoveItem.inc.php" onsubmit="return confirm(\'Are you sure you want to remove this item?\');">';
    echo ' <input type="hidden" id="table" name="table" value="' . $id . '">';
    echo '<button  class="redButton">Remove Item</button>';
    echo '</form>';
    
}


} else {
    echo '<div><h3 style="margin-bottom: 1rem;">Coins Available</div>';
    echo '<form method="POST" action="includes/coinReturn.inc.php" >';
    echo ' <input type="hidden" id="table" name="table" value="' . $id . '">';
    echo '<button  class="fancyButton">Collect Coins</button>';
    echo '</form>';
}















