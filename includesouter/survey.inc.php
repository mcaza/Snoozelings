<?php

    require_once 'dbh-inc.php';


//Grab All Users
$one = "1";
$zero = "0";
$query = "SELECT * FROM users";
$stmt = $pdo->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($users as $user) {
    //Send Letter
    $zero = 0;
    $one = 1;
    $title = "Quick Survey";
    $sender = 1;
    $zero = 0;
    $now = new DateTime("now", new DateTimezone('UTC'));
    $date = $now->format('Y-m-d H:i:s');
    if ($user['birthdayOptOut'] == 0) {
        $message = 'Hey there ' . $user['username'] . '! 
            
        This is a letter from Slothie: Lead developer of Snoozelings.
        
        As part of our enamel pin expansion in 2025, we have prepared some adorable new designs that we are very excited to show our members.
        
        Which brings us to the real problem. We have too many cute designs!!
        
        To find out which designs users are most interested in, we are sending a survey link to all registered users.
        
        Please fill this out as soon as possible. Everyone that does will receive 1 Kindness Token as thanks. The survey will close in 2 days / 48ish Hours.
        
        <b><i>(Kindness Tokens will be sent by hand and might take some time to arrive. If you choose to remain anonymous, you will NOT receive a kindness coin.)</i></b>
        
        <a href="https://forms.gle/hfj7Nsh5KmPsb1D79">Click Here to Fill Out the Survey</a>
        
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
}