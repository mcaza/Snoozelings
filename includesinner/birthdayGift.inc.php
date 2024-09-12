<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $userId = $_SESSION['user_id'];
    $gift = $_POST['gift'];
    $id = $_POST['postId'];
    
    //Get Item Info
    $query = 'SELECT * FROM items WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $gift);
    $stmt->execute();
    $item = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Check ID Exists
    if (!$item) {
        header("Location: ../index");
        die();
    }
    
    //Check Matches Username
    if ($item['user_id'] == $userId) {
        
    } else {
        header("Location: ../index");
        die();
    }
    
    //Birthday Check
    $query = "SELECT * FROM users WHERE id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $fiveDays = new DateTime('now');
    $fiveDays->add(new DateInterval('P5D'));
    $query = 'SELECT * FROM times';
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $times = $stmt->fetch(PDO::FETCH_ASSOC);
    $now = new DateTime($times['mailone']);
    $tester = new DateTime($result['birthdate']);
    
    if ($tester->format('2024-m-d') == $now->format('Y-m-d')) {
        header("Location: ../index");
        die();
    } else if ($tester->format('2024-m-d') < $now->format('Y-m-d') || $tester->format('2024-m-d') > $fiveDays->format('Y-m-d')) {
        header("Location: ../index");
        die();
    }
    
    //Check Gift already Given
    $query = 'SELECT * FROM birthdayGifts WHERE gifter = :gifter AND giftee = :giftee';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":gifter", $userId);
    $stmt->bindParam(":giftee", $id);
    $stmt->execute();
    $giftCheck = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($giftCheck) {
        header("Location: ../index");
        die();
    }
    
    //Give Gift
    
    $query = 'SELECT * FROM itemList WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $item['list_id']);
    $stmt->execute();
    $iteminfo = $stmt->fetch(PDO::FETCH_ASSOC);
     
    $query = 'INSERT INTO birthdayGifts (gifter, giftee, birthdate, list_id, display, dye) VALUES (:gifter,:giftee,:birthdate,:list_id,:display,:dye)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":gifter", $userId);
    $stmt->bindParam(":giftee", $id);
    $stmt->bindParam(":birthdate", $tester->format('2024-m-d'));
    $stmt->bindParam(":list_id", $item['list_id']);
    $stmt->bindParam(":display", $item['display']);
    $stmt->bindParam(":dye", $item['dye']);
    $stmt->execute();
    
    //Delete Item
    $query = 'DELETE FROM items WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $gift);
    $stmt->execute();
    
    //Reply & Reroute
    header("Location: ../profile?id=" . $id);
    die();
    
} else {
header("Location: ../index");
    die();
}
