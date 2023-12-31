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
                <button class="fancyButton" onClick="window.location.href=\'/updateaccount\'">Update Account</button>
                <button class="fancyButton" onClick="window.location.href=\'/editprofile\'">Edit Profile</button>
            </div>';
    //Left Side Profile Info + Right Side Active Pet
    echo '<div class="profilerow">';
    echo '<div class="profilecontainerleft">';
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
           echo '<button class="fancyButton" onClick="window.location.href=\'/includes/addFriend.inc.php?id=' . $id . '\'">Add Friend</button>';
       }   
    $count = intval($result['blockMessages']);
    if (!$count) {
           echo '<button class="fancyButton" onClick="window.location.href=\'sendmessage?id=' . $id . '\'">Send Message</button>';
       }  

    echo '</div>';
    //Left Side Profile Info + Right Side Active Pet
    echo '<div class="profilerow">';
    echo '<div class="profilecontainerleft">';
    echo "<h3>" . htmlspecialchars($result["username"]) . "'s Profile</h3>";
    }
    //Insert Status Here
    echo "<p>" . $result["status"] . "</p>";
    
echo '<div class="profilebox bar" style="overflow-y: auto;">';
echo '<h4 style="text-align: left; margin-top: 1rem; padding-bottom: .5rem; font-size: 2.2rem;border-bottom: 2px dashed #827188;" >&nbsp;&nbsp;&nbsp;Profile Info</h4>';
    echo '<p class="snoozelinginfo"><strong>Player ID: </strong>' . $result['id'];
    echo '<p class="snoozelinginfo"><strong>Pronouns: </strong>' . $result['pronouns'];
    echo '<p class="snoozelinginfo"><strong>Birthday: </strong>' . $monthArray[$monthNum -1] . " " . $dayNum;
    
    if (!($id === "3" || $id === "4" || $id === "5" || $id === "6" || $id === "7" || $id === "8" || $id === "9")) {
          
          echo '<p class="snoozelinginfo"><strong>Join Date: </strong>' . $monthArray[$joinMonth -1] . " " . $joinDay;
    echo '<p class="snoozelinginfo"><strong>User Records: </strong>';
    echo '<ul style="text-align: left;margin-top: 0;padding-bottom: 0;font-size:1.6rem;">';
        if ($result['journalEntries'] === "1") {
                        echo '<li style="margin-bottom:.3rem;margin-left:3rem;">' . $result['journalEntries'] . ' Journal Entry</p>';

        } else {
            echo '<li style="margin-bottom:.3rem;margin-left:3rem;">' . $result['journalEntries'] . ' Journal Entries</p>';
        }
        if ($result['cropsHarvested'] === "1") {
                                    echo '<li style="margin-bottom:.3rem;margin-left:3rem;">' . $result['cropsHarvested'] . ' Crop Harvested</p>';

        } else {
                        echo '<li style="margin-bottom:.3rem;margin-left:3rem;">' . $result['cropsHarvested'] . ' Crops Harvested</p>';

        }
        if ($result['snoozelingsCrafted'] === "1") {
                        echo '<li style="margin-bottom:.3rem;margin-left:3rem;">' . $result['snoozelingsCrafted'] . ' Snoozeling Crafted</p>';

        } else {
            echo '<li style="margin-bottom:.3rem;margin-left:3rem;">' . $result['snoozelingsCrafted'] . ' Snoozelings Crafted</p>';
        }
        if ($result['itemsCrafted'] === "1") {
                        echo '<li style="margin-bottom:.3rem;margin-left:3rem;">' . $result['itemsCrafted'] . ' Item Crafted</p>';

        } else {
            echo '<li style="margin-bottom:.3rem;margin-left:3rem;">' . $result['itemsCrafted'] . ' Items Crafted</p>';
        }
    
    
    
    
    echo '</ul>';
    echo '<p class="snoozelinginfo"><strong>Farm Name: </strong>' . $result['farmName'];
    } else {
        if ($id === "4") {
              echo '<p class="snoozelinginfo" style="overflow-y: auto;"><strong>Job: </strong>Seed Shopkeeper</p>';
              echo '<p class="snoozelinginfo"><strong>Favorite Food: </strong>Trail Mix</p>';
            echo '<p class="snoozelinginfo"><strong>Personality: </strong>Responsible & Hard Working</p>';
              echo '<p class="snoozelinginfo"><strong>Special Skill: </strong>Crossbreeding Plants</p>';
             echo '<p class="snoozelinginfo"><strong>Life\'s Mission: </strong>Preserving Fauna</p>';
              echo '<p class="snoozelinginfo" style="line-height: 20px;"><strong>Fun Fact:</strong> Sprout holds the Snooze Land record for most plants harvested in a single lifetime.</p>';
        } elseif ($id === "3") {
            echo '<p class="snoozelinginfo"><strong>Job: </strong>Professional Snow Sledder</p>';
              echo '<p class="snoozelinginfo"><strong>Favorite Food: </strong>Snownuts</p>';
            echo '<p class="snoozelinginfo"><strong>Personality: </strong>Playful & Worry Free</p>';
              echo '<p class="snoozelinginfo"><strong>Special Skill: </strong>Building Snow Forts</p>';
             echo '<p class="snoozelinginfo"><strong>Life\'s Mission: </strong>Spreading Joy</p>';
              echo '<p class="snoozelinginfo" style="line-height: 20px;"><strong>Fun Fact:</strong> Snow\'s fur changes depending on the season, just like a weasel.</p>';
        } elseif ($id === "5") {
            echo '<p class="snoozelinginfo"><strong>Job: </strong>Adoption Director</p>';
              echo '<p class="snoozelinginfo"><strong>Favorite Food: </strong>Cucumber Sandwiches</p>';
            echo '<p class="snoozelinginfo"><strong>Personality: </strong>Loving & Sincere</p>';
              echo '<p class="snoozelinginfo"><strong>Special Skill: </strong>Braiding Hair</p>';
             echo '<p class="snoozelinginfo"><strong>Life\'s Mission: </strong>Finding Homes for Homeless Snoozelings</p>';
              echo '<p class="snoozelinginfo" style="line-height: 20px;"><strong>Fun Fact:</strong> Miss Lulu and Minky are often seen together. They\'re platonic soulmates.</p>';
        } elseif ($id === "6") {
            echo '<p class="snoozelinginfo"><strong>Job: </strong>Runs Sewing Shop</p>';
              echo '<p class="snoozelinginfo"><strong>Favorite Food: </strong>Honeycomb</p>';
            echo '<p class="snoozelinginfo"><strong>Personality: </strong>Artistic & Quick-witted</p>';
              echo '<p class="snoozelinginfo"><strong>Special Skill: </strong>Creating Snoozelings</p>';
             echo '<p class="snoozelinginfo"><strong>Life\'s Mission: </strong>To find that pin he dropped almost three years ago.</p>';
              echo '<p class="snoozelinginfo" style="line-height: 20px;"><strong>Fun Fact:</strong> When Minky isn\'t working, he spends time stitching teddy bears for the adoption house.</p>';
        } elseif ($id === "7") {
            echo '<p class="snoozelinginfo"><strong>Job: </strong>Mail Courier</p>';
              echo '<p class="snoozelinginfo"><strong>Favorite Food: </strong>Blueberries</p>';
            echo '<p class="snoozelinginfo"><strong>Personality: </strong>Determined & 	Pro-active</p>';
              echo '<p class="snoozelinginfo"><strong>Special Skill: </strong>Shadow Puppets</p>';
             echo '<p class="snoozelinginfo"><strong>Life\'s Mission: </strong>To find joy in simple things.</p>';
              echo '<p class="snoozelinginfo" style="line-height: 20px;"><strong>Fun Fact:</strong> Even with their prosthetic leg, Cole always delivers the mail on time. Their favorite part of the job is seeing the excitement on every customer\'s face.</p>';
        } elseif ($id === "8") {
            echo '<p class="snoozelinginfo"><strong>Job: </strong>Kindness Shopkeeper</p>';
              echo '<p class="snoozelinginfo"><strong>Favorite Food: </strong>Cream Cheese Bagels</p>';
            echo '<p class="snoozelinginfo"><strong>Personality: </strong>Generous & Warmhearted</p>';
              echo '<p class="snoozelinginfo"><strong>Special Skill: </strong>Counting Backwards</p>';
             echo '<p class="snoozelinginfo"><strong>Life\'s Mission: </strong>To encourage unity</p>';
              echo '<p class="snoozelinginfo" style="line-height: 20px;"><strong>Fun Fact:</strong> Melody is on the autism spectrum and doesn\'t like to hugged. Instead, they prefer forehead to forehead contact.</p>';
        } elseif ($id === "9") {
            echo '<p class="snoozelinginfo"><strong>Job: </strong>Baking Pies</p>';
              echo '<p class="snoozelinginfo"><strong>Favorite Food: </strong>Whipped Cream</p>';
            echo '<p class="snoozelinginfo"><strong>Personality: </strong>Patient & Messy</p>';
              echo '<p class="snoozelinginfo"><strong>Special Skill: </strong>Touching Nose with Tongue</p>';
             echo '<p class="snoozelinginfo"><strong>Life\'s Mission: </strong>Opening a Bakery</p>';
              echo '<p class="snoozelinginfo" style="line-height: 20px;"><strong>Fun Fact:</strong> Pudding can sense free food from miles away. Pudding will show up at random parties and events just for the food.</p>';
        }
    }
    echo '</div>';
    echo '</div>';
