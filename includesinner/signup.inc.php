<?php 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];
    $pwd2 = $_POST["pwd2"];
    $email = strtolower($_POST["email"]);
    $birthday = $_POST["birthday"];
    $pronouns = $_POST["pronouns"];
    $code = $_POST["code"];
    
        $newsletter = 0;
    
    
    try {
        
        require_once '../../includes/dbh-inc.php';
        require_once '../../includes/signup_model.inc.php';
        require_once '../../includes/signup_contr.inc.php';
        
        // Error Handlers
        $errors = [];
        $username = $_POST["username"];
        $pwd = $_POST["pwd"];
        $pwd2 = $_POST["pwd2"];
        $email = strtolower($_POST["email"]);
        $birthday = $_POST["birthday"];
        $pronouns = $_POST["pronouns"];
        $code = $_POST["code"];
        
        if (isInputEmpty($username, $pwd, $email)) {
            header("Location: ../signup?error=1");
            die();
        }
        if (isEmailInvalid($email)) {
            header("Location: ../signup?error=2");
            die();
        }
        if (isUsernameTaken($pdo, $username)) {
            $link = "Location: ../signup?error=3";
            if ($code) {
                $link = $link . '&code=' . $code;
            }
            if ($username) {
                $link = $link . '&username=' . $username;
            }
            header($link);
            die();
        }
        if (isEmailRegistered($pdo, $email)) {
            $link = "Location: ../signup?error=4";
            if ($code) {
                $link = $link . '&code=' . $code;
            }
            if ($username) {
                $link = $link . '&username=' . $username;
            }
            if ($birthday) {
                $link = $link . '&birthday=' . $birthday;
            }
            header($link);
            die();
        }
        
        if (futureDate($birthday)) {
            $link = "Location: ../signup?error=5";
            if ($code) {
                $link = $link . '&code=' . $code;
            }
            if ($username) {
                $link = $link . '&username=' . $username;
            }
            if ($email) {
                $link = $link . '&email=' . $email;
            }
            header($link);
            die();
        }
        
        if(thirteenYears($birthday)) {
            $link = "Location: ../signup?error=6";
            if ($code) {
                $link = $link . '&code=' . $code;
            }
            if ($username) {
                $link = $link . '&username=' . $username;
            }
            if ($email) {
                $link = $link . '&email=' . $email;
            }
            header($link);
            die();
        } 
        if(passwordCheck($pwd, $pwd2)) {
            $link = "Location: ../signup?error=7";
            if ($code) {
                $link = $link . '&code=' . $code;
            }
            if ($username) {
                $link = $link . '&username=' . $username;
            }
            if ($email) {
                $link = $link . '&email=' . $email;
            }
            if ($birthday) {
                $link = $link . '&birthday=' . $birthday;
            }
            header($link);
            die();
        }
        if(passwordLength($pwd)) {
            $link = "Location: ../signup?error=8";
            if ($code) {
                $link = $link . '&code=' . $code;
            }
            if ($username) {
                $link = $link . '&username=' . $username;
            }
            if ($email) {
                $link = $link . '&email=' . $email;
            }
            if ($birthday) {
                $link = $link . '&birthday=' . $birthday;
            }
            header($link);
            die();
        }
        if (earlyAccessCode($pdo, $code)) {
            $link = "Location: ../signup?error=9";
            if ($username) {
                $link = $link . '&username=' . $username;
            }
            if ($email) {
                $link = $link . '&email=' . $email;
            }
            if ($birthday) {
                $link = $link . '&birthday=' . $birthday;
            }
            header($link);
            die();
        }
        if (earlyAccessCodeCheck($pdo, $code)) {
            $link = "Location: ../signup?error=10";
            if ($username) {
                $link = $link . '&username=' . $username;
            }
            if ($email) {
                $link = $link . '&email=' . $email;
            }
            if ($birthday) {
                $link = $link . '&birthday=' . $birthday;
            }
            header($link);
            die();
        }
        if (!($pronouns === "She/Her" || $pronouns === "He/Him" || $pronouns === "Any" || $pronouns === "They/Them" || $pronouns === "She/Them" || $pronouns === "He/Them" || $pronouns === "She/Him")) {
            $link = "Location: ../signup?error=11";
            if ($code) {
                $link = $link . '&code=' . $code;
            }
            if ($username) {
                $link = $link . '&username=' . $username;
            }
            if ($email) {
                $link = $link . '&email=' . $email;
            }
            if ($birthday) {
                $link = $link . '&birthday=' . $birthday;
            }
            header($link);
            die();
        }
        
        require_once '../../includes/config_session.inc.php';
        
        if ($errors) {
            setcookie('errors_signup', $errors, 60, '/');
            
            $signupData = [
                "username" => $username,
                "email" => $email,
                "birthday" => $birthday,
                "code" => $code
            ];
            setcookie('signupData', $signupData, 60, '/');
            
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
          
        createUser($pdo, $username, $pwd, $email, $birthday, $pronouns, $newsletter, $randomString, $code);
        
        $address = $email;

        $title ="Snoozelings Email Confirmation";
        $msg = '<h2>Email Confirmation</h2> <p>Dear ' . $username . ',<br><br>We are excited to welcome you into the world of Snoozelings!!! <br><br>You\'ll get to play in just a few more seconds, but first, we need you to confirm your email using the link below. If the link doesn\t work, you can also copy & paste the code manually.<br><br><a href="https://snoozelings.com/verify?code=' . $randomString . '">Click Here to Verify Email</a></p><h1>' . $randomString . '</h1><p>See you soon,<br><i>Snoozelings</i></p>';

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        //From
        $headers .= 'From: Snoozelings <autoreply@snoozelings.com>' . "\r\n";

        mail($address, $title, $msg, $headers);
        
        header("Location: ../login?success=1");
        
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