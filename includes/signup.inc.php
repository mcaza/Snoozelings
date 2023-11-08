<?php 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];
    $email = $_POST["email"];
    $birthday = $_POST["birthday"];
    
    try {
        
        require_once 'dbh-inc.php';
        require_once 'signup_model.inc.php';
        require_once 'signup_contr.inc.php';
        
        // Error Handlers
        $errors = [];
        
        if (isInputEmpty($username, $pwd, $email)) {
            $errors["empty_input"] = "You must fill in all fields.";
        }
        if (isEmailInvalid($email)) {
            $errors["invalid_email"] = "Invalid email used.";
        }
        if (isUsernameTaken($pdo, $username)) {
            $errors["username_taken"] = "Username already taken.";
        }
        if (isEmailRegistered($pdo, $email)) {
            $errors["email_registered"] = "Email already registered.";
        }
        
        require_once 'config_session.inc.php';
        
        if ($errors) {
            $_SESSION["errors_signup"] = $errors;
            
            $signupData = [
                "username" => $username,
                "email" => $email,
                "birthday" => $birthday
            ];
            $_SESSION['signupData'] = $signupData;
            
            header("Location: ../signup.php");
            die();
        }
        
        createUser($pdo, $username, $pwd, $email, $birthday);
        
        header("Location: ../index.php");
        
        $pdo = null;
        $stmt = null;
        
        die();
        
    } catch (PDOException $e) {
        die("Query Failed:" . $e->getMessage()); 
    }
} else {
    header("Location: ../signup.php?signup=success");
    die();
}

?>