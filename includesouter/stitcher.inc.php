<?php

//Get User ID & Reply
$userId = $_COOKIE['user_id'];

//Replies
$query = "SELECT * FROM replies WHERE user_id = :id;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$reply = $stmt->fetch(PDO::FETCH_ASSOC);

//Set Pride Outfits
$now = new DateTime('now', new DateTimezone('UTC'));
$month = $now->format('m');
$month = ltrim($month, '0');

//Get Page. Assign to 1 if no page
$page = isset($_GET['page']) ? $_GET['page'] : "questions";

if ($page === "questions") {
    //Go Back Arrow
    echo '<div class="leftRightButtons">';
    echo '<a href="shops"><<</a>';
    echo '</div>';
} else {
    //Go Back Arrow
    echo '<div class="leftRightButtons">';
    echo '<a href="stitcher"><<</a>';
    echo '</div>';
}

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

//Show Image. Change Later
if ($month == 6) {
    echo '<a href="profile?id=2"><img src="resources/minkyPride.png" style="width: 40%;"></a>';
} else {
    echo '<a href="profile?id=2"><img src="resources/sewingprofileNPC.png" style="width: 40%;"></a>';
}


if ($page === "questions") {
    echo '<h1><i>"What can I help you stitch today?"</i></h1><br>';
    
    echo '<div class="stitcherDivs" style="display:flex;flex-direction:row;justify-content:center;margin-left:auto;margin-right:auto;align-items:center;">';
    echo '<div class="stitcherBoxes"><a href="stitcher?page=design"><img src="items/DesignCollie.png"><h1>Apply Design</h1></a></div>';
    echo '<div class="stitcherBoxes centerBox" ><a href="stitcher?page=fabric"><img src="items/FabricPastelShapes.png"><h1>Apply Fabric</h1></a></div>';
    echo '<div class="stitcherBoxes"><a href="stitcher?page=new"><img src="items/SewingKit.png" ><h1>Use Sewing Kit</h1></a></div>';
    echo '</div>';
    
    /*echo '<a href="stitcher?page=fabric"><h4>"I want to apply fabric to a snoozeling."</h4></a>';
    echo '<a href="stitcher?page=design"><h4>"I want to apply a design to a snoozeling."</h4></a>';
    echo '<a href="stitcher?page=new"><h4>"I want to create a new snoozeling."</h4></a>'; */
} elseif ($page === "fabric") {
    echo '<p><i>"Yes yes! Let\'s take a look at your fabrics. New fabrics for a new you."</i></p><br>';
    
    //Grab Fabrics
    $query = "SELECT * FROM items WHERE type = :fabric AND user_id = :id GROUP BY name, id ORDER BY name";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":fabric", $page);
    $stmt->execute();
    $fabrics = $stmt->fetchAll(PDO::FETCH_ASSOC); 

    //Show Form if there are results. Else show "no results" 
    if ($fabrics) {
        //Get All Snoozelings
        $query = "SELECT * FROM snoozelings WHERE owner_id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
        $pets = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo '<h4>Fabrics You Currently Own</h4>';
        echo "<form method='POST' action='includes/applyFabric.inc.php' onsubmit=\"return confirm('Are you sure you want to apply this fabric? It will remove Dual Nose and Ear Bands from any snoozelings. This action cannot be reversed. ');\">";    
        echo '<div class="fabricItems">';
        $colorsShown = [];
        foreach ($fabrics as $result) {
            if (!in_array($result['name'], $colorsShown)) {
                echo '<div>';
                echo '<img src="items/' . $result['name'] . '.png" style="width:120px;" id="' . $result['name'] . '">';
                echo '<p><b>' . $result['display'] . '</b></p>';
                echo '</div>';
                array_push($colorsShown,$result['name']);
            }
        }
        echo '</div>';
        echo '<label style="margin-top: 3rem;" for="fabric" class="form">Which Fabric Would You Like to Use?</label><br>';
        echo '<select class="input"  name="fabric">';
        $colorsListed = [];
        foreach ($fabrics as $result) {
        if (!in_array($result['name'], $colorsListed)) {
                echo '<option value="' . $result['id'] . '">' . $result['display'] . '</option>';
                array_push($colorsListed,$result['name']);
            }
        }
        echo '</select><br>';
        echo '<label style="margin-top: 2rem;" for="pet" class="form">Apply to which Snoozeling?</label><br>';
        echo '<select class="input"  name="pet">';
        foreach ($pets as $pet) {
            echo '<option value="' . $pet['id'] . '">' . htmlspecialchars($pet['name']) . '</option>';
        }
        echo '</select><br>';
        echo '<button  class="fancyButton">Apply Fabric</button>';
        echo '</form>';
    } else {
        echo '<p><strong>You do not have any fabrics to use.</strong></p>';
    }
} elseif ($page === "design") {
    echo '<p><i>"What will it be? New tail? New hair? Wings? The sky is the limit."</i></p><br>';
    //Grab Designs
    $design = "design";
    $query = "SELECT * FROM items WHERE type = :design AND user_id = :id GROUP BY name, id ORDER BY name";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":design", $design);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    //Show Form if there are results. Else show "no results" 
    if ($results) {
        //Get All Snoozelings
        $query = "SELECT * FROM snoozelings WHERE owner_id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
        $pets = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo '<h4>Designs You Currently Own</h4>';
        echo "<form method='POST' action='includes/applyDesign.inc.php' onsubmit=\"return confirm('Are you sure you want to apply this design? This action cannot be reversed.');\">";    
        echo '<div class="fabricItems">';
        $colorsShown = [];
        foreach ($results as $result) {
            if (!in_array($result['name'], $colorsShown)) {
                echo '<div>';
                $name = str_replace(" Dye", "", $dye['display']);
                echo '<img src="items/' . $result['name'] . '.png" style="width:150px;" id="' . $result['name'] . '">';
                echo '<p><b>' . $result['display'] . '</b></p>';
                echo '</div>';
                array_push($colorsShown,$result['name']);
            }
        }
        echo '</div>';
        echo '<label style="margin-top: 3rem;" for="design" class="form">Which Design Would You Like to Use?</label><br>';
        echo '<select class="input"  name="design">';
        $colorsListed = [];
        foreach ($results as $result) {
            if (!in_array($result['name'], $colorsListed)) {
                echo '<option value="' . $result['id'] . '">' . $result['display'] . '</option>';
                array_push($colorsListed,$result['name']);
            }
        }
        echo '</select><br>';
        echo '<label style="margin-top: 1rem;" for="pet" class="form">Apply to which Snoozeling?</label><br>';
        echo '<select class="input"  name="pet">';
        foreach ($pets as $pet) {
            echo '<option value="' . $pet['id'] . '">' . htmlspecialchars($pet['name']) . '</option>';
        }
        echo '</select><br>';
        echo '<button  class="fancyButton">Apply Design</button>';
        echo '</form>';
    } else {
        echo '<p><strong>You do not have any designs to use.</strong></p>';
    }
} elseif ($page === "new") {
    //Check Active Breeding
    $query = "SELECT * FROM breedings WHERE user_id = :id AND completed = 0";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $breedingstatus = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Count Sewing Kits
    $sewingid = 209;
    $query = "SELECT * FROM items WHERE list_id = :id AND user_id = :user";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $sewingid);
    $stmt->bindParam(":user", $userId);
    $stmt->execute();
    $kits = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $kitcount = count($kits);
    
    //Count Blueprints
    $bpid = 137;
    $query = "SELECT * FROM items WHERE list_id = :id  AND user_id = :user";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user", $userId);
    $stmt->bindParam(":id", $bpid);
    $stmt->execute();
    $bp = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $bpcount = count($bp);
    
    //Count Beds
    $query = "SELECT * FROM users WHERE id = :user";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user", $userId);
    $stmt->execute();
    $beds = $stmt->fetch(PDO::FETCH_ASSOC); 

    
    $query = "SELECT * FROM snoozelings WHERE owner_id = :user";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user", $userId);
    $stmt->execute();
    $snoozes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $bedCount = intval($beds['petBeds']) - count($snoozes);
    
    
    if ($breedingstatus['completed'] == "0") {
        echo '<p><strong>You need to wait until your snoozeling is delivered before you can craft another.</strong></p>';
        
        
}  elseif ($bpcount > 0 && $kitcount > 0 && $bedCount > 0) {
        if (!$bpcount) {
            echo '<p><strong>You do not have any blueprints. <br><br>You need at least 1 blueprint to make a new snoozeling.</strong></p>';
        } else if ($bedCount < 1) {
            echo '<p><strong>You do not have any empty beds. Each snoozeling needs a bed to sleep in.</strong></p>';
        } else {
            if ($bpcount > 10) {
                $bpcount = 10;
            }
            echo '<p><i>"It looks like you have all the items I\'ll need. Now I just need 2 snoozelings for inspiration."</i></p>';
            //Get All Snoozelings
            $query = "SELECT * FROM snoozelings WHERE owner_id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $userId);
            $stmt->execute();
            $pets = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo "<form method='POST' action='includes/breedSnoozelings.inc.php' onsubmit=\"return confirm('Are you sure you want to make a new snoozeling? This action will consume 1 sewing kit and the selected number of blueprints. It will also move a single snoozeling into your empty bed.');\">";    
            
            echo '<div class="stitcherDivs">';
            echo '<div style="width:40%;border:2px dashed #827188;border-radius:10px;margin-right:20px;height:430px;"><img id="firstPet" src="snoozeImages/' . $pets[0]['id'] . '.png" style="width:70%">';
            echo '<label style="margin-top: 1rem;" for="first" class="form">1st Snoozeling for Inspiration:</label><br>';
            echo '<select class="input" id="firstSelect" name="first">';
            foreach ($pets as $pet) {
                echo '<option value="' . $pet['id'] . '">' . htmlspecialchars($pet['name']) . '</option>';
            }
            echo '</select><br>';
            echo '</div>';
            if (count($pets) > 1) {
                echo '<div style="width:40%;border:2px dashed #827188;border-radius:10px;height:430px;"><img src="snoozeImages/' . $pets[1]['id'] . '.png" style="width:70%" id="secondImage">';
                echo '<label style="margin-top: 1rem;" for="second" class="form">2nd Snoozeling for Inspiration:</label><br>';
                echo '<select class="input" id="second"  onchange="check()" name="second">';
                $skip = 0;
                foreach ($pets as $pet) {
                    if ($skip > 0) {
                        echo '<option value="' . $pet['id'] . '">' . htmlspecialchars($pet['name']) . '</option>';
                    } else {
                        $skip++;
                    }
                }
                echo '<option value="' . $pets[0]['id'] . '">' . htmlspecialchars($pets[0]['name']) . '</option>';
                echo '<option value="other">Type ID</option>';
                echo '</select><br>';
                echo '<div id="idbox" style="display: none;">';
                echo '<label style="margin-top: 1rem;" for="id" class="form" id="hidden2">Enter ID:</label><br>';
                echo '<input class="input" name="id" type="number" min="1" style="width:100px;" id="hidden1"><br>';
                echo '</div>';
                echo '</div>';
            } else {
                echo '<div style="width:40%;border:2px dashed #827188;border-radius:10px;height:430px;"><img src="resources/ProfileEmpty.png" style="width:70%"  id="secondImage">';
                echo '<label style="margin-top: 1rem;" for="second" class="form">2nd Snoozeling for Inspiration:</label><br>';
                echo '<select class="input" id="second" onchange="check()" name="second">';
                echo '<option value="other">Type ID</option>';
                echo '</select><br>';
                echo '<div id="idbox" style="display: block;">';
                echo '<label style="margin-top: 1rem;" for="id" class="form" id="hidden2">Enter ID:</label><br>';
                echo '<input class="input" name="id" type="number" min="1" style="width:100px;" id="hidden1"><br>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
            
            
            
            echo '<label style="margin-top: 1rem;" for="blueprints" class="form">How Many Blueprints Will You Use?</label><br>';
            echo '<select class="input"  name="blueprints">';
            for ($i = 1; $i <= $bpcount; $i++) {
                if ($i > 1) {
                    echo '<option value="' . $i . '">' . $i . ' Blueprints</option>';
                } else {
                    echo '<option value="' . $i . '">' . $i . ' Blueprint</option>';
                }
            }
            echo '</select><br>';
            echo '<button  class="fancyButton">Create Snoozeling</button>';
            echo '</form>';
        }
    } else  {
        echo '<p><b>The following is needed to craft a snoozeling:</b></p>';
        echo '<div class="stitcherDivs">';
            if ($kitcount) {
                echo '<div class="stitcherBoxes"><img src="items/SewingKit.png"><h1>1x Sewing Kit</h1><p style="font-size:20px;margin-top:-5px;">✅</p></div>';
            } else {
                echo '<div class="stitcherBoxes"><img src="items/SewingKit.png"><h1>1x Sewing Kit</h1><p style="font-size:20px;margin-top:-5px;">❌</p></div>';
            }
            if ($bpcount) {
                echo '<div class="stitcherBoxes centerBox"><img src="items/Blueprint.png"><h1>1x Blueprint</h1><p style="font-size:20px;margin-top:-5px;">✅</p></div>';
            } else {
                echo '<div class="stitcherBoxes centerBox"><img src="items/Blueprint.png"><h1>1x Blueprint</h1><p style="font-size:20px;margin-top:-5px;">❌</p></div>';
            }
        
        if ($bedCount > 0) {
                echo '<div class="stitcherBoxes centerBox"><img src="items/PetBed.png"><h1>1x Empty Bed</h1><p style="font-size:20px;margin-top:-5px;">✅</p></div>';
            } else {
                echo '<div class="stitcherBoxes centerBox"><img src="items/PetBed.png"><h1>1x Empty Bed</h1><p style="font-size:20px;margin-top:-5px;">❌</p></div>';
            }
        echo '</div>';
        
    } 
    
}



















