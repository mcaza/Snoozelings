<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //Make Sure Topic is Selected
    if ($_POST['topic']) {
        $topic = htmlspecialchars($_POST['topic']);
    } else {
        header("Location: ../moderatormail.php");
        die();
    }
    
    //Get Datetime
    $now = date_create('now')->format('Y-m-d H:i:s');
    
    //Get User ID
    if ($_POST['userId']) {
        $userId = htmlspecialchars($_POST['userId']);
    } else {
        $userId = 0;
    }
    
    //Get Highest Ticket ID
    $query = "SELECT ticketid FROM modtickets ORDER BY ticketid DESC LIMIT 1";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        $newId = intval($result['ticketid']) +1 ;
    } else {
        $newId = 1;

    }

    if ($topic == "Account") {
        $information = htmlspecialchars($_POST['information1']);
        $email = htmlspecialchars($_POST['email1']);
        $query = "INSERT INTO modtickets (ticketid, email, topic, information, submitter, datetime) VALUES (:ticketid, :email, :topic, :information, :submitter, :datetime);";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":ticketid", $newId);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":topic", $topic);
        $stmt->bindParam(":information", $information);
        $stmt->bindParam(":submitter", $userId);
        $stmt->bindParam(":datetime", $now);
        $stmt->execute();
    } else if ($topic == "Rules") {
        $reported = htmlspecialchars($_POST['reportedaccount']);
        $information = htmlspecialchars($_POST['information2']);
        $query = "INSERT INTO modtickets (ticketid, userid, topic, information, submitter, datetime) VALUES (:ticketid, :userid, :topic, :information, :submitter, :datetime);";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":ticketid", $newId);
        $stmt->bindParam(":userid", $reported);
        $stmt->bindParam(":topic", $topic);
        $stmt->bindParam(":information", $information);
        $stmt->bindParam(":submitter", $userId);
        $stmt->bindParam(":datetime", $now);
        $stmt->execute();
    } else if ($topic == "Purchase") {
        $email = htmlspecialchars($_POST['email3']);
        $purchaseid = htmlspecialchars($_POST['purchaseid']);
        $information = htmlspecialchars($_POST['information3']);
        $query = "INSERT INTO modtickets (ticketid, email, topic, information, submitter, datetime, purchaseid) VALUES (:ticketid, :email, :topic, :information, :submitter, :datetime, :purchaseid);";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":ticketid", $newId);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":topic", $topic);
        $stmt->bindParam(":information", $information);
        $stmt->bindParam(":submitter", $userId);
        $stmt->bindParam(":datetime", $now);
        $stmt->bindParam(":purchaseid", $purchaseid);
        $stmt->execute();
    } else if ($topic == "Merch") {
        $email = htmlspecialchars($_POST['email4']);
        $purchaseid = htmlspecialchars($_POST['purchaseid']);
        $information = htmlspecialchars($_POST['information4']);
        $query = "INSERT INTO modtickets (ticketid, email, topic, information, submitter, datetime, purchaseid) VALUES (:ticketid, :email, :topic, :information, :submitter, :datetime, :purchaseid);";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":ticketid", $newId);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":topic", $topic);
        $stmt->bindParam(":information", $information);
        $stmt->bindParam(":submitter", $userId);
        $stmt->bindParam(":datetime", $now);
        $stmt->bindParam(":purchaseid", $purchaseid);
        $stmt->execute();
    } else if ($topic == "Bugs") {
        $information = htmlspecialchars($_POST['information5']);
        $query = "INSERT INTO modtickets (ticketid, topic, information, submitter, datetime) VALUES (:ticketid, :topic, :information, :submitter, :datetime);";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":ticketid", $newId);
        $stmt->bindParam(":topic", $topic);
        $stmt->bindParam(":information", $information);
        $stmt->bindParam(":submitter", $userId);
        $stmt->bindParam(":datetime", $now);
        $stmt->execute();
    } else if ($topic == "Other" ) {
        $information = htmlspecialchars($_POST['information6']);
        $email = htmlspecialchars($_POST['email6']);
        $query = "INSERT INTO modtickets (ticketid, email, topic, information, submitter, datetime) VALUES (:ticketid, :email, :topic, :information, :submitter, :datetime);";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":ticketid", $newId);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":topic", $topic);
        $stmt->bindParam(":information", $information);
        $stmt->bindParam(":submitter", $userId);
        $stmt->bindParam(":datetime", $now);
        $stmt->execute();
    }
    
    $_SESSION['reply'] = "Your Moderator Mail Has Been Submitted";
    
    header("Location: ../moderatormail");
    
} else {
    header("Location: ../moderatormail");
    die();
}
