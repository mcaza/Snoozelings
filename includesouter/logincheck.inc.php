<?php

$userId = $_COOKIE['user_id'];

$query = "SELECT * FROM sessions WHERE session = :token AND user_id = :username";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":token", $_COOKIE['PHPSESSID']);
    $stmt->bindParam(":username", $_COOKIE['user_id']);
    $stmt->execute();
    $testToken = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$testToken) {
    header("Location: ../login");
    die();
}