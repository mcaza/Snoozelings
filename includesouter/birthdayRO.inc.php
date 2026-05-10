 <?php
    require_once 'dbh-inc.php';

    //Grab Current Date
    $query = 'SELECT * FROM times';
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $times = $stmt->fetch(PDO::FETCH_ASSOC);
    $now = new DateTime($times['mailone']);
    
    //Birthday Gifts
    $query = 'SELECT * FROM birthdayGifts';
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $gifts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //Plushie & Birthday Array
    $plushies = [384,385,386,387,388,389,390,391,392,393,394,395,396,397,398,399,400,401,402,403,404,405,406,407,408,409,410,411,412,413,419,422,423,438];
    $today = [];
        
    //Birthday Check
    $query = "SELECT * FROM users";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $birthdays = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($birthdays as $user) {
        $firstDate = $now->format('m-d');
        $secondDate = substr($user['birthdate'], 5);
        if ($firstDate == $secondDate) {
            array_push($today,$user['id']);
        }
    }

    echo 'Today\'s Birthdays: ' . var_dump($today);

    foreach ($today as $bd) {
        //Random Plush Gift
        $plush = count($plushies) - 1;
        $num = rand(0,$plush);
        
        $query = 'SELECT * FROM itemList WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $plushies[$num]);
        $stmt->execute();
        $iteminfo = $stmt->fetch(PDO::FETCH_ASSOC);
        
        //Get User Status
        $query = 'SELECT * FROM users WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $bd);
        $stmt->execute();
        $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);
        
        //Add Plushie to Items
        $query = "INSERT INTO items (list_id, user_id, name, display, description, type, rarity, canDonate) VALUES (:list, :user, :name, :display, :description, :type, :rarity, :canDonate);";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":list", $iteminfo['id']);
        $stmt->bindParam(":user", $bd);
        $stmt->bindParam(":name", $iteminfo['name']);
        $stmt->bindParam(":display", $iteminfo['display']);
        $stmt->bindParam(":description", $iteminfo['description']);
        $stmt->bindParam(":type", $iteminfo['type']);
        $stmt->bindParam(":rarity", $iteminfo['rarity']);
        $stmt->bindParam(":canDonate", $iteminfo['canDonate']);
        $stmt->execute();
        
        //Letter
        $sender = 1;
        $zero = 0;
        $one = 1;
        $title = "Happy Birthday " . $userInfo['username'] . '!';
        $now = new DateTime("now", new DateTimezone('UTC'));
        $date = $now->format('Y-m-d H:i:s');
        $message = 'Hey there ' . $userInfo['username'] . ', 
            
            Here at Snoozelings, we know birthdays can sometimes be not so great. Sometimes friends and families fall through. Sometimes we just don\'t have anyone to spend the day with. Sometimes people just forget.
            
            That\'s why we want to send you a little gift on us. A random plushie for your snoozeling to cuddle - a cute little ' . $iteminfo['display'] . '. Because we care about you.
            
            You may also find some birthday gifts from other users appearing in your mailbox in the next few minutes. Our community is very kind and generous.
            
            Please remember: You are loved, You are valued, You are worthy, You are enough.
            
            Happy birthday from all of us at Snoozelings <3
            
            ~Slothie';
        $query = 'INSERT INTO mail (sender, reciever, title, message, sent, opened, sendtime) VALUES (:sender, :reciever, :title, :message, :sent, :opened, :sendtime)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":sender", $sender);
        $stmt->bindParam(":reciever", $bd);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":message", $message);
        $stmt->bindParam(":sent", $one);
        $stmt->bindParam(":opened", $zero);
        $stmt->bindParam(":sendtime", $date);
        $stmt->execute(); 
        
        //Send User Presents
        if ($userInfo['birthdayOptOut'] == 0) {
            $giftList = [];
            $names = [];
            $gifters = [];
            foreach ($gifts as $gift) {
                if ($bd == $gift['giftee']) {
                    array_push($giftList,$gift['list_id']);
                    array_push($names,$gift['display']);
                    array_push($gifters,$gift['gifter']);
                    
                    $query = 'SELECT * FROM itemList WHERE id = :id';
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(":id", $gift['list_id']);
                    $stmt->execute();
                    $iteminfo = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    //Add Item to Inventory
                    if ($gift['dye']) {
                        $query = "INSERT INTO items (list_id, user_id, name, display, description, type, rarity, canDonate, dye) VALUES (:list, :user, :name, :display, :description, :type, :rarity, :canDonate, :dye);";
                    } else {
                        $query = "INSERT INTO items (list_id, user_id, name, display, description, type, rarity, canDonate) VALUES (:list, :user, :name, :display, :description, :type, :rarity, :canDonate);";
                    }

                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(":list", $gift['list_id']);
                    $stmt->bindParam(":user", $gift['giftee']);
                    $stmt->bindParam(":name", $iteminfo['name']);
                    $stmt->bindParam(":display", $iteminfo['display']);
                    $stmt->bindParam(":description", $iteminfo['description']);
                    $stmt->bindParam(":type", $iteminfo['type']);
                    $stmt->bindParam(":rarity", $iteminfo['rarity']);
                    $stmt->bindParam(":canDonate", $iteminfo['canDonate']);
                    if ($gift['dye']) {
                        $stmt->bindParam(":dye", $gift['dye']);
                    }
                    $stmt->execute();
                }
            }
            
            //Send Letter with Gifts
            $sender = 1;
            $zero = 0;
            $one = 1;
            $title = 'More Birthday Gifts for you!';
            $now = new DateTime("now", new DateTimezone('UTC'));
            $date = $now->format('Y-m-d H:i:s');
            $message = 'Hi again ' . $userInfo['username'] . '. It\'s Mayor Cocoa again!! 

                I\'m back to deliver even more birthday gifts.
                
                These ones are from other users that wanted to give you something special today.
                
                The following items have been added to your account:<br><br>';
            $count = 0;
            foreach ($giftList as $line) {
                $query = 'SELECT * FROM users WHERE id = :id';
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":id", $gifters[$count]);
                $stmt->execute();
                $gifterInfo = $stmt->fetch(PDO::FETCH_ASSOC);
                $message = $message . "\u{2665} " . $names[$count] . ' from <a href="profile?id=' . $gifterInfo['id'] . '">' . $gifterInfo['username'] . '</a><br><br>';
                $count++;
            }

            $message = $message . '<br>   ~Slothie';
            $query = 'INSERT INTO mail (sender, reciever, title, message, sent, opened, sendtime) VALUES (:sender, :reciever, :title, :message, :sent, :opened, :sendtime)';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":sender", $sender);
            $stmt->bindParam(":reciever", $bd);
            $stmt->bindParam(":title", $title);
            $stmt->bindParam(":message", $message);
            $stmt->bindParam(":sent", $one);
            $stmt->bindParam(":opened", $zero);
            $stmt->bindParam(":sendtime", $date);
            $stmt->execute();
        }
        
        //Delete all User Presents
        $query = 'DELETE FROM birthdayGifts WHERE giftee = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $bd);
        $stmt->execute();
        
    }
