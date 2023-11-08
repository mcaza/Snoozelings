<?php

declare(strict_types=1);

function getUsername(object $pdo, string $username) {
    $query = "SELECT username FROM users WHERE username = :username;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function getEmail(object $pdo, string $email) {
    $query = "SELECT email FROM users WHERE email = :email;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function setUser(object $pdo, string $username, string $pwd, string $email, $birthdate) {
    $query = "INSERT INTO users (username, password, email, birthdate, signupDate) VALUES (:username, :pwd, :email, :birthdate, :signupDate);";
    $stmt = $pdo->prepare($query);
    
    //Password Hashing
    $options = [
        'cost' => 12
    ];
    $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);
    
    $todaysDate = date("Y-m-d");
    
    
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":pwd", $hashedPwd);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":birthdate", $birthdate);
    $stmt->bindParam(":signupDate", $todaysDate);
    $stmt->execute();
}