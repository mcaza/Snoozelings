<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //Get Values
    $userId = $_COOKIE['user_id'];
    $email = trim($_POST["email"]);
    
    
    //Double Check for Item
    if ($_POST["item"]) {
        $id = $_POST["item"];
    } else {
        $reply = "Please select an item.";
        $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":message", $reply);
        $stmt->execute();
        header("Location: ../earlyaccess");
        die();
        }
    
    
    //Create Item Code
    $length = 6;
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString =  strtoupper(substr($id,0,5));
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    
    
    //Insert Into Database
    $type = "convention";
    $query = 'INSERT INTO itemCodes (code, type, item) VALUES (:code, :type, :item)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":code", $randomString);
    $stmt->bindParam(":type", $type);
    $stmt->bindParam(":item", $id);
    $stmt->execute();
    
    //Get Item Display
    $query = "SELECT * FROM itemList WHERE name = :name";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $id);
    $stmt->execute();
    $display = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Send Email
    if ($email) {
        $address = $email;
        $title ="Snoozelings Item Code";
        $msg = '<h2>Email Confirmation</h2> <p>Thank you so much for buying snoozelings merch!!! <br><br>We are sending you this email with a copy of your item code. You can also use this link to redeem your item: <a href="https://snoozelings.com/coderedemption?code=' . $randomString . '">CLICK HERE!!!</a><br><br>If the link doesn\'t work, Copy/Pasting the code is best so the characters don\'t get mistyped.<br><br>You can also join our discord server if haven\'t already: <a href="https://discord.gg/p6wr4NBrx9">Discord Link</a><br><br><b>Item:</b> ' . $display['display'] . '<br><b>Item Code: </b>' . $randomString . '<br><br>See you soon,<br><i>Snoozelings</i></p>';
    

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        //From
        $headers .= 'From: Snoozelings <autoreply@snoozelings.com>' . "\r\n";

        mail($address, $title, $msg, $headers);
    }
    
    
    //Reply and Reroute
    $reply = "Item Code: " . $randomString;
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
    header("Location: ../earlyaccess");
} else {
    header("Location: ../index");
}