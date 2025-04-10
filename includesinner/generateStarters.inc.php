<?php
require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

//Important Variables
$userId = $_COOKIE['user_id'];

//Grab all the Common Color Info
$query = 'SELECT * FROM colors WHERE rarity = "Common" OR rarity = "Uncommon"';
$stmt = $pdo->prepare($query);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$count = count($results) - 1;

//Check for Blueprints already
$query = 'SELECT * FROM blueprints WHERE owner_id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$check = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($check) {
    header("Location: ../welcome");
    die();
}

//Do Functions 6 Times
for ($i = 0; $i < 6; $i++) {
    randomCommon($pdo, $results, $userId, $count);
}

//Update Tutorial
    $query = 'UPDATE users SET tutorial = 2 WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();

header("Location: ../welcome");
die();

//Function to Randomize info

function randomCommon($pdo, $results, $userId, $count) {
    //Determine Special Features
    $tempSpecials = "";
    
    $randomNum = rand(1,2); 
    if ($randomNum === 1) {
        $tempSpecials .= "Belly ";
    }
    
    $randomNum = rand(1,2); 
    if ($randomNum === 1) {
        $tempSpecials .= "Spots ";
    }
    
    $randomNum = rand(1,2); 
    if ($randomNum === 1) {
        $tempSpecials .= "Boots ";
    }
    
    $randomNum = rand(1,2); 
    if ($randomNum === 1) {
        $tempSpecials .= "Cupid ";
    }
    
    $randomNum = rand(1,2); 
    if ($randomNum === 1) {
        $tempSpecials .= "Sublimation ";
    }
    
    $randomNum = rand(1,2); 
    if ($randomNum === 1) {
        $tempSpecials .= "EarTip ";
    }
    
   /* $randomNum = rand(1,2); 
    if ($randomNum === 1) {
        $tempSpecials .= "Stitches ";
    } */
    
    $finalSpecials = substr($tempSpecials, 0, -1);
    
    //Determine Hair and Tail Type
    $hairTypes = ['Floof', 'Forelock', 'Mane', 'Mohawk', 'Wave'];
    $tailTypes = ['Dragon', 'Long', 'Nub', 'Pom'];
    
    $hairCount = count($hairTypes) - 1;
    $tailCount = count($tailTypes) - 1;
    
    $randomNum = rand(0, $hairCount); 
    $tempHairType = $hairTypes[$randomNum];
    
    $randomNum = rand(0, $tailCount); 
    $tempTailType = $tailTypes[$randomNum];
    
    //Determine Colors
    $randomNum = rand(0, $count); 
    $tempMainColor = $results[$randomNum]["name"];
    
    $randomNum = rand(0, $count); 
    $tempEyeColor = $results[$randomNum]["name"];
    
    $randomNum = rand(0, $count); 
    $tempNoseColor = $results[$randomNum]["name"];
    
    $randomNum = rand(0, $count); 
    $tempHairColor = $results[$randomNum]["name"];
    
     
    //Tail Color Determination
    //If Tail = Dragon, Tail Color = Hair Color
    //If Not Dragon, Roll 1-3. 1=Tail is Same as Main, 2=Tail as Same as Hair, 3=Tail is Random Color
    if ($tempTailType === "Dragon") {
        $tempTailColor = $tempHairColor;
    } else {
        $randomNum = rand(1,3);
        if ($randomNum === 1) {
            $tempTailColor = $tempMainColor;
        } elseif ($randomNum === 2) {
            $tempTailColor = $tempHairColor;
        } else {
            $randomNum = rand(0, $count); 
            $tempTailColor = $results[$randomNum]["name"];
        }
    }
    
    //Insert Pet into Database
    $query = "INSERT INTO blueprints (owner_id, mainColor, hairColor, tailColor, eyeColor, noseColor, hairType, tailType, specials) VALUES (:owner_id, :mainColor, :hairColor, :tailColor, :eyeColor, :noseColor, :hairType, :tailType, :specials);";
    $stmt = $pdo->prepare($query);
    
    $stmt->bindParam(":owner_id", $userId);
    $stmt->bindParam(":mainColor", $tempMainColor);
    $stmt->bindParam(":hairColor", $tempHairColor);
    $stmt->bindParam(":tailColor", $tempTailColor);
    $stmt->bindParam(":eyeColor", $tempEyeColor);
    $stmt->bindParam(":noseColor", $tempNoseColor);
    $stmt->bindParam(":hairType", $tempHairType);
    $stmt->bindParam(":tailType", $tempTailType);
    $stmt->bindParam(":specials", $finalSpecials);

    $stmt->execute();
}



















