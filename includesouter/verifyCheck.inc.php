<?php

if (isset($_SESSION['user_id'])) {
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

    }
}

function logCheck($pdo) {
    $userId = $_SESSION['user_id'];
    if ($userId) {
    
    $query = "SELECT lastLog FROM users WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result['lastLog'] === "1") {
        
    } else {
        $num = 1;
        $query = 'UPDATE users SET lastlog = :num WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->bindParam(":num", $num);
        $stmt->execute();
    }
    }
}

logCheck($pdo);

//verifyEmail($pdo);
    
}