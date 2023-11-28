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
    
    //Delete Blueprints 
    $query = "DELETE FROM blueprints WHERE owner_id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    
    //Mark Breeding Completes
    $one = 1;
    $query = 'UPDATE breedings SET completed = :one WHERE user_id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":one", $one);
    $stmt->execute();
    
    //Reroute 
    $_SESSION['reply'] = 'Thanks again! ' . $name . ' is so excited to be home.';
    header("Location: ../stitcher?page=new");
    
} else {
    header("Location: ../index.php");
}