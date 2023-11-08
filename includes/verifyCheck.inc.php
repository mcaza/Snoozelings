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

verifyEmail($pdo);