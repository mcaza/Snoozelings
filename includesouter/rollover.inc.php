 <?php
    require_once 'dbh-inc.php';
    $winner = 0;

    //Date Stuff
    $hours = 24;
    $now = new DateTime('now', new DateTimezone('UTC'));
    $modified = (clone $now)->add(new DateInterval("PT{$hours}H")); 
    $rotime = $modified->format('Y-m-d H:i:s');
    $hours = 5;
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
        $query = "UPDATE users SET affirmation = :affirmation, lastLog = 0, dailyPrize = 0, requests = 0 WHERE id = :id";
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
        if ($firstDate === $secondDate) {
            //Add Item
            $list = 111;
            $one = 1;
            $name = "FabricPurplePlaid";
            $display = "Fabric: Purple Plaid";
            $description = "Use this fabric as an applicator or breeding item. It changes the nose and ear insides of the snoozeling.";
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
            $message = 'Hey there ' . $user['username'] . ', 
            
            Here at Snoozelings, we know birthdays can sometimes be not so great. Sometimes friends and families fall through. Sometimes we just don\'t have anyone to spend the day with. Sometimes people just forget.
            
            That\'s why we want to send you a little gift on us. A birthday exclusive fabric for a snoozeling of your choice. Because we care.
            
            Please remember: You are loved, You are valued, You are worthy, You are enough.
            
            Happy birthday from all of us at Snoozelings <3
            
            ~Slothie';
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
    echo "Journal Entries Closed! \n";

    //Reset Daily Post
    $one = 1;
    $zero = 0;
    $query = "UPDATE posts SET new = :one WHERE new = :zero";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":one", $one);
    $stmt->bindParam(":zero", $zero);
    $stmt->execute();

    //Draw Raffle Winners
    $query = 'SELECT * FROM rafflecount ORDER BY id DESC LIMIT 1';
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $raffentries = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Grab 3 Newest Raffle ids
    $query = "SELECT * FROM raffles ORDER BY id DESC LIMIT 3";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $raffles = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Pick Winners for Raffles
