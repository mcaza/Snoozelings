<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //Grab Form Variables
    $reply = $_POST["post"];
    $id = $_POST["request"];
    $userId = $_SESSION['user_id'];
    $emoticons = [':‑)',':)',':-]',':]',':}',':^)','=]', '=)', ':‑D',':D','=D','=3','c:','C:',':O',':‑O',':‑o',':o',':-0',':0','=O','=o','=0',':-3',':3','=3','>:3',':‑P',':P',':‑p','>:P','>:‑)','}:)','>:)','>:3','\o/','*\0/*','._.','O_O','o_o','O-O','o‑o','O_o','o_O','\( ͡° ͜ʖ ͡°\)','\(◕‿◕✿\)','ʕ •ᴥ•ʔ','<(｀^´)>','^_^','(°o°)','=^_^=','>^_^<','^_^','\(^o^)/','＼(^o^)／'];
    $count = count($emoticons) - 1;
    $num = rand(0,$count);
    
    //Get Request Info
    $query = "SELECT * FROM penpalRequests WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $request = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$request) {
        header("Location: ../index");
        die();
    }

    //Check if Expired
    if ($request['expired'] == 1) {
        $_SESSION['reply'] = "This penpal request is now expired.";
        header("Location: ../penpals");
        die();
    }
    
    
    //Post Penpal
    $query = "INSERT INTO penpals (user1, user2, request,sign) VALUES (:user1, :user2, :request,:sign)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user1", $request['user']);
    $stmt->bindParam(":user2", $userId);
    $stmt->bindParam(":request", $request['id']);
    $stmt->bindParam(":sign", $emoticons[$num]);
    $stmt->execute();
    
    //Get Penpal ID
    $query = "SELECT * FROM penpals WHERE request = :request AND user2 = :id ORDER BY id DESC";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":request", $request['id']);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $newid = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Send Mail
    $title = "A Reply From Your Newest Penpal!!!";
    $one = 1;
    $now = new DateTime("now", new DateTimezone('UTC'));
    $result = $now->format('Y-m-d H:i:s');
    $query = "INSERT INTO mail (sender, reciever, title, message, sendtime, anon, penpalid) VALUES (:sender, :reciever, :title, :message, :sendtime, :anon, :penpalid)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":sender", $userId);
    $stmt->bindParam(":reciever", $request['user']);
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":sendtime", $result);
    $stmt->bindParam(":anon", $one);
    $stmt->bindParam(":penpalid", $newid['id']);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
    
    //Mark Reply as Closed
    //Cancel Request
    $query = 'UPDATE penpalRequests SET closed = 1 WHERE id = :ticketid';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":ticketid", $id);
    $stmt->execute();
    
    
    $_SESSION['reply'] = "Your reply is in the postbox and will be delivered soon.";
    
    header("Location: ../mailbox");
    
} else {
    header("Location: ../boards.php");
}
