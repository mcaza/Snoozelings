<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["usernamelogin"];
    $pwd = $_POST["pwdlogin"];
    try {
        require_once '../../includes/dbh-inc.php';
        require_once '../../includes/login_model.inc.php';
        require_once '../../includes/login_contr.inc.php';
        
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
        
        require_once '../../includes/config_session.inc.php';
        
        if ($errors) {
            $_SESSION["errors_login"] = $errors;
            
            header("Location: ../login.php");
            die();
        } 
        
        $newSessionId = session_create_id();
        $sessionId = $newSessionId . "_" . $results["id"];
        //session_id($sessionId);
        
        //Set Bonded Pet Name
        $name = petName($pdo, $results['bonded']);
        $_SESSION["user_id"] = $results["id"];
        $_SESSION["user_username"] = htmlspecialchars($results["username"]);
        $_SESSION['bonded'] = htmlspecialchars($name['name']);
        
        $_SESSION["last_regeneration"] = time();
        
        header("Location: ../");
        
        $pdo=null;
        $stmt = null;
        die();
        
    } 
    catch (PDPException $e) {
        die("Query failed:" . $e->getMessage());
    }
}
else {
    header("Location: ../");
    die();
}