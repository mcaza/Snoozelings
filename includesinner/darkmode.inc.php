<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SESSION['user_id']) {
        $userId = $_SESSION['user_id'];
    } else {
        header("Location: ../login");
        die();
    }


//Grab User Info
    $query = 'SELECT * FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user['mode'] == "Dark") {
    $new = "Light";
} else {
    $new = "Dark";
}

$query = "UPDATE users SET mode = :mode WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->bindParam(":mode", $new);
$stmt->execute();

header("Location: ../index");
die();