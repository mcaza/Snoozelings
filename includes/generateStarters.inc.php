<?php
require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

$userId = $_SESSION['user_id'];
$common = "Common";

//Grab all the Common Color Info
$query = "SELECT * FROM colors";
$stmt = $pdo->prepare($query);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$count = count($results) - 1;

//Do Functions 4 Times
for ($i = 0; $i < 6; $i++) {
    randomCommon($pdo, $results, $userId, $count);
}

header("Location: ../welcome.php");

//Function to Randomize info

function randomCommon($pdo, $results, $userId, $count) {
    $tempSpecials = "";
    
    $hairTypes = ['Floof', 'Mane', 'Mohawk', 'Wave'];
    $tailTypes = ['Dragon', 'Long', 'Nub', 'Pom'];
    
    $hairCount = count($hairTypes) - 1;
    $tailCount = count($tailTypes) - 1;
    
    $randomNum = rand(0, $count); 
    $tempMainColor = $results[$randomNum]["name"];
    
    $randomNum = rand(0, $count); 
    $tempEyeColor = $results[$randomNum]["name"];
    
    $randomNum = rand(0, $count); 
    $tempNoseColor = $results[$randomNum]["name"];
    
    $randomNum = rand(0, $hairCount); 
    $tempHairType = $hairTypes[$randomNum];
    
    $randomNum = rand(0, $tailCount); 
    $tempTailType = $tailTypes[$randomNum];
    
    $randomNum = rand(0, $count); 
    $tempHairColor = $results[$randomNum]["name"];
    
     
    
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
        $tempSpecials .= "Wings ";
    }
    
    $finalSpecials = substr($tempSpecials, 0, -1);
    
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



















