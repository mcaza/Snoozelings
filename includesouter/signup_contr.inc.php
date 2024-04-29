<?php

declare(strict_types=1);

function isInputEmpty(string $username, string $pwd, string $email) {
    if (empty($username) || empty($pwd) || empty($email)) {
        return true;
    }
    else {
        return false;
    }
}

function isEmailInvalid(string $email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    else {
        return false;
    }
}

function isUsernameTaken(object $pdo, string $username) {
    if (getUsername($pdo, $username)) {
        return true;
    }
    else {
        return false;
    }
}

function isEmailRegistered(object $pdo, string $email) {
    if (getEmail($pdo, $email)) {
        return true;
    }
    else {
        return false;
    }
}

function futureDate($date) {
    $todaysDate = date("Y");
    if ($date > $todaysDate) {
        return true;
    }
}

function thirteenYears($date) {
    $date = strtotime($date);
    $today = strtotime("-13 year");
    if ($date > $today) {
        return true;
    }
}

function passwordCheck(string $pwd, string $pwd2) {

    if ($pwd === $pwd2) {
        
    } else {
        return true;
    }
}

function passwordLength($pwd) {
    $count = strlen($pwd);
    if ($count < 8) {
        return true;
    }
}

function alphaEmail(object $pdo, string $email) {
    if (checkEmail($pdo, $email)) {
        return false;
    } else {
        return true;
    }
}

function createUser(object $pdo, string $username, string $pwd, string $email, $birthdate, string $pronouns, int $newsletter, string $randomString) {
    setUser($pdo, $username, $pwd, $email, $birthdate, $pronouns, $newsletter, $randomString);
}