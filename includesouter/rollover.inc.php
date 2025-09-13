 <?php
    require_once 'dbh-inc.php';
    $winner = 0;

    //Date Stuff
    $hours = 24;
    $now = new DateTime('now', new DateTimezone('UTC'));
    $modified = (clone $now)->add(new DateInterval("PT{$hours}H")); 
    $rotime = $modified->format('Y-m-d H:i:s');
    $hours = 3;
    $modified = (clone $now)->add(new DateInterval("PT{$hours}H")); 
    $mailone = $modified->format('Y-m-d H:i:s');
    $hours = 16;
    $modified = (clone $now)->add(new DateInterval("PT{$hours}H")); 
    $mailtwo = $modified->format('Y-m-d H:i:s');
    $hours = 29;
    $modified = (clone $now)->add(new DateInterval("PT{$hours}H")); 
    $mailthree = $modified->format('Y-m-d H:i:s');

    //Reset Rollover Time
    $query = 'UPDATE times SET rotime = :time, mailone = :one, mailtwo = :two, mailthree = :three';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":time", $rotime);
    $stmt->bindParam(":one", $mailone);
    $stmt->bindParam(":two", $mailtwo);
    $stmt->bindParam(":three", $mailthree);
    $stmt->execute();
    echo "Rollover Times Set! \n";

    //Reset Daily Records
    $query = "INSERT INTO dailyRecords SET journalEntries = 0, cropsHarvested = 0, snoozelingsCrafted = 0, itemsCrafted = 0, activeMembers = 0, newMembers = 0, kindnessCoins = 3, requestsFilled = 0, rotime = :rotime";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":rotime", $rotime);
    $stmt->execute();
    echo "Daily Records Reset! \n";

    //Grab Today's User Count
    $query = "SELECT * FROM dailyRecords ORDER BY id DESC LIMIT 1";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $usercount = $stmt->fetch(PDO::FETCH_ASSOC);

    //Grab All Info
    $one = "1";
    $zero = "0";
    $query = "SELECT * FROM users WHERE lastLog = :num";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":num", $one);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //Get all Affirmations
    $affirmquery = "SELECT * FROM affirmations";
    $affirmstmt = $pdo->prepare($affirmquery);
    $affirmstmt->execute();
    $affirmresults = $affirmstmt->fetchAll(PDO::FETCH_ASSOC);

    $affirmlength = count($affirmresults) - 1; 
    
    $loopcount = 0;
    foreach ($users as $user) {
        //Assign Affirmations & Reset lastLog & DailyItem & Reset Requests
        $randomNum = rand(1, $affirmlength);
        $query = "UPDATE users SET affirmation = :affirmation, lastLog = 0, dailyPrize = 0, requests = 0, penpalRequests = 0, dailyWish = 0 WHERE id = :id AND lastLog = 1";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":affirmation", $affirmresults[$randomNum]["affirmation"]);
        $stmt->bindParam(":id", $user["id"]);
        $stmt->execute();
        $loopcount++;
    }
    echo "Affirmations Set: " . $loopcount . "\n";

    //Check Birthdays
    $loopcount = 0;
    foreach ($users as $user) {
        $firstDate = $now->format('m-d');
        $secondDate = substr($user['birthdate'], 5);
        if ($firstDate == $secondDate) {
            //Add Item
            $list = 222;
            $one = 1;
            $name = "FabricPurplePlaid";
            $display = "Fabric: Purple Plaid";
            $description = "Take to Minky to give your snoozeling purple plaid nose and ear insides.";
            $type = "fabric";
            $rarity = "special";
            $query = 'INSERT INTO items (list_id, user_id, name, display, description, type, rarity, canDonate) VALUES (:list, :user, :name, :display, :description, :type, :rarity, :donate)';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":list", $list);
            $stmt->bindParam(":user", $user["id"]);
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":display", $display);
            $stmt->bindParam(":description", $description);
            $stmt->bindParam(":type", $type);
            $stmt->bindParam(":rarity", $rarity);
            $stmt->bindParam(":donate", $one);
            $stmt->execute();
            
            //Send Letter
            $zero = 0;
            $one = 1;
            $title = "Happy Birthday " . $user['username'] . '!';
            $sender = 1;
            $zero = 0;
            $now = new DateTime("now", new DateTimezone('UTC'));
            $date = $now->format('Y-m-d H:i:s');
            if ($user['birthdayOptOut'] == 0) {
                $message = 'Hey there ' . $user['username'] . ', 
            
            Here at Snoozelings, we know birthdays can sometimes be not so great. Sometimes friends and families fall through. Sometimes we just don\'t have anyone to spend the day with. Sometimes people just forget.
            
            That\'s why we want to send you a little gift on us. A birthday exclusive fabric for a snoozeling of your choice. Because we care.
            
            You may also find some birthday gifts from other users appearing in your mailbox in the next 5-10 minutes.
            
            Please remember: You are loved, You are valued, You are worthy, You are enough.
            
            Happy birthday from all of us at Snoozelings <3
            
            ~Slothie';
            } else {
                $message = 'Hey there ' . $user['username'] . ', 
            
            Here at Snoozelings, we know birthdays can sometimes be not so great. Sometimes friends and families fall through. Sometimes we just don\'t have anyone to spend the day with. Sometimes people just forget.
            
            That\'s why we want to send you a little gift on us. A birthday exclusive fabric for a snoozeling of your choice. Because we care.
            
            Please remember: You are loved, You are valued, You are worthy, You are enough.
            
            Happy birthday from all of us at Snoozelings <3
            
            ~Slothie';
            }
            $query = 'INSERT INTO mail (sender, reciever, title, message, sent, opened, sendtime) VALUES (:sender, :reciever, :title, :message, :sent, :opened, :sendtime)';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":sender", $sender);
            $stmt->bindParam(":reciever", $user["id"]);
            $stmt->bindParam(":title", $title);
            $stmt->bindParam(":message", $message);
            $stmt->bindParam(":sent", $one);
            $stmt->bindParam(":opened", $zero);
            $stmt->bindParam(":sendtime", $date);
            $stmt->execute();
            $loopcount++;
        }
    }
    echo "Birthday Gifts Sent: " . $loopcount . "\n";
    

    //Close All Journal Entries
    $query = "UPDATE chronicPainEntries SET closed = 1";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $query = "UPDATE mentalHealthEntries SET closed = 1";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $query = "UPDATE productivityEntries SET closed = 1";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $query = "UPDATE genericEntries SET closed = 1";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    echo "Journal Entries Closed! \n";

    //Reset Daily Post
    $one = 1;
    $zero = 0;
    $query = "UPDATE posts SET new = :one WHERE new = :zero";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":one", $one);
    $stmt->bindParam(":zero", $zero);
    $stmt->execute();

    
