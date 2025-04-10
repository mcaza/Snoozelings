<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_COOKIE['user_id']) {
        $userId = $_COOKIE['user_id'];
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

session_set_cookie_params([
           'lifetime' => 0, 
            'domain' => 'snoozelings.com',
            'path' => '/',
            'secure' => true,
            'httponly' => true
        ]);

if ($user['mode'] == "Dark") {
    $new = "Light";
    setcookie('MODE', "Light", 0, '/');
} else {
    $new = "Dark";
    setcookie('MODE', "Dark", 0, '/');
}



$query = "UPDATE users SET mode = :mode WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->bindParam(":mode", $new);
$stmt->execute();

header("Location: ../index");
die();