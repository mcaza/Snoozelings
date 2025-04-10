<?php
require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';


if (isset($_COOKIE["user_id"])) {
$userId = $_COOKIE['user_id'];
}

$query = "DELETE FROM notifications WHERE user_id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();

header("Location: " . $_SERVER["HTTP_REFERER"]);