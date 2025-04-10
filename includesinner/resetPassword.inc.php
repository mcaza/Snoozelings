<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $code = $_POST["code"];
    $pwd = $_POST["password"];
    $two = $_POST["two"];
    
    //Check Code is Entered
    if (!$code || !$pwd || !$two) {
        header("Location: ../helpme?error=5");
        die();
    }
    
    //Check if Code Matches tempCode
    $query = 'SELECT id FROM users WHERE tempCode = :tempCode';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":tempCode", $code);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        header("Location: ../helpme?error=6");
        die();
    }
    
    //Check if Passwords Match
    if (!($pwd === $two)) {
        header("Location: ../helpme?code=" . $code . '?error=7');
        die();
    }
    
    //Check Password Length
    $count = strlen($pwd);
    if ($count < 8) {
        header("Location: ../helpme?code=" . $code . '?error=8');
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
    header("Location: ../helpme?reset=2");
    
} else {
    header("Location: ../index");
}