<?php 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];
    $pwd2 = $_POST["pwd2"];
    $email = strtolower($_POST["email"]);
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
        if (alphaEmail($pdo, $email)) {
            $errors["alpha_email"] = "That email is not registered for alpha testing.";
        }
        if (!($pronouns === "She/Her" || $pronouns === "He/Him" || $pronouns === "Any" || $pronouns === "They/Them" || $pronouns === "She/Them" || $pronouns === "He/Them" || $pronouns === "She/Him")) {
            $errors["pronouns"] = "Please do not enter custom pronouns.";
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
        
        //Email Code
        $length = 8;
        $characters = '0123456789abcdefghijklmnopqrs092u3tuvwxyzaskdhfhf9882323ABCDEFGHIJKLMNksadf9044OPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
          
        createUser($pdo, $username, $pwd, $email, $birthday, $pronouns, $newsletter, $randomString);
        
        $address = $email;

        $title ="Snoozelings Email Confirmation";
        $msg = '<h2>Email Confirmation</h2> <p>Dear ' . $username . ',<br><br>We are excited to welcome you into the world of Snoozelings!!! <br><br>You\'ll get to play in just a few more seconds, but first, we need you to confirm your email using the link below. If the link doesn\t work, you can also copy & paste the code manually.<br><br><a href="https://snoozelings.com/verify?code=' . $randomString . '">Click Here to Verify Email</a></p><h1>' . $randomString . '</h1><p>If you did not personally attempt to log in to your account just now, please reset your password immediately.<br><br>See you soon,<br><i>Snoozelings</i></p>';

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        //From
        $headers .= 'From: Snoozelings <autoreply@snoozelings.com>' . "\r\n";

        mail($address, $title, $msg, $headers);
        
        header("Location: ../login");
        
        $pdo = null;
        $stmt = null;
        
        die();
        
    } catch (PDOException $e) {
        die("Query Failed:" . $e->getMessage()); 
    }
} else {
    header("Location: ../");
    die();
}

?>