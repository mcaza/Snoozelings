<?php
require_once 'dbh-inc.php';
require_once 'config_session.inc.php';


if (isset($_SESSION["user_id"])) {
$userId = $_SESSION['user_id'];
}

$query = "DELETE FROM notifications WHERE user_id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();

header("Location: " . $_SERVER["HTTP_REFERER"]);