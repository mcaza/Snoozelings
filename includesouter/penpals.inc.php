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
echo '<div style="text-align: right;"><button  class="fancyButton" onClick="window.location.href=\'newNote\'">Post Inquiry</button></div>';
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
echo '<h3 id="requestitle">📮 Find New Penpals 📮</h3><br>';

//Get User Difficulty
$query = "SELECT * FROM users WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user['penpal']) {
    $setting = $user['penpal'];
} else {
    $setting = "Easy";
}


//Get all Open Notes
if ($setting == "Moderate") {
    $query = "SELECT * FROM penpalRequests WHERE closed = 0 AND expired = 0 AND (setting = :easy OR setting = :moderate)";
} else if ($setting == "Stressful") {
    $query = "SELECT * FROM penpalRequests WHERE closed = 0 AND expired = 0";
} else {
    $query = "SELECT * FROM penpalRequests WHERE closed = 0 AND expired = 0 AND setting = :easy";
}

$stmt = $pdo->prepare($query);
if ($setting == "Moderate") {
    $easy = "Easy";
    $mod = "Moderate";
    $stmt->bindParam(":easy", $easy);
    $stmt->bindParam(":moderate", $mod);
} else if ($setting == "Stressful") {
    
} else {
    $easy = "Easy";
    $stmt->bindParam(":easy", $easy);
}
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);



//Corkboard Div
$month = ltrim(date('m'), "0");

if ($month == 9) { 
    echo '<div style="background-image:url(resources/September.png);padding:20px;border-radius:10px;border: #2e1a12 solid 12px;
  -webkit-box-shadow: inset 0px 0px 10px rgba(0,0,0,1);display:flex;flex-wrap:wrap;min-height:250px;background-size:1000px;">';
    } else if ($month == 10) {
    echo '<div style="background-image:url(resources/October.png);padding:20px;border-radius:10px;border: #2e1a12 solid 12px;
  -webkit-box-shadow: inset 0px 0px 10px rgba(0,0,0,1);display:flex;flex-wrap:wrap;min-height:250px;background-size:1000px;">';
} else if ($month == 11) {
    echo '<div style="background-image:url(resources/November.png);padding:20px;border-radius:10px;border: #2e1a12 solid 12px;
  -webkit-box-shadow: inset 0px 0px 10px rgba(0,0,0,1);display:flex;flex-wrap:wrap;min-height:250px;background-size:1000px;">';
} else if ($month == 12) {
    echo '<div style="background-image:url(resources/December.png);padding:20px;border-radius:10px;border: #2e1a12 solid 12px;
  -webkit-box-shadow: inset 0px 0px 10px rgba(0,0,0,1);display:flex;flex-wrap:wrap;min-height:250px;background-size:1000px;">';
} else if ($month == 5) {
    echo '<div style="background-image:url(resources/May.jpg);padding:20px;border-radius:10px;border: #2e1a12 solid 12px;
  -webkit-box-shadow: inset 0px 0px 10px rgba(0,0,0,1);display:flex;flex-wrap:wrap;min-height:250px;background-size:1000px;">';
} else if ($month == 6) {
    echo '<div style="background-image:url(resources/June.jpg);padding:20px;border-radius:10px;border: #2e1a12 solid 12px;
  -webkit-box-shadow: inset 0px 0px 10px rgba(0,0,0,1);display:flex;flex-wrap:wrap;min-height:250px;background-size:1000px;">';
} else if ($month == 8) {
    echo '<div style="background-image:url(resources/August.png);padding:20px;border-radius:10px;border: #2e1a12 solid 12px;
  -webkit-box-shadow: inset 0px 0px 10px rgba(0,0,0,1);display:flex;flex-wrap:wrap;min-height:250px;background-size:800px;">';
} else if ($month == 2) {
    echo '<div style="background-image:url(resources/February.png);padding:20px;border-radius:10px;border: #2e1a12 solid 12px;
  -webkit-box-shadow: inset 0px 0px 10px rgba(0,0,0,1);display:flex;flex-wrap:wrap;min-height:250px;background-size:1000px;">';
} else if ($month == 1) {
    echo '<div style="background-image:url(resources/January.png);padding:20px;border-radius:10px;border: #2e1a12 solid 12px;
  -webkit-box-shadow: inset 0px 0px 10px rgba(0,0,0,1);display:flex;flex-wrap:wrap;min-height:250px;background-size:1000px;">';
} else if ($month == 4) {
    echo '<div style="background-image:url(resources/April.png);padding:20px;border-radius:10px;border: #2e1a12 solid 12px;
  -webkit-box-shadow: inset 0px 0px 10px rgba(0,0,0,1);display:flex;flex-wrap:wrap;min-height:250px;background-size:700px;">';
} else if ($month == 7) {
    echo '<div style="background-image:url(resources/July.png);padding:20px;border-radius:10px;border: #2e1a12 solid 12px;
  -webkit-box-shadow: inset 0px 0px 10px rgba(0,0,0,1);display:flex;flex-wrap:wrap;min-height:250px;background-size:1000px;">';
} else if ($month == 3) {
    echo '<div style="background-image:url(resources/March.jpg);padding:20px;border-radius:10px;border: #2e1a12 solid 12px;
  -webkit-box-shadow: inset 0px 0px 10px rgba(0,0,0,1);display:flex;flex-wrap:wrap;min-height:250px;background-size:1000px;">';
}

//Display Penpal Requests
foreach ($results as $result) {
    if ($result['user'] != $userId) {
        echo '<a href="penpalrequest?id=' . $result['id'] . '" class="paper bar" style="overflow:auto;color: black;">';
        if ($result['setting'] == "Easy") {
            echo '<p class="penpalNote" style="margin-top:30px;text-align:center;margin-right:10px;margin-left: auto;background-color:DarkSeaGreen;border-radius:8px;width:40px;padding:3px;height:20px;"><b>Easy</b></p>';
        } else if ($result['setting'] == "Moderate") {
            echo '<p class="penpalNote" style="margin-top:30px;text-align:center;margin-right:10px;margin-left: auto;background-color:#FFFF8F;border-radius:8px;width:80px;padding:3px;height:20px;color:black;"><b>Moderate</b></p>';
        } else if ($result['setting'] == "Stressful") {
            echo '<p class="penpalNote" style="margin-top:30px;text-align:center;margin-right:10px;margin-left: auto;background-color:Salmon;border-radius:8px;width:70px;padding:3px;height:20px;"><b>Stressful</b></p>';
        }  
        echo '<p style="padding-left:10px;padding-right:10px;text-overflow: hidden;margin-top:-5px;">' . nl2br(htmlspecialchars($result['post'])) . '</p>';
        echo '<p style="margin-bottom:20px;">~ Anonymous</p>';
        echo '</a>';
    }
}

echo '</div>';
if ($setting) {
    echo '<p><i>Your penpal setting is currently set to ' . $setting . '</i></p>';
} else {
    echo '<p><i>Your penpal setting is currently set to Easy.</i></p>';
}