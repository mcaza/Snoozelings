<?php

//Get all Journals
$input = "productivity";
$query = 'SELECT id FROM journals WHERE type = :input';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":input", $input);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($results as $result) {
    //Send Letter
            $zero = 0;
            $one = 1;
            $title = "Productivity Journal Notice";
            $sender = 1;
            $zero = 0;
            $now = new DateTime("now", new DateTimezone('UTC'));
            $date = $now->format('Y-m-d H:i:s');
            $message = 'Hey there ' . $user['username'] . ', 
            
            You are receiving this message because you have the Productivity journal type.
            
            Due to a bug on September 1st, some data was not properly saved. This only affected the Sunday only data such as setting Habit 1, setting Habit 2, Weekly Wins, Weekly Losses, and What I Learned this week.
            
            The data is not recoverable at this time.
            
            To fix this, we have set the Sunday boxes to be available today only - Monday September 2nd. After today, it will go back to showing only on Sunday.
            
            If you haven\'t filled out your journal yet today, it should be there when you do your New Journal Entry page.
            
            If you have filled out your journal today, it should now appear in your Edit Journal page.
            
            ~Lead Developer Slothie';
            $query = 'INSERT INTO mail (sender, reciever, title, message, sent, opened, sendtime) VALUES (:sender, :reciever, :title, :message, :sent, :opened, :sendtime)';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":sender", $sender);
            $stmt->bindParam(":reciever", $result["user_id"]);
            $stmt->bindParam(":title", $title);
            $stmt->bindParam(":message", $message);
            $stmt->bindParam(":sent", $one);
            $stmt->bindParam(":opened", $zero);
            $stmt->bindParam(":sendtime", $date);
            $stmt->execute();
}

