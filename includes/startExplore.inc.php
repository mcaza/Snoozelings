<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';





if ($_SERVER["REQUEST_METHOD"] === "POST") {
//Grab Form Variables
$petId = $_POST["explorer"];
if ($petId) {
$area = $_POST["area"];
    $userId = $_SESSION['user_id'];
    $specials = ['21', '20'];
    $farmCommon = ['Coin', '2', '3', '4', '1', '5', '116'];
    $farmUncommon = ['15', '16', 'FabricCow', '93'];
    $farmRare = ['96'];
    $cowArray = ['87', '90', '88', '89'];
    $woodsCommon = ['Coin', '3', '6', '7', '8', '9', '116'];
    $woodsUncommon = ['17', '25', '94', '91'];
    $woodsRare = ['97'];
    $oceanCommon = ['Coins', '10', '11', '12', '13', '14', '116'];
    $oceanUncommon = ['18', '19', '95', '92'];
    $oceanRare = ['98'];
    $seeds = ['29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40', '41', '42', '43'];
    $itemsWon = [];
    $coinsWon = 0;
    
    //Get Pet Name
    $query = "SELECT name, owner_id, job FROM snoozelings WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $petId);
    $stmt->execute();
    $name = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Check if Pet is Owned by Account
    if (!($userId === $name['owner_id'])) {
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
        if ($table) {
            $now = new DateTime();
            $future_date = new DateTime($result['finishtime']);
            if ($future_date <= $now) {
                $_SESSION['error'] = "That snoozeling is currently crafting.";
                header("Location: ../explore");
                die(); 
            }
        }
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
    
    //Get Previous Coins
    $query = "SELECT coinCount FROM users WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $coins = $result['coinCount'];

    
    //Calculate How Many Rolls
    $exp = intval($result['exploreEXP']);
    $rolls = howMany($exp);
    
    for($i = 0; $i < $rolls; $i++) {
        $rarity = rollRarity();
        $item = pickItem($rarity, $area);
    }
    
    //Insert Items Into Player's Table
    foreach ($itemsWon as $item) {

        $number = intval($item);
        $fixedNumber = $number -1;
        $query = "INSERT INTO items (list_id, user_id, name, display, description, type, rarity, canDonate) VALUES (:list, :user, :name, :display, :description, :type, :rarity, :canDonate);";
        $stmt = $pdo->prepare($query);
    $stmt->bindParam(":list", $number);
    $stmt->bindParam(":user", $userId);
    $stmt->bindParam(":name", $items[$fixedNumber]['name']);
    $stmt->bindParam(":display", $items[$fixedNumber]['display']);
    $stmt->bindParam(":description", $items[$fixedNumber]['description']);
    $stmt->bindParam(":type", $items[$fixedNumber]['type']);
    $stmt->bindParam(":rarity", $items[$fixedNumber]['rarity']);
    $stmt->bindParam(":canDonate", $items[$fixedNumber]['canDonate']);
    $stmt->execute();
    }
    
    //Add Coins to User
    $query = "UPDATE users SET coinCount = :coins WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":coins", $coins);
    $stmt->execute();
    
    //Update Snoozeling to working and add cooldown
    $now = new DateTime();
    $hours = 2;
    $modified = (clone $now)->add(new DateInterval("PT{$hours}H")); 
    $formatted = $modified->format('Y-m-d H:i:s');

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
    
    //Update +1 to User Records
    $query = 'UPDATE snoozelings SET exploreEXP = exploreEXP + 1 WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $petId);
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
    return rand(1, 200);
}

function pickItem($rarity, $area) {
    global $farmCommon;
    global $farmUncommon;
    global $farmRare;
    global $specials;
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
    global $coins;
    global $cowArray;
    global $coinsWon;
    if ($area === "Farmland") {
        if ($rarity < 110) {
            $randomNum = rand(0, 6);
            $item = $farmCommon[$randomNum];
            if ($item === "Coin") {
                $coins++;
                $coinsWon++;
            } else {
                array_push($itemsWon, $item);
            }
        } elseif ($rarity < 150) {
            $randomNum = rand(0, 3);
            $item = $farmUncommon[$randomNum];
            if ($item === "FabricCow") {
                $randomNum = rand(0, 3);
                $item = $cowArray[$randomNum];
                array_push($itemsWon, $item);
            } else {
                array_push($itemsWon, $item);
            }
        } elseif ($rarity < 160) {
            $randomNum = 0;
            $item = $farmRare[$randomNum];
            array_push($itemsWon, $item);
        } elseif ($rarity === 160) {
            $randomNum = rand(0, 1);
            $item = $specials[$randomNum];
            array_push($itemsWon, $item);
        } else {
            $randomNum = rand(0, 14);
            $item = $seeds[$randomNum];
            array_push($itemsWon, $item);
        }
    } elseif ($area === "Forest") {
        if ($rarity < 110) {
            $randomNum = rand(0, 6);
            $item = $woodsCommon[$randomNum];
            if ($item === "Coin") {
                $coins++;
                $coinsWon++;
            } else {
                array_push($itemsWon, $item);
            }
        } elseif ($rarity < 150) {
            $randomNum = rand(0, 3);
            $item = $woodsUncommon[$randomNum];
            array_push($itemsWon, $item);
        } elseif ($rarity < 160) {
            $randomNum = 0;
            $item = $woodsRare[$randomNum];
            array_push($itemsWon, $item);
        } elseif ($rarity === 160) {
            $randomNum = rand(0, 2);
            $item = $specials[$randomNum];
            array_push($itemsWon, $item);
        } else {
            $randomNum = rand(0, 14);
            $item = $seeds[$randomNum];
            array_push($itemsWon, $item);
        }
    } elseif ($area === "Beach") {
        if ($rarity < 110) {
            $randomNum = rand(0, 6);
            $item = $oceanCommon[$randomNum];
            if ($item === "Coins") {
                $coins += 3;
                $coinsWo +=3;
            } else {
                array_push($itemsWon, $item);
            }
        } elseif ($rarity < 150) {
            $randomNum = rand(0, 3);
            $item = $oceanUncommon[$randomNum];
            array_push($itemsWon, $item);
        } elseif ($rarity < 160) {
            $randomNum = 0;
            $item = $oceanRare[$randomNum];
            array_push($itemsWon, $item);
        } elseif ($rarity = 160) {
            $randomNum = rand(0, 1);
            $item = $specials[$randomNum];
            array_push($itemsWon, $item);
        } else {
            $randomNum = rand(0, 14);
            $item = $seeds[$randomNum];
            array_push($itemsWon, $item);
        }
    }
}