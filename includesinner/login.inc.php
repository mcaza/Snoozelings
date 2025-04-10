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
            header("Location: ../login?error=1");
            die();
        }
        
        $results = getUser($pdo, $username);
        
        if (isUsernameWrong($results)) {
            header("Location: ../login?error=2");
            die();
        }
        
        if (!isUsernameWrong($results) && isPasswordWrong($pwd, $results["password"])) {
            header("Location: ../login?error=3");
            die();
        }
        

        //require_once '../../includes/config_session.inc.php';
        
        if ($errors) {
            setcookie('errors_login', $errors, 0, '/');
            
            header("Location: ../login");
            die();
        } 
        
        $newSessionId = session_create_id();
        $sessionId = $newSessionId . $results["id"];
        
        
        //$id = session_id(); 
        //session_id($sessionId);
        //session_start();
        session_set_cookie_params([
           'lifetime' => 0, 
            'domain' => 'snoozelings.com',
            'path' => '/',
            'secure' => true,
            'httponly' => true
        ]);
        
        //setcookie("user_id",$results["id"]);
        setcookie('PHPSESSID', $sessionId, 0, '/');
        setcookie('user_id',$results["id"], 0, '/');

        //Insert into Server
        $now = new DateTime("now", new DateTimezone('EST'));
        $formatted = $now->format('Y-m-d H:i:s');

        $query = "INSERT INTO sessions (user_id, username, session, datetime) VALUES (:user_id, :username, :session, :datetime)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $results["id"]);
        $stmt->bindParam(":username", $results["username"]);
        $stmt->bindParam(":session", $sessionId);
        $stmt->bindParam(":datetime", $formatted);
        $stmt->execute();


                
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