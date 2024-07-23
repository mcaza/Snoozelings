<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $id = $_POST["id"];
    $pronouns = $_POST["pronouns"];
    $userId = $_SESSION['user_id'];
    $todaysDate = date("Y-m-d");
    $job = "jack";
    $mood = "Happy";
    $breedStatus = "Closed";
    $title = "The New One";
    $bed = "BlueFree";
    
    $query = "SELECT * FROM blueprints WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $query = "INSERT INTO snoozelings (owner_id, mainColor, hairColor, tailColor, eyeColor, noseColor, hairType, tailType, specials, name, pronouns, birthDate, job, mood, breedStatus, title, bedcolor) VALUES (:owner_id, :mainColor, :hairColor, :tailColor, :eyeColor, :noseColor, :hairType, :tailType, :specials, :name, :pronouns, :birthDate, :job, :mood, :breedStatus, :title, :bed);";
    $stmt = $pdo->prepare($query);
    
    $stmt->bindParam(":owner_id", $userId);
    $stmt->bindParam(":mainColor", $result["mainColor"]);
    $stmt->bindParam(":hairColor", $result["hairColor"]);
    $stmt->bindParam(":tailColor", $result["tailColor"]);
    $stmt->bindParam(":eyeColor", $result["eyeColor"]);
    $stmt->bindParam(":noseColor", $result["noseColor"]);
    $stmt->bindParam(":hairType", $result["hairType"]);
    $stmt->bindParam(":tailType", $result["tailType"]);
    $stmt->bindParam(":specials", $result["specials"]);
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":pronouns", $pronouns);
    $stmt->bindParam(":birthDate", $todaysDate);
    $stmt->bindParam(":job", $job);
    $stmt->bindParam(":mood", $mood);
    $stmt->bindParam(":breedStatus", $breedStatus);
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":bed", $bed);
    $stmt->execute(); 
    
    //Get Breeding Parents
    $query = 'SELECT * FROM breedings WHERE blueprint = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $breeding = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Get New Snooze ID
    $query = 'SELECT * FROM snoozelings ORDER BY id DESC LIMIT 1';
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $newsnooze = $stmt->fetch(PDO::FETCH_ASSOC);
    
    
    
    //Add to Parent's Inspire
    $parents = [];
    array_push($parents, $breeding['one'], $breeding['two']);
    foreach ($parents as $parent) {
        $query = 'SELECT * FROM snoozelings WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $parent);
        $stmt->execute();
        $inspire = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $add = ' ' . $newsnooze['id'];
        $temp = $inspire['inspire'] .= $add;
        $temp = trim($temp);

        $query = 'UPDATE snoozelings SET inspire = :inspire WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $parent);
        $stmt->bindParam(":inspire", $temp);
        $stmt->execute();

        
        if ($inspire['owner_id'] == $userId) {
            
        } else {
            //Message
        if ($pronouns == "Any" || $pronouns == "They/Them" || $pronouns == "She/Them" || $pronouns == "He/Them") {
            $message = 'You\'re snoozeling has been used as inspiration!!!

            Their name is ' . $name . ' and their pronouns are ' . $pronouns . '.

            <strong style="font-size: 2.5rem"><a href="pet?id=' . $newsnooze['id'] . '">Click Here to View Them</a></strong>';
        } else if ($pronouns == "She/Her") {
              $message = 'You\'re snoozeling has been used as inspiration!!!

            Her name is ' . $name . ' and her pronouns are ' . $pronouns . '.

            <strong style="font-size: 2.5rem"><a href="pet?id=' . $newsnooze['id'] . '">Click Here to View Her</a></strong>';  
        } else if ($pronouns == "He/Him") {
               $message = 'You\'re snoozeling has been used as inspiration!!!

            His name is ' . $name . ' and his pronouns are ' . $pronouns . '.

            <strong style="font-size: 2.5rem"><a href="pet?id=' . $newsnooze['id'] . '">Click Here to View Him</a></strong>'; 
        } else {
            $message = 'You\'re snoozeling has been used as inspiration!!!

            Their name is ' . $name . ' and their pronouns are ' . $pronouns . '.

            <strong style="font-size: 2.5rem"><a href="pet?id=' . $newsnooze['id'] . '">Click Here to View Them</a></strong>'; 
            }
            
            //Send Mail to Owner
            $title = 'Notice of Inspiration';
            $sender = 6;
            $zero = 0;
            $picture = "sewingNPC";
            $now = new DateTime();
            $date = $now->format('Y-m-d H:i:s');


            $query = 'INSERT INTO mail (sender, reciever, title, message, sent, opened, sendtime, picture) VALUES (:sender, :reciever, :title, :message, :sent, :opened, :sendtime, :picture)';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":sender", $sender);
            $stmt->bindParam(":reciever", $inspire['owner_id']);
            $stmt->bindParam(":title", $title);
            $stmt->bindParam(":message", $message);
            $stmt->bindParam(":sent", $zero);
            $stmt->bindParam(":opened", $zero);
            $stmt->bindParam(":sendtime", $date);
            $stmt->bindParam(":picture", $picture);
            $stmt->execute();
        }
        
        
    }
    
    //Delete Blueprints 
    $query = "DELETE FROM blueprints WHERE owner_id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    
    //Mark Breeding Completed
    $one = 1;
    $query = 'UPDATE breedings SET completed = :one WHERE user_id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":one", $one);
    $stmt->execute();
    
    //Increase Daily Records +1
    $query = 'UPDATE dailyRecords SET snoozelingsCrafted = snoozelingsCrafted + 1 ORDER BY id DESC LIMIT 1';
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    //Increase User Records +1
    $query = 'UPDATE users SET snoozelingsCrafted = snoozelingsCrafted + 1 WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    
    //Reroute 
    $_SESSION['reply'] = 'Thanks again! ' . $name . ' is so excited to be home.';
    header("Location: ../stitcher?page=new");
    
} else {
    header("Location: ../index.php");
}