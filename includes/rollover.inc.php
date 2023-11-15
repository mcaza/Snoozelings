<?php
    require_once 'dbh-inc.php';

    //Get all Affirmations
    $affirmquery = "SELECT * FROM affirmations";
    $affirmstmt = $pdo->prepare($affirmquery);
    $affirmstmt->execute();
    $affirmresults = $affirmstmt->fetchAll(PDO::FETCH_ASSOC);

    //Get All Users
    $userquery = "SELECT id FROM users";
    $userstmt = $pdo->prepare($userquery);
    $userstmt->execute();
    $users = $userstmt->fetchAll(PDO::FETCH_ASSOC);

    $affirmlength = count($affirmresults); 

    //Assign Affirmations
    foreach ($users as $user) {
        $randomNum = rand(1, $affirmlength);
        $query = "UPDATE users SET affirmation = :affirmation WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":affirmation", $affirmresults[$randomNum]["affirmation"]);
        $stmt->bindParam(":id", $user["id"]);
        $stmt->execute();
    }

    //Reset Daily Records
    $query = "UPDATE dailyRecords SET journalEntries = 0, cropsHarvested = 0, snoozelingsCrafted = 0, itemsCrafted = 0, activeMembers = 0, newMembers = 0, kindnessCoins = 0 WHERE id = 1;";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    //Reset Daily Free Item Variable
    $query = "UPDATE users SET dailyPrize = 0";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    //Close All Journal Entries
    $query = "UPDATE chronicPainEntries SET closed = 1";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $query = "UPDATE mentalHealthEntries SET closed = 1";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    $affirmstmt = null;
    $userstmt = null;
    $pdo = null;
    $stmt = null;
die();