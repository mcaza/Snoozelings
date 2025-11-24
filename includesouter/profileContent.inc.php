<?php
$id = $_GET['id'];
$userId = $_COOKIE['user_id'];
$year = date("Y"); 

//Friend Request Check
$query = "SELECT * FROM friendRequests WHERE newFriend = :id AND sender = :sender;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->bindParam(":sender", $id);
$stmt->execute();
$friendRequests = $stmt->fetchAll(PDO::FETCH_ASSOC);


if ($friendRequests) {
    echo '<h4>You have a friend request from this user.</h4>';
    echo '<div style="display: flex;flex-direction: row;flex-wrap: wrap; justify-content: center;">';
    echo '<form action="../includes/acceptRequest.inc.php" method="post">';
    echo '<input type="hidden" name="sender" value="' . $id . '">';
    echo '<button class="fancyButton" style="margin-right:20px;width:100px;">Accept</button>';
    echo '</form>';
    echo '<form action="../includes/denyRequest.inc.php" method="post">';
    echo '<input type="hidden" name="sender" value="' . $id . '">';
    echo '<button class="redButton" style="width:100px;">Deny</button>';
    echo '</form>';
    echo '</div>';
    echo '<hr>';
}



//Replies
$query = "SELECT * FROM replies WHERE user_id = :id;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$reply = $stmt->fetch(PDO::FETCH_ASSOC);

$query = "SELECT * FROM users WHERE id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

//Check for Blocks
$block = 0;
$list = explode(" ", $result['blockList']);
if (in_array($userId, $list)) {
    $block = 1;
}

if ($result['backpackColor']) {
    $backpackColor = $result['backpackColor'];
} else {
    $backpackColor = "Sprout";
}

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

