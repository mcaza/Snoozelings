<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';


if ($_SERVER["REQUEST_METHOD"] === "POST") {
//Grab Form Variables
$petId = $_POST["explorer"];
if ($petId) {
$area = $_POST["area"];
    $userId = $_SESSION['user_id'];
    $farmCommon = ['28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39'];
    $farmUncommon = ['64', '65', '66', '74', '75', '14'];
    $farmRare = ['78', '79', '80', '92', '93', '94', '95', '98'];
    $woodsCommon = ['40', '41', '42', '43', '44', '45', '46', '47', '48', '49', '50', '51'];
    $woodsUncommon = ['68', '67', '69', '76','14'];
    $woodsRare = ['81', '82', '83', '84', '85', '96', '99', '223'];
    $oceanCommon = ['52', '53', '54', '55', '56', '57', '58', '59', '60', '61', '62', '63'];
    $oceanUncommon = ['70', '72', '73', '74', '77'];
    $oceanRare = ['86', '87', '88', '89', '90', '91', '97', '100'];
    $seeds = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13'];
    $itemsWon = [];
    $coinsWon = 0;
    
    //Get Pet Name
    $query = "SELECT name, owner_id, job, cooldownTime FROM snoozelings WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $petId);
    $stmt->execute();
    $name = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Check if Pet is Owned by Account
    if (!($userId == $name['owner_id'])) {
        header("Location: ../index");
        die(); 
    }
    
    //Check if Pet is Crafting
    if ($name['job'] === "jack") {
        $query = 'SELECT * FROM craftingtables WHERE pet_id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $petId);
        $stmt->execute();
        $table = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($table['name']) {
            $_SESSION['error'] = "That snoozeling is currently crafting.";
                header("Location: ../explore");
                die(); 
        }
    }
    
    //Check if Pet can Explore
    $now = new DateTime("now", new DateTimezone('UTC'));
    $result = $now->format('Y-m-d H:i:s');
    if ($result < $name['cooldownTime']) {
        $_SESSION['error'] = "That snoozeling is unable to explore at this time.";
        header("Location: ../explore");
        die(); 
    } 
    
    //Get Items
    $query = "SELECT * FROM itemList";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    //Get Snoozeling Explore Level
    $query = "SELECT exploreEXP FROM snoozelings WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $petId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $exp = intval($result['exploreEXP']);
    
    //Calculate How Many Rolls
    $exp = intval($result['exploreEXP']);
    $rolls = howMany($exp);
    
    for($i = 0; $i < $rolls; $i++) {
        $rarity = rollRarity();
        pickItem($rarity, $area);
    }
    
    //Insert into exploredrops
    if ($coinsWon && $itemsWon) {
        $query = "INSERT INTO exploredrops (user_id, coins, drops) VALUES (:user_id, :coins, :drops);";
    } else if ($coinsWon) {
        $query = "INSERT INTO exploredrops (user_id, coins) VALUES (:user_id, :coins);";
    } else if ($itemsWon) {
        $query = "INSERT INTO exploredrops (user_id, drops) VALUES (:user_id, :drops);";
    }
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    if ($coinsWon && $itemsWon) {
        $stmt->bindParam(":coins", $coinsWon);
        $itemstring = "";
        foreach ($itemsWon as $itemWon) {
            $itemstring = $itemstring . $itemWon . " ";
        }
        $stmt->bindParam(":drops", $itemstring);
    } else if ($coinsWon) {
        $stmt->bindParam(":coins", $coinsWon);
    } else if ($itemsWon) {
        $itemstring = "";
        foreach ($itemsWon as $itemWon) {
            $itemstring = $itemstring . $itemWon . " ";
        }
        $stmt->bindParam(":drops", $itemstring);
    }
    $stmt->execute();
    
   //Insert Items Into Player's Table
    foreach ($itemsWon as $item) {
        $query = 'SELECT * FROM itemList WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $item);
        $stmt->execute();
        $iteminfo = $stmt->fetch(PDO::FETCH_ASSOC);
         
        $query = "INSERT INTO items (list_id, user_id, name, display, description, type, rarity, canDonate) VALUES (:list, :user, :name, :display, :description, :type, :rarity, :canDonate);";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":list", $item);
        $stmt->bindParam(":user", $userId);
        $stmt->bindParam(":name", $iteminfo['name']);
        $stmt->bindParam(":display", $iteminfo['display']);
        $stmt->bindParam(":description", $iteminfo['description']);
        $stmt->bindParam(":type", $iteminfo['type']);
        $stmt->bindParam(":rarity", $iteminfo['rarity']);
        $stmt->bindParam(":canDonate", $iteminfo['canDonate']);
        $stmt->execute();
    } 
    
    if ($coinsWon) {
        //Add Coins to User
        $query = "UPDATE users SET coinCount = coinCount + :coins WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->bindParam(":coins", $coinsWon);
        $stmt->execute();
    }
    
    
    //Update Snoozeling to working and add cooldown
    $now = new DateTime("now", new DateTimezone('UTC'));
    $hours = 2;
    $modified = (clone $now)->add(new DateInterval("PT{$hours}H")); 
    $formatted = $modified->format('Y-m-d H:i:s');

    //Set Cooldown
    $query = "UPDATE snoozelings SET cooldownTime = :datetime WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":datetime", $formatted);
    $stmt->bindParam(":id", $petId);
    $stmt->execute();  
    
    //Update +1 to User Records
    $query = 'UPDATE users SET explores = explores + 1 WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute(); 
    
    if ($name['job'] == "Explorer") {
        //Update +1 to User Records
        $query = 'UPDATE snoozelings SET exploreEXP = exploreEXP + 1 WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $petId);
        $stmt->execute();
    } 
    
    //Update lastExplore
    $query = 'UPDATE users SET lastExplore = :last WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":last", $area);
    $stmt->execute();
    
    $_SESSION['coins'] = $coinsWon;
    $_SESSION['items'] = $itemsWon;
    $_SESSION['petName'] = htmlspecialchars($name['name']);
    header("Location: ../explore"); 
} else {
    $_SESSION['error'] = 'You must select an explorer.';
        header("Location: ../explore");
}
} else {
    header("Location: ../index.php");
}

