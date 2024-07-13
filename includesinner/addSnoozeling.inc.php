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
        $query = 'SELECT inspire FROM snoozelings WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $parent);
        $stmt->execute();
        $inspire = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $add = ' ' . $newsnooze['id'];
        $temp = $inspire .= $add;
        $temp = trim($temp);
        
        $query = 'UPDATE snoozelings SET inspire = :inspire WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $parent);
        $stmt->bindParam(":inspire", $temp);
        $stmt->execute();
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