<?php
$id = $_GET['id'];
$userId = $_SESSION['user_id'];

$query = "SELECT * FROM users WHERE id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
$birthday = substr($result['birthdate'], 5);
$join = substr($result['signupDate'], 5);
$monthNum = $birthday.substr(0, 3);
$monthNum = intval($monthNum);
$dayNum = substr($birthday, -2);
$dayNum = intval($dayNum);
$joinMonth = $join.substr(0, 3);
$joinMonth = intval($joinMonth);
$joinDay = substr($join, -2);
$joinDay = intval($joinDay);
$monthArray = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

$petId = $result['bonded'];

$query = "SELECT * FROM snoozelings WHERE id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $petId);
    $stmt->execute();
    
    $pet = $stmt->fetch(PDO::FETCH_ASSOC);

if ($id === $userId) {
    //User Navigation
            echo '<div id="onlyOne" class="leftRightButtons">';
            if ($id > 1) {
                echo '<a id="leftArrow" href="profile?id=' . ($id - 1) . '"><<</a>';
            }
    echo '<a href="profile?id=' . ($id + 1) . '">>></a>';
    echo '</div>';
    echo '<div class="button-bar">
                <button class="fancyButton" onClick="window.location.href=\'/updateAccount.php?ID=' . $id . '\'">Update Account</button>
                <button class="fancyButton" onClick="window.location.href=\'/editProfile.php?ID=' . $id . '\'">Edit Profile</button>
            </div>';
    //Left Side Profile Info + Right Side Active Pet
    echo '<div class="petrow rowone">';
    echo '<div class="petinfo-container">';
    echo "<h3>Your Profile</h3>";
    
} else {
    //User Navigation
    echo '<div class="leftRightButtons">';
    echo '<a href="profile?id=' . ($id - 1) . '"><<</a>';
    echo '<a href="profile?id=' . ($id + 1) . '">>></a>';
    echo '</div>';
    //Right Side Buttons
    echo '<div class="button-bar">';
    $count = intval($result['blockRequests']);
       if (!$count) {
           echo '<button class="fancyButton" onClick="window.location.href=\'/addFriend.php?ID=' . $id . '\'">Add Friend</button>';
       }   
    $count = intval($result['blockMessages']);
    if (!$count) {
           echo '<button class="fancyButton" onClick="window.location.href=\'../includes/sendMessage.php?ID=' . $id . '\'">Send Message</button>';
       }  

    echo '</div>';
    //Left Side Profile Info + Right Side Active Pet
    echo '<div class="petrow rowone">';
    echo '<div class="petinfo-container">';
    echo "<h3>" . htmlspecialchars($result["username"]) . "'s Profile</h3>";
}


    
    
    
    //Insert Status Here
    echo "<p>" . $result["status"] . "</p>";
    
    echo '<div class="physicalInfo info">';
    echo '<h4>Profile Info</h4>';
    echo '<p class="snoozelinginfo"><strong>Player ID: </strong>' . $result['id'];
    echo '<p class="snoozelinginfo"><strong>Pronouns: </strong>' . $result['pronouns'];
    echo '<p class="snoozelinginfo"><strong>Birthday: </strong>' . $monthArray[$monthNum -1] . " " . $dayNum;
    echo '<p class="snoozelinginfo"><strong>Join Date: </strong>' . $monthArray[$joinMonth -1] . " " . $joinDay;

    echo '<p class="snoozelinginfo"><strong>User Records: </strong>';
    echo '<ul style="text-align: left;margin-top: 0;padding-bottom: 0;font-size:1.6rem;">';
    echo '<li style="margin-bottom:.3rem;margin-left:3rem;">' . $result['journalEntries'] . ' Journal Entries</p>';
    echo '<li style="margin-bottom:.3rem;margin-left:3rem;">' . $result['cropsHarvested'] . ' Crops Harvested</p>';
    echo '<li style="margin-bottom:.3rem;margin-left:3rem;">' . $result['snoozelingsCrafted'] . ' Snoozelings Crafted</p>';
    echo '<li style="margin-bottom:.3rem;margin-left:3rem;">' . $result['itemsCrafted'] . ' Items Crafted</p>';


    echo '</ul>';
    echo '<p class="snoozelinginfo"><strong>Farm Name: </strong>' . $result['farmName'];
    echo '</div>';
    echo '</div>';
    echo '<div class="art-container">';
    displayPet($pet, "artlarge");
    echo "<p><strong>Bonded Snoozeling:</strong> " . "<a href='pet?ID=" . $pet['id'] . "'>" . htmlspecialchars($pet["name"]) . "</a></p>";
    echo '</div>';    
    echo '</div>';
 
    //Hr
       echo "<hr>";
    
    //Left Side Achievements + Right Side Friends
    echo '  <div class="petrow profileRow">
               <div class="physicalInfo info">
                    <h4>Achievements</h4>
                </div>
                <div class="physicalInfo info">
                    <h4>Friends</h4>
                </div>
            </div> ';
    
    //Hr
    echo '<hr>';
    
    echo '<div id="bottomSpace"><h3 ><a href="collection?id=' . $id . '">Go To Collection >></a></div>';


    echo "<script>
    //Profile / Snoozeling / Collection Fix When Only Right Arrow
var leftArrow = document.getElementById('leftArrow');
if (!leftArrow) {
    document.getElementById('onlyOne').style.justifyContent = 'flex-end';
}
    </script>";