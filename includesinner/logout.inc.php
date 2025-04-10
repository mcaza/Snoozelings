<?php

require_once '../../includes/dbh-inc.php';

$token = $_COOKIE['PHPSESSID'];

$query = 'DELETE FROM sessions WHERE session = :token';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":token", $token);
$stmt->execute(); 

setcookie("user_id", "", time() - 3600);
setcookie("PHPSESSID", "", time() - 3600);
header("Location: ../index");
die();

header("Location: ../login");
die();