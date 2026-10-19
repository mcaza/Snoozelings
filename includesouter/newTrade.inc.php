<?php

$userId = $_COOKIE['user_id'];

//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="plushMarket"><<</a>';
echo '</div>';

//Get User Info
$query = "SELECT * FROM users WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

//Get Plushies Available
$query = "SELECT * FROM items WHERE name LIKE '%Plushie' AND user_id = :user ORDER BY name";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":user", $userId);
$stmt->execute();
$plushies = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Title
echo '<h3>Create Plushie Trade</h3><br>';

//Check if Requests are Maxed
$requests = intval($result['plushTrades']);
if ($requests > 0) {
    echo '<p>You have already submitted the max number of trades today.</p>';
} else {
    //Show Request Form
    echo '<form method="post" action="includes/createTrade.inc.php">';
    
    echo '<br><label for="plushie"  class="form">Select Plushie:</label><br>';
    echo '<select class="input" name="plushie" required>';
    echo '<option value=""></option>';
    
    $list = [];
    foreach ($plushies as $plush) {
        if (in_array($plush['name'],$list)) {
            
        } else {
            $query = "SELECT * FROM plushies WHERE name = :name";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":name", $plush['name']);
            $stmt->execute();
            $plushCheck = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($request['type'] <= $plushCheck['rarity']) {
                echo '<option value="' . $plush['name'] . '">' . $plush['display'] . '</option>';
            }
            
            
            array_push($list,$plush['name']);
        }
    }
    echo '</select><br>';
    echo '<br><label for="plushie"  class="form">Trade Type:</label><br>';
    echo '<select class="input" name="type" required>';
    echo '<option value=""></option>';
    echo '<option value="0">Accepting Any Plushie Offers</option>';
    echo '<option value="1">Accepting NPC, Event, and Merch Plushies</option>';
    echo '<option value="2">Accepting Only Event or Merch Plushies</option>';
    echo '<option value="3">Accepting Only Merch Type Plushies</option>';
    echo '</select><br>';
    echo '<br><label for="anon"  class="form">Post Anonymously:</label><br>';
    echo '<select class="input" name="anon" required>';
    echo '<option value=""></option>';
    echo '<option value="0">I Don\'t Mind My Username Posted</option>';
    echo '<option value="1">Yes - Keep me Anonymous</option>';
    echo '</select><br>';
    echo '<label for="notes" class="form">Notes: <i>(Optional)</i></label><br>';
    echo '<textarea id="notes" name="notes" rows="5" cols="40" name="bio"></textarea><br><br>';
    echo '<label for="private" class="form">Private Trade: <i>(Optional)</i></label><br>';
    echo '<input type="number" name="private">';
    echo '<p><i>Leave Empty to Make Trade Public</i></p>';
    echo "<button class='fancyButton'>Create Trade</button>";
    echo '</form>';
    echo '<br><p><i>Please note only 1 Plushie Trade can be created each day.<br><br>All Plushie Trades expire automatically after 7 days.</i></p>';
}













