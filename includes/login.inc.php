<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["usernamelogin"];
    $pwd = $_POST["pwdlogin"];
    try {
        require_once 'dbh-inc.php';
        require_once 'login_model.inc.php';
        require_once 'login_contr.inc.php';
        
        //ERROR HANDLERS
        $errors = [];
        
        if (isInputEmpty($username, $pwd)) {
            $errors["empty_input"] = "You must fill in all fields.";
        }
        
        $results = getUser($pdo, $username);
        
        if (isUsernameWrong($results)) {
            $errors["login_incorrect"] = "Username Doesn't Exist.";
        }
        
        if (!isUsernameWrong($results) && isPasswordWrong($pwd, $results["password"])) {
            $errors["wrong_password"] = "Your password is incorrect";
        }
        
        require_once 'config_session.inc.php';
        
        if ($errors) {
            $_SESSION["errors_login"] = $errors;
            
            header("Location: ../signup.php");
            die();
        } 
        
        $newSessionId = session_create_id();
        $sessionId = $newSessionId . "_" . $results["id"];
        session_id($sessionId);
        
        $_SESSION["user_id"] = $results["id"];
        $_SESSION["user_username"] = htmlspecialchars($results["username"]);
        
        $_SESSION["last_regeneration"] = time();
        
        header("Location: ../signup.php");
        
        $pdo=null;
        $stmt = null;
        die();
        
    } 
    catch (PDPException $e) {
        die("Query failed:" . $e->getMessage());
    }
}
else {
    header("Location: ../index.php");
    die();
}