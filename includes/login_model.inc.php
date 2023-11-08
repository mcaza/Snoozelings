<?php

declare(strict_types=1);

function getUser(object $pdo, string $username) {
    $query = "SELECT id, username, password FROM users WHERE username = :username;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}