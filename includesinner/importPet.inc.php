<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") { 
    $id = $_POST['pet'];
    
    //Redirect
    header("Location: ../designer?id=" . $id);
    
} else {
     header("Location: ../index");
}