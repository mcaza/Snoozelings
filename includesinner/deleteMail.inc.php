<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") { 
    
    function deleteMail($id, $pdo) {
    $query = "DELETE FROM mail WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
}
    
$userId = $_COOKIE['user_id'];
$first = $_POST['1'];
$second = $_POST['2'];
$third = $_POST['3'];
$forth = $_POST['4'];
$fifth = $_POST['5'];
$sixth = $_POST['6'];
$seventh = $_POST['7'];
$eighth = $_POST['8'];
$ninth = $_POST['9'];
$tenth = $_POST['10'];
$button = $_POST['button'];
    
if ($button) {
     deleteMail($button,$pdo);
}

if ($first) {
    deleteMail($first,$pdo);
}

if ($second) {
    deleteMail($second,$pdo);
}

if ($third) {
    deleteMail($third,$pdo);
}

if ($forth) {
    deleteMail($forth,$pdo);
}

if ($fifth) {
    deleteMail($fifth,$pdo);
}

if ($sixth) {
    deleteMail($sixth,$pdo);
}

if ($seventh) {
    deleteMail($seventh,$pdo);
}

if ($eighth) {
    deleteMail($eighth,$pdo);
}

if ($ninth) {
    deleteMail($ninth,$pdo);
}

if ($tenth) {
    deleteMail($tenth,$pdo);
}
        $reply = "All checked mail has been deleted.";
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
    
    header("Location: ../mailbox");


    
} else {
     header("Location: ../mailbox");
}