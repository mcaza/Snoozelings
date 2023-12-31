<?php
//Get Values
$userId = $_SESSION['user_id'];
$count = 1;
$now = new DateTime(null, new DateTimezone('UTC'));
$result = $now->format('Y-m-d');

$query = 'SELECT * FROM users WHERE id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

//Pick Starter Snoozeling
if (!$user['bonded']) {
    echo '<div style="margin-bottom: .8rem;"><a href="welcome" class="notif">' . $count . '. Pick 1st Snoozeling</a></div>';
    $count++;
}

//Unopened Mail Check
$query = 'SELECT * FROM mail WHERE reciever = :id AND sent = 1 AND opened = 0';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$letters = $stmt->fetchAll(PDO::FETCH_ASSOC);
if ($letters) {
    echo '<div style="margin-bottom: .8rem;"><a href="mailbox" class="notif">' . $count . '. Check Mail</a></div>';
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
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $journal = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($journal['id']) {
        if ($journal['closed'] === "1") {
            echo '<div style="margin-bottom: .8rem;"><a href="journal" class="notif">' . $count . '. Journal Entry</a></div>';
            $count++; 
        }
    }
} elseif ($journal['type'] === "mentalHealth") {
    $query = 'SELECT * FROM mentalHealthEntries WHERE user_id = :id ORDER BY id DESC LIMIT 1';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $journal = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($journal['id']) {
        if ($journal['closed'] === "1") {
            echo '<div style="margin-bottom: .8rem;"><a href="journal" class="notif">' . $count . '. Journal Entry</a></div>';
            $count++; 
        }
    }
} else {
    echo '<div style="margin-bottom: .8rem;"><a href="journal" class="notif">' . $count . '. Create Journal</a></div>';
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
$now = new DateTime(null, new DateTimezone('UTC'));
$result = $now->format('Y-m-d H:i:s');
foreach ($explorers as $pet) {
    if ($result > $pet['cooldownTime']) {
        '<div style="margin-bottom: .8rem;"><a href="explore" class="notif">' . $count . '. Go Exploring</a></div>';
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
            echo '<div style="margin-bottom: .8rem;"><a href="plot?id=' . $plant['id'] . '" class="notif">' . $count . '. Harvest Crop</a></div>';
            $count++;
            break;
        }
    }
}

//Crops Plant Check
foreach ($plants as $plant) {
    if (!$plant['plantName']) {
        echo '<div style="margin-bottom: .8rem;"><a href="plot?id=' . $plant['id'] . '" class="notif">' . $count . '. Plant Seeds</a></div>';
        $count++;
        break;
    }
}
//Water Crops Check
if ($result > $user['lastWater']) {
    echo '<div style="margin-bottom: .8rem;"><a href="farm" class="notif">' . $count . '. Water Plants</a></div>';
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
        echo '<div style="margin-bottom: .8rem;"><a href="explore" class="notif">' . $count . '. Go Exploring</a></div>';
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
    echo '<div style="margin-bottom: .8rem;"><a href="raffle" class="notif">' . $count . '. Enter Raffle</a></div>';
    $count++;
}

//Get Free Item
if ($user['dailyPrize'] === "0") {
    echo '<div style="margin-bottom: .8rem;"><a href="randomitem" class="notif">' . $count . '. Collect Free Item</a></div>';
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
        echo '<div style="margin-bottom: .8rem;"><a href="crafting" class="notif">' . $count . '. Finish Craft</a></div>';
        $count++;
    }
}
















