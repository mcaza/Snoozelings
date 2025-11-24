<?php

$userId = $_COOKIE['user_id'];

echo '<div style="display: flex;justify-content:space-between;flex-direction: row;">';
//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="community"><<</a>';
echo '</div>';

//Check if User is 18+

$query = "SELECT * FROM users WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

 $date = strtotime($result['birthdate']);
    $today = strtotime("-18 year");


    if ($date < $today) {
       $mature = 1;
    } 

/*
//Post Button (Right)
if ($userId == 1) {
    echo '<div style="text-align: right;"><button  class="fancyButton" onClick="window.location.href=\'newPost\'">New Post</button></div>';
    
} */

echo '</div>';

//Title
echo '<h3 style="margin-bottom: 3rem">World Wide Critter Web</h3>';

$adminTopics = ['News', 'Submissions'];
$adminDescriptions = ['The Official Hub for all Snoozelings News', 'Help Improve Snoozelings and Earn Kindness Coins'];
$topics1 = ['Discussion', 'Share','HelpCenter'];
$topics2 = ['General', 'VirtualPets', 'FindFriends','Mature'];
$topics3 = ['Creative', 'Roleplay', 'ForumGames'];
$descriptions1 = ['For discussion of the snoozelings game mechanics and snoozelings pets.', 'Share your many snoozelings with other snoozeling collectors.',  'Ask questions and get help from more experienced players.'];
$descriptions2 = ['Share your hyperfixations and current interests with other members.', 'For all types of Virtual Pets including Virtual Pet Games and Physical Toys.', 'A space for posting Player Introductions and making new friends.', 'A more mature - and hidden - space exclusively for 18+ users.'];
$descriptions3 = ['To share your many creative passions and projects.', 'Roleplay with other members with your snoozelings or other characters.', 'Play all kinds of fun player run forum games here.'];


$round = 1;
$count = count($adminTopics);
echo "<h3 style='margin-bottom:8px;'>Staff News</h3>";
foreach ($adminTopics as $topic) {
    if ($round === 1) {
        echo '<a class="critterbox" style="border: 2px dashed #827188; border-radius: 20px 20px 0px 0px;" href="boards?type=' . $topic . '">';
    } elseif ($round === $count) {
        echo '<a class="critterbox" style="border-bottom: 2px dashed #827188; border-left: 2px dashed #827188; border-right: 2px dashed #827188; border-radius: 0px 0px 20px 20px; " href="boards?type=' . $topic . '">';

    } else {
        echo '<a class="critterbox" style="border-left: 2px dashed #827188;border-right: 2px dashed #827188;border-bottom: 2px dashed #827188;" href="boards?type=' . $topic . '">';
    }
    echo '<h4 style="margin-top: 0;text-align: center;">>> ' . $topic . ' <<</h4><br>';
    echo '<p >' . $adminDescriptions[$round -1] . '</p>';
    echo '<p style="margin-top: 1.5rem;"><strong>Read More</strong></p>';
    echo '</a>';
    $round++;
}

$round = 1;
$count = count($topics1);
echo "<h3 style='margin-top:20px;margin-bottom:8px;'>Snoozelings Game</h3>";
foreach ($topics1 as $topic) {
    if ($topic == "HelpCenter") {
        $name = "Help Center";
    } else if ($topic == "Discussion") {
        $name = "Game Discussion";
    } else if ($topic == "Share") {
        $name = "Snoozeling Share";
    } else {
        $name = $topic;
    }
    if ($round === 1) {
        echo '<a class="critterbox" style="border: 2px dashed #827188; border-radius: 20px 20px 0px 0px;" href="boards?type=' . $topic . '">';
    } elseif ($round === $count) {
        echo '<a class="critterbox" style="border-bottom: 2px dashed #827188; border-left: 2px dashed #827188; border-right: 2px dashed #827188; border-radius: 0px 0px 20px 20px; " href="boards?type=' . $topic . '">';

    }  else {
        echo '<a class="critterbox" style="border-left: 2px dashed #827188;border-right: 2px dashed #827188;border-bottom: 2px dashed #827188;" href="boards?type=' . $topic . '">';
    }
    echo '<h4 style="margin-top: 0;text-align: center;">>> ' . $name . ' <<</h4><br>';
    echo '<p>' . $descriptions1[$round -1] . '</p>';
    echo '<p style="margin-top: 1.5rem;"><strong>Read More</strong></p>';
    echo '</a>';
    
    $round++;
}

