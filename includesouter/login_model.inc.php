<?php

declare(strict_types=1);

function getUser(object $pdo, string $username) {
    $username = strtolower($username);
    $query = "SELECT id, username, password, bonded FROM users WHERE LOWER(username) = :username;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function petName(object $pdo, int $bonded) {
    $query = "SELECT name FROM snoozelings WHERE id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $bonded);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}