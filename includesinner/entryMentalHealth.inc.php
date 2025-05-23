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
    $anxiety = $_POST["anxiety"];
    $depression = $_POST["depression"];
    $stress = $_POST["stress"];
    $productivity = $_POST["productivity"];
    $health = $_POST["health"];
    $sleep = $_POST["sleep"];
    $water = $_POST["water"];
    $triggers = $_POST['triggers'];
    $notes = $_POST['notes'];
    
    //Custom Variable Checks
    if ($anxiety > 10 || $anxiety < 1) {
        header("Location: ../index");
            die();
    }
    
    if ($depression > 10 || $depression < 1) {
        header("Location: ../index");
            die();
    }
    if ($stress > 10 || $stress < 1) {
        header("Location: ../index");
            die();
    }
    if ($productivity > 10 || $productivity < 1) {
        header("Location: ../index");
            die();
    }
    if ($health > 10 || $health < 1) {
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
    
    if($_POST['meds']) {
        $meds = $_POST['meds'];
    } else {
        $meds = "Took all my meds";
    }
    
    //Insert Journal Into Chart
    $query = 'INSERT INTO mentalHealthEntries (user_id, journal_id, date, closed, anxiety, depression, stress, physicalHealth, productivity, sleep, water, productive, destructive, missedMeds, triggers, notes) VALUES (:id, :journal, :date, :closed, :anxiety, :depression, :stress, :physicalHealth, :productivity, :sleep, :water, :productive, :destructive, :missedMeds, :triggers, :notes)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":journal", $result['id']);
    $stmt->bindParam(":date", $formatted);
    $stmt->bindParam(":closed", $closed);
    $stmt->bindParam(":anxiety", $anxiety);
    $stmt->bindParam(":depression", $depression);
    $stmt->bindParam(":stress", $stress);
    $stmt->bindParam(":physicalHealth", $health);
    $stmt->bindParam(":productivity", $productivity);
    $stmt->bindParam(":sleep", $sleep);
    $stmt->bindParam(":water", $water);
    $stmt->bindParam(":productive", $good);
    $stmt->bindParam(":destructive", $bad);
    $stmt->bindParam(":missedMeds", $meds);
    $stmt->bindParam(":triggers", $triggers);
    $stmt->bindParam(":notes", $notes);
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













