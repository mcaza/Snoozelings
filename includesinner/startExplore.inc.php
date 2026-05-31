<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //Grab Form Variables
    $snoozes = [];
    array_push($snoozes,$_POST["one"]);
    if ($_POST["two"]) {
        array_push($snoozes,$_POST["two"]);
    }
    if ($_POST["three"]) {
        array_push($snoozes,$_POST["three"]);
    }
    if ($_POST["four"]) {
        array_push($snoozes,$_POST["four"]);
    }
    $userId = $_COOKIE['user_id'];
    
    if(!array_unique($snoozes)) {
        header("Location: ../index");
        die(); 
    } 

    if ($snoozes) {
        $area = $_POST["area"];
        $userId = $_COOKIE['user_id'];
        $farmSeeds = ['3','5','11','13','9'];
        $farmCommon = ['28','29','30','31','32','37','38','39'];
        $farmUncommon = ['65','64','66','14','73','75','74','55'];
        $farmRare = ['78', '79', '80', '92', '93', '94', '95', '98','415'];
        $woodsCommon = ['40','41','50','51','43','47','42','35'];
        $woodsSeeds = ['12','6','10','4'];
        $woodsUncommon = ['69','48','49','14','73','76','74','55'];
        $woodsRare = ['81', '82', '83', '84', '85', '96', '99', '223','416','220','221'];
        $oceanSeeds = ['2','214','8','1','7'];
        $oceanCommon = ['52','53','54','59','58','60','57','45'];
        $oceanUncommon = ['70','56','72','14','73','77','74','55'];
        $oceanRare = ['86', '87', '88', '89', '90', '91', '97', '100','417'];
        $itemsWon = [];
        $coinsWon = 0;

        //If Holiday Month, add Holiday Items to Rare Arrays
        $now = new DateTime('now', new DateTimezone('UTC'));
        $firstDate = $now->format('m');
        if ($firstDate == 10) {
            array_push($farmRare,'236','237','238','239');
            array_push($woodsRare,'236','237','238','239');
            array_push($oceanRare,'236','237','238','239');
        }
        
        //Add snoozes to array and check if owned by player
        $snoozeInfo = [];
        
        foreach ($snoozes as $pet) {
            //Get Pet Name
            $query = "SELECT * FROM snoozelings WHERE id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $pet);
            $stmt->execute();
            $infoCheck = $stmt->fetch(PDO::FETCH_ASSOC);

            //Check if Pets Are Owned by Account
            if (!($userId == $infoCheck['owner_id'])) {
                header("Location: ../index");
                die(); 
            }
            
            array_push($snoozeInfo,$infoCheck);
        }

        //Get Items
        $query = "SELECT * FROM itemList";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        /* //Get Snoozeling Explore Level
        $query = "SELECT exploreEXP FROM snoozelings WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $petId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $exp = intval($result['exploreEXP']); */

        //Calculate How Many Rolls
        $rolls = 0;
        foreach ($snoozeInfo as $pet) {
            $exp = $pet['exploreEXP'];
            $temp = howMany($exp);
            $rolls = $rolls + $temp;
        }

        for($i = 0; $i < $rolls; $i++) {
            $rarity = rollRarity();
            pickItem($rarity, $area);
        }

        /* //Insert into exploredrops
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
        $stmt->execute(); */

        $itemNames = [];
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

            array_push($itemNames, $iteminfo['display']);
        } 

        if ($coinsWon) {
            //Add Coins to User
            $query = "UPDATE users SET coinCount = coinCount + :coins WHERE id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $userId);
            $stmt->bindParam(":coins", $coinsWon);
            $stmt->execute();
        }


        //Get Update
        $now = new DateTime("now", new DateTimezone('UTC'));
        $hours = 2;
        $modified = (clone $now)->add(new DateInterval("PT{$hours}H")); 
        $formatted = $modified->format('Y-m-d H:i:s');


        //Update +1 to User Records
        $query = 'UPDATE users SET explores = explores + 1 WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->execute(); 

        //Update +1 to Snoozeling EXP Records. EXP no matter role
        foreach ($snoozes as $pet) {
            $query = 'UPDATE snoozelings SET exploreEXP = exploreEXP + 1 WHERE id = :id';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $pet);
            $stmt->execute();
        }
        
        //Update Party
        $query = "SELECT * FROM exploringParties WHERE user_id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
        $previous = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($previous) {
            if (count($snoozes) == 4) {
                $query = 'UPDATE exploringParties SET lastArea = :last, one = :one, two = :two, three = :three, four = :four, cooldownTime = :datetime WHERE user_id = :id';
            } else if (count($snoozes) == 3) {
                $query = 'UPDATE exploringParties SET lastArea = :last, one = :one, two = :two, three = :three, cooldownTime = :datetime WHERE user_id = :id';
            } else if (count($snoozes) == 2) {
                $query = 'UPDATE exploringParties SET lastArea = :last, one = :one, two = :two, cooldownTime = :datetime WHERE user_id = :id';
            } else {
                $query = 'UPDATE exploringParties SET lastArea = :last, one = :one, cooldownTime = :datetime WHERE user_id = :id';
            }
            $stmt = $pdo->prepare($query);
            if (count($snoozes) > 1) {
                $stmt->bindParam(":two", $snoozes[1]);
            }
            if (count($snoozes) > 2) {
                $stmt->bindParam(":three", $snoozes[2]);
            }
            if (count($snoozes) > 3) {
                $stmt->bindParam(":four", $snoozes[3]);
            }
            $stmt->bindParam(":id", $userId);
            $stmt->bindParam(":one", $snoozes[0]);
            $stmt->bindParam(":last", $area);
            $stmt->bindParam(":datetime", $formatted);
            $stmt->execute(); 
        } else {
            if (count($snoozes) == 4) {
                $query = 'INSERT INTO exploringParties (user_id, lastArea, one, two, three, four, cooldownTime) VALUES (:user, :area, :one, :two, :three, :four, :datetime)';
            } else if (count($snoozes) == 3) {
                $query = 'INSERT INTO exploringParties (user_id, lastArea, one, two, three, cooldownTime) VALUES (:user, :area, :one, :two, :three, :datetime)';
            } else if (count($snoozes) == 2) {
                $query = 'INSERT INTO exploringParties (user_id, lastArea, one, two, cooldownTime) VALUES (:user, :area, :one, :two, :datetime)';
            } else {
                $query = 'INSERT INTO exploringParties (user_id, lastArea, one, cooldownTime) VALUES (:user, :area, :one, :datetime)';
            }
            $stmt = $pdo->prepare($query);
            if (count($snoozes) > 1) {
                $stmt->bindParam(":two", $snoozes[1]);
            }
            if (count($snoozes) > 2) {
                $stmt->bindParam(":three", $snoozes[2]);
            }
            if (count($snoozes) > 3) {
                $stmt->bindParam(":four", $snoozes[3]);
            }
            $stmt->bindParam(":user", $userId);
            $stmt->bindParam(":one", $snoozes[0]);
            $stmt->bindParam(":area", $area);
            $stmt->bindParam(":datetime", $formatted);
            $stmt->execute(); 
        }
        

        $count = count($itemsWon);
        $i = 1;

        $itemString = implode(", ",$itemNames);



        if ($itemString || $coinsWon > 0) {
        if ($coinsWon == 1) {
            if ($itemString) {
                $greeting = 'Your snoozelings brought you 1 snooze coin.<br><br>';
            } else {
                $greeting = htmlspecialchars($name['name']) . ' brought you 1 snooze coin.';
            }
        } elseif ($coinsWon > 1) {
            if ($itemString) {
                $greeting = 'Your snoozelings brought you ' . $coinsWon . ' snooze coins.<br><br>';
            } else {
                $greeting = 'Your snoozelings brought you ' . $coinsWon . ' snooze coins.';
            }

        }
        if ($itemString) {
            if ($coinsWon > 0) {
                $greeting = $greeting . ' They also brought back the following:<br><br>' . $itemString;
            } else {
                $greeting = 'Your snoozelings brought you the following items:<br><br>' . $itemString;
            }
        }
    }
        $reply = $greeting;
        $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":message", $reply);
        $stmt->execute();

        header("Location: ../explore"); 
    } else {
        $reply = "You must select an explorer.";
        $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":message", $reply);
        $stmt->execute();
        header("Location: ../explore");
    }
} else {
    header("Location: ../index.php");
}

