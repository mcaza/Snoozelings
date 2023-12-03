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

function checkEmail(object $pdo, string $email) {
    $query = "SELECT emails FROM alphaemails WHERE emails = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}

function setUser(object $pdo, string $username, string $pwd, string $email, $birthdate, string $pronouns, int $newsletter, string $randomString) {
    $query = "INSERT INTO users (username, password, email, birthdate, signupDate, newsletter, pronouns, affirmation, tempCode) VALUES (:username, :pwd, :email, :birthdate, :signupDate, :newsletter, :pronouns, :affirmation, :tempCode);";
    $stmt = $pdo->prepare($query);
    
    //Password Hashing
    $options = [
        'cost' => 12
    ];
    $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);
    $affirmation = "I'm going to do my best to journal everyday. And even when I'm not perfect, I'm going to forgive myself. The important thing is not giving up.";
    
    $todaysDate = date("Y-m-d");
    
    
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":pwd", $hashedPwd);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":birthdate", $birthdate);
    $stmt->bindParam(":signupDate", $todaysDate);
    $stmt->bindParam(":newsletter", $newsletter);
    $stmt->bindParam(":affirmation", $affirmation);
    $stmt->bindParam(":pronouns", $pronouns);
    $stmt->bindParam(":tempCode", $randomString);
    $stmt->execute();
}