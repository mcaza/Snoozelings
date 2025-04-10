<?php
require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $userId = $_COOKIE['user_id'];
    $difficulty = $_POST["difficulty"];
    $post = $_POST["post"];
    
    //Check Difficulty
    if ($difficulty == "Easy" || $difficulty == "Moderate" || $difficulty == "Stressful") {
        
    } else {
        header("Location: ../index");
    }
    
    //Check if User has posted today
    $query = 'SELECT * FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result['penpalRequests'] == 1) {
        header("Location: ../index");
    }
    
    //Post Request
    $now = new DateTime("now", new DateTimezone('UTC'));
    $hours = 168;
    $modified = (clone $now)->add(new DateInterval("PT{$hours}H")); 
    $formatted = $modified->format('Y-m-d H:i:s');
    
    $query = "INSERT INTO penpalRequests (post, setting, user, expire) VALUES (:post,:setting,:user,:expire);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":post", $post);
    $stmt->bindParam(":setting", $difficulty);
    $stmt->bindParam(":user", $userId);
    $stmt->bindParam(":expire", $formatted);
    $stmt->execute();
    
    //Mark User as posted for day
    $query = "UPDATE users SET penpalRequests = 1 WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    
    //Redirect with Reply
        $reply = "Your Request Has Been Submitted.";
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
    header("Location: ../penpals");
    
    
} else {
     header("Location: ../index");
}

