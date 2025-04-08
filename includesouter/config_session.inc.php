<?php



session_set_cookie_params([
   'lifetime' => 0, 
    'domain' => 'snoozelings.com',
    'path' => '/',
    'secure' => true,
    'httponly' => true
]);

$token = $_COOKIE['PHPSESSID'];

if ($token) {
    $query = "SELECT * FROM sessions WHERE session = :token";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":token", $token);
    $stmt->execute();
    $testToken = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($testToken) {
        $now = new DateTime("now", new DateTimezone('EST'));
        $formatted = $now->format('Y-m-d H:i:s');
        //$checkOne = $now->format('Y-m-d');
        
        $query = "UPDATE sessions SET datetime = :datetime WHERE session = :token";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":datetime", $formatted);
        $stmt->bindParam(":token", $testToken['session']);
        $stmt->execute();
        
        /*
        if ($CheckOne == $testToken['datetime']) {
            echo 'success';
            die();
        }
        */
        $userId = $testToken['username'];
        session_start();
        session_id($token);
        
        
        
        
    } 
    
    
}

/* if (session_status() == PHP_SESSION_NONE) {
    session_start();
} */

//Code to Keep All Non Staff Out
/* if (isset($_SESSION['user_id'])) {
    if (intval($_SESSION['user_id']) > 10) {
        session_unset();
        session_destroy();
        header("Location: ../login.php");
        die();
    }
} */

/* if (isset($_SESSION["user_id"])) {
    if (!isset($_SESSION['last_regeneration'])) {
    regenerate_session_id_loggedin();
} else {
    $interval = 60 * 1; 
    if (time() - $_SESSION['last_regeneration'] >= $interval) {
        regenerate_session_id_loggedin();
    }
}
} else {
    if (!isset($_SESSION['last_regeneration'])) {
    regenerate_session_id();
} else {
    $interval = 60 * 1; 
    if (time() - $_SESSION['last_regeneration'] >= $interval) {
        regenerate_session_id();
    }
}
    
} */

function regenerate_session_id() {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
}

function regenerate_session_id_loggedin() {
    session_regenerate_id(true);
    
    $userID = $_SESSION["user_id"];
    
    $newSessionId = session_create_id();
    $sessionId = $newSessionId . "_" . $userID;
    session_id($sessionId);
    
    $_SESSION['last_regeneration'] = time();
}

