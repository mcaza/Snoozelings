<?php

$userId = $_SESSION['user_id'];

if ($_SESSION['reply']) {
    $reply = $_SESSION['reply'];
    unset($_SESSION['reply']);
}


//Top Bar. Back Error Left. Request Button Right
echo '<div style="display: flex;justify-content:space-between;flex-direction: row;">';
//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="snoozevillage"><<</a>';
echo '</div>';

//Post Button (Right)
echo '<div style="text-align: right;"><button  class="fancyButton" onClick="window.location.href=\'newRequest\'">Post Request</button></div>';
echo '</div>';

//Notification
if ($reply) {
    echo '<div class="returnBar" style="margin-top: 1rem;margin-bottom: 2rem;">';
    echo '<p>' . $reply . '</p>';
    echo '</div><br><br>';
}

//Title
echo '<h3 id="requestitle">Requests Board</h3><br>';

//Grab All Requests
$query = "SELECT * FROM requests WHERE fulfilled = 0 AND expired = 0";
$stmt = $pdo->prepare($query);
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
        
        
        echo '<div id="note" style="list-style:none;margin:1em;' . $tilt . '"><a href="request?id=' . $note['id'] . '" style="text-decoration:none;color:#000;background:' . $notesarray[$rand] . ';display:block;height:20em;width:20em;padding:1em;box-shadow: 5px 5px 7px rgba(33,33,33,.7);">';
        echo '<h2 style="font-weight:bold;padding:0;">Request #' . $note['id'] . '</h2>';
        echo '<img src="items/' . $note['name'] . '.png" style="width:10em;">';
        echo '<p style="1rem; font-weight: normal">' . $note['displayname'] . '</p>';
        echo '</a>';
        echo '</div>';
        
        $round++;
    }
}

echo '</div>';