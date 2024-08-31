<?php

declare(strict_types=1);

function getUsername(object $pdo, string $username) {
    $username = strtolower($username);
    $query = "SELECT username FROM users WHERE usernamedata = :username;";
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

function checkCode(object $pdo, string $code) {
    $query = "SELECT * FROM earlyaccess WHERE code = :code";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":code", $code);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}

function checkCodeUsed(object $pdo, string $code) {
    $query = "SELECT * FROM earlyaccess WHERE code = :code";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":code", $code);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['used'];
}

function setUser(object $pdo, string $username, string $pwd, string $email, $birthdate, string $pronouns, int $newsletter, string $randomString, string $code) {
    $query = "SELECT * FROM earlyaccess WHERE code = :code";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":code", $code);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result['kindness']) {
        $kindness = $result['kindness'];
    } else {
        $kindness = 0;
    }
    
    if ($result['token'] == 1) {
        $token = 1;
    } else {
        $token = 0;
    }
    
    $query = "INSERT INTO users (id,username, password, email, birthdate, signupDate, newsletter, pronouns, affirmation, tempCode, usernamedata, kindnessCount,alphaTester) VALUES (:id,:username, :pwd, :email, :birthdate, :signupDate, :newsletter, :pronouns, :affirmation, :tempCode, :data, :kindness,:tester);";
    $stmt = $pdo->prepare($query);
    
    $data = strtolower($username);
    
    //Password Hashing
    $options = [
        'cost' => 12
    ];
    $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);
    $affirmation = "I'm going to do my best to journal everyday. And even when I'm not perfect, I'm going to forgive myself. The important thing is I will keep trying.";
    $one = 1;
    
    $todaysDate = date("Y-m-d");
    
    
    $stmt->bindParam(":id", $result['chosenID']);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":pwd", $hashedPwd);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":birthdate", $birthdate);
    $stmt->bindParam(":signupDate", $todaysDate);
    $stmt->bindParam(":newsletter", $newsletter);
    $stmt->bindParam(":affirmation", $affirmation);
    $stmt->bindParam(":pronouns", $pronouns);
    $stmt->bindParam(":tempCode", $randomString);
    $stmt->bindParam(":data", $data);
    $stmt->bindParam(":kindness", $kindness);
    $stmt->bindParam(":tester", $token);
    $stmt->execute();
    
    $query = "UPDATE earlyaccess SET used = 1 WHERE code = :code";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":code", $code);
    $stmt->execute();
}