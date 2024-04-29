<?php



ini_set('session.gc_maxlifetime', 30*60);

ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

session_set_cookie_params([
   'lifetime' => 0, 
    'domain' => 'snoozelings.com',
    'path' => '/',
    'secure' => true,
    'httponly' => true
]);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
if (intval($_SESSION['user_id']) > 10) {
    session_unset();
    session_destroy();
    header("Location: ../login.php");
    die();
}
}

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

