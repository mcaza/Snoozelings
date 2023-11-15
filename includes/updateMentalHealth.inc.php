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
    if ($_POST["anxiety"]) {
        $anxiety = $_POST["anxiety"];
        $query = "UPDATE mentalHealthEntries SET anxiety = :pain WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":pain", $anxiety);
        $stmt->execute();
    }
    if ($_POST["depression"]) {
        $depression = $_POST["depression"];
        $query = "UPDATE mentalHealthEntries SET depression = :pain WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":pain", $depression);
        $stmt->execute();
    }
    if ($_POST["stress"]) {
        $stress = $_POST["stress"];
        $query = "UPDATE mentalHealthEntries SET stress = :pain WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":pain", $stress);
        $stmt->execute();
    }
    if ($_POST["productivity"]) {
        $produce = $_POST["productivity"];
        $query = "UPDATE mentalHealthEntries SET productivity = :pain WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":pain", $produce);
        $stmt->execute();
    }
    if ($_POST["health"]) {
        $health = $_POST["health"];
        $query = "UPDATE mentalHealthEntries SET physicalHealth = :pain WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":pain", $health);
        $stmt->execute();
    }
    if ($_POST["sleep"]) {
        $sleep = $_POST["sleep"];
        $query = "UPDATE mentalHealthEntries SET sleep = :pain WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":pain", $sleep);
        $stmt->execute();
    }
    if ($_POST["water"]) {
        $water = $_POST["water"];
        $query = "UPDATE mentalHealthEntries SET water = :pain WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":pain", $water);
        $stmt->execute();
    }
    if ($_POST["triggers"]) {
        $triggers = $_POST["triggers"];
        $query = "UPDATE mentalHealthEntries SET triggers = :pain WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":pain", $triggers);
        $stmt->execute();
    }
    if ($_POST["notes"]) {
        $notes = $_POST["notes"];
        $query = "UPDATE mentalHealthEntries SET notes = :pain WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":pain", $notes);
        $stmt->execute();
    }

    if ($_POST['eat'] || $_POST['washed'] || $_POST['teeth'] || $_POST['chore'] || $_POST['walk'] || $_POST['excercise'] || $_POST['talk'] || $_POST['creative'] || $_POST['therapy']) {
    //Good Behaviours
    $good = "";
    if ($_POST['eat']) {
        $good .= "Ate a Meal, ";
    }
    if ($_POST['washed']) {
        $good .= "Showered/Bathed , ";
    }
    if ($_POST['teeth']) {
        $good .= "Brushed Teeth, ";
    }
    if ($_POST['chore']) {
        $good .= "Did a Chore, ";
    }
    if ($_POST['walk']) {
        $good .= "Went for a Walk, ";
    }
    if ($_POST['excercise']) {
        $good .= "Did Some Excercise, ";
    }
    if ($_POST['talk']) {
        $good .= "Talked to Friends/Family, ";
    }
    if ($_POST['creative']) {
        $good .= "Made Some Art, ";
    }
    if ($_POST['therapy']) {
        $good .= "Had a Therapy Session, ";
    }
    $good = substr($good, 0, -2);
        $query = "UPDATE mentalHealthEntries SET productive = :good WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":good", $good);
        $stmt->execute();
    }
    
    if ($_POST['doomscroll'] || $_POST['angry'] || $_POST['alone'] || $_POST['skip'] || $_POST['shop'] || $_POST['damage'] || $_POST['hurt']) {
    //Bad Behaviours
    $bad = "";
    if ($_POST['doomscroll']) {
        $bad .= "Doomscrolled, ";
    }
    if ($_POST['angry']) {
        $bad .= "Lashed Out at Others, ";
    }
    if ($_POST['alone']) {
        $bad .= "Isolated Myself, ";
    }
    if ($_POST['skip']) {
        $bad .= "Stayed Home from School/Work, ";
    }
    if ($_POST['shop']) {
        $bad .= "Spent Recklessly, ";
    }
    if ($_POST['damage']) {
        $bad .= "Picked at my Body, ";
    }
    if ($_POST['hurt']) {
        $bad .= "Hurt Myself, ";
    }
    $bad = substr($bad, 0, -2);
        $query = "UPDATE mentalHealthEntries SET destructive = :bad WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":bad", $bad);
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
        
    

    //SPop Up
    $_SESSION['finish'] = 2;
    
    header("Location: ../journal");
    
} else {
    header("Location: ../journal");
}













