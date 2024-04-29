<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $code = $_POST["code"];
    $pwd = $_POST["password"];
    $two = $_POST["two"];
    
    //Check Code is Enterred
    if (!$code || !$pwd || !$two) {
        $_SESSION["reply"] = "You must enter both the code, password, and confirm your password.";
        header("Location: ../helpme");
        die();
    }
    
    //Check if Code Matches tempCode
    $query = 'SELECT id FROM users WHERE tempCode = :tempCode';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":tempCode", $code);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        $_SESSION["reply"] = "The temporary code you enterred is incorrect.";
        header("Location: ../helpme");
        die();
    }
    
    //Check if Passwords Match
    if (!($pwd === $two)) {
        $_SESSION["reply"] = "The passwords enterred do not match.";
        header("Location: ../helpme?code=" . $code);
        die();
    }
    
    //Check Password Length
    $count = strlen($pwd);
    if ($count < 8) {
        $_SESSION["reply"] = "Your password must be at least 8 characters long.";
        header("Location: ../helpme?code=" . $code);
        die();
    }
    
    //Hash Password
    $options = [
        'cost' => 12
    ];
    $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);
    
    //Update Password
    $temp = "";
    $query = 'UPDATE users SET password = :pwd, tempCode = :temp WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":temp", $temp);
    $stmt->bindParam(":pwd", $hashedPwd);
    $stmt->bindParam(":id", $user['id']);
    $stmt->execute();
    
    //Reply & Reroute
    $_SESSION["reply"] = "Your password has been reset. You may now log in.";
    header("Location: ../helpme?code=" . $code);
    
} else {
    header("Location: ../index");
}