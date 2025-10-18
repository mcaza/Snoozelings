<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //Get Values
    $userId = $_COOKIE['user_id'];
    $id = $_POST['user'];
    
    
    
} else {
header("Location: ../index");
    die();
}