<?php

//Get User ID & Reply
$userId = $_SESSION['user_id'];
$reply = $_SESSION['reply'];
unset($_SESSION['reply']);

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
    echo '<div class="returnBar" style="margin-top: 1rem;margin-bottom: 2rem;">';
    echo '<p>' . $reply . '</p>';
    echo '</div>';
}

//Show Image. Change Later
echo '<img src="resources/sewingNPC.png" style="width: 40%;">';

if ($page === "questions") {
    echo '<p><i>"Welcome to my sewing studio. How can I help you?"</i></p>';
    echo '<a href="stitcher?page=fabric"><h4>"I want to apply fabric to a snoozeling."</h4></a>';
    echo '<a href="stitcher?page=design"><h4>"I want to use a tail design on a snoozeling."</h4></a>';
    echo '<a href="stitcher?page=new"><h4>"I want to create a new snoozeling."</h4></a>';
} elseif ($page === "fabric") {
    echo '<p><i>"Yes yes! Let\'s take a look at your fabrics. New fabrics for a new you."</i></p>';
    //Grab Fabrics
    $fabric = "fabric";
    $query = "SELECT * FROM items WHERE type = :fabric AND user_id = :id GROUP BY name";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":fabric", $fabric);
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
        
        echo '<h4>Fabrics You Currently Own</h4>';
        echo "<form method='POST' action='includes/applyFabric.inc.php' onsubmit=\"return confirm('Are you sure you want to apply this fabric? This action cannot be reversed.');\">";    
        echo '<div class="fabricItems">';
        foreach ($results as $result) {
            
            echo '<img src="items/' . $result['name'] . '.png">';
        }
        echo '</div>';
        echo '<label style="margin-top: 3rem;" for="fabric" class="form">Which Fabric Would You Like to Use?</label><br>';
        echo '<select class="input"  name="fabric">';
        foreach ($results as $result) {
            echo '<option value="' . $result['id'] . '">' . $result['display'] . '</option>';
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
        echo '<p><strong>You do not have any fabrics to use.<strong></p>';
    }
} elseif ($page === "design") {
    echo '<p><i>"A new tail? That\'s very exciting. Should be no problem at all."</i></p>';
    //Grab Designs
    $design = "design";
    $query = "SELECT * FROM items WHERE type = :design AND user_id = :id GROUP BY name";
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
        foreach ($results as $result) {
            
            echo '<img src="items/' . $result['name'] . '.png">';
        }
        echo '</div>';
        echo '<label style="margin-top: 3rem;" for="design" class="form">Which Fabric Would You Like to Use?</label><br>';
        echo '<select class="input"  name="design">';
        foreach ($results as $result) {
            echo '<option value="' . $result['id'] . '">' . $result['display'] . '</option>';
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
        echo '<p><strong>You do not have any designs to use.<strong></p>';
    }
} elseif ($page === "new") {
    //Check Active Breeding
    $query = "SELECT * FROM breedings WHERE user_id = :id ORDER BY id DESC LIMIT 1";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $breedingstatus = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Count Sewing Kits
    $sewingid = 20;
    $query = "SELECT * FROM items WHERE list_id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $sewingid);
    $stmt->execute();
    $kits = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $kitcount = count($kits);
    
    //Count Blueprints
    $sewingid = 21;
    $query = "SELECT * FROM items WHERE list_id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $sewingid);
    $stmt->execute();
    $bp = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $bpcount = count($bp);
    if ($breedingstatus['completed'] === "0") {
        echo '<p><strong>You need to wait until your snoozeling is delivered before you can craft another.<strong></p>';
        
}  elseif ($kitcount === 0) {
        if ($bpcount === 0) {
            echo '<p><strong>You do not have any sewing kits or blueprints.<strong></p>';
        } else {
            echo '<p><strong>You do not have any sewing kits.<strong></p>';
        }
    } else {
        if ($bpcount === 0) {
            echo '<p><strong>You do not have any blueprints. <br><br>You need at least 1 blueprint to make a new snoozeling.<strong></p>';
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
            echo "<form method='POST' action='includes/breedSnoozelings.inc.php' onsubmit=\"return confirm('Are you sure you want to make a new snoozeling?');\">";    
            echo '<label style="margin-top: 1rem;" for="first" class="form">1st Snoozeling for Inspiration:</label><br>';
            echo '<select class="input"  name="first">';
            foreach ($pets as $pet) {
                echo '<option value="' . $pet['id'] . '">' . htmlspecialchars($pet['name']) . '</option>';
            }
            echo '</select><br>';
            echo '<label style="margin-top: 1rem;" for="second" class="form">2nd Snoozeling for Inspiration:</label><br>';
            echo '<select class="input" id="second" onchange="check()" name="second">';
            foreach ($pets as $pet) {
                echo '<option value="' . $pet['id'] . '">' . htmlspecialchars($pet['name']) . '</option>';
            }
            echo '<option value="other">Type ID</option>';
            echo '</select><br>';
            echo '<div id="idbox" style="display: none;">';
            echo '<label style="margin-top: 1rem;" for="id" class="form" id="hidden2">Enter ID:</label><br>';
            echo '<input class="input" name="id" type="number" min="1" style="width:100px;" id="hidden1"><br>';
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
    }
    
}



