function howMany($exp) {
    if ($exp < 50) {
        return rand(1, 5);
    } elseif ($exp < 150) {
        return rand(2,5);
    } elseif ($exp < 325) {
        return rand(3,5);
    } elseif ($exp < 600) {
        return rand(4,5);
    } elseif ($exp < 1000) {
        return 5;
    } else {
        return 6;
    }
}

function rollRarity() {
    return rand(1, 400);
}

function pickItem($rarity, $area) {
    global $farmCommon;
    global $farmUncommon;
    global $farmRare;
    global $seeds;
    global $coinsWon;
    global $itemsWon;
    global $woodsCommon;
    global $woodsUncommon;
    global $woodsRare;
    global $oceanCommon;
    global $oceanUncommon;
    global $oceanRare;
    global $itemsWon;
    global $cowArray;
    global $coinsWon;
    

    if ($area === "Farmland") {
        //Farm Rolls
        if ($rarity === 1) {
            $item = '209';
            array_push($itemsWon, $item);
        } elseif ($rarity < 6) {
            $item = '137';
            array_push($itemsWon, $item);
        } elseif ($rarity < 21) {
            $count = count($farmRare) - 1;
            $randomNum = rand(0, $count);
            $item = $farmRare[$randomNum];
            array_push($itemsWon, $item);
        } elseif ($rarity < 41) {
            $count = count($farmUncommon) - 1;
            $randomNum = rand(0, $count);
            $item = $farmUncommon[$randomNum];
            array_push($itemsWon, $item);
        } elseif ($rarity < 51) {
            $coinsWon += 3;
        } elseif ($rarity < 71) {
            $coinsWon += 2;
        } elseif ($rarity < 131) {
            $coinsWon++;
        } elseif ($rarity < 286) {
            $count = count($farmCommon) - 1;
            $randomNum = rand(0, $count);
            $item = $farmCommon[$randomNum];
            array_push($itemsWon, $item);
        } else {
            $count = count($seeds) - 1;
            $randomNum = rand(0, $count);
            $item = $seeds[$randomNum];
            array_push($itemsWon, $item);
        }
    } elseif ($area === "Forest") {
        //Forest Rolls
        if ($rarity === 1) {
            $item = '209';
            array_push($itemsWon, $item);
        } elseif ($rarity < 6) {
            $item = '137';
            array_push($itemsWon, $item);
        } elseif ($rarity < 21) {
            $count = count($woodsRare) - 1;
            $randomNum = rand(0, $count);
            $item = $woodsRare[$randomNum];
            array_push($itemsWon, $item);
        } elseif ($rarity < 41) {
            $count = count($woodsUncommon) - 1;
            $randomNum = rand(0, $count);
            $item = $woodsUncommon[$randomNum];
            array_push($itemsWon, $item);
        } elseif ($rarity < 51) {
            $coinsWon += 3;
        } elseif ($rarity < 71) {
            $coinsWon += 2;
        } elseif ($rarity < 131) {
            $coinsWon++;
        } elseif ($rarity < 286) {
            $count = count($woodsCommon) - 1;
            $randomNum = rand(0, $count);
            $item = $woodsCommon[$randomNum];
            array_push($itemsWon, $item);
        } else {
            $count = count($seeds) - 1;
            $randomNum = rand(0, $count);
            $item = $seeds[$randomNum];
            array_push($itemsWon, $item);
        }
    } elseif ($area === "Beach") {
        //Beach Rolls
        if ($rarity === 1) {
            $item = '209';
            array_push($itemsWon, $item);
        } elseif ($rarity < 6) {
            $item = '137';
            array_push($itemsWon, $item);
        } elseif ($rarity < 21) {
            $count = count($oceanRare) - 1;
            $randomNum = rand(0, $count);
            $item = $oceanRare[$randomNum];
            array_push($itemsWon, $item);
        } elseif ($rarity < 41) {
            $count = count($oceanUncommon) - 1;
            $randomNum = rand(0, $count);
            $item = $oceanUncommon[$randomNum];
            array_push($itemsWon, $item);
        } elseif ($rarity < 51) {
            $coinsWon += 3;
        } elseif ($rarity < 71) {
            $coinsWon += 2;
        } elseif ($rarity < 131) {
            $coinsWon++;
        } elseif ($rarity < 286) {
            $count = count($oceanCommon) - 1;
            $randomNum = rand(0, $count);
            $item = $oceanCommon[$randomNum];
            array_push($itemsWon, $item);
        } else {
            $count = count($seeds) - 1;
            $randomNum = rand(0, $count);
            $item = $seeds[$randomNum];
            array_push($itemsWon, $item);
        }
    }
}