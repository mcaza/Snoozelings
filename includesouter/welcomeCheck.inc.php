<?php

function welcomecheck($pdo) {
$userId = $_COOKIE['user_id'];

$query = "SELECT * FROM users WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

//Check for Logged in 
if (isset($_COOKIE["user_id"])) {
    if (!$result['bonded'] == 0) {
            header("Location:../index.php");
        } else {
        
    }
    

}
}

welcomecheck($pdo);