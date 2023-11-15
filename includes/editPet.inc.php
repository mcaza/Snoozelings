<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
//Grab Form Variables
$name = $_POST["name"];
$pronouns = $_POST["pronouns"];
$status = $_POST["status"];
$title = $_POST["title"];
    $userId = $_SESSION['user_id'];

//Grab Pet ID
$id = $_SESSION['id'];
unset($_SESSION['id']);


//Insert into Pet Table
 $query = "UPDATE snoozelings SET name = :name, pronouns = :pronouns, breedStatus = :status, title = :title WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":pronouns", $pronouns);
    $stmt->bindParam(":status", $status);
    $stmt->bindParam(":title", $title);
    $stmt->execute();
    
    //Check if Bonded and Adjust Session Name
    $query = "SELECT bonded FROM users WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $one = intval($result['bonded']);
    $two = intval($id);
    if ($one === $two) {
    $_SESSION['bonded'] = htmlspecialchars($name);
    }
    
//Redirect to Pet Page
header("Location: ../pet?ID=" . $id);
} else {
    header("Location: ../index.php");
}