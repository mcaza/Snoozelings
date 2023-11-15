<?php 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];
    $pwd2 = $_POST["pwd2"];
    $email = $_POST["email"];
    $birthday = $_POST["birthday"];
    $pronouns = $_POST["pronouns"];
    if (isset($_POST['newsletter'])) {
        $newsletter = 1;
    } else {
        $newsletter = 0;
    }
    
    try {
        
        require_once '../../includes/dbh-inc.php';
        require_once '../../includes/signup_model.inc.php';
        require_once '../../includes/signup_contr.inc.php';
        
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
        
        if (futureDate($birthday)) {
            $errors["future_date"] = "Your birth date cannot be in the future.";
        }
        
        if(thirteenYears($birthday)) {
            $errors["too_young"] = "You need to be 13 or older to register.";
        } 
        if(passwordCheck($pwd, $pwd2)) {
            $errors["no_match"] = "Your passwords do not match.";
        }
        if(passwordLength($pwd)) {
            $errors["short_password"] = "Your password must be at least 8 characters in length.";
        }
        
        require_once '../../includes/config_session.inc.php';
        
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
        
        createUser($pdo, $username, $pwd, $email, $birthday, $pronouns, $newsletter);
        
        header("Location: ../login.php");
        
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