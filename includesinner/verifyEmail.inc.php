<?php
require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

$code = $_POST["code"];
$userId = $_SESSION['user_id'];

$errors = [];
$value = 1;
$emptyString = "";

$query = "SELECT * FROM users WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$result) {
    $_SESSION["reply"] = "Please log into your account and try again.";
    header("Location: ../verify.php");
    die();
}

if (!$code) {
    $_SESSION["reply"] = "You forgot to enter the code.";
    header("Location: ../verify.php");
    die();
}

if ($result["tempCode"] === $code) {
    $query = "UPDATE users SET emailVerified = :value WHERE id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":value", $value);
    $stmt->execute();
    
    $query = "UPDATE users SET tempCode = :emptyString WHERE id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":emptyString", $emptyString);
    $stmt->execute();
    
    header("Location: ../index.php");
} else {
    $_SESSION["reply"] = "The code you entered is incorrect.";
    header("Location: ../verify.php");
}

} else {
    header("Location: ../index");
}