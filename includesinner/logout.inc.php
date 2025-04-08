<?php

require_once '../../includes/dbh-inc.php';

$token = $_COOKIE['PHPSESSID'];

$query = 'DELETE FROM sessions WHERE session = :token';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":token", $token);
$stmt->execute(); 

session_start();
session_unset();
session_destroy();

header("Location: ../login");
die();