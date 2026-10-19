<?php

$userId = $_COOKIE['user_id'];


//Replies
$query = "SELECT * FROM replies WHERE user_id = :id;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$reply = $stmt->fetch(PDO::FETCH_ASSOC);


//Top Bar. Back Error Left. Request Button Right
echo '<div style="display: flex;justify-content:space-between;flex-direction: row;">';

//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="community"><<</a>';
echo '</div>';

//Post Button (Right)
echo '<div style="text-align: right;"><button  class="fancyButton" onClick="window.location.href=\'newTrade\'">Post Trade</button></div>';
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

//Title
echo '<h3 id="requestitle">&#129525; Plushie Market Trades &#129525;</h3>';
echo '<p>** Marks Private Trades**</p><br>';

//Grab All Requests
$query = "SELECT * FROM plushieTrades WHERE private = 0 OR private = :id ORDER BY id DESC";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo '<br><div id="notediv" style="display:flex;flex-wrap:wrap;gap:50px;justify-content:center;list-style:none;">';

//Display Sticky Notes
$notesarray = ['#FDDFDF', '#FCF7DE', '#DEFDE0', '#DEF3FD', '#F0Defd'];
$count = count($notesarray)-1;
$round = 1;
foreach ($results as $note) {
    if ($note['user_id'] == $userId) {
        
    } else {
        if ($round%2 == 0) {
            $tilt = "transform:rotate(4deg);position:relative;top:5px;";
        } else if ($round/3) {
            $tilt = "transform:rotate(-3deg);position:relative;top:-5px;";
        } else if ($round/5) {
            $tilt = "transform:rotate(5deg);position:relative;top:-10px;";
        } else {
            $tilt = "transform: rotate(-6deg)";
        }
        
        //Choose Random Note Color
        if ($round == 1) {
            $rand = rand(0, $count); 
            $prev = $rand;
        } else {
            while ($rand == $prev) {
                $rand = rand(0, $count); 
            }
        }
        $prev = $rand;
        
        //Type of Trade
        if ($note['type'] == 0) {
            $tradeType = "Any Plush Offers";
        } else if ($note['type'] == 0) {
            $tradeType = "Holiday Plush Only";
        } else {
            $tradeType = "Merch Plush Only";
        }
        
        
        echo '<div id="note" style="list-style:none;margin:1em;' . $tilt . '"><a href="plushPost?id=' . $note['id'] . '" style="text-decoration:none;color:#000;background:' . $notesarray[$rand] . ';display:block;height:20em;width:20em;padding:1em;box-shadow: 5px 5px 7px rgba(33,33,33,.7);">';
        if ($note['private'] == $userId) {
            echo '<h2 style="font-weight:bold;padding:0;">**' . $note['displayName'] . '**</h2>';
        } else {
            echo '<h2 style="font-weight:bold;padding:0;">' . $note['displayName'] . '</h2>';
        }

        echo '<img src="items/' . $note['plushie'] . '.png" style="width:10em;">';
        echo '<p style="1rem; font-weight: bold">Allowed Offers:</p>';
        echo '<p style="1rem; font-weight: normal">' . $tradeType . '</p>';
        echo '</a>';
        echo '</div>';
        
        $round++;
    }
}

echo '</div>';

echo '<hr>';

$query = "SELECT * FROM plushieTrades WHERE user_id = :id ORDER BY id DESC";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo '<h4>Your Open Trades</h4>';
echo '<br><div id="notediv" style="display:flex;flex-wrap:wrap;gap:50px;justify-content:center;list-style:none;">';
foreach ($results as $note) {
    if ($note['user_id'] == $userId) {
        if ($round%2 == 0) {
            $tilt = "transform:rotate(4deg);position:relative;top:5px;";
        } else if ($round/3) {
            $tilt = "transform:rotate(-3deg);position:relative;top:-5px;";
        } else if ($round/5) {
            $tilt = "transform:rotate(5deg);position:relative;top:-10px;";
        } else {
            $tilt = "transform: rotate(-6deg)";
        }
        
        //Choose Random Note Color
        if ($round == 1) {
            $rand = rand(0, $count); 
            $prev = $rand;
        } else {
            while ($rand == $prev) {
                $rand = rand(0, $count); 
            }
        }
        $prev = $rand;
        
        //Type of Trade
        if ($note['type'] == 0) {
            $tradeType = "Any Plush Offers";
        } else if ($note['type'] == 0) {
            $tradeType = "Holiday Plush Only";
        } else {
            $tradeType = "Merch Plush Only";
        }
        
        
        echo '<div id="note" style="list-style:none;margin:1em;' . $tilt . '"><a href="plushPost?id=' . $note['id'] . '" style="text-decoration:none;color:#000;background:' . $notesarray[$rand] . ';display:block;height:20em;width:20em;padding:1em;box-shadow: 5px 5px 7px rgba(33,33,33,.7);">';
        if ($note['private'] == $userId) {
            echo '<h2 style="font-weight:bold;padding:0;">**' . $note['displayName'] . '**</h2>';
        } else {
            echo '<h2 style="font-weight:bold;padding:0;">' . $note['displayName'] . '</h2>';
        }

        echo '<img src="items/' . $note['plushie'] . '.png" style="width:10em;">';
        echo '<p style="1rem; font-weight: bold">Allowed Offers:</p>';
        echo '<p style="1rem; font-weight: normal">' . $tradeType . '</p>';
        echo '</a>';
        echo '</div>';
        
        $round++;
    } 
}

echo '</div>';