echo '<div class="displaycontainerright" >';
if ($id === "4") {
    echo '<img src="resources/seedNPC.png" style="height: 40rem;margin-left: 6rem;">';
} elseif ($id === "3") {
    echo '<img src="resources/snowNPC.png" style="height: 40rem;margin-left: .5rem;">';
} elseif ($id === "5") {
    echo '<img src="resources/adoptNPC.png" style="height: 40rem;margin-left: 5.5rem;">';
} elseif ($id === "6") {
    echo '<img src="resources/sewingNPC.png" style="height: 38rem;margin-left: .5rem;margin-bottom: 2rem;">';
} elseif ($id === "7") {
    echo '<img src="resources/postmanNPC.png" style="height: 39rem;margin-left: 1rem; margin-bottom: 1rem;">';
} elseif ($id === "8") {
    echo '<img src="resources/kindnessNPC.png" style="height: 40rem;margin-left: 6.8rem;">';
} elseif ($id === "9") {
    echo '<img src="resources/bakerNPC.png" style="height: 38rem;margin-left: 1rem;margin-bottom: 2rem;">';
} else {
    displayPet($pet, "artlarge");
    echo "<p><strong>Bonded Snoozeling:</strong> " . "<a href='pet?id=" . $pet['id'] . "'>" . htmlspecialchars($pet["name"]) . "</a></p>";
}
    
    
    echo '</div>';    
    echo '</div>';
 
    //Hr
       echo "<hr>";
    
    //Left Side Achievements + Right Side Friends
    echo '  <div class="secondrow">
               <div class="profilerowtwo" style="border: 2px dashed #827188; border-radius: 20px; height: 200px;">
