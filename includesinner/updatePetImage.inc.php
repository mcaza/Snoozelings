<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';
require_once '../../includes/imageFunction.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userId = $_COOKIE['user_id'];
    $pet = $_POST["number"];
    
    if ($userId > 1) {
        header("Location: ../");
        die();
    }
    
    //Update Image
    resetImage($pet, $pdo);
    
    header("Location: ../snoozeTests?id=" . $pet);
    } else {
header("Location: ../index");
    die();
}


