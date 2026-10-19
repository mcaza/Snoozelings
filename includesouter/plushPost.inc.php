<?php

$userId = $_COOKIE['user_id'];
$id = $_GET['id'];

//Get Request Information
$query = "SELECT * FROM plushieTrades WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $id);
$stmt->execute();
$request = $stmt->fetch(PDO::FETCH_ASSOC);

//Get Request Information
$query = "SELECT * FROM users WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $request['user_id']);
$stmt->execute();
$poster = $stmt->fetch(PDO::FETCH_ASSOC);

//Get all Offers
$query = "SELECT * FROM plushieOffers WHERE trade_id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $id);
$stmt->execute();
$offers = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Date
$now = new DateTime('now', new DateTimezone('UTC'));
$future_date = new DateTime($request['expiry']);
$interval = $future_date->diff($now);

//Back to Pack Arrows
echo '<div class="leftRightButtons">';
echo '<a href="plushMarket"><<</a>';
echo '</div>';

//Color Selection
$notesarray = ['#FDDFDF', '#FCF7DE', '#DEFDE0', '#DEF3FD', '#F0Defd'];
$count = count($notesarray)-1;
$rand = rand(0, $count);

//Display Request
echo '<div class="itemPageRow" style="background-color:' . $notesarray[$rand] . ';margin-bottom:20px;">';
echo '<div class="itemPage requestText">';
echo '<h4 id="colortitle" style="margin-top:0;margin-bottom:20px;">Plush Trade #' . $id . '</h4>';
echo '<img id="itemicon" src="items/' . $request['plushie'] . '.png" style="width: 150px;">';
echo '<p style="margin-top:12px"><b>Up For Offers:</b></p>';
echo '<p style="margin-top:12px">1x ' . $request['displayName'] . '</p>';
if ($request['description']) {
    echo '<p style="margin-top:12px"><b>Notes:</b></p>';
    echo '<p style="margin-top:12px">' . $request['description'] . '</p>';
}
echo '<p style="margin-top:12px"><b>Posted By:</b></p>';
if ($request['anon'] == 0) {
    echo '<p style="margin-top:12px"><a ref="user?id=' . $request['user_id'] . '"><i>' . $poster['username'] . '</i></a></p>';
} else {
    echo '<p style="margin-top:12px"><i>Anonymous</i></a></p>';
}
echo '</div>';
echo '</div>';
echo '<p><i>This trade will expire in ' . $interval->format("%a Days") . '.</i></p><hr>';

//Display Offers
echo '<h4>Current Offers</h4>';
echo '<div style="display:flex;flex-wrap:wrap;gap:10px;justify-content:center;">';
foreach ($offers as $offer) {
    
    $query = "SELECT * FROM users WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $offer['user_id'] );
    $stmt->execute();
    $username = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo '<div style="border: 2px dashed #827188;width: 20%;border-radius:5px;padding:10px;">';
    if ($request['user_id'] == $userId ) {
        echo '<p><b><a href="profile?id=' . $offer['user_id'] . '">' . $username['username'] . ' #' . $offer['user_id'] . '</a></b></p>';
    }
    echo '<img id="itemicon" src="items/' . $offer['plushie'] . '.png" style="width: 100px;">';
    echo '<p>' . $offer['displayName'] . '</p>';
    echo '</div>';
}
echo '</div>';
echo '<hr>';

//Accept / Deny Offers
if ($request['user_id'] == $userId) {
    echo '<h4>Accept Offer</h4>';
    echo '<form method="post" action="includes/acceptPlushOffer.inc.php" onsubmit="return confirm(\'Are you sure you want to ACCEPT this offer?\');">';
    echo '<label for="status" class="form">Select Offer:</label><br>';
    echo '<select class="input" name="plushieOffer">';
    echo '<option value=""></option>';
    foreach ($offers as $offer) {
        echo '<option value="' . $offer['id'] . '">' . $offer['displayName'] . ' (User #' . $offer['user_id'] . ')</option>';
    }
    echo '</select><br>';
    echo '<input type="hidden" id="trade" name="trade" value="' . $_GET['id'] . '">';
    echo "<button class='fancyButton'>Accept Offer</button>";
    echo '</form>';
    echo '<hr>';
    echo '<h4>Deny Offer</h4>';
    echo '<form method="post" action="includes/denyPlushieOffer.inc.php" onsubmit="return confirm(\'Are you sure you want to DENY this offer?\');">';
    echo '<label for="status" class="form">Select Offer:</label><br>';
    echo '<select class="input" name="plushieOffer">';
    echo '<option value=""></option>';
    foreach ($offers as $offer) {
        echo '<option value="' . $offer['id'] . '">' . $offer['displayName'] . ' (User #' . $offer['user_id'] . ')</option>';
    }
    echo '</select><br>';
    echo '<input type="hidden" id="trade" name="trade" value="' . $_GET['id'] . '">';
    echo '<label for="notes" class="form">Notes: <i>(Optional)</i></label><br>';
    echo '<textarea id="notes" name="notes" rows="5" cols="40" name="bio"></textarea><br><br>';
    echo "<button class='redButton'>Deny Offer</button>";
    echo '</form>';
    
    //Delete Entire Post
    echo '<hr>';
    echo '<h4>Cancel Trade</h4>';
    echo '<form method="post" action="includes/removePlushTrade.inc.php" onsubmit="return confirm(\'Are you sure you want to cancel this trade?\');">';
    echo '<input type="hidden" id="trade" name="trade" value="' . $_GET['id'] . '">';
    echo "<button class='redButton'>Cancel Trade</button>";
} else {
    //Make an Offer
    $query = "SELECT * FROM items WHERE name LIKE '%Plushie' AND user_id = :user ORDER BY name";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user", $userId);
    $stmt->execute();
    $plushies = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    
    echo '<h4>Make an Offer</h4>';
    echo '<form method="post" action="includes/offerPlushie.inc.php" onsubmit="return confirm(\'Are you sure you want to OFFER this plushie?\');">';
    echo '<label for="status" class="form">Select Plushie:</label><br>';
    echo '<select class="input" name="plushieOffer">';
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
    echo '<input type="hidden" id="trade" name="trade" value="' . $_GET['id'] . '">';
    echo "<button class='fancyButton'>Submit Offer</button>";
    echo '</form>';
    echo '<hr>';
    
    //Delete Offer
    $query = "SELECT * FROM plushieOffers WHERE trade_id = :id AND user_id = :user";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":user", $userId);
    $stmt->execute();
    $userOffers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo '<h4>Delete Offer</h4>';
    echo '<form method="post" action="includes/offerPlushieRemove.inc.php" onsubmit="return confirm(\'Are you sure you want to REMOVE this plushie offer?\');">';
    echo '<label for="status" class="form">Select Plushie:</label><br>';
    echo '<select class="input" name="plushieOffer">';
    echo '<option value=""></option>';
    foreach ($userOffers as $offer) {
        echo '<option value="' . $offer['id'] . '">' . $offer['displayName'] . '</option>';
    }
    echo '</select><br>';
    echo '<input type="hidden" id="trade" name="trade" value="' . $_GET['id'] . '">';
    echo "<button class='redButton'>Remove Offer</button>";
}



//Make Offers

//Way to Delete Offer