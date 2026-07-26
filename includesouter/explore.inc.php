<?php

//Basic Info
$userId = $_COOKIE['user_id'];
$jack = "jack";
$explorer = "Explorer";

date_default_timezone_set('UTC');

$query = "SELECT * FROM replies WHERE user_id = :id;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$reply = $stmt->fetch(PDO::FETCH_ASSOC);

//Check if Party is Saved
$query = "SELECT * FROM exploringParties WHERE user_id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$lastexplore = $stmt->fetch(PDO::FETCH_ASSOC);

if ($lastexplore['lastArea']) {
    $temp = $lastexplore['lastArea'];
} else {
    $temp = "Farmland";
}

$coins = intval($_COOKIE['coins']);
$items = $_COOKIE['items'];
$error = $_COOKIE['error'];
$name = $_COOKIE['petName'];

setcookie("coins", "", time()-3600);
setcookie("error", "", time()-3600);
setcookie("items", "", time()-3600);
setcookie("petName", "", time()-3600);

$itemString = "";

$query = "SELECT * FROM snoozelings WHERE owner_id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Get Items
$query = "SELECT * FROM itemList";
$stmt = $pdo->prepare($query);
$stmt->execute();
$itemQuery = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="snoozevillage"><<</a>';
echo '</div>';

if ($temp === "Farmland") {
    echo '<div><img id="exploreImage" class="wideImage" src="resources/Farmland.png"></div>';
    $optionone = "selected";
} elseif ($temp === "Forest") {
    echo '<div><img id="exploreImage" class="wideImage" src="resources/Forest.png"></div>';
    $optiontwo = "selected";
} elseif ($temp === "Beach") {
    echo '<div><img id="exploreImage" class="wideImage" src="resources/Beach.png"></div>';
    $optionthree = "selected";
}
echo '<div class="returnItems">';

echo $itemListTests;

if ($reply) {
    echo '<div class="returnBar" style="margin-top: 2rem;margin-bottom:1rem;">';
    echo '<p>' . $reply['message'] . '</p>';
    $itemPics = explode(" ",$reply['items']);
    foreach ($itemPics as $pic) {
        echo '<img src="items/' . $pic . '.png" style="width:35px">'; 
    }
    echo '</div>';
    
    $query = "DELETE FROM replies WHERE user_id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
}



//Form Details



    $now = new DateTime("now", new DateTimezone('UTC'));
    $result = $now->format('Y-m-d H:i:s');
    
    
    if ($result > $lastexplore['cooldownTime']) {
        echo '<form method="post" action="includes/startExplore.inc.php">';
        echo '<label for="explorer"  class="form pushDown">Choose Party Explorers:</label><br>';
       //Check if More than 4 Snoozelings
        if (count($results) > 4) {
            $many = true;
        } else {
            $many = false;
        }
        
        //Owner Check
        $ownercheck = true;
        $groupPets = [];
        array_push($groupPets,$lastexplore['one']);
        array_push($groupPets,$lastexplore['two']);
        array_push($groupPets,$lastexplore['three']);
        array_push($groupPets,$lastexplore['four']);
        foreach ($groupPets as $round) {
            $query = "SELECT * FROM snoozelings WHERE id = :id;";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $round);
            $stmt->execute();
            $snoozeCheck = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($snoozeCheck['owner_id'] == $userId) {
                
            } else {
                $ownercheck = false;
            }
        }
        
        echo '<div>';
        echo '<div>';

        echo '<select  class="input" name="one"  style="margin-right:30px;width:120px;"><br>';
            if ($many == false) {
                echo '<option value="' . $results[0]['id'] . '">' . htmlspecialchars($results[0]['name']) . '</option>';
            } else if ($lastexplore && $ownercheck) {
                foreach ($results as $pet) {
                    if ($pet['id'] == $lastexplore['one']) {
                        echo '<option value="' . $pet['id'] . '">' . htmlspecialchars($pet['name']) . '</option>';
                    }
                }
                foreach ($results as $pet) {
                    if ($pet['id'] != $lastexplore['one']) {
                        echo '<option value="' . $pet['id'] . '">' . htmlspecialchars($pet['name']) . '</option>';
                    }
                }
            } else {
                foreach ($results as $pet) {
                echo '<option value="' . $pet['id'] . '">' . htmlspecialchars($pet['name']) . '</option>';
            }
        }
        echo '</select>';

        echo '<select class="input" name="two" style="width:120px;">';
        if ($many == false) {
            if (count($results) > 1) {
                echo '<option value="' . $results[1]['id'] . '">' . htmlspecialchars($results[1]['name']) . '</option>';
            }  else {
                echo '<option value=""></option>';
            }

        } else if ($lastexplore && $ownercheck) {
                if ($lastexplore['two']) {
                    foreach ($results as $pet) {
                        if ($pet['id'] == $lastexplore['two']) {
                            echo '<option value="' . $pet['id'] . '">' . htmlspecialchars($pet['name']) . '</option>';
                        }
                    }
                    foreach ($results as $pet) {
                    if ($pet['id'] != $lastexplore['two']) {
                        echo '<option value="' . $pet['id'] . '">' . htmlspecialchars($pet['name']) . '</option>';
                    }
                }
                } else {
                    echo '<option value=""></option>';
                }
            } else {
            $i = 0;
            foreach ($results as $pet) {
                if ($i < 1) {
                    $i++;
                } else {
                    echo '<option value="' . $pet['id'] . '">' . htmlspecialchars($pet['name']) . '</option>';
                }
            }
        }
        echo '</select>';

        echo '</div>';
        echo '<div>';

        echo '<select class="input" name="three" style="margin-right:30px;width:120px;">';
        if ($many == false) {
            if (count($results) > 2) {
                echo '<option value="' . $results[2]['id'] . '">' . htmlspecialchars($results[2]['name']) . '</option>';
            } else {
                echo '<option value=""></option>';
            }

        } else if ($lastexplore && $ownercheck) {
                if ($lastexplore['three']) {
                    foreach ($results as $pet) {
                        if ($pet['id'] == $lastexplore['three']) {
                            echo '<option value="' . $pet['id'] . '">' . htmlspecialchars($pet['name']) . '</option>';
                        }
                    }
                    foreach ($results as $pet) {
                    if ($pet['id'] != $lastexplore['three']) {
                        echo '<option value="' . $pet['id'] . '">' . htmlspecialchars($pet['name']) . '</option>';
                    }
                }
                } else {
                    echo '<option value=""></option>';
                }
            } else {
            $i = 0;
            foreach ($results as $pet) {
                if ($i < 2) {
                    $i++;
                } else {
                    echo '<option value="' . $pet['id'] . '">' . htmlspecialchars($pet['name']) . '</option>';
                }
            }
        }
        echo '</select>';

        echo '<select class="input" name="four" style="width:120px;">';
        if ($many == false) {
            if (count($results) > 3) {
                echo '<option value="' . $results[3]['id'] . '">' . htmlspecialchars($results[3]['name']) . '</option>';
            } else {
                echo '<option value=""></option>';
            }
        } else if ($lastexplore && $ownercheck) {
                if ($lastexplore['four']) {
                    foreach ($results as $pet) {
                        if ($pet['id'] == $lastexplore['four']) {
                            echo '<option value="' . $pet['id'] . '">' . htmlspecialchars($pet['name']) . '</option>';
                        }
                    }
                    foreach ($results as $pet) {
                    if ($pet['id'] != $lastexplore['four']) {
                        echo '<option value="' . $pet['id'] . '">' . htmlspecialchars($pet['name']) . '</option>';
                    }
                }
                } else {
                    echo '<option value=""></option>';
                }
            } else {
            $i = 0;
            foreach ($results as $pet) {
                if ($i < 3) {
                    $i++;
                } else {
                    echo '<option value="' . $pet['id'] . '">' . htmlspecialchars($pet['name']) . '</option>';
                }
            }
        }
        echo '</select>';

        echo '</div>';
        echo '</div>';



        echo '<label for="area"  class="form">Choose An Area:</label><br>';
        echo '<select  class="input" name="area" id="exploreArea"><br>';
        echo '<option value="Farmland" ' . $optionone . '>Snoozeling Ranch</option>';
        echo '<option value="Forest" ' . $optiontwo . '>Wistful Woods</option>';
        echo '<option value="Beach" ' . $optionthree . '>Dazzling Coast</option>';
        echo '</select></br>';
        echo '<button  class="fancyButton editButton">Send Exploring</button>';
        echo '</form>';
    } else {
        echo '<h1 style="margin-top:25px;"><b>Explorer Countdown:</b></h1><br>';
        
        //Date Stuff
        $now = new DateTime('now', new DateTimezone('UTC'));
        $future_date = new DateTime($lastexplore['cooldownTime']);
        $interval = $future_date->diff($now);
        echo '<p>' . $interval->format("%h hours, %i minutes, %s seconds") . '</p>';
    }




echo '<br><br><hr><br>';

//if ($temp === "Farmland") {
echo '<div id="Farmland">';
echo '<h6>Snoozeling Ranch Items</h6>';
echo '<h6></h6>';
echo '<table class="exploretable">';
echo '<tr><th colspan="4">Common Items</th></tr>';
echo '<tr>';
echo '<td>Eggshells</td>';
echo '<td>Tiny Feather</td>';
echo '<td>Dirt</td>';
echo '<td>Manure</td>';
echo '</tr>';
echo '<tr>';
echo '<td>Honey</td>';
echo '<td>Egg Carton</td>';
echo '<td>Empty Jug</td>';
echo '<td>Old Can</td>';
echo '</tr>';
echo '<tr>';
echo '<tr><th colspan="4">Uncommon Items</th></tr>';
echo '</tr>';
echo '<tr>';
echo '<td>Ram Horn</td>';
echo '<td>Horse Hair</td>';
echo '<td>Cowbell</td>';
echo '<td>Mystery Seed</td>';
echo '</tr>';
echo '<tr>';
echo '<td>Old Coin</td>';
echo '<td>Farm Chest</td>';
echo '<td>Key</td>';
echo '<td>Button</td>';
echo '</tr>';
echo '<tr>';
echo '<tr><th colspan="4">Rare Items</th></tr>';
echo '</tr>';
echo '<tr>';
echo '<td>Wooly Pattern</td>';
echo '<td>Collie Pattern</td>';
echo '<td>Duck Hoodie</td>';
echo '<td>Horse Hoodie</td>';
echo '</tr>';
echo '<tr>';
echo '<td>Cow Hoodie</td>';
echo '<td>Blue Cow Fabric</td>';
echo '<td>Brown Cow Fabric</td>';
echo '<td>Pink Cow Fabric</td>';
echo '</tr>';
echo '<tr>';
echo '<td>Grey Cow Fabric</td>';
echo '<td></td>';
echo '<td></td>';
echo '<td></td>';
echo '</tr>';
echo '<tr>';
echo '<tr><th colspan="4">Special Items</th></tr>';
echo '</tr>';
echo '<tr>';
echo '<td>Blueprint</td>';
echo '<td>Sewing Kit</td>';
echo '<td></td>';
echo '<td></td>';
echo '</tr>';
echo '</table><br><br>';
echo '</div>';
//} elseif ($temp === "Forest") {
echo '<div id="Forest">';
echo '<h6>Wistful Woods Items</h6>';
echo '<h6></h6>';
echo '<table class="exploretable">';
echo '<tr><th colspan="4">Common Items</th></tr>';
echo '<tr>';
echo '<td>Wood Log</td>';
echo '<td>Colorful Feather</td>';
echo '<td>Gooseberry</td>';
echo '<td>Blueberry</td>';
echo '</tr>';
echo '<tr>';
echo '<td>Leaf</td>';
echo '<td>Tree Sap</td>';
echo '<td>Plant Fiber</td>';
echo '<td>Flower</td>';
echo '</tr>';
echo '<tr>';
echo '<tr><th colspan="4">Uncommon Items</th></tr>';
echo '</tr>';
echo '<tr>';
echo '<td>Lizard Tail</td>';
echo '<td>Bug Wings</td>';
echo '<td>Mushroom</td>';
echo '<td>Mystery Seed</td>';
echo '</tr>';
echo '<tr>';
echo '<td>Old Coin</td>';
echo '<td>Woods Chest</td>';
echo '<td>Key</td>';
echo '<td>Button</td>';
echo '</tr>';
echo '<tr>';
echo '<tr><th colspan="4">Rare Items</th></tr>';
echo '</tr>';
echo '<tr>';
echo '<td>Panther Pattern</td>';
echo '<td>Foxy Pattern</td>';
echo '<td>Deer Hoodie</td>';
echo '<td>Doe Hoodie</td>';
echo '</tr>';
echo '<tr>';
echo '<td>Fairy Horns</td>';
echo '<td>Acorns Fabric</td>';
echo '<td>Leaves Fabric</td>';
echo '<td>Forest Fabric</td>';
echo '</tr>';
echo '<tr>';
echo '<td>Acorn Bag</td>';
echo '<td>Squirrel Hoodie</td>';
echo '<td>Deer Antlers</td>';
echo '<td></td>';
echo '</tr>';
echo '<tr>';
echo '<tr><th colspan="4">Special Item</th></tr>';
echo '</tr>';
echo '<tr>';
echo '<td>Blueprint</td>';
echo '<td>Sewing Kit</td>';
echo '<td></td>';
echo '<td></td>';
echo '</tr>';
echo '</table>';
echo '</div><br><br>';
//} elseif ($temp === "Beach") {
echo '<div id="Beach">';
echo '<h6>Dazzling Coast Items</h6>';
echo '<h6></h6>';
echo '<table class="exploretable">';
echo '<tr><th colspan="4">Common Items</th></tr>';
echo '<tr>';
echo '<td>Copper Wire</td>';
echo '<td>Silver Earring</td>';
echo '<td>Gold Ring</td>';
echo '<td>Seagull Feather</td>';
echo '</tr>';
echo '<tr>';
echo '<td>Sand</td>';
echo '<td>Water</td>';
echo '<td>Nail</td>';
echo '<td>Moss</td>';
echo '</tr>';
echo '<tr>';
echo '<tr><th colspan="4">Uncommon Items</th></tr>';
echo '</tr>';
echo '<tr>';
echo '<td>Sewing Needle</td>';
echo '<td>Shark Fang</td>';
echo '<td>Old Lock</td>';
echo '<td>Mystery Seed</td>';
echo '</tr>';
echo '<tr>';
echo '<td>Old Coin</td>';
echo '<td>Beach Chest</td>';
echo '<td>Key</td>';
echo '<td>Button</td>';
echo '</tr>';
echo '<tr>';
echo '<tr><th colspan="4">Rare Items</th></tr>';
echo '</tr>';
echo '<tr>';
echo '<td>Mermaid Pattern</td>';
echo '<td>Scales Pattern</td>';
echo '<td>Beach Hat</td>';
echo '<td>Sunscreen</td>';
echo '</tr>';
echo '<tr>';
echo '<td>Shark Towel</td>';
echo '<td>Frog Towel</td>';
echo '<td>Fox Towel</td>';
echo '<td>Wetsuit</td>';
echo '</tr>';
echo '<tr>';
echo '<td>Ocean Fabric</td>';
echo '<td></td>';
echo '<td></td>';
echo '<td></td>';
echo '</tr>';
echo '<tr>';
echo '<tr><th colspan="4">Special Items</th></tr>';
echo '</tr>';
echo '<tr>';
echo '<td>Blueprint</td>';
echo '<td>Sewing Kit</td>';
echo '<td></td>';
echo '<td></td>';
echo '</tr>';
echo '</table>';
echo '</div>';
//}
echo '<p>**All biomes can also drop currency and seeds</p>';
echo '</div>';
