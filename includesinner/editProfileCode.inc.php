<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';



if ($_SERVER["REQUEST_METHOD"] === "POST") {
//Grab Form Variables
    $pronouns = $_POST["pronouns"];
    $status = $_POST["status"];
    $friends = $_POST["friends"];
    $messages = $_POST["messages"];
    $bonded = $_POST["bonded"];
    $userId = $_SESSION['user_id'];
    $farmName = $_POST['farm'];
    $mailbox = $_POST['mailbox'];
    $shortcutArray = "";
    
     //Update Shortcuts
    $shortCount = 0;
    
    if (isset($_POST['Crafting'])) {
        $shortCount++;
        $shortcutArray = $shortcutArray . $_POST['Crafting'] . " ";
    }
    if (isset($_POST['Dyes'])) {
        $shortCount++;
        $shortcutArray = $shortcutArray . $_POST['Dyes'] . " ";
    }
    if (isset($_POST['Explore'])) {
        $shortCount++;
        $shortcutArray = $shortcutArray . $_POST['Explore'] . " ";
    }
    if (isset($_POST['Garden'])) {
        $shortCount++;
        $shortcutArray = $shortcutArray . $_POST['Garden'] . " ";
    }
    if (isset($_POST['Journal'])) {
        $shortCount++;
        $shortcutArray = $shortcutArray . $_POST['Journal'] . " ";
    }
    if (isset($_POST['Mailbox'])) {
        $shortCount++;
        $shortcutArray = $shortcutArray . $_POST['Mailbox'] . " ";
    }
    if (isset($_POST['Penpals'])) {
        $shortCount++;
        $shortcutArray = $shortcutArray . $_POST['Penpals'] . " ";
    }
    if (isset($_POST['Snoozeling'])) {
        $shortCount++;
        $shortcutArray = $shortcutArray . $_POST['Snoozeling'] . " ";
    }
    
    if ($shortCount > 5) {
        $_SESSION['error'] = "You Cannot Have More Than 5 Shortcuts";
        header("Location: ../editprofile");
        die(); 
    }
    
    if ($shortCount > 0) {
        $finalShorts = trim($shortcutArray);
        $query = "UPDATE users SET shortcuts = :shortcuts WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->bindParam(":shortcuts", $finalShorts);
        $stmt->execute();
    }
    
    //Variable Checks
    //Pronouns
    if ($pronouns) {
        if(!($pronouns === "She/Her" || $pronouns === "He/Him" || $pronouns === "Any" || $pronouns === "They/Them" || $pronouns === "She/Them" || $pronouns === "He/Them" || $pronouns === "She/Him")) {
            header("Location: ../editprofile?id=" . $userId);
            die();
        }
    }
    //Status
    if ($status) {
        $query = 'SELECT * FROM statuses';
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $statuses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $check = 0;
        foreach ($statuses as $stat) {
            if ($status === $stat['status']) {
                $check = 1;
            }
        }
        if ($check === 0) {
            header("Location: ../editprofile?id=" . $userId);
            die();
        }
    }
    //Farm Name
    if ($farmName) {
        $query = 'SELECT * FROM farmNames';
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $farms = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $check = 0;
        foreach ($farms as $farm) {
            if ($farmName === $farm['name']) {
                $check = 1;
            }
        }
        if ($check === 0) {
            header("Location: ../editprofile?id=" . $userId);
            die();
        }
    }
    //Mailbox Color
    if ($mailbox) {
        if (!($mailbox === 'blue' || $mailbox === 'cyan' || $mailbox === 'orange' || $mailbox === 'purple' || $mailbox === 'red')) {
            header("Location: ../editprofile?id=" . $userId);
            die();
        }
    }
    //Allow Friend Requests
    if ($friends) {
        if (!($friends === "0" || $friends === "1")) {
            header("Location: ../editprofile?id=" . $userId);
            die();
        }
    }
    //Alow Messages
    if ($messages) {
        if (!($messages === "0" || $messages === "1")) {
            header("Location: ../editprofile?id=" . $userId);
            die();
        }
    }
    //Check if Bonded Pet is Owned by Person
    if ($bonded) {
        $query = 'SELECT * FROM snoozelings WHERE owner_id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
        $pets = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $check = 0;
        foreach ($pets as $pet) {
            if ($bonded === $pet['id']) {
                $check = 1;
            }
        }
        if ($check === 0) {
            header("Location: ../editprofile?id=" . $userId);
            die();
        }
    }
    
    
    //Update Pronouns, Friend Requests, and Message Requests
    $query = "UPDATE users SET pronouns = :pronouns, blockRequests = :friends, blockMessages = :messages WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":pronouns", $pronouns);
    $stmt->bindParam(":messages", $messages);
    $stmt->bindParam(":friends", $friends);
    $stmt->execute();
    
    //Updated Bonded Pet
    if ($bonded) {
        $query = "UPDATE users SET bonded = :bonded WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":bonded", $bonded);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
        
        $query = "SELECT name FROM snoozelings WHERE id = :bonded";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":bonded", $bonded);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $_SESSION['bonded'] = htmlspecialchars($result['name']);
    }
    
    //Update Mailbox Color
    if ($mailbox) {
        $query = 'UPDATE users SET mailbox = :mailbox WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":mailbox", $mailbox);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
    }
    
    //Update Status
    if ($status) {
        $query = "UPDATE users SET status = :status WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
    }
    
    //Update Farm Name
    if ($farmName) {
        $query = "UPDATE users SET farmName = :farmName WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":farmName", $farmName);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
    }
    
    header("Location: ../profile?id=" . $userId);
    
    
    
} else {
    header("Location: ../index.php");
}
