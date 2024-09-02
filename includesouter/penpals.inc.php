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
echo '<a href="community"><<</a>';
echo '</div>';

//Post Button (Right)
echo '<div style="text-align: right;"><button  class="fancyButton" onClick="window.location.href=\'newNote\'">Post Inquiry</button></div>';
echo '</div>';

//Notification
if ($reply) {
    echo '<div class="returnBar" style="margin-top: 1rem;margin-bottom: 2rem;">';
    echo '<p>' . $reply . '</p>';
    echo '</div><br><br>';
}

//Title
echo '<h3 id="requestitle">Find Penpals</h3><br>';

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
echo '<div style="background-image:url(resources/corkboard.avif);padding:20px;border-radius:10px;border: solid 8px #1C161D;display:flex;flex-wrap:wrap;">';

//Display Penpal Requests
foreach ($results as $result) {
    if ($result['user'] != $userId) {
        echo '<a href="penpalrequest?id=' . $result['id'] . '" class="paper bar" style="overflow:auto;">';
        if ($setting == "Easy") {
            echo '<p style="margin-top:30px;text-align:center;margin-right:10px;margin-left: auto;background-color:DarkSeaGreen;border-radius:8px;width:40px;padding:3px;height:20px;"><b>Easy</b></p>';
        } else if ($setting == "Moderate") {
            echo '<p style="margin-top:30px;text-align:center;margin-right:10px;margin-left: auto;background-color:#FFFF8F;border-radius:8px;width:80px;padding:3px;height:20px;"><b>Moderate</b></p>';
        } else if ($setting == "Stressful") {
            echo '<p style="margin-top:30px;text-align:center;margin-right:10px;margin-left: auto;background-color:Salmon;border-radius:8px;width:70px;padding:3px;height:20px;"><b>Stressful</b></p>';
        }  
        echo '<p style="padding-left:10px;padding-right:10px;text-overflow: hidden;margin-top:-5px;">' . nl2br(htmlspecialchars($result['post'])) . '</p>';
        echo '<p style="margin-bottom:20px;">~ Anonymous</p>';
        echo '</a>';
    }
}

echo '</div>';
if ($setting) {
    echo '<p><i>Your penpal setting is currently set to ' . $setting . '. This can be adjusted in <a href="editprofile">Profile Settings</a>.</i></p>';
} else {
    echo '<p><i>Your penpal setting is currently set to Easy only. This can be adjusted in Profile Settings.</i></p>';
}