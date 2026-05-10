<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';



if ($_SERVER["REQUEST_METHOD"] === "POST") {
//Grab Form Variables
    $userId = $_COOKIE['user_id'];
    $messages = $_POST["messages"];
    $raffleMail = $_POST["raffle"];
    $adoptionMail = $_POST["adoption"];
    $inspirationMail = $_POST["inspiration"];
    
    if (isset($_POST['Mailbox'])) {
        $shortCount++;
        $shortcutArray = $shortcutArray . $_POST['Mailbox'] . " ";
    }
    
    //Check for Inputted Answers
    $num = intval($messages);
    if ($messages) {
        if ($num < 0 || $num > 2) {
            header("Location: ../index");
            die();
        }
    }
    
   
    if ($raffleMail) {
        if (!($raffleMail === "0" || $raffleMail === "1")) {
            header("Location: ../index");
            die();
        }
    }

    if ($adoptionMail) {
        if (!($adoptionMail === "0" || $adoptionMail === "1")) {
            header("Location: ../index");
            die();
        }
    }

    if ($inspirationMail) {
        if (!($inspirationMail === "0" || $inspirationMail === "1")) {
            header("Location: ../index");
            die();
        }
    }

    
    //Update Settings
    $query = "UPDATE users SET raffleMail = :raffle, adoptionMail = :adoption, blockMessages = :messages, inspirationMail = :inspiration WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":messages", $messages);
    $stmt->bindParam(":raffle", $raffleMail);
    $stmt->bindParam(":adoption", $adoptionMail);
    $stmt->bindParam(":inspiration", $inspirationMail);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    
    //Update Mailbox Color
    if ($mailbox) {
        $query = 'UPDATE users SET mailbox = :mailbox WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":mailbox", $mailbox);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
    }
    
    header("Location: ../mailSettings");
    
} else {
    header("Location: ../");
}