function howMany($exp) {
    if ($exp < 50) {
        return rand(1,3);
    } elseif ($exp < 150) {
        return rand(2,4);
    } elseif ($exp < 325) {
        return rand(3,4);
    } elseif ($exp < 600) {
        return rand(3,5);
    } elseif ($exp < 1000) {
        return rand(4,5);
    } else {
        return 5;
    }
}

function rollRarity() {
    return rand(1, 400);
}

function pickItem($rarity, $area) {
    global $farmSeeds;
    global $woodsSeeds;
    global $oceanSeeds;
    global $farmCommon;
    global $farmUncommon;
    global $farmRare;
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
        } elseif ($rarity < 16) {
            $count = count($farmRare) - 1;
            $randomNum = rand(0, $count);
            $item = $farmRare[$randomNum];
            array_push($itemsWon, $item);
        } elseif ($rarity < 46) {
            $count = count($farmUncommon) - 1;
            $randomNum = rand(0, $count);
            $item = $farmUncommon[$randomNum];
            array_push($itemsWon, $item);
        } elseif ($rarity < 56) {
            $coinsWon += 3;
        } elseif ($rarity < 81) {
            $coinsWon += 2;
        } elseif ($rarity < 131) {
            $coinsWon++;
        } elseif ($rarity < 311) {
            $count = count($farmCommon) - 1;
            $randomNum = rand(0, $count);
            $item = $farmCommon[$randomNum];
            array_push($itemsWon, $item);
        } else {
            $count = count($farmSeeds) - 1;
            $randomNum = rand(0, $count);
            $item = $farmSeeds[$randomNum];
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
        } elseif ($rarity < 16) {
            $count = count($woodsRare) - 1;
            $randomNum = rand(0, $count);
            $item = $woodsRare[$randomNum];
            array_push($itemsWon, $item);
        } elseif ($rarity < 46) {
            $count = count($woodsUncommon) - 1;
            $randomNum = rand(0, $count);
            $item = $woodsUncommon[$randomNum];
            array_push($itemsWon, $item);
        } elseif ($rarity < 56) {
            $coinsWon += 3;
        } elseif ($rarity < 81) {
            $coinsWon += 2;
        } elseif ($rarity < 131) {
            $coinsWon++;
        } elseif ($rarity < 311) {
            $count = count($woodsCommon) - 1;
            $randomNum = rand(0, $count);
            $item = $woodsCommon[$randomNum];
            array_push($itemsWon, $item);
        } else {
            $count = count($woodsSeeds) - 1;
            $randomNum = rand(0, $count);
            $item = $woodsSeeds[$randomNum];
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
        } elseif ($rarity < 16) {
            $count = count($oceanRare) - 1;
            $randomNum = rand(0, $count);
            $item = $oceanRare[$randomNum];
            array_push($itemsWon, $item);
        } elseif ($rarity < 46) {
            $count = count($oceanUncommon) - 1;
            $randomNum = rand(0, $count);
            $item = $oceanUncommon[$randomNum];
            array_push($itemsWon, $item);
        } elseif ($rarity < 56) {
            $coinsWon += 3;
        } elseif ($rarity < 81) {
            $coinsWon += 2;
        } elseif ($rarity < 131) {
            $coinsWon++;
        } elseif ($rarity < 311) {
            $count = count($oceanCommon) - 1;
            $randomNum = rand(0, $count);
            $item = $oceanCommon[$randomNum];
            array_push($itemsWon, $item);
        } else {
            $count = count($oceanSeeds) - 1;
            $randomNum = rand(0, $count);
            $item = $oceanSeeds[$randomNum];
            array_push($itemsWon, $item);
        }
    }
}