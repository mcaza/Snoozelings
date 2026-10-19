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

//Tutorial Pop Up
if ($user['tutorial'] == 7) {
    echo '<div class="tutorialHeader"><div class="tutorialDiv"><img src="snoozeImages/' . $bondedNumber . '.png?timestamp=' . $ts['timestamp'] . '" class="tutorialImage"></div><div style="text-align:center;width:100%"><br><br><br><Br><p style="width:90%">Next, we\'re going to go <b>Exploring</b>.<br><br>Different locations have different items, but we will be searching for <b>Wood Logs</b> in <b>Wistful Woods</b>.<br><br><img src="items/WoodLog.png" style="width:65px"><img src="items/WoodLog.png" style="width:65px"><img src="items/WoodLog.png" style="width:65px"><br><br></p></div></div><br><Br>';
    
    echo '<div><img id="exploreImage" class="wideImage" src="resources/Forest.png"></div>';
} else {
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
}



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
        if ($user['tutorial'] == 7) { 
            echo '<option value="Forest" ' . $optiontwo . '>Wistful Woods</option>';
        } else {
            echo '<option value="Farmland" ' . $optionone . '>Snoozeling Ranch</option>';
            echo '<option value="Forest" ' . $optiontwo . '>Wistful Woods</option>';
            echo '<option value="Beach" ' . $optionthree . '>Dazzling Coast</option>';
        }
        
        
        echo '</select></br>';
        echo '<button  class="fancyButton editButton">Go Exploring</button>';
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
echo '<h6>Snoozeling Ranch Drops</h6>';
echo '<h6></h6>';
echo '<table class="exploretable">';
echo '<tr><th colspan="4">Common Items</th></tr>';
echo '<tr>';
echo '<td>Eggshells<br><img src="items/Eggshells.png" style="width:20%"></td>';
echo '<td>Tiny Feather<br><img src="items/TinyFeather.png" style="width:20%"></td>';
echo '<td>Dirt<br><img src="items/Dirt.png" style="width:20%"></td>';
echo '<td>Manure<br><img src="items/Manure.png" style="width:20%"></td>';
echo '</tr>';
echo '<tr>';
echo '<td>Honey<br><img src="items/Honey.png" style="width:20%"></td>';
echo '<td>Egg Carton<br><img src="items/EggCarton.png" style="width:20%"></td>';
echo '<td>Empty Jug<br><img src="items/EmptyJug.png" style="width:20%"></td>';
echo '<td>Old Can<br><img src="items/OldCan.png" style="width:20%"></td>';
echo '</tr>';
echo '<tr>';
echo '<tr><th colspan="4">Uncommon Items</th></tr>';
echo '</tr>';
echo '<tr>';
echo '<td>Ram Horn<br><img src="items/RamHorn.png" style="width:20%"></td>';
echo '<td>Horse Hair<br><img src="items/HorseHair.png" style="width:20%"></td>';
echo '<td>Cowbell<br><img src="items/Cowbell.png" style="width:20%"></td>';
echo '<td>Mystery Seed<br><img src="items/MysterySeed.png" style="width:20%"></td>';
echo '</tr>';
echo '<tr>';
echo '<td>Old Coin<br><img src="items/OldCoin.png" style="width:20%"></td>';
echo '<td>Farm Chest<br><img src="items/FarmChest.png" style="width:20%"></td>';
echo '<td>Key<br><img src="items/Key.png" style="width:20%"></td>';
echo '<td>Button<br><img src="items/Button.png" style="width:20%"></td>';
echo '</tr>';
echo '<tr>';
echo '<tr><th colspan="4">Rare Items</th></tr>';
echo '</tr>';
echo '<tr>';
echo '<td>Wooly Tail Design<br><img src="items/DesignWoolyTail.png" style="width:20%"></td>';
echo '<td>Collie Marking Design<br><img src="items/DesignCollie.png" style="width:20%"></td>';
echo '<td>Duck Hoodie<br><img src="items/DuckHoodie.png" style="width:20%"></td>';
echo '<td>Horse Hoodie<br><img src="items/HorseHoodie.png" style="width:20%"></td>';
echo '</tr>';
echo '<tr>';
echo '<td>Cow Hoodie<br><img src="items/CowHoodie.png" style="width:20%"></td>';
echo '<td>Blue Cow Fabric<br><img src="items/FabricCowBlue.png" style="width:20%"></td>';
echo '<td>Brown Cow Fabric<br><img src="items/FabricCowBrown.png" style="width:20%"></td>';
echo '<td>Pink Cow Fabric<br><img src="items/FabricCowPink.png" style="width:20%"></td>';
echo '</tr>';
echo '<tr>';
echo '<td>Grey Cow Fabric<br><img src="items/FabricCowGrey.png" style="width:20%"></td>';
echo '<td></td>';
echo '<td></td>';
echo '<td></td>';
echo '</tr>';
echo '<tr>';
echo '<tr><th colspan="4">Special Items</th></tr>';
echo '</tr>';
echo '<tr>';
echo '<td>Blueprint<br><img src="items/Blueprint.png" style="width:20%"></td>';
echo '<td>Sewing Kit<br><img src="items/SewingKit.png" style="width:20%"></td>';
echo '<td></td>';
echo '<td></td>';
echo '</tr>';
echo '</table>';
echo '</div>';
//} elseif ($temp === "Forest") {
echo '<div id="Forest">';
echo '<h6>Wistful Woods Drops</h6>';
echo '<h6></h6>';
echo '<table class="exploretable">';
echo '<tr><th colspan="4">Common Items</th></tr>';
echo '<tr>';
echo '<td>Wood Log<br><img src="items/WoodLog.png" style="width:20%"></td>';
echo '<td>Colorful Feather<br><img src="items/ColorfulFeather.png" style="width:20%"></td>';
echo '<td>Gooseberry<br><img src="items/Gooseberry.png" style="width:20%"></td>';
echo '<td>Blueberry<br><img src="items/Blueberry.png" style="width:20%"></td>';
echo '</tr>';
echo '<tr>';
echo '<td>Leaf<br><img src="items/Leaf.png" style="width:20%"></td>';
echo '<td>Tree Sap<br><img src="items/TreeSap.png" style="width:20%"></td>';
echo '<td>Plant Fiber<br><img src="items/PlantFiber.png" style="width:20%"></td>';
echo '<td>Flower<br><img src="items/Flower.png" style="width:20%"></td>';
echo '</tr>';
echo '<tr>';
echo '<tr><th colspan="4">Uncommon Items</th></tr>';
echo '</tr>';
echo '<tr>';
echo '<td>Lizard Tail<br><img src="items/LizardTail.png" style="width:25%"></td>';
echo '<td>Bug Wings<br><img src="items/BugWings.png" style="width:20%"></td>';
echo '<td>Mushroom<br><img src="items/Mushroom.png" style="width:20%"></td>';
echo '<td>Mystery Seed<br><img src="items/MysterySeed.png" style="width:20%"></td>';
echo '</tr>';
echo '<tr>';
echo '<td>Old Coin<br><img src="items/OldCoin.png" style="width:20%"></td>';
echo '<td>Woods Chest<br><img src="items/WoodsChest.png" style="width:20%"></td>';
echo '<td>Key<br><img src="items/Key.png" style="width:20%"></td>';
echo '<td>Button<br><img src="items/Button.png" style="width:20%"></td>';
echo '</tr>';
echo '<tr>';
echo '<tr><th colspan="4">Rare Items</th></tr>';
echo '</tr>';
echo '<tr>';
echo '<td>Panther Tail Design<br><img src="items/DesignPantherTail.png" style="width:20%"></td>';
echo '<td>Foxy Marking Design<br><img src="items/DesignFoxy.png" style="width:20%"></td>';
echo '<td>Deer Hoodie<br><img src="items/DeerHoodie.png" style="width:20%"></td>';
echo '<td>Doe Hoodie<br><img src="items/DoeHoodie.png" style="width:20%"></td>';
echo '</tr>';
echo '<tr>';
echo '<td>Fairy Horns<br><img src="items/FairyHorns.png" style="width:20%"></td>';
echo '<td>Acorns Fabric<br><img src="items/FabricAcorns.png" style="width:20%"></td>';
echo '<td>Leaves Fabric<br><img src="items/FabricLeaves.png" style="width:20%"></td>';
echo '<td>Forest Fabric<br><img src="items/FabricForest.png" style="width:20%"></td>';
echo '</tr>';
echo '<tr>';
echo '<td>Acorn Bag<br><img src="items/AcornBag.png" style="width:20%"></td>';
echo '<td>Squirrel Hoodie<br><img src="items/SquirrelHoodie.png" style="width:20%"></td>';
echo '<td>Deer Antlers<br><img src="items/DeerAntlers.png" style="width:20%"></td>';
echo '<td></td>';
echo '</tr>';
echo '<tr>';
echo '<tr><th colspan="4">Special Items</th></tr>';
echo '</tr>';
echo '<tr>';
echo '<td>Blueprint<br><img src="items/Blueprint.png" style="width:20%"></td>';
echo '<td>Sewing Kit<br><img src="items/SewingKit.png" style="width:20%"></td>';
echo '<td></td>';
echo '<td></td>';
echo '</tr>';
echo '</table>';
echo '</div>';
//} elseif ($temp === "Beach") {
echo '<div id="Beach">';
echo '<h6>Dazzling Coast Drops</h6>';
echo '<h6></h6>';
echo '<table class="exploretable">';
echo '<tr><th colspan="4">Common Items</th></tr>';
echo '<tr>';
echo '<td>Copper Wire<br><img src="items/CopperWire.png" style="width:20%"></td>';
echo '<td>Silver Earring<br><img src="items/SilverEarring.png" style="width:20%"></td>';
echo '<td>Gold Ring<br><img src="items/GoldRing.png" style="width:20%"></td>';
echo '<td>Seagull Feather<br><img src="items/SeagullFeather.png" style="width:20%"></td>';
echo '</tr>';
echo '<tr>';
echo '<td>Sand<br><img src="items/Sand.png" style="width:20%"></td>';
echo '<td>Water<br><img src="items/Water.png" style="width:20%"></td>';
echo '<td>Nail<br><img src="items/Nail.png" style="width:20%"></td>';
echo '<td>Moss<br><img src="items/Moss.png" style="width:20%"></td>';
echo '</tr>';
echo '<tr>';
echo '<tr><th colspan="4">Uncommon Items</th></tr>';
echo '</tr>';
echo '<tr>';
echo '<td>Sewing Needle<br><img src="items/SewingNeedle.png" style="width:20%"></td>';
echo '<td>Shark Fang<br><img src="items/SharkFang.png" style="width:20%"></td>';
echo '<td>Old Lock<br><img src="items/OldLock.png" style="width:20%"></td>';
echo '<td>Mystery Seed<br><img src="items/MysterySeed.png" style="width:20%"></td>';
echo '</tr>';
echo '<tr>';
echo '<td>Old Coin<br><img src="items/OldCoin.png" style="width:20%"></td>';
echo '<td>Beach Chest<br><img src="items/BeachChest.png" style="width:20%"></td>';
echo '<td>Key<br><img src="items/Key.png" style="width:20%"></td>';
echo '<td>Button<br><img src="items/Button.png" style="width:20%"></td>';
echo '</tr>';
echo '<tr>';
echo '<tr><th colspan="4">Rare Items</th></tr>';
echo '</tr>';
echo '<tr>';
echo '<td>Mermaid Tail Design<br><img src="items/DesignMermaidTail.png" style="width:20%"></td>';
echo '<td>Scales Marking Design<br><img src="items/DesignScales.png" style="width:20%"></td>';
echo '<td>Beach Hat<br><img src="items/BeachHat.png" style="width:20%"></td>';
echo '<td>Sunscreen<br><img src="items/Sunscreen.png" style="width:20%"></td>';
echo '</tr>';
echo '<tr>';
echo '<td>Shark Towel<br><img src="items/SharkTowel.png" style="width:20%"></td>';
echo '<td>Frog Towel<br><img src="items/FrogTowel.png" style="width:20%"></td>';
echo '<td>Fox Towel<br><img src="items/FoxTowel.png" style="width:20%"></td>';
echo '<td>Wetsuit<br><img src="items/Wetsuit.png" style="width:20%"></td>';
echo '</tr>';
echo '<tr>';
echo '<td>Ocean Fabric<br><img src="items/FabricOcean.png" style="width:20%"></td>';
echo '<td></td>';
echo '<td></td>';
echo '<td></td>';
echo '</tr>';
echo '<tr>';
echo '<tr><th colspan="4">Special Items</th></tr>';
echo '</tr>';
echo '<tr>';
echo '<td>Blueprint<br><img src="items/Blueprint.png" style="width:20%"></td>';
echo '<td>Sewing Kit<br><img src="items/SewingKit.png" style="width:20%"></td>';
echo '<td></td>';
echo '<td></td>';
echo '</tr>';
echo '</table>';
echo '</div>';
echo '<p><i>**All biomes can also drop currency and seeds**</i></p>';
echo '</div>';