if (intval($usercount['activeMembers']) > 2) {
    $array = [];
    array_push($array, $raffles[0]['id'], $raffles[1]['id'], $raffles[2]['id']);
    
        $entries = explode(" ", $raffentries['entries']);
        array_shift($entries);
    $count = 0;
    //unset($entriesone[0]);  
    //$entries = array_values($entriesone); 
    foreach ($array as $round) {
        //Pick Winner
            $num = count($entries) - 1;
            $rand = rand(0, $num);
            $winner = $entries[$rand];
        
        $query = 'UPDATE raffles SET winner = :winner WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":winner", $winner);
        $stmt->bindParam(":id", $round);
        $stmt->execute();
        
        //Get Item Info
        $query = 'SELECT * FROM itemList WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $raffles[$count]['list_id']);
        $stmt->execute();
        $item = $stmt->fetch(PDO::FETCH_ASSOC);
        
        //Give Item to Winner
        $query = "INSERT INTO items (list_id, user_id, name, display, description, type, rarity, canDonate) VALUES (:list, :user, :name, :display, :description, :type, :rarity, :canDonate);";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":list", $raffles[$count]['list_id']);
        $stmt->bindParam(":user", $winner);
        $stmt->bindParam(":name", $item['name']);
        $stmt->bindParam(":display", $item['display']);
        $stmt->bindParam(":description", $item['description']);
        $stmt->bindParam(":type", $item['type']);
        $stmt->bindParam(":rarity", $item['rarity']);
        $stmt->bindParam(":canDonate", $item['canDonate']);
        $stmt->execute();
    
        echo "Raffle Winner: " . $winner . "\n";
        //Remove Winner for Next Round
        $key = array_search($winner, $entries);
        unset($entries[$key]);
        $entries = array_values($entries);
        
        //Send Winner Mail
        $zero = 0;
        $one = 1;
        $title = "You Won the Daily Raffle!!!";
        $sender = 7;
        $zero = 0;
        $picture = "postmanNPC";
        $now = new DateTime('now', new DateTimezone('UTC'));
        $date = $now->format('Y-m-d H:i:s');
        $message = 'Hello there fellow snoozeling!!!
        
        I brought you something. I believe it\'s a raffle prize?
        
        Oh yes!!! It\'s a ' . $raffles[$count]['display'] . '!
        
        Maybe I\'ll win next time. I could really use a new hat.';
        $query = 'INSERT INTO mail (sender, reciever, title, message, sent, opened, sendtime, picture) VALUES (:sender, :reciever, :title, :message, :sent, :opened, :sendtime, :picture)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":sender", $sender);
        $stmt->bindParam(":reciever", $winner);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":message", $message);
        $stmt->bindParam(":sent", $one);
        $stmt->bindParam(":opened", $zero);
        $stmt->bindParam(":sendtime", $date);
        $stmt->bindParam(":picture", $picture);
        $stmt->execute();
        $count++;
        } 
    
    
    //Pick 3 New Prizes
    for ($i = 0; $i < 3; $i++) {
        $query = 'SELECT * FROM raffleitems';
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($items) {
            //Random Item
            $count = count($items) - 1;
            $rand = rand(0, $count);
            $tempwinner = 0;
            $query = 'INSERT INTO raffles (list_id, item, display, donator, winner) VALUES (:list, :name, :display, :donator, :winner)';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":list", $items[$rand]['list_id']);
            $stmt->bindParam(":name", $items[$rand]['item']);
            $stmt->bindParam(":display", $items[$rand]['display']);
            $stmt->bindParam(":donator", $items[$rand]['donator_id']);
            $stmt->bindParam(":winner", $tempwinner);
            $stmt->execute();
            
            echo "New Raffle Item: " . $items[$rand]['display'] . "\n";
            
            //Delete Item
            $query = 'DELETE FROM raffleitems WHERE id = :id AND donator_id = :user LIMIT 1';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $items[$rand]['id']);
            $stmt->bindParam(":user", $items[$rand]['donator_id']);
            $stmt->execute();
            
            //Give Coin
            $price = 1;
            $query = 'UPDATE users SET kindnessCount = kindnessCount + :price WHERE id = :id';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $items[$rand]['donator_id']);
            $stmt->bindParam(":price", $price);
            $stmt->execute();
            
            //Send Letter
            $zero = 0;
            $one = 1;
            $title = "You Recieved a Kindness Coin!!!";
            $sender = 8;
            $zero = 0;
            $picture = "kindnessNPC";
            $now = new DateTime('now', new DateTimezone('UTC'));
            $date = $now->format('Y-m-d H:i:s');
            $message = 'Guess what?!?!?
            
            An item you\'ve donated to the daily raffle has been randomly chosen. That means one lucky player will get a chance to win your item.
            
            Thank you so much for your contribution. It\'s donation like these that keep the kindness flowing.
            
            <i>One kindness coin has been added to your bank</i>';
            $query = 'INSERT INTO mail (sender, reciever, title, message, sent, opened, sendtime, picture) VALUES (:sender, :reciever, :title, :message, :sent, :opened, :sendtime, :picture)';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":sender", $sender);
            $stmt->bindParam(":reciever", $items[$rand]['donator_id']);
            $stmt->bindParam(":title", $title);
            $stmt->bindParam(":message", $message);
            $stmt->bindParam(":sent", $one);
            $stmt->bindParam(":opened", $zero);
            $stmt->bindParam(":sendtime", $date);
            $stmt->bindParam(":picture", $picture);
            $stmt->execute();
        } else {
            $one = 1;
            $query = 'SELECT * FROM itemList WHERE canDonate = :one';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":one", $one);
            $stmt->execute();
            $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $count = count($items) - 1;
            $rand = rand(0, $count);
            $query = 'INSERT INTO raffles (list_id, item, display, donator) VALUES (:list, :name, :display, :donator)';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":list", $items[$rand]['id']);
            $stmt->bindParam(":name", $items[$rand]['name']);
            $stmt->bindParam(":display", $items[$rand]['display']);
            $stmt->bindParam(":donator", $one);
            $stmt->execute();
            
            echo "New Raffle Item: " + $items[$rand]['display'] + "\n";
        }
    }
    
    //Set New Raffle Day
    $entries = "";
    $query = 'INSERT INTO rafflecount (entries) VALUE (:entries)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":entries", $entries);
    $stmt->execute();
    echo "Raffle Reset! \n";
} else {
    echo "Not Enough Users to Run Raffle. \n";
}

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

    
    echo "Rollover Finished!";

    $affirmstmt = null;
    $userstmt = null;
    $pdo = null;
    $stmt = null;
die();















