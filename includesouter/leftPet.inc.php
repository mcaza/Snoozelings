<?php

//Connection Stuff
require_once '../includes/displayPet.inc.php';

    if (isset($_COOKIE["user_id"])) {
        //$Results - Grab Bonded Pet ID
        $userId = $_COOKIE['user_id'];

        $query = "SELECT bonded FROM users WHERE id = :userID";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":userID", $userId);
        $stmt->execute();
        $bondArray = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $bondedNumber = $bondArray["bonded"];
        
        if ($bondedNumber != 0) {
        $query2 = "SELECT * FROM snoozelings WHERE id = $bondedNumber;";
        $stmt2 = $pdo->prepare($query2);
        $stmt2->execute();
        $petInfo = $stmt2->fetch(PDO::FETCH_ASSOC);
        echo '<h2><a href="pet?id=' . $bondedNumber . '">' . htmlspecialchars($petInfo["name"]) . '</a></h2>';
        displayPet($petInfo, "art");
        echo '<p id="mood" onClick="showForm()"><strong>Mood:</strong> ' . $petInfo['mood'] . '</p>';
        echo '<form id="moodForm" method="POST" action="includes/changeMood.inc.php">';
        echo '<label class="form" for="mood">Choose a Mood:</label><br>';
        echo '<select class="input" id="moodSelect" name="mood">';
        echo '<option value="Happy">Happy</option>';
        echo '<option value="Anxious">Anxious</option>';
        echo '<option value="Overwhelmed">Overwhelmed</option>';
        echo '<option value="Sleepy">Sleepy</option>';
        echo '<option value="Cheeky">Cheeky</option>';
        //echo '<option value="Naughty">Naughty</option>';
        echo '</select><br>';
        echo '<button class="fancyButton" style="font-size: 2rem; margin-bottom: 1rem;">Change Mood</button>';
        echo '</form>';

            

        }      else {
             $query = "SELECT * FROM snoozelings;";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    
        $allPets = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $petCount = count($allPets) -1;
        $randNum = rand(0, $petCount);
        echo '<h2><a href="pet?id=' . $allPets[$randNum]['id'] . '">Random Snoozeling</a></h2>';
        displayPet($allPets[$randNum], "art");
        }   
    }  else {
 $query = "SELECT * FROM snoozelings;";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    
        $allPets = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $petCount = count($allPets) -1;
        $randNum = rand(0, $petCount);
        echo '<h2><a href="pet?id=' . $allPets[$randNum]['id'] . '">Random Snoozeling</a></h2>';
        displayPet($allPets[$randNum], "art");
       
    }


                    

                    