//Expire Old Requests
$query = 'SELECT * FROM requests WHERE fulfilled = 0 AND expired = 0';
$stmt = $pdo->prepare($query);
$stmt->execute();
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

$now = new DateTime('now', new DateTimezone('UTC'));
$result = $now->format('Y-m-d H:i:s');

$requestcount = 0;
foreach ($requests as $request) {
    if ($result > $request['datetime']) {
        $query = 'UPDATE requests SET expired = 1 WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $request['id']);
        $stmt->execute();
        $requestcount++;
    }
}

echo $requestcount . ' Trades Cancelled. \n';

//Expire Old Penpals
$query = 'SELECT * FROM penpalRequests WHERE expired = 0';
$stmt = $pdo->prepare($query);
$stmt->execute();
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

$now = new DateTime('now', new DateTimezone('UTC'));
$result = $now->format('Y-m-d H:i:s');

$requestcount = 0;
foreach ($requests as $request) {
    if ($result > $request['expire']) {
        $query = 'UPDATE penpalRequests SET expired = 1 WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $request['id']);
        $stmt->execute();
        $requestcount++;
    }
}

echo $requestcount . ' Penpal Requests Cancelled. \n';

//Select New Kindness Store Items
$query = 'UPDATE kindnessShop SET daily = 0';
$stmt = $pdo->prepare($query);
$stmt->execute();

$query = 'SELECT * FROM kindnessShop WHERE name != "SewingKit" ORDER BY rand() LIMIT 7';
$stmt = $pdo->prepare($query);
$stmt->execute();
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);



foreach ($items as $kind) {
    $query = 'UPDATE kindnessShop SET daily = 1 WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $kind['id']);
    $stmt->execute();
}

$query = 'UPDATE kindnessShop SET daily = 1 WHERE name = "SewingKit"';
    $stmt = $pdo->prepare($query);
    $stmt->execute();

$query = 'DELETE FROM requests WHERE fulfilled = 1';
    $stmt = $pdo->prepare($query);
    $stmt->execute();

$query = 'DELETE FROM requests WHERE expired = 1';
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    echo "Rollover Finished!";

    $affirmstmt = null;
    $userstmt = null;
    $pdo = null;
    $stmt = null;
die();













