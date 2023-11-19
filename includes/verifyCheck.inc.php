<?php

function verifyEmail($pdo) {
$userId = $_SESSION['user_id'];

$query = "SELECT * FROM users WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

//Check for Logged in 
if (isset($_SESSION["user_id"])) {
    if ($result['emailVerified'] == 0) {
            header("Location:../verify.php");
        die();
        }
    
    /* //Check if Has Pet
    if ($result['bonded'] == 0) {
        //Check for Email Verification
        if ($result['emailVerified'] == 0) {
            header("Location:../verify.php");
        } else {
            header("Location:../intro.php");
        }
    } 
} else {
    header("Location:../login.php");
} */

}
}

function logDate($pdo) {
    $userId = $_SESSION['user_id'];
    
    //Date Stuff
    $now = new DateTime();
    $date = $now->format('Y-m-d');
    
    $query = "SELECT lastLog FROM users WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($date === $result['lastLog']) {
        
    } else {
        $query = 'UPDATE users SET lastlog = :date WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->bindParam(":date", $date);
        $stmt->execute();
    }
}

logDate($pdo);

verifyEmail($pdo);