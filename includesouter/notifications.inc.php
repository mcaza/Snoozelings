<?php

date_default_timezone_set('UTC');
//Get Values
$userId = $_COOKIE['user_id'];
$count = 1;
$now = new DateTime("now", new DateTimezone('UTC'));
$result = $now->format('Y-m-d');


$weekday = date('d');
$month = ltrim(date('m'), "0");


$query = 'SELECT * FROM users WHERE id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$tutorial = intval($user['tutorial']);

if ($tutorial < 4) {
    if ($tutorial < 3) {
         //Pick Starter Snoozeling
        if (!$user['bonded']) {
            echo '<div class="notificationbox"><a href="welcome" class="notif">' . $count . '. Pick 1st Snoozeling</a></div>';
            $count++;
        }
    } if ($tutorial == 3) {
        echo '<div class="notificationbox"><a href="journal" class="notif">' . $count . '. Create Journal</a></div>';
    }
} else {
    //Check for New Mod Tickets
    if ($userId == 1) {

        $query = 'SELECT * FROM modtickets WHERE status = 0 OR status = 1';
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $ticketcheck = false;
        foreach ($tickets as $ticket) {
            if ($ticket['waitingreply'] == NULL or $ticket['waitingreply'] == 0) {
                $ticketcheck = true;
                break;
            }
        }
        if ($ticketcheck == true) {
            echo '<div class="notificationbox"><a href="stafftickets" class="notif" style="color:red;">' . $count . '. Moderator Ticket</a></div>';
            $count++;
        }

        
        
        $query = 'SELECT * FROM dailyRecords ORDER BY id DESC LIMIT 1';
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $records = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($emails) {
                echo '<div class="notificationbox"><a href="secretemailpage" class="notif" style="color:red;">' . $count . '. Add Emails</a></div>';
                $count++;
            }
        
    }

   

    //Unopened Mail Check
    $query = 'SELECT * FROM mail WHERE reciever = :id AND sent = 1 AND opened = 0';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $letters = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($letters) {
        echo '<div class="notificationbox"><a href="mailbox" class="notif">' . $count . '. Check Mail</a></div>';
        $count++;
    }
    
    //Check for Breedings
    $zero = 0;
    $query = "SELECT * FROM breedings WHERE user_id = :id AND completed = :zero";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":zero", $zero);
    $stmt->execute();
    $breeding = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($breeding['status'] == 1 && $breeding['blueprint'] == false) {
        echo '<div class="notificationbox"><a href="blueprints?id=' . $breeding['id'] . '" class="notif">' . $count . '. Pick Blueprint</a></div>';
        $count++;
    }
    if ($breeding['status'] == 2 && $breeding['completed'] == false) {
        echo '<div class="notificationbox"><a href="delivery?id=' . $breeding['blueprint'] . '" class="notif">' . $count . '. Snoozeling Delivery</a></div>';
        $count++;
    }
    
    //Friend Request
    $query = "SELECT * FROM friendRequests WHERE newFriend = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $newFriend = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($newFriend) {
        echo '<div class="notificationbox"><a href="profile?id=' . $newFriend['sender'] . '" class="notif">' . $count . '. Friend Request</a></div>';
        $count++;
    }
    
    //Daily Journal Check
    $query = 'SELECT * FROM journals WHERE user_id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $journal = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($journal['type'] === "pain") {
        $query = 'SELECT * FROM chronicPainEntries WHERE user_id = :id ORDER BY id DESC LIMIT 1';
    } else if ($journal['type'] === "mentalHealth") {
        $query = 'SELECT * FROM mentalHealthEntries WHERE user_id = :id ORDER BY id DESC LIMIT 1';
    } else if ($journal['type'] === "productivity") {
        $query = 'SELECT * FROM productivityEntries WHERE user_id = :id ORDER BY id DESC LIMIT 1';
    } else if ($journal['type'] === "generic") {
        $query = 'SELECT * FROM genericEntries WHERE user_id = :id ORDER BY id DESC LIMIT 1';
    }
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $journal = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($journal['closed'] == "1" || !$journal) {
        echo '<div class="notificationbox"><a href="journal" class="notif">' . $count . '. Journal Entry</a></div>';
        $count++; 
    }

    //Explore Check
    $query = "SELECT * FROM exploringParties WHERE user_id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $party = $stmt->fetch(PDO::FETCH_ASSOC);
    $now = new DateTime("now", new DateTimezone('UTC'));
    $result = $now->format('Y-m-d H:i:s');
    
    if (!$party || $result > $party['cooldownTime']) {
        echo '<div class="notificationbox"><a href="explore" class="notif">' . $count . '. Go Exploring</a></div>';
        $count++;
    }


    //Crops Harvest Check
    $query = 'SELECT * FROM farms WHERE user_id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $plants = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($plants as $plant) {
        if ($plant['plantName']) {
            if ($result > $plant['stg3']) {
                echo '<div class="notificationbox"><a href="plot?id=' . $plant['id'] . '" class="notif">' . $count . '. Harvest Crop</a></div>';
                $count++;
                break;
            }
        }
    }

    //Crops Plant Check
    foreach ($plants as $plant) {
        if (!$plant['plantName']) {
            echo '<div class="notificationbox"><a href="plot?id=' . $plant['id'] . '" class="notif">' . $count . '. Plant Seeds</a></div>';
            $count++;
            break;
        }
    }

    //Water Crops Check
    if ($result > $user['lastWater']) {
        echo '<div class="notificationbox"><a href="farm" class="notif">' . $count . '. Water Plants</a></div>';
        $count++;
    }

    //Daily Raffle
    $query = 'SELECT entries FROM rafflecount ORDER BY id DESC LIMIT 1';
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $entries = $stmt->fetch(PDO::FETCH_ASSOC);
    $raffle = explode(" ", $entries['entries']);
    $str = strval($userId);

    if (!in_array($str, $raffle)) {
        echo '<div class="notificationbox"><a href="raffle" class="notif">' . $count . '. Enter Raffle</a></div>';
        $count++;
    }

    //Get Free Item
    if ($user['dailyPrize'] == "0") {
        echo '<div class="notificationbox"><a href="randomitem" class="notif">' . $count . '. Daily Gift</a></div>';
        $count++;
    }
    
    //Daily Wishing Well
    $query = "SELECT * FROM items WHERE list_id = 73 AND user_id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $coinCheck = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($coinCheck) {
        if ($user['dailyWish'] == 0) {
            echo '<div class="notificationbox"><a href="wishingwell" class="notif">' . $count . '. Wishing Well</a></div>';
            $count++;
        }
    }
    
    //Free Item December
    if ($month == 12) {
        $gift = 0;
        if ($weekday < 25 || $weekday == 31) {
            if ($user['decGift'] < $weekday) {
                $gift = 1;
            }
        } else  {
            if ($user['decGift'] < 25) {
                $gift = 1;
            }
        }
        if ($gift == 1) {
            echo '<div class="notificationbox"><a href="decemberGifts" class="notif">' . $count . '. Cocoa\'s Gift</a></div>';
            $count++;
        }
    }
    
    //Finished Craft
    $query = 'SELECT * FROM craftingtables WHERE user_id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $crafting = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($crafting['display']) {
        if ($result > $crafting['finishtime']) {
            echo '<div class="notificationbox"><a href="crafting" class="notif">' . $count . '. Finish Craft</a></div>';
            $count++;
        }
    }
    
    //Start Craft
    if ($user['craftNotify'] == 1 && $crafting['recipe_id'] == 0 ) {
        echo '<div class="notificationbox"><a href="crafting" class="notif">' . $count . '. Craft Item</a></div>';
            $count++;
    }
    
    //Check For Flea Market Coins
    $query = 'SELECT * FROM marketTables WHERE user_id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $marketTable = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($marketTable['itemOne'] == "Coins" || $marketTable['itemTwo'] == "Coins"  || $marketTable['itemThree'] == "Coins"  || $marketTable['itemFour'] == "Coins" ) {
        echo '<div class="notificationbox"><a href="fleaMarket" class="notif">' . $count . '. Collect Coins</a></div>';
        $count++;
    }

    //Finished Dye
    $query = 'SELECT * FROM dyebatches WHERE user_id = :id AND finished = 0';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $dyebatch = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($dyebatch) {
        if ($result > $dyebatch['endtime']) {
            echo '<div class="notificationbox"><a href="dyes" class="notif">' . $count . '. Check Dye Pot</a></div>';
            $count++;
        }
    }

    //Check ModMail
    $query = 'SELECT * FROM modtickets WHERE submitter = :id AND waitingreply = 1 AND (status = 1 OR status = 0 OR status IS NULL)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $modmail = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($modmail) {
        echo '<div class="notificationbox"><a href="moderatormail" class="notif">' . $count . '. Moderator Mail</a></div>';
        $count++;
    }
    
    if ($count == 1) {
        echo '<div class="notificationbox"><p>Nothing!!!</p></div>';
    }
}










