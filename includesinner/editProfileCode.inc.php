<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';



if ($_SERVER["REQUEST_METHOD"] === "POST") {
//Grab Form Variables
    $pronouns = $_POST["pronouns"];
    $status = $_POST["status"];
    $friends = $_POST["friends"];
    $messages = $_POST["messages"];
    $gifts = $_POST["birthdayGifts"];
    $bonded = $_POST["bonded"];
    $userId = $_COOKIE['user_id'];
    $farmName = $_POST['farm'];
    $houseName = $_POST['house'];
    $backpackName = $_POST['backpack'];
    $mailbox = $_POST['mailbox'];
    $shortcutArray = "";
    $bio = $_POST['bio'];
    
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
    
    if (isset($_POST['Pack'])) {
        $shortCount++;
        $shortcutArray = $shortcutArray . $_POST['Pack'] . " ";
    }
    
    if ($shortCount > 5) {
            $reply = "You Cannot Have More Than 5 Shortcuts.";
        $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":message", $reply);
        $stmt->execute();
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
        if(!($pronouns === "She/Her" || $pronouns === "He/Him" || $pronouns === "Any" || $pronouns === "They/Them" || $pronouns === "She/Them" || $pronouns === "He/Them" || $pronouns === "She/Him" || $pronouns === "See Bio")) {
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
    
    //Home Name
    if ($houseName) {
        $query = 'SELECT * FROM homeNames';
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $farms = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $check = 0;
        foreach ($farms as $farm) {
            if ($houseName === $farm['name']) {
                $check = 1;
            }
        }
        if ($check === 0) {
            header("Location: ../editprofile?id=" . $userId);
            die();
        }
    }
    
    //Backpack Name
    if ($backpackName) {
        $query = 'SELECT * FROM backpackNames';
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $farms = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $check = 0;
        foreach ($farms as $farm) {
            if ($backpackName === $farm['name']) {
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
    
    //Alow Messages
    if ($gifts) {
        if (!($gifts === "0" || $gifts === "1")) {
            header("Location: ../editprofile?id=" . $userId);
            die();
        }
    }
    
    //Bonded Update
    if ($bonded) {
        $query = 'SELECT * FROM snoozelings WHERE owner_id = :id AND id = :petid';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->bindParam(":petid", $bonded);
        $stmt->execute();
        $bondedpet = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($bondedpet) {
            $query = "UPDATE users SET bonded = :bonded WHERE id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":bonded", $bonded);
            $stmt->bindParam(":id", $userId);
            $stmt->execute();
        } else {
            header("Location: ../");
        }

    }
    
    
    //Update Pronouns, Friend Requests, and Message Requests
    $query = "UPDATE users SET pronouns = :pronouns, blockRequests = :friends, blockMessages = :messages, birthdayOptOut = :gifts WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":pronouns", $pronouns);
    $stmt->bindParam(":messages", $messages);
    $stmt->bindParam(":friends", $friends);
    $stmt->bindParam(":gifts", $gifts);
    $stmt->execute();
    
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
    
    //Update House Name
    if ($houseName) {
        $query = "UPDATE users SET homeName = :homeName WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":homeName", $houseName);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
    }
    
    //Update Backpack Name
    if ($backpackName) {
        $query = "UPDATE users SET backpackName = :backpackName WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":backpackName", $backpackName);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
    }
    
    //Update Bio
    if ($bio) {
        if (strlen($bio) > 500) {
                $reply = "The bio entered is longer than 500 characters.";
            $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":user_id", $userId);
            $stmt->bindParam(":message", $reply);
            $stmt->execute();
            header("Location: ../editprofile?id=" . $userId);
            die();
        } else {
            $query = 'UPDATE users SET bio = :bio WHERE id = :id';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $userId);
            $stmt->bindParam(":bio", $bio);
            $stmt->execute();
        }
    }
    
    header("Location: ../profile?id=" . $userId);
    
    
    
} else {
    header("Location: ../");
}
