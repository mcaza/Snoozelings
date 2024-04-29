<?php

function verifyCheck($pdo) {
$userId = $_SESSION['user_id'];

$query = "SELECT * FROM users WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

//Check for Logged in 
if (isset($_SESSION["user_id"])) {
    if ($result['emailVerified'] == 1) {
            header("Location:../index.php");
        } else {
        
    }
    

}
}

verifyCheck($pdo);