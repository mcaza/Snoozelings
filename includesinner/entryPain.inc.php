<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userId = $_COOKIE['user_id'];
    
    //Get Journal Id
    $query = 'SELECT id FROM journals WHERE user_id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $closed = 0;
    
    //Get Date
    $query = 'SELECT * FROM times';
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $times = $stmt->fetch(PDO::FETCH_ASSOC);
    $future_date2 = new DateTime($times['mailone']);
    $formatted = $future_date2->format('Y-m-d');
    
    //Grab Form Variables
    $low = $_POST["low"];
    $high = $_POST["high"];
    $avg = $_POST["avg"];
    $location = $_POST["location"];
    $sleep = $_POST["sleep"];
    $water = $_POST["water"];
    $activity = $_POST['activity'];
    $weather = $_POST['weather'];
    $air = $_POST['air'];
    $remedy = $_POST['remedy'];
    $notes = $_POST['notes'];
    
    //Custom Variable Checks
    if ($low > 10 || $low < 1) {
        header("Location: ../index");
            die();
    }
    if ($high > 10 || $high < 1) {
        header("Location: ../index");
            die();
    }
    if ($avg > 10 || $avg < 1) {
        header("Location: ../index");
            die();
    }
    if ($sleep > 10 || $sleep < 1) {
        header("Location: ../index");
            die();
    }
    if ($water > 10 || $water < 1) {
        header("Location: ../index");
            die();
    }
    if ($activity > 10 || $activity < 1) {
        header("Location: ../index");
            die();
    }
    if (!($weather === "Frozen" || $weather === "Cold" || $weather === "Mild" || $weather === "Hot" || $weather === "Wet" || $weather === "Dry")) {
        header("Location: ../index");
            die();
    }
    if (!($air === "Sickly" || $air === "Bad" || $air === "Fine" || $air === "Good")) {
        header("Location: ../index");
            die();
    }
    
    //Description
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
    
    if($_POST['meds']) {
        $meds = $_POST['meds'];
    } else {
        $meds = "Took all my meds";
    }

    
    //Insert Journal Into Chart
    $query = 'INSERT INTO chronicPainEntries (user_id, journal_id, date, closed, lowestPain, highestPain, averagePain, painLocation, painDescription, otherSymptoms, weather, air, sleep, water, physicalActivity, missedMeds, remedies, otherNotes) VALUES (:id, :journal, :date, :closed, :lowestPain, :highestPain, :averagePain, :painLocation, :painDescription, :otherSymptoms, :weather, :air, :sleep, :water, :physicalActivity, :missedMeds, :remedies, :otherNotes)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":journal", $result['id']);
    $stmt->bindParam(":date", $formatted);
    $stmt->bindParam(":closed", $closed);
    $stmt->bindParam(":lowestPain", $low);
    $stmt->bindParam(":highestPain", $high);
    $stmt->bindParam(":averagePain", $avg);
    $stmt->bindParam(":painLocation", $location);
    $stmt->bindParam(":painDescription", $description);
    $stmt->bindParam(":otherSymptoms", $symptoms);
    $stmt->bindParam(":weather", $weather);
    $stmt->bindParam(":air", $air);
    $stmt->bindParam(":sleep", $sleep);
    $stmt->bindParam(":water", $water);
    $stmt->bindParam(":physicalActivity", $activity);
    $stmt->bindParam(":missedMeds", $meds);
    $stmt->bindParam(":remedies", $remedy);
    $stmt->bindParam(":otherNotes", $notes);
    $stmt->execute();
    
    //Add +1 Journal to Daily Record
    $query = 'UPDATE dailyRecords SET journalEntries = journalEntries + 1 ORDER BY id DESC LIMIT 1';
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    //Add +1 Journal to User Data
    $query = 'UPDATE users SET journalEntries = journalEntries + 1 WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    
    //Add +1 Entries to Journal
    $query = 'UPDATE journals SET entries = entries + 1 WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $result['id']);
    $stmt->execute();
    
    //Add 5 Coins
    $query = 'UPDATE users SET coinCount = coinCount + 5 WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    
    //Set Session for Coins
    //Set Session for Coins
    $reply = "You earned 5 snooze coins.";
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
    
    header("Location: ../journal");
    
} else {
    header("Location: ../journal");
}













