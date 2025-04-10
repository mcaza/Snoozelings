<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //Make Sure Topic is Selected
    if ($_POST['topic']) {
        $topic = $_POST['topic'];
    } else {
        header("Location: ../moderatormail.php");
        die();
    }
    
    //Get Datetime
    $now = date_create('now')->format('Y-m-d H:i:s');
    
    //Get User ID
    if ($_POST['userId']) {
        $userId = $_POST['userId'];
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
        $information = $_POST['information1'];
        $email = $_POST['email1'];
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
        $reported = $_POST['reportedaccount'];
        $information = $_POST['information2'];
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
        $email = $_POST['email3'];
        $purchaseid = $_POST['purchaseid'];
        $information = $_POST['information3'];
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
        $email = $_POST['email4'];
        $purchaseid = $_POST['purchaseid'];
        $information = $_POST['information4'];
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
        $information = $_POST['information5'];
        $query = "INSERT INTO modtickets (ticketid, topic, information, submitter, datetime) VALUES (:ticketid, :topic, :information, :submitter, :datetime);";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":ticketid", $newId);
        $stmt->bindParam(":topic", $topic);
        $stmt->bindParam(":information", $information);
        $stmt->bindParam(":submitter", $userId);
        $stmt->bindParam(":datetime", $now);
        $stmt->execute();
    } else if ($topic == "Other" ) {
        $information = $_POST['information6'];
        $email = $_POST['email6'];
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
    
    $address = "support@snoozelings.com";

        $title ="Moderator Report Submitted";
        $msg = '<h2>New Moderator Report</h2> <p><b>Type: ' . $topic . '<br></b>Link:</b> <a href="snoozelings.com/ticket?ticketid=' . $newId . '">Click Here</a><br><b>Information:</b>' . $information . '</p>';

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        //From
        $headers .= 'From: Snoozelings <autoreply@snoozelings.com>' . "\r\n";

        mail($address, $title, $msg, $headers);
        $reply = "Your Moderator Mail Has Been Submitted.";
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
    
    header("Location: ../moderatormail");
    
} else {
    header("Location: ../moderatormail");
    die();
}
