<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //Get Values
    $userId = $_COOKIE['user_id'];
    $email = trim($_POST["email"]);
    if ($_POST["number"]) {
        $id = $_POST["number"];
    } else {
        $id = 0;
    }
    
    //Check Email
    $query = 'SELECT * FROM earlyaccess WHERE email = :email';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
            $reply = "That email is already taken.";
            $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":user_id", $userId);
            $stmt->bindParam(":message", $reply);
            $stmt->execute();
        header("Location: ../earlyaccess");
        die();
    }
    
    //Check ID
    if ($id) {
    $query = 'SELECT * FROM earlyaccess WHERE chosenID = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
                $reply = "That ID number is already taken.";
            $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":user_id", $userId);
            $stmt->bindParam(":message", $reply);
            $stmt->execute();
            header("Location: ../earlyaccess");
            die();
        }
    }
    
    //Create Alpha Code
    $length = 20;
    $characters = '0123456789abcdefghijklmnopqrs092u3tuvwxyzaskdhfhf9882323ABCDEFGHIJKLMNksadf9044OPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = "";
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    
    //Insert Into Database
    $query = 'INSERT INTO earlyaccess (email, code, chosenID) VALUES (:email, :code, :chosenid)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":code", $randomString);
    $stmt->bindParam(":chosenid", $id);
    $stmt->execute();
    
    //Send Email
    $address = $email;
    $title ="Snoozelings Early Access Confirmation";
        $msg = '<h2>Email Confirmation</h2> <p>Dear ' . $email . ',<br><br>Thank you so much for registering for the Snoozelings Early Access!!! <br><br>We are sending you this email as confirmation of your chosen ID and alpha code. To make things easy, you can use this link. It will insert the code for you. <a href="https://snoozelings.com/signup?code=' . $randomString . '">CLICK HERE!!!</a><br><br>If the link doesn\'nt work, Copy/Pasting the code is best so the characters don\'t get mistyped.<br><br>You can also join our discord server if haven\'t already: <a href="https://discord.gg/sqjMSepvet">Discord Link</a><br><br><b>Account ID:</b> ' . $id . '<br><br><b>Alpha Code: </b>' . $randomString . '<br><br>See you soon,<br><i>Snoozelings</i></p>';
    

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        //From
        $headers .= 'From: Snoozelings <autoreply@snoozelings.com>' . "\r\n";

        mail($address, $title, $msg, $headers);
    
    //Reply and Reroute
        $reply = "Email Sent.";
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
    header("Location: ../earlyaccess");
} else {
    header("Location: ../index");
}
