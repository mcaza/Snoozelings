 <?php
    require_once '../includes/dbh-inc.php';

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
    $array = [];
    array_push($array, $raffles[0]['id'], $raffles[1]['id'], $raffles[2]['id']);
    if(strlen($raffentries['entries']) === 0) {
        $entries = 0;
    } else {
        $entries = explode(" ", $raffentries['entries']);
        array_shift($entries);
    }

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
        $now = new DateTime(null, new DateTimezone('UTC'));
        $date = $now->format('Y-m-d H:i:s');
        $message = 'Hello there fellow snoozeling!!!
        
        I brought you something. I believe it\'s a raffle prize?
        
        Hmmmm... Yes yes. It\'s a ' . $raffles[$count]['display'] . '!
        
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
            $query = 'INSERT INTO raffles (list_id, item, display, donator) VALUES (:list, :name, :display, :donator)';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":list", $items[$rand]['list_id']);
            $stmt->bindParam(":name", $items[$rand]['item']);
            $stmt->bindParam(":display", $items[$rand]['display']);
            $stmt->bindParam(":donator", $items[$rand]['donator_id']);
            $stmt->execute();
            
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
            $now = new DateTime(null, new DateTimezone('UTC'));
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
        }
    }

    //Set New Raffle Day
    $entries = "";
    $query = 'INSERT INTO rafflecount (entries) VALUE (:entries)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":entries", $entries);
    $stmt->execute();