<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userId = $_SESSION['user_id'];
    
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
    $physical = $_POST["physical"];
    $mental = $_POST["mental"];
    $emotional = $_POST["emotional"];
    $spiritual = $_POST["spiritual"];
    $social = $_POST["social"];
    $food = $_POST["food"];
    $exercise = $_POST["exercise"];
    $sleep = $_POST["sleep"];
    $water = $_POST["water"];
    $pain = $_POST['pain'];
    $illness = $_POST['illness'];
    $notes = $_POST['notes'];
    $goodThing = $_POST['goodThing'];
    $badThing = $_POST['badThing'];
    
    //Insert Journal Into Chart
    $query = 'INSERT INTO genericEntries (user_id, journal_id, date, closed, physicalHealth, mentalHealth, emotionalHealth, spiritualHealth, socialHealth, eating, excercise, sleeping, pain, illness, goodThing, badThing, notes, water) VALUES (:user_id, :journal_id, :date, :closed, :physicalHealth, :mentalHealth, :emotionalHealth, :spiritualHealth, :socialHealth, :eating, :excercise, :sleeping, :pain, :illness, :goodThing, :badThing, :notes, :water)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":journal_id", $result['id']);
    $stmt->bindParam(":date", $formatted);
    $stmt->bindParam(":closed", $closed);
    $stmt->bindParam(":physicalHealth", $physical);
    $stmt->bindParam(":mentalHealth", $mental);
    $stmt->bindParam(":emotionalHealth", $emotional);
    $stmt->bindParam(":spiritualHealth", $spiritual);
    $stmt->bindParam(":socialHealth", $social);
    $stmt->bindParam(":eating", $food);
    $stmt->bindParam(":excercise", $exercise);
    $stmt->bindParam(":sleeping", $sleep);
    $stmt->bindParam(":pain", $pain);
    $stmt->bindParam(":illness", $illness);
    $stmt->bindParam(":goodThing", $goodThing);
    $stmt->bindParam(":badThing", $badThing);
    $stmt->bindParam(":notes", $notes);
    $stmt->bindParam(":water", $water);
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
    $_SESSION['finish'] = 1;
    
    header("Location: ../journal");
    
} else {
    header("Location: ../journal");
}




