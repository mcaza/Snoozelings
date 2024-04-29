<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    //Get Values
    $email = trim($_POST["email"]);

    //Check if Email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['reply'] = "That email is invalid.";
        header("Location: ../index");
        die();
    }

    //Check in Database
    $query = 'SELECT * FROM updates WHERE email = :email';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result) {
        $_SESSION['reply'] = "That email is already signed up.";
        header("Location: ../index");
        die(); 
    }

    //Add to Database
    $one = 1;
    $query = 'INSERT INTO updates (email, releases, allnews) VALUES (:email, :one, :one)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":one", $one);
    $stmt->execute();

    //Reply & Return
    $_SESSION['reply'] = "You have successfully signed up for the newsletter.";
    header("Location: ../index");
    die(); 
    
} else {
    header("Location: ../index");
    die();
}