<h4 style="text-align: left; margin-top: 1rem; padding-bottom: .5rem; font-size: 2.2rem;border-bottom: 2px dashed #827188;" >&nbsp;&nbsp;&nbsp;Achievements</h4>
                                   <div  >';
    if ($result['trophies']) {
        $trophies = explode(" ", $result['trophies']);
        array_shift($trophies);
        foreach ($trophies as $trophy) {
        echo '<img style="height: 60px;" src="trophies/' . $trophy . '.png" title="' . $trophy . '">';
    }
    }


             echo   '</div>';
             echo   '</div>
                <div class="profilerowtwo" style="border: 2px dashed #827188; border-radius: 20px; height: 200px;">
                    <h4 style="text-align: left; margin-top: 1rem; padding-bottom: .5rem; font-size: 2.2rem;border-bottom: 2px dashed #827188;" ><a href="friends?id=' . $id . '">&nbsp;&nbsp;&nbsp;Friends</a></h4>';
    
                 //Friend Display
                echo '<div style="display: flex; flex-direction: row; column-gap: 3rem;">';
                 if ($result['friendList']) {
                     $friends = explode(" ", $result['friendList']);
                     array_shift($friends);
                     $friends = array_slice($friends, 0, 11);
                     $length = count($friends);
                     $count = 0;
                     foreach ($friends as $friend) {
                         $query = "SELECT * FROM users WHERE id = :id";
                         $stmt = $pdo->prepare($query);
                         $stmt->bindParam(":id", $friend);
                        $stmt->execute();
                        $friendinfo = $stmt->fetch(PDO::FETCH_ASSOC);
                         if ($count === 0 || $count === 6) {
                             echo '<div>';
                             echo '<ul>';
                         }
                         echo '<li style ="font-size: 1.6rem;text-align: left;"><a href="profile?id=' . $friendinfo['id'] . '">' . $friendinfo['username'] . '</a></li>';
                         if ($count === 5 || $count === 11 || $count === $length-1) {
                             echo '</ul>';
                             echo '</div>';
                         }
                         $count++;
                     }
                     
                 }
    echo '</div></div></div> ';
    
    //Nav section
    if ($id === $userId) {
    echo '<hr>';
    echo '<div class="profilenav">';
    echo '<a href="crafting"><img src="resources/desk.png" style="height: 150px; width: auto;"></a>';
    echo '<a href="farm"><img src="resources/plantbox.png" style="height: 150px; width: auto;"></a>';
    echo '<a href="pack"><img src="resources/backpack.jpg" style="height: 150px; width: auto;"></a>';
    echo '</div>';
    }


    //Bottom Section
    echo '<hr>';
    
    echo '<div id="bottomSpace"><h3 ><a href="collection?id=' . $id . '">Go To Collection >></a></div>';

    if ($userId === "1") {
    echo '<div style="text-align: right;"><form action="includes/rewardCoin.inc.php" method="POST"><input type="hidden" name="user" value="' . $id . '"><input name="reason" type="text" class="input"><br><button class="modButton">Kindness Coin</button></form></div>';
    }

    echo "<script>
    //Profile / Snoozeling / Collection Fix When Only Right Arrow
var leftArrow = document.getElementById('leftArrow');
if (!leftArrow) {
    document.getElementById('onlyOne').style.justifyContent = 'flex-end';
}
    </script>";
