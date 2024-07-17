<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") { 
    $userId = $_SESSION['user_id'];
    $id = $_POST['request'];
    
    //Get Request Information
    $query = "SELECT * FROM requests WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $request = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Check that Ticket isn't closed or fulfilled
    if ($request['fulfilled'] == 1 || $request['expired'] == 1) {
        header("Location: ../requests");
    }
    
    //Check that user has the item (and dye = NULL)
    $query = "SELECT * FROM items WHERE list_id = :item AND user_id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":item", $request['item_id']);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $check = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $plaincheck = 0;
    foreach ($check as $dyecheck) {
        if ($dyecheck['dye']) {
        
        } else {
            $plaincheck = 1;
            $itemid = $dyecheck['id'];
            break;
        }
    }
    
    if (($check && $plaincheck == 1)) {
        
    } else {
        header("Location: ../requests");
    }
     
    //Switch item to new user_id. Be sure to not use a dyed version.
    $query = "UPDATE items SET user_id = :user WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user", $request['user_id']);
    $stmt->bindParam(":id", $itemid);
    $stmt->execute();
    
    //Mark Request Fulfilled
    $query = "UPDATE requests SET fulfilled = 1 WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    
    //Add Points to User
    $query = "SELECT * FROM users WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $points = intval($user['requestPoints']) + intval($request['points']);
    
    //Check if points are 10. If so, reward kindness coin and subtract 10
    if ($points > 9) {
        $kindness = intval($user['kindnessCount']) + 1;
        $new = $points - 10;
        $query = "UPDATE users SET kindnessCount = :kindness, requestPoints = :points WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":kindness", $kindness);
        $stmt->bindParam(":points", $new);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
        $_SESSION['reply'] = "Request Fulfilled. You have also recieved a Kindness Coin";
        
        //Increase Daily Records +1
        $query = 'UPDATE dailyRecords SET requestsFilled = requestsFilled + 1, kindnessCoins = kindnesscoins + 1 ORDER BY id DESC LIMIT 1';
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    } else {
        $query = "UPDATE users SET requestPoints = :points WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":points", $points);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
        $_SESSION['reply'] = "Request Successfully Fulfilled";
        
        //Increase Daily Records +1
        $query = 'UPDATE dailyRecords SET requestsFilled = requestsFilled + 1 ORDER BY id DESC LIMIT 1';
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    }
    
    //Update +1 to User Records
    $query = 'UPDATE users SET requestsFilled = requestsFilled + 1 WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    
    //Send Mail
    
    $message = "Great news for you!!
    
    Your request for " . $check['display'] . " has been fulfilled.
    
    It has been added to your inventory.
    
    Also sorry if it has slobber on it. I don't have hands.
    
    ~Simon";

    $title = "Your request has been fulfilled!";
    $from = 7;
    $one = 1;
    $zero = 0;
    $now = new DateTime('now');
    $date = $now->format('Y-m-d H:i:s');
    $query = "INSERT INTO mail (sender, reciever, title, message, sent, opened, sendtime) VALUES (:from, :to, :title, :message, :sent, :opened, :datetime)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":from", $from);
    $stmt->bindParam(":to", $request['user_id']);
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":message", $message);
    $stmt->bindParam(":sent", $one);
    $stmt->bindParam(":opened", $zero);
    $stmt->bindParam(":datetime", $date);
    $stmt->execute();
    
    //Redirect
    header("Location: ../requests");
    
    
} else {
     header("Location: ../index");
}

