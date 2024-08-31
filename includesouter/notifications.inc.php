<?php
//Get Values
$userId = $_SESSION['user_id'];
$count = 1;
$now = new DateTime("now", new DateTimezone('UTC'));
$result = $now->format('Y-m-d');

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

        $query = 'SELECT * FROM users WHERE newsletter = 0 And emailVerified = 1';
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $emails = $stmt->fetch(PDO::FETCH_ASSOC);

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
    $jack = "jack";
    $explorer = "Explorer";
    $query = "SELECT * FROM snoozelings WHERE (job = :jack OR job = :explorer) && owner_id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":jack", $jack);
    $stmt->bindParam(":explorer", $explorer);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $explorers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $now = new DateTime("now", new DateTimezone('UTC'));
    $result = $now->format('Y-m-d H:i:s');
    foreach ($explorers as $pet) {
        if ($result > $pet['cooldownTime']) {
            '<div class="notificationbox"><a href="explore" class="notif">' . $count . '. Go Exploring</a></div>';
            break;
        }
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

    //Exploring Check
    $jack = "jack";
    $explorer = "Explorer";
    $query = 'SELECT * FROM snoozelings WHERE owner_id = :id AND (job = :jack OR job = :explorer)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":jack", $jack);
    $stmt->bindParam(":explorer", $explorer);
    $stmt->execute();
    $explorers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($explorers as $explorer) {
        if ($result > $explorer['cooldownTime']) {
            echo '<div class="notificationbox"><a href="explore" class="notif">' . $count . '. Go Exploring</a></div>';
            $count++;
            break;
        }
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
}










