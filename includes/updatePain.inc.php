<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userId = $_SESSION['user_id'];
    
    //Get Newest Entry
    $query = 'SELECT id FROM chronicPainEntries WHERE user_id = :id ORDER BY id DESC LIMIT 1';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $id = $result['id'];
    
    //Form Updates
    if ($_POST["low"]) {
        $low = $_POST["low"];
        $query = "UPDATE chronicPainEntries SET lowestPain = :pain WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":pain", $low);
        $stmt->execute();
    }
    if ($_POST["high"]) {
        $high = $_POST["high"];
        $query = "UPDATE chronicPainEntries SET highestPain = :pain WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":pain", $high);
        $stmt->execute();
    }
    if ($_POST["avg"]) {
        $avg = $_POST["avg"];
        $query = "UPDATE chronicPainEntries SET averagePain = :pain WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":pain", $avg);
        $stmt->execute();
    }
        if ($_POST["location"]) {
        $location = $_POST["location"];
        $query = "UPDATE chronicPainEntries SET painLocation = :pain WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":pain", $location);
        $stmt->execute();
    }
    if ($_POST["sleep"]) {
        $sleep = $_POST["sleep"];
        $query = "UPDATE chronicPainEntries SET sleep = :pain WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":pain", $sleep);
        $stmt->execute();
    }
    if ($_POST["water"]) {
        $water = $_POST["water"];
        $query = "UPDATE chronicPainEntries SET water = :pain WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":pain", $water);
        $stmt->execute();
    }
    if ($_POST["activity"]) {
        $activity = $_POST["activity"];
        $query = "UPDATE chronicPainEntries SET physicalActivity = :pain WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":pain", $activity);
        $stmt->execute();
    }
    if ($_POST["weather"]) {
        $weather = $_POST["weather"];
        $query = "UPDATE chronicPainEntries SET weather = :pain WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":pain", $weather);
        $stmt->execute();
    }
    if ($_POST["air"]) {
        $air = $_POST["air"];
        $query = "UPDATE chronicPainEntries SET air = :pain WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":pain", $air);
        $stmt->execute();
    }
    if ($_POST["remedy"]) {
        $remedies = $_POST["remedy"];
        $query = "UPDATE chronicPainEntries SET remedies = :pain WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":pain", $remedies);
        $stmt->execute();
    }
    if ($_POST["notes"]) {
        $notes = $_POST["notes"];
        $query = "UPDATE chronicPainEntries SET otherNotes = :pain WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":pain", $notes);
        $stmt->execute();
    }
    
    //Update Description
    if ($_POST['swollen'] || $_POST['throbbing'] || $_POST['aching'] || $_POST['numb'] || $_POST['numb'] || $_POST['burning'] || $_POST['cramping'] || $_POST['tight'] || $_POST['tender'] || $_POST['shooting']) {
    $description = "";
    if ($_POST['swollen']) {
        $description .= "Swollen, ";
    }
    if ($_POST['throbbing']) {
        $description .= "Throbbing, ";
    }
    if ($_POST['aching']) {
        $description .= "Aching, ";
    }
    if ($_POST['numb']) {
        $description .= "Numb, ";
    }
    if ($_POST['burning']) {
        $description .= "Burning, ";
    }
    if ($_POST['cramping']) {
        $description .= "Cramping, ";
    }
    if ($_POST['tight']) {
        $description .= "Tight, ";
    }
    if ($_POST['tender']) {
        $description .= "Tender, ";
    }
    if ($_POST['shooting']) {
        $description .= "Shooting, ";
    }
    $description = substr($description, 0, -2);
        $query = "UPDATE chronicPainEntries SET painDescription = :description WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":description", $description);
        $stmt->execute();
    }
    
    if ($_POST['exhaustion'] || $_POST['nausea'] || $_POST['vomit'] || $_POST['poops'] || $_POST['throat'] || $_POST['insomnia'] || $_POST['bloating'] || $_POST['fever'] || $_POST['chills'] || $_POST['congestion'] || $_POST['muscle'] || $_POST['fog'] || $_POST['badmood'] || $_POST['vertigo']) {
    //Symptoms
    $symptoms = "";
    if ($_POST['exhaustion']) {
        $symptoms .= "Exhaustion, ";
    }
    if ($_POST['nausea']) {
        $symptoms .= "Nausea, ";
    }
    if ($_POST['vomit']) {
        $symptoms .= "Vomiting, ";
    }
    if ($_POST['poops']) {
        $symptoms .= "Bad Poops, ";
    }
    if ($_POST['throat']) {
        $symptoms .= "Sore Throat, ";
    }
    if ($_POST['insomnia']) {
        $symptoms .= "Insomnia, ";
    }
    if ($_POST['bloating']) {
        $symptoms .= "Bloating, ";
    }
    if ($_POST['fever']) {
        $symptoms .= "Fever, ";
    }
    $symptoms = "";
    if ($_POST['chills']) {
        $symptoms .= "Chills, ";
    }
    if ($_POST['congestion']) {
        $symptoms .= "Congestion, ";
    }
    if ($_POST['muscle']) {
        $symptoms .= "Muscle Spasms, ";
    }
    if ($_POST['fog']) {
        $symptoms .= "Brain Fog, ";
    }
    if ($_POST['badmood']) {
        $symptoms .= "Bad Mood, ";
    }
        if ($_POST['vertigo']) {
        $symptoms .= "Vertigo, ";
    }
    $symptoms = substr($symptoms, 0, -2);
        
    $symptoms = substr($symptoms, 0, -2);
        $description = substr($description, 0, -2);
        $query = "UPDATE chronicPainEntries SET otherSymptoms = :symptoms WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":symptoms", $symptoms);
        $stmt->execute();
    }
    
    if($_POST['meds']) {
        $meds = $_POST['meds'];
        $query = "UPDATE mentalHealthEntries SET missedMeds = :meds WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":meds", $meds);
        $stmt->execute();
    } 

    //Set Session for Coins
    $_SESSION['finish'] = 2;
    
    header("Location: ../journal");
    
} else {
    header("Location: ../journal");
}













