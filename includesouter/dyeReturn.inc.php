 <?php
    require_once 'dbh-inc.php';
    
//Grab all Users
$query = "SELECT * FROM users";
$stmt = $pdo->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Grab all Dyes
$type = "dye";
$query = 'SELECT * FROM itemList WHERE type = :type';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":type", $type);
$stmt->execute();
$dyes = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($users as $user) {
    $coins = 0;
    
    //Grab Dyes from Raffle
    $query = 'SELECT * FROM raffleitems WHERE donator_id = :id AND item LIKE "%Dye%"';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $user['id']);
    $stmt->execute();
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($items as $dye) {
        if ($dye['item'] == "YellowDye") {
            $coins = $coins + 12;
        }
        if ($dye['item'] == "OrangeDye") {
            $coins = $coins + 12;
        }
        if ($dye['item'] == "RedDye") {
            $coins = $coins + 29;
        }
        if ($dye['item'] == "GreenDye") {
            $coins = $coins + 18;
        }
        if ($dye['item'] == "BlueDye") {
            $coins = $coins + 18;
        }
        if ($dye['item'] == "BrownDye") {
            $coins = $coins + 60;
        }
        if ($dye['item'] == "BlackDye") {
            $coins = $coins + 24;
        }
        if ($dye['item'] == "PinkDye") {
            $coins = $coins + 18;
        }
        if ($dye['item'] == "PurpleDye") {
            $coins = $coins + 78;
        }
        if ($dye['item'] == "PastelBrownDye") {
            $coins = $coins + 78;
        }
        if ($dye['item'] == "PastelPinkDye") {
            $coins = $coins + 36;
        }
        if ($dye['item'] == "PastelPurpleDye") {
            $coins = $coins + 68;
        }
        if ($dye['item'] == "PastelBlueDye") {
            $coins = $coins + 36;
        }
        if ($dye['item'] == "GooseberryDye") {
            $coins = $coins + 14;
        }
        if ($dye['item'] == "BlueberryDye") {
            $coins = $coins + 14;
        }
        if ($dye['item'] == "TealDye") {
            $coins = $coins + 50;
        }
        if ($dye['item'] == "WhiteDye") {
            $coins = $coins + 24;
        }
        if ($dye['item'] == "GreyDye") {
            $coins = $coins + 50;
        }
        
    }

    //Add Coins to User
    $coinCount = $user['coinCount'] + $coins;
    $query = "UPDATE users SET coinCount = :coins WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $user['id']);
    $stmt->bindParam(":coins", $coinCount);
    $stmt->execute();
    
    if ($coins) {
        //Send Letter
        $title = "Raffle Dye Coins Added";
        $s = "";
        $message = "As part of our improvements to Early Acces, we have decided to remove all single color dyes from the Raffle Item Pool.

        In our next update, these items will be able to be sold for Snooze Coins in a feature we call the Flea Market. We hope this change will help users earn more coins to help them earn more Pet Beds, while also keeping the pool of items in the daily raffle more exciting. 
        
        Multi color dyes such as Pride Dyes and Spooky Dyes can still be donated to the raffle. You can also still request single color dyes through the Request Board.
        
        Because you had dyes donated to the Daily Raffle, we are deleting the items from the raffle pool and sending you snooze coins. The value of the coins matches the value if you were to sell all the items at the Flea Markets. This way you can use the coins to buy yourself something special.
        
        <b>Coins Added To Account: </b>" . $coins . '
        
        Thank you so much for your patience as our little game grows and evolves.
        
        ~Slothie';
        $from = 1;
        $zero = 1;
        $a = 0;
        $now = new DateTime();
        $date = $now->format('Y-m-d H:i:s');
        $query = 'INSERT INTO mail (sender, reciever, title, message, sent, opened, sendtime) VALUES (:sender, :reciever, :title, :message, :sent, :opened, :sendtime)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":sender", $from);
        $stmt->bindParam(":reciever", $user['id']);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":message", $message);
        $stmt->bindParam(":sent", $zero);
        $stmt->bindParam(":opened", $a);
        $stmt->bindParam(":sendtime", $date);
        $stmt->execute();
    }
    
    //Delete Dyes
    $query = 'DELETE FROM raffleitems WHERE donator_id = :id AND item LIKE "%Dye%"';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $user['id']);
    $stmt->execute();
}



