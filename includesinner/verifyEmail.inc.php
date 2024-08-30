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
    
    //Add Puffball Hoodie
    $item = 224;
    $query = 'SELECT * FROM itemList WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $item);
    $stmt->execute();
    $iteminfo = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $query = "INSERT INTO items (list_id, user_id, name, display, description, type, rarity, canDonate) VALUES (:list, :user, :name, :display, :description, :type, :rarity, :canDonate);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":list", $item);
    $stmt->bindParam(":user", $userId);
    $stmt->bindParam(":name", $iteminfo['name']);
    $stmt->bindParam(":display", $iteminfo['display']);
    $stmt->bindParam(":description", $iteminfo['description']);
    $stmt->bindParam(":type", $iteminfo['type']);
    $stmt->bindParam(":rarity", $iteminfo['rarity']);
    $stmt->bindParam(":canDonate", $iteminfo['canDonate']);
    $stmt->execute();
    
    header("Location: ../verify");
} else {
    $_SESSION["reply"] = "The code you entered is incorrect.";
    header("Location: ../verify.php");
}

} else {
    header("Location: ../index");
}