$round = 1;
$count = count($topics2);
echo "<h3 style='margin-top:20px;margin-bottom:8px;'>Free Chatting</h3>";
foreach ($topics2 as $topic) {
    if ($topic == "General") {
        $name = "General Chatter";
    } else if ($topic == "VirtualPets") {
        $name = "Virtual Pets";
    } else if ($topic == "FindFriends") {
        $name = "Find Friendships";
    }else if ($topic == "ForumGames") {
        $name = "Forum Games";
    } else if ($topic == "Mature") {
        $name = "Mature Space";
    } else {
        $name = $topic;
    }
    if ($round === 1) {
        echo '<a class="critterbox" style="border: 2px dashed #827188; border-radius: 20px 20px 0px 0px;" href="boards?type=' . $topic . '">';
    }elseif ($mature == 1 && $topic == "Mature") {
        echo '<a class="critterbox" style="border-bottom: 2px dashed #827188; border-left: 2px dashed #827188; border-right: 2px dashed #827188; border-radius: 0px 0px 20px 20px; " href="boards?type=' . $topic . '">';

    } elseif ($mature == 0 && $topic == "FindFriends") {
        echo '<a class="critterbox" style="border-bottom: 2px dashed #827188; border-left: 2px dashed #827188; border-right: 2px dashed #827188; border-radius: 0px 0px 20px 20px; " href="boards?type=' . $topic . '">';

    }  elseif ($mature == 0 && $topic == "Mature") {
        
    } else {
        echo '<a class="critterbox" style="border-left: 2px dashed #827188;border-right: 2px dashed #827188;border-bottom: 2px dashed #827188;" href="boards?type=' . $topic . '">';
    }
    if ($mature == 0 && $topic == "Mature") {
        
    } else {
        echo '<h4 style="margin-top: 0;text-align: center;">>> ' . $name . ' <<</h4><br>';
        echo '<p style="width:90%;margin-left:auto;margin-right:auto;">' . $descriptions2[$round -1] . '</p>';
        echo '<p style="margin-top: 1.5rem;"><strong>Read More</strong></p>';
        echo '</a>';
    }
    $round++;
}

$round = 1;
$count = count($topics3);
echo "<h3 style='margin-top:20px;margin-bottom:8px;'>Fun And Creative</h3>";
foreach ($topics3 as $topic) {
    if ($topic == "Creative") {
        $name = "Creative Corner";
    } else if ($topic == "Roleplay") {
        $name = "Roleplay Boards";
    } else if  ($topic == "ForumGames") {
        $name = "Forum Games";
    } else if ($topic == "Mature") {
        $name = "Mature Space";
    } else {
        $name = $topic;
    }
    if ($round === 1) {
        echo '<a class="critterbox" style="border: 2px dashed #827188; border-radius: 20px 20px 0px 0px;" href="boards?type=' . $topic . '">';
    } elseif ($round === $count) {
        echo '<a class="critterbox" style="border-bottom: 2px dashed #827188; border-left: 2px dashed #827188; border-right: 2px dashed #827188; border-radius: 0px 0px 20px 20px; " href="boards?type=' . $topic . '">';

    } else {
        echo '<a class="critterbox" style="border-left: 2px dashed #827188;border-right: 2px dashed #827188;border-bottom: 2px dashed #827188;" href="boards?type=' . $topic . '">';
    }
    echo '<h4 style="margin-top: 0;text-align: center;">>> ' . $name . ' <<</h4><br>';
    echo '<p>' . $descriptions3[$round -1] . '</p>';
    echo '<p style="margin-top: 1.5rem;"><strong>Read More</strong></p>';
    echo '</a>';
    $round++;
}