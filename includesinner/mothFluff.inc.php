<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';



if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //Grab Form Variables
    $snooze = $_POST['snoozeling'];
    $dye = $_POST['dye'];
    $userId = $_COOKIE['user_id'];
    
    //Check if user has coins
    $query = "SELECT coinCount FROM users WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $coins = $stmt->fetch(PDO::FETCH_ASSOC);
    $count = intval($coins['coinCount']);
    
    if ($count < 25) {
            $reply = "You do not have enough snooze coins.";
        $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":message", $reply);
        $stmt->execute();
        header("Location: ../trendytails");
        die();
    } 
    
    //Grab Snoozeling Info
    $query = "SELECT * FROM snoozelings WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $snooze);
    $stmt->execute();
    $snoozeling = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Check if snoozeling is owned by user
    if ($userId == $snoozeling['owner_id']) {
        
    } else {
        header("Location: ..");
        die();
    }
    
    //Check if Snoozeling has Mothfluff
    $specials = explode(" ", $snoozeling['specials']);
    $check = 0;
    $spot = 0;
    
    foreach ($specials as $special) {
        if (str_contains($special, "MothFluff")) {
            $check = 1;
            $type = $special;
            break;
        } else {
            $spot++;
        }
    }

    
    if($check) {
        
    } else {
        header("Location: ..");
        die();
    }
    
    //Check is user has dye
    $query = "SELECT * FROM items WHERE user_id = :id AND name = :name";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":name", $dye);
    $stmt->execute();
    $dyeCheck = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($dyeCheck) {
        
    } else {
            $reply = "You do not have any of the selected dye.";
        $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":message", $reply);
        $stmt->execute();
        header("Location: ../trendytails");
        die();
    }
    
    //Create Array & Remove MothFluff
    unset($specials[$spot]); 
    $removedSpecials = array_values($specials);
    
    //Add new mothfluff
    $color = str_replace("Dye", "", $dye);
    $name = "MothFluff" . $color;
    array_push($removedSpecials,$name);
    if (count($removedSpecials) == 1) {
        $finalSpecials = $name;
    } else {
        $count = 0;
        foreach ($removedSpecials as $special) {
            if ($count == 0) {
                $finalSpecials = $special;
                $count++;
            } else {
                $finalSpecials = $finalSpecials . " " . $special;
            }
        }
    }
    
    if ($dye == "WhiteDye") {
        $special = "MothFluff";
    }
    
    //Check if MothFluff is the Same
    if ($name == $type) {
            $reply = "You snoozelings\'s moth fluff is already that color.";
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
        header("Location: ../trendytails");
        die();
    }
    
    //Update Specials
    $query = 'UPDATE snoozelings SET specials = :specials WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $snooze);
    $stmt->bindParam(":specials", $finalSpecials);
    $stmt->execute();
    
    //Remove dye from inventory
    $query = 'DELETE FROM items WHERE user_id = :id AND name = :name LIMIT 1';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":name", $dye);
    $stmt->execute();
    
    //Remove coins from inventory
    $query = 'UPDATE users SET coinCount = coinCount - 25 WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    
    //Pronouns
    if ($snoozeling['pronouns'] === "He/Him") {
        $pronouns = "his";
    } elseif ($snoozeling['pronouns'] === "She/Her") {
        $pronouns = "her";
    } else {
        $pronouns = "their";
    }
    
    //Update Session message
    $greeting = htmlspecialchars($snoozeling['name'] . ' loves ' . $pronouns . ' new moth fluffies!!!');
        $reply = $greeting;
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
    
    //Reroute to trendytails
    header("Location: ../trendytails");
    
    
} else {
    header("Location: ../index");
    die();
}
