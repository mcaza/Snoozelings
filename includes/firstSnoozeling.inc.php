<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $name = $_POST["name"];
    $id = $_POST["snoozeling"];
    $pronouns = $_POST["pronouns"];
    $userId = $_SESSION['user_id'];
    $todaysDate = date("Y-m-d");
    $job = "jack";
    $mood = "Happy";
    $breedStatus = "Closed";
    $title = "The New";
    
    $query = "SELECT * FROM blueprints WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    
   $query = "INSERT INTO snoozelings (owner_id, mainColor, hairColor, tailColor, eyeColor, noseColor, hairType, tailType, specials, name, pronouns, birthDate, job, mood, breedStatus, title) VALUES (:owner_id, :mainColor, :hairColor, :tailColor, :eyeColor, :noseColor, :hairType, :tailType, :specials, :name, :pronouns, :birthDate, :job, :mood, :breedStatus, :title);";
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

    $stmt->execute(); 
    
    $query = "DELETE FROM blueprints WHERE owner_id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();    
    
    $query = "SELECT id FROM snoozelings WHERE owner_id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $newId = $result["id"];
    
    $query = "UPDATE users SET bonded = :id WHERE id = :userId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $newId);
    $stmt->bindParam(":userId", $userId);
    $stmt->execute();
    
    $number = 1;
    $query = "UPDATE users SET snoozelingsCrafted = :number WHERE id = :userId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":number", $number);
    $stmt->bindParam(":userId", $userId);
    $stmt->execute();
    
    //Add 2 Farms to Account
    $round = 2;
    for ($i = 0; $i < $round; $i++) {
        $query = 'INSERT farms (user_id) VALUES (:id)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
    }
    
    $_SESSION['bonded'] = htmlspecialchars($name);
    
    header("Location: ../pet?ID=" . $result["id"]);
    
    
} else {
    header("Location: ../index.php");
}