if ($id == $userId) {
    //User Navigation
            echo '<div id="onlyOne" class="leftRightButtons">';
            if ($id > 1) {
                $query = 'SELECT * FROM users WHERE id < :id ORDER BY id DESC LIMIT 1';
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":id", $id);
                $stmt->execute();
                $down = $stmt->fetch(PDO::FETCH_ASSOC);
                echo '<input type="hidden" name="left" value="' . $down['id'] . '" id="left">';
                echo '<a id="leftArrow" href="profile?id=' . $down['id'] . '"><<</a>';
            }
        $query = 'SELECT * FROM users WHERE id > :id ORDER BY id ASC LIMIT 1';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $up = $stmt->fetch(PDO::FETCH_ASSOC);
    echo '<input type="hidden" name="right" value="' . $up['id'] . '" id="right">';
    echo '<a href="profile?id=' . $up['id'] . '">>></a>';
    echo '</div>';
    echo '<div class="button-bar">
                <button class="fancyButton" onClick="window.location.href=\'/updateaccount\'">Update Account</button>
                <button class="fancyButton" onClick="window.location.href=\'/editprofile\'">Edit Profile</button>
            </div>';
    
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
    
    //Left Side Profile Info + Right Side Active Pet
    echo '<div class="profilerow">';
    echo '<div class="profilecontainerleft">';
    echo "<h3>Your Profile</h3>";
    
} else {
    //User Navigation
    echo '<div id="onlyOne" class="leftRightButtons">';
            if ($id > 1) {
                $query = 'SELECT * FROM users WHERE id < :id ORDER BY id DESC LIMIT 1';
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":id", $id);
                $stmt->execute();
                $down = $stmt->fetch(PDO::FETCH_ASSOC);
                echo '<input type="hidden" name="left" value="' . $down['id'] . '" id="left">';
                echo '<a id="leftArrow" href="profile?id=' . $down['id'] . '"><<</a>';
            }
        $query = 'SELECT * FROM users WHERE id > :id ORDER BY id ASC LIMIT 1';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $up = $stmt->fetch(PDO::FETCH_ASSOC);
    echo '<input type="hidden" name="right" value="' . $up['id'] . '" id="right">';
    echo '<a href="profile?id=' . $up['id'] . '">>></a>';
    echo '</div>';
    //Right Side Buttons
    echo '<div class="button-bar">';
    $count = intval($result['blockRequests']);
    $check = 0;
       if (!$count && $block == 0) {
           $check = 1;
           echo '<button class="fancyButton" onClick="window.location.href=\'/includes/addFriend.inc.php?id=' . $id . '\'">Add Friend</button>';
       }   
    $count = intval($result['blockMessages']);
    if ($count == 0 && $block == 0) { 
        $check = 1;
           echo '<button class="fancyButton" onClick="window.location.href=\'sendmessage?id=' . $id . '\'">Send Message</button>';
       }  else if ($count == 2) {
        $check = 1;
        //Check if Friends
                $query = 'SELECT friendList FROM users WHERE id = :id';
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":id", $userId);
                $stmt->execute();
                $friendCheck = $stmt->fetch(PDO::FETCH_ASSOC);
            $list = explode(" ", $friendCheck['friendList']);
            if (in_array($id, $list)) {
                echo '<button class="fancyButton" onClick="window.location.href=\'sendmessage?id=' . $id . '\'">Send Message</button>';
            } 
    }
    if ($check == 1) {
        echo '<div style="height:50px;"></div>';
    }
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
    
    //Left Side Profile Info + Right Side Active Pet
    echo '<div class="profilerow">';
    echo '<div class="profilecontainerleft">';
    echo "<h3>" . htmlspecialchars($result["username"]) . "'s Profile</h3>";
    }
    //Insert Status Here
    if ($result['status']) {
        echo "<p>" . $result["status"] . "</p>";
    } else {
        echo "<p><br></p>";
    }
    
    
    echo '<div class="profilebox bar" style="overflow-y: auto;">';

    //Staff Icons
    if ($id == 1) {
        echo '<h4 class="profileh4">&nbsp;&nbsp;&nbsp;Profile Info<img src="resources/admin.png" style="width:20px;margin-left:10px;" title="Lead Developer"></h4>';
    } else if ($result['staff'] == "admin") {
        echo '<h4 class="profileh4" >&nbsp;&nbsp;&nbsp;Profile Info<img src="resources/developer.png" style="width:20px;margin-left:10px;" title="Administrator"></h4>';
    } else if ($result['staff'] == "artist") {
        echo '<h4 class="profileh4" >&nbsp;&nbsp;&nbsp;Profile Info<img src="resources/artist.png" style="width:20px;margin-left:10px;" title="Site Artist"></h4>';
    } else if ($result['staff'] == "moderator") {
        echo '<h4 class="profileh4" >&nbsp;&nbsp;&nbsp;Profile Info<img src="resources/moderator.png" style="width:20px;margin-left:10px;" title="Moderator"></h4>';
    } else if ($id > 2 && $id < 10) {
        echo '<h4 class="profileh4" >&nbsp;&nbsp;&nbsp;Profile Info<img src="resources/NPC.png" style="width:20px;margin-left:10px;" title="NPC Account"></h4>';
    } else {
        echo '<h4 class="profileh4" >&nbsp;&nbsp;&nbsp;Profile Info</h4>';
    }
    echo '<p class="snoozelinginfo"><strong>Player ID: </strong>' . $result['id'];

    if ($id == 3) {
        $today = new DateTime();

        $spring = new DateTime('March 20');
        $summer = new DateTime('June 20');
        $fall = new DateTime('September 22');
        $winter = new DateTime('December 21');

        if ($today >= $spring && $today < $summer) {
            echo '<p class="snoozelinginfo"><strong>Pronouns: </strong>She/Her';
            $tempnoun = "Her ";
        } else if ($today >= $summer && $today < $fall) {
            echo '<p class="snoozelinginfo"><strong>Pronouns: </strong>She/Her';
            $tempnoun = "Her ";
        } else if ($today >= $fall && $today < $winter) {
            echo '<p class="snoozelinginfo"><strong>Pronouns: </strong>He/Him';
            $tempnoun = "His ";
        } else {
            echo '<p class="snoozelinginfo"><strong>Pronouns: </strong>He/Him';
            $tempnoun = "His ";
        }
    } else {
        echo '<p class="snoozelinginfo"><strong>Pronouns: </strong>' . $result['pronouns'];
    }

    echo '<p class="snoozelinginfo"><strong>Birthday: </strong>' . $monthArray[$monthNum -1] . " " . $dayNum;
    
    if (!($id === "3" || $id === "4" || $id === "5" || $id === "6" || $id === "7" || $id === "8" || $id === "9")) {
          
          echo '<p class="snoozelinginfo"><strong>Join Date: </strong>' . $monthArray[$joinMonth -1] . " " . $joinDay;
    echo '<p class="snoozelinginfo"><strong>User Records: </strong>';
    echo '<ul style="text-align: left;margin-top: 0;padding-bottom: 0;font-size:1.6rem;">';
        if ($result['journalEntries'] == "1") {
                        echo '<li style="margin-bottom:.3rem;margin-left:3rem;">' . $result['journalEntries'] . ' Journal Entry</p>';

        } else {
            echo '<li style="margin-bottom:.3rem;margin-left:3rem;">' . $result['journalEntries'] . ' Journal Entries</p>';
        }
        if ($result['cropsHarvested'] == "1") {
                                    echo '<li style="margin-bottom:.3rem;margin-left:3rem;">' . $result['cropsHarvested'] . ' Crop Harvested</p>';

        } else {
                        echo '<li style="margin-bottom:.3rem;margin-left:3rem;">' . $result['cropsHarvested'] . ' Crops Harvested</p>';

        }
        if ($result['itemsCrafted'] == "1") {
                        echo '<li style="margin-bottom:.3rem;margin-left:3rem;">' . $result['itemsCrafted'] . ' Item Crafted</p>';

        } else {
            echo '<li style="margin-bottom:.3rem;margin-left:3rem;">' . $result['itemsCrafted'] . ' Items Crafted</p>';
        }
        if ($result['requestsFilled'] == 1) {
                        echo '<li style="margin-bottom:.3rem;margin-left:3rem;">' . $result['requestsFilled'] . ' Request Fulfilled</p>';

        } else {
            echo '<li style="margin-bottom:.3rem;margin-left:3rem;">' . $result['requestsFilled'] . ' Requests Fulfilled</p>';
        }
        
    
    
    
    
    echo '</ul>';
    echo '<p class="snoozelinginfo"><strong>Farm Name: </strong>' . $result['farmName'];

    
    } else {
        if ($id === "4") {
              echo '<p class="snoozelinginfo" style="overflow-y: auto;"><strong>Job: </strong>Seed Sower</p>';
              echo '<p class="snoozelinginfo"><strong>Favorite Food: </strong>Trail Mix</p>';
            echo '<p class="snoozelinginfo"><strong>Personality: </strong>Responsible & Hard Working</p>';
              echo '<p class="snoozelinginfo"><strong>Special Skill: </strong>Crossbreeding Plants</p>';
              echo '<p class="snoozelinginfo" style="line-height: 20px;"><strong>Fun Fact:</strong> Sprout holds the Snooze Land record for most plants harvested in a single lifetime.</p>';
              echo '<p class="snoozelinginfo" style="line-height: 20px;"><strong>Fun Fact:</strong> Sprout holds the Snooze Land record for most plants harvested in a single lifetime.</p>';
        } elseif ($id === "3") {
            echo '<p class="snoozelinginfo"><strong>Job: </strong>Polymath</p>';
            echo '<p class="snoozelinginfo"><strong>Personality: </strong>Playful & Worry Free</p>';
             echo '<p class="snoozelinginfo"><strong>Life\'s Mission: </strong>Spreading Joy</p>';
              echo '<p class="snoozelinginfo" style="line-height: 20px;"><strong>Fun Fact:</strong> Similar to the snowshoe hare, Cozy\'s fur changes depending on the season. ' . $tempnoun . 'gender fluidity is heavily influenced by these physical changes.</p>';
        } elseif ($id === "5") {
            echo '<p class="snoozelinginfo"><strong>Job: </strong>Adoption Director</p>';
              echo '<p class="snoozelinginfo"><strong>Favorite Food: </strong>Cucumber Sandwiches</p>';
            echo '<p class="snoozelinginfo"><strong>Personality: </strong>Loving & Sincere</p>';
              echo '<p class="snoozelinginfo"><strong>Special Skill: </strong>Braiding Hair</p>';
             echo '<p class="snoozelinginfo"><strong>Life\'s Mission: </strong>Finding Homes for Homeless Snoozelings</p>';
              echo '<p class="snoozelinginfo" style="line-height: 20px;"><strong>Fun Fact:</strong> Miss Lulu and Minky are often seen together. They\'re platonic soulmates.</p>';
        } elseif ($id === "6") {
            echo '<p class="snoozelinginfo"><strong>Job: </strong>Runs Sewing Shop</p>';
              echo '<p class="snoozelinginfo"><strong>Favorite Food: </strong>Cotton Candy</p>';
            echo '<p class="snoozelinginfo"><strong>Personality: </strong>Artistic & Quick-witted</p>';
              echo '<p class="snoozelinginfo"><strong>Special Skill: </strong>Creating Snoozelings</p>';
             echo '<p class="snoozelinginfo"><strong>Life\'s Mission: </strong>To find that pin he dropped almost three years ago.</p>';
              echo '<p class="snoozelinginfo" style="line-height: 20px;"><strong>Fun Fact:</strong> When Minky isn\'t working, he spends time stitching teddy bears for the adoption house.</p>';
        } elseif ($id === "7") {
              echo '<p class="snoozelinginfo"><strong>Favorite Food: </strong>Dog Treats</p>';
            echo '<p class="snoozelinginfo"><strong>Personality: </strong>Playful & Friendly</p>';
              echo '<p class="snoozelinginfo"><strong>Special Skill: </strong>Swimming Long Distances</p>';
             echo '<p class="snoozelinginfo"><strong>Life\'s Mission: </strong>To find joy in simple things.</p>';
              echo '<p class="snoozelinginfo" style="line-height: 20px;"><strong>Fun Fact:</strong> Simon is not a hoarder. He is a collector. But when his many piles begin to overflow, he\'s always happy to share his knick knacks with the community.</p>';
        } elseif ($id === "8") {
            echo '<p class="snoozelinginfo"><strong>Job: </strong>Kindness Shopkeeper</p>';
              echo '<p class="snoozelinginfo"><strong>Favorite Food: </strong>Cream Cheese Bagels</p>';
            echo '<p class="snoozelinginfo"><strong>Personality: </strong>Generous & Warmhearted</p>';
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
    echo '<img src="resources/seedNPC.png" style="height: 40rem;margin-bottom: 2rem;">';
} elseif ($id === "3") {
    $today = new DateTime();
    
    $spring = new DateTime('March 20');
    $summer = new DateTime('June 20');
    $fall = new DateTime('September 22');
    $winter = new DateTime('December 21');
    
    if ($today >= $spring && $today < $summer) {
        echo '<img src="resources/snowsummerNPC.png" style="height: 40rem;">';
    } else if ($today >= $summer && $today < $fall) {
        echo '<img src="resources/snowsummerNPC.png" style="height: 40rem;">';
    } else if ($today >= $fall && $today < $winter) {
        echo '<img src="resources/snowNPC.png" style="height: 40rem;margin-bottom: 2rem;">';
    } else {
        echo '<img src="resources/snowNPC.png" style="height: 40rem;margin-bottom: 2rem;">';
    }
} elseif ($id === "5") {
    echo '<img src="resources/adoptNPC.png" style="height: 40rem;margin-bottom: 2rem;">';
} elseif ($id === "6") {
    echo '<img src="resources/sewingprofileNPC.png" style="height: 40rem;margin-bottom: 2rem;">';
} elseif ($id === "7") {
    echo '<img src="resources/simonNPC.png" style="height: 40rem;margin-bottom: 2rem;">';
} elseif ($id === "8") {
    echo '<img src="resources/kindnessNPC.png" style="height: 40rem;margin-bottom: 2rem;">';
} elseif ($id === "9") {
    echo '<img src="resources/bakerNPC.png" style="height: 40rem;margin-left: 1rem;margin-bottom: 2rem;">';
} else if (!$pet) {
    echo '<img src="Layers/transparentSquare.png" style="height: 40rem;margin-left: 1rem;margin-bottom: 2rem;">';
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
               <div class="profilerowtwo" style="overflow:auto;overflow-x: hidden;" >
<h4 class="profileh4">&nbsp;&nbsp;&nbsp;Bio</h4>
                                   <div  >';
if ($block == 1) {
    $bio = "";
} else {
    $bio = nl2br(htmlspecialchars($result['bio']));
}
   echo '<p class="snoozelinginfo">' . $bio . '</p>';


             echo   '</div>';
             echo   '</div>
                <div class="profilerowtwo" >';
                 echo '<h4 class="profileh4">&nbsp;&nbsp;&nbsp;<a href="/friends">Friends</a></h4>';

    
                 //Friend Display
                echo '<div style="display: flex; flex-direction: row; column-gap: 3rem;">';
                 if ($result['friendList'] && $block == 0) {
                     $friends = explode(" ", $result['friendList']);
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
    echo '</div>';
    echo '</div></div> ';

//Nav section
    if ($id == $userId) {
    echo '<hr>';
    echo '<div class="profilenav">';
    echo '<a href="crafting"><img src="resources/shortcutTable.png" class="profilenavimage"></a>';
    echo '<a href="farm"><img src="resources/shortcutFarm.png" class="profilenavimage"></a>';
    echo '<a href="pack"><img src="resources/ShortcutBackpack' . $backpackColor . '.png" class="profilenavimage"></a>';
    echo '<a href="dyes"><img src="resources/shortcutPot.png" class="profilenavimage"></a>';
    echo '</div>';
    }


    

    //Birthday Gifts
    $fiveDays = new DateTime('now');
    $fiveDays->add(new DateInterval('P5D'));

    //Important Dates
    $query = 'SELECT * FROM times';
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $times = $stmt->fetch(PDO::FETCH_ASSOC);
    $now = new DateTime($times['mailone']);
    $tester = new DateTime($result['birthdate']);

    //Bottom Section
    echo '<hr>';
    
    if ($id > 3 && $id < 9) {
        echo '<div id="bottomSpace"></div>';
    } else if ($userId == $id) {
        echo '<div id="bottomSpace"><h3 ><a href="collection?id=' . $id . '">Go To Collection >></a></div>';
    } else if ($tester->format($year . '-m-d') == $now->format('Y-m-d')) {
        echo '<div id="bottomSpace"><h3 ><a href="collection?id=' . $id . '">Go To Collection >></a></div>';
    } else if ($result['birthdayOptOut'] == 1 && $tester->format($year . '-m-d') > $now->format('Y-m-d') && $tester->format($year . '-m-d') < $fiveDays->format('Y-m-d')) {
        echo '<div><h3><a href="collection?id=' . $id . '">Go To Collection >></a><hr></div>';
            echo '<p><b>This user has opted out of receiving birthday gifts</b></p>';
    } else if ($tester->format($year . '-m-d') > $now->format('Y-m-d') && $tester->format($year . '-m-d') < $fiveDays->format('Y-m-d')) {
            $query = 'SELECT * FROM birthdayGifts WHERE gifter = :gifter AND giftee = :giftee';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":gifter", $userId);
        $stmt->bindParam(":giftee", $id);
        $stmt->execute();
        $giftCheck = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($giftCheck) {
            echo '<div><h3><a href="collection?id=' . $id . '">Go To Collection >></a><hr></div>';
            echo '<p><b>You have already given a birthday gift to this user</b></p>';
        } else {
            echo '<div><h3><a href="collection?id=' . $id . '">Go To Collection >></a><hr></div>';
            echo '<div style="border: 2px dashed #827188;border-radius: 10px;width:80%;margin-left:auto;margin-right:auto;margin-bottom:25px;"><h1>Give a Birthday Gift</h1>';
            echo '<form method="POST" id="comment" name="comment" action="includes/birthdayGift.inc.php">';
            echo '<input type="hidden" id="postId" name="postId" value="' . $id . '" />';
            $query = 'SELECT * FROM items WHERE user_id = :id ORDER BY id';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $userId);
            $stmt->execute();
            $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo '<label style="margin-top: 2rem;" for="gift" class="form" required>Choose a Gift:</label><br>';
            echo '<select class="input"  name="gift">';
            echo '<option value=""></option>';
            foreach ($items as $item) {
                $query = 'SELECT * FROM itemList WHERE name = :name';
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":name", $item['name']);
                $stmt->execute();
                $canDye = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($canDye['canDye'] == 1) {
                    if ($item['dye']) {
                        $query = 'SELECT * FROM dyes WHERE name = :name';
                        $stmt = $pdo->prepare($query);
                        $stmt->bindParam(":name", $item['dye']);
                        $stmt->execute();
                        $color = $stmt->fetch(PDO::FETCH_ASSOC);
                        echo '<option value="' . $item['id'] . '">' . $item['display'] . ' [' . $color['display'] . ']</option>';
                    } else {
                        echo '<option value="' . $item['id'] . '">' . $item['display'] . ' [Basic]</option>';
                    }
                } else {
                    echo '<option value="' . $item['id'] . '">' . $item['display'] . '</option>';
                }
            }
            echo '</select><br>';
            echo "<button class='fancyButton' style='margin-bottom:20px;'>Send Gift</button><br>";
            echo '</form></div>';
        }
        
    } else {
        echo '<div id="bottomSpace"><h3 ><a href="collection?id=' . $id . '">Go To Collection >></a></div>';
    }
    
    //Block Button
    
    if (($id == 2 || $id > 9) && $userId != $id) {
        echo '<div class="button-bar" style="margin-bottom:20px;">';
        echo '<div style="text-align: right;"><form onsubmit="return confirm(\'Are you sure you want to block this user?\');" action="includes/blockUser.inc.php" method="POST"><input type="hidden" name="user" value="' . $id . '"><br><button class="redButton">Block User</button></form></div>';
        echo '</div>';
    }
    

    //Kindness
    if ($userId == "1") {
        echo '<hr>';
    echo '<div style="text-align: right;"><form action="includes/rewardCoin.inc.php" method="POST"><input type="hidden" name="user" value="' . $id . '"><input name="reason" type="text" class="input"><br><button class="modButton">Kindness Coin</button></form></div>';
    }


    echo "<script>
    //Profile / Snoozeling / Collection Fix When Only Right Arrow
var leftArrow = document.getElementById('leftArrow');
if (!leftArrow) {
    document.getElementById('onlyOne').style.justifyContent = 'flex-end';
}
    </script>";
