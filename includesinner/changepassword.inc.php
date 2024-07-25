<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $password = $_POST['password'];
    $pwd = $_POST['pwd'];
    $pwdtwo = $_POST['pwdtwo'];
    $userId = $_SESSION['user_id'];
    
    //Get Hash
    $query = 'SELECT password FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Check Password
    if(!password_verify($password, $result['password'])) {
        $_SESSION['reply'] = "Password entered is not correct.";
        header("Location: ../updateaccount");
        die();
    }
    
    //Check if Passwords Match
    if (!($pwd === $pwdtwo)) {
        $_SESSION['reply'] = "Your new passwords do not match.";
        header("Location: ../updateaccount");
        die();
    }
    
    //Hash New Password
    //Password Hashing
    $options = [
        'cost' => 12
    ];
    $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);
    
    //Update Password
    $query = 'UPDATE users SET password = :password WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":password", $hashedPwd);
    $stmt->execute();
    
    //Reply & Reroute
    $_SESSION['reply'] = "Your password has been changed.";
    header("Location: ../updateaccount");
    die();
    
} else {
header("Location: ../index");
    die();
}