$now = new DateTime('now', new DateTimezone('UTC'));
$firstDate = $now->format('m');
if ($firstDate == 10) {
    echo '<br><hr><br><div id="October">';
    echo '<h6>&#127875; Festival of Treats Drops &#127875;</h6>';
    echo '<h6></h6>';
    echo '<table class="exploretable">';
    echo '<tr><th colspan="4">Special Items</th></tr>';
    echo '<tr>';
    echo '<td>Skeleton Design<br><img src="items/DesignSkeleton.png" style="width:20%"></td>';
    echo '<td>Tailless Design<br><img src="items/DesignTailless.png" style="width:20%"></td>';
    echo '<td></td>';
    echo '<td></td>';
    echo '</tr>';
    echo '<tr><th colspan="4">Decor Items</th></tr>'; 
    echo '<tr>';
    echo '<td>Spooky Striped Bandana<br><img src="items/SpookyStripedBandana.png" style="width:20%"></td>';
    echo '<td>Spooky Layered Bandana<br><img src="items/SpookyLayeredBandana.png" style="width:20%"></td>';
    echo '<td>Imp Horns<br><img src="items/ImpHorns.png" style="width:20%"></td>'; 
    echo '<td></td>';
    echo '</tr>'; 
    echo '<tr><th colspan="4">Plushies</th></tr>';
    echo '<tr>';
    echo '<td>Haunted Plushie<br><img src="items/HauntedPlushie.png" style="width:20%"></td>'; 
    echo '<td>Candy Corn Plushie<br><img src="items/CandyCornPlushie.png" style="width:20%"></td>'; 
    echo '<td>Zombie Puppy Plushie<br><img src="items/ZombiePuppyPlushie.png" style="width:20%"></td>'; 
    echo '<td></td>';
    echo '</tr>';
    echo '<tr><th colspan="4">Stains</th></tr>';
    echo '<tr>';
    echo '<td>Stain: Fright<br><img src="items/StainFright.png" style="width:20%"></td>';
    echo '<td>Stain: Haunt<br><img src="items/StainHaunt.png" style="width:20%"></td>';
    echo '<td>Stain: Night<br><img src="items/StainNight.png" style="width:20%"></td>';
    echo '<td>Stain: Zombie<br><img src="items/StainZombie.png" style="width:20%"></td>';
    echo '</tr>'; 
    echo '</table>';
    echo '</div><br><br>';
}














