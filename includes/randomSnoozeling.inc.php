<?php

    try {
        
        //Connection Stuff
        require_once "dbh-inc.php";
        
        //$Results - Grab all Common Colors
        $query = "SELECT * FROM Colors WHERE rarity = 'Common'";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        //Determine Main Color
        $randKey = array_rand($results);
        $mainColor = $results[$randKey]["name"];
        
        //Determine Hair Color
        $randKey = array_rand($results);
        $hairColor = $results[$randKey]["name"];
        
        //Determine Tail Color. Equal chance of new color, hair color, or main color
        $tails = array(1, 2, 3)[random_int(0,1)];
        if ($tails === 1) {
            $tailColor = $mainColor;
        } elseif ($tails === 2) {
            $randKey = array_rand($results);
            $tailColor = $results[$randKey]["name"];
        } else {
            $tailColor = $hairColor;
        }
        
        //Determine Nose Color
        $randKey = array_rand($results);
        $noseColor = $results[$randKey]["name"];
        
        //Determine Eye Color
        $randKey = array_rand($results);
        $eyeColor = $results[$randKey]["name"];
        
        //Arrays for Hair Styles and Tail Types
        $hairTypes = array("Floof", "Wave", "Mane", "Mop", "Flowing");
        $tailTypes = array("Long", "Nub", "Poof", "Dragon");
        
        //Determines Hair Style
        $randKey = array_rand($hairTypes);
        $hairType = $hairTypes[$randKey];
        
        //Determines Tail Style
        $randKey = array_rand($tailTypes);
        $tailType = $tailTypes[$randKey];
        
        //Inserts Owner Id (Update Later)
        $ownerID = 303;
        
        //Determines any Special Features (Currently Belly + Spots)
        $specials = "";
        $result = array(true, false)[random_int(0,1)];
        if ($result) {
            $specials .= "Belly ";
        }
        $result = array(true, false)[random_int(0,1)];
        if ($result) {
            $specials .= "Spots ";
        }
        
        //Removes the last space from the Specials String *VERY IMPORTANT*
        $specials = substr($specials, 0, -1);
        
        //Inserts Snoozeling into Blueprints. Might need Updating
        $query = "INSERT INTO blueprints (ownerID, mainColor, hairColor, tailColor, eyeColor, noseColor, hairType, tailType, specials) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$ownerID, $mainColor, $hairColor, $tailColor, $eyeColor, $noseColor, $hairType, $tailType, $specials]);
        
        //Ends Connections
        $pdo = null;
        $stmt = null;
        
        //Sends you to Last Page
        $previousPage = $_SERVER["HTTP_REFERER"];
        header('Location: '.$previousPage);
        
        //Die
        die();
    
    } catch (PDOException $e) {
        die("Query Failed: " . $e->getMessage());        
    }


/*

$hairTypes = ('Floof', 'Wave', 'Mane', 'Mop', 'Flowing');
$tailTypes = ('Dragon', 'Long', 'Nub', 'Poof');

function chooseTailColor (tempHairColor) {
    $result = array("heads", "tails")[random_int(0,1)];
    
}

//Choose Tail Color Function
function chooseTailColor(tempHairColor) {
    const randomChance = flipCoin();
    if (tempHairColor.colorRarity === 'Rare' || randomChance === true) {
        return tempHairColor;
    } else {
        return chooseByColorRarity('Common');
    }
}

//Snoozeling Factory
function Snoozeling(id, mainColor, eyeColor, hairColor, tailColor, noseColor, hairType, tailType, bellyMarking, spotsMarking, wings, mood) {
    this.id = id;
    this.mainColor = mainColor;
    this.eyeColor = eyeColor;
    this.hairColor = hairColor;
    this.tailColor = tailColor;
    this.noseColor = noseColor;
    this.hairType = hairType;
    this.tailType = tailType;
    if (this.tailType === "Dragon") {
        this.tailColor = this.hairColor;
    }
    this.bellyMarking = bellyMarking;
    this.spotsMarking = spotsMarking;
    this.wings = wings;
    this.mood = mood;
    this.faceType = this.mood.fileName;
    if (this.mood.colors === true) {
        this.faceColor = this.mood.fileName;
    } else {
        this.faceColor = "";
    }
}

function randomSnoozeling(id) {
    const tempMainColor = chooseFromArrayRandom(colorList);
    const tempEyecolor = chooseByColorRarity('Common');
    const tempHairColor = chooseHairColor(tempMainColor);
    const tempTailColor = chooseTailColor(tempHairColor);
    const tempTailType = chooseFromArrayRandom(tailTypes);
    const tempHairType = chooseFromArrayRandom(hairTypes);
    const tempNoseColor = chooseFromArrayRandom(colorList);
    const tempBelly = flipCoin();
    const tempSpots = flipCoin();
    const tempWings = randomNumbercheck(4);
    const tempMood = chooseFromArrayRandom(moodList);
    const newSnooze = new Snoozeling(id, tempMainColor, tempEyecolor, tempHairColor, tempTailColor, tempNoseColor, tempHairType, tempTailType, tempBelly, tempSpots, tempWings, tempMood);
    return newSnooze;
}
*/