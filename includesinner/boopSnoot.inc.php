<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") { 
    //Get Variables
    $userId = $_SESSION['user_id'];
    $id = $_POST['id'];
    
    //Get Boop Data
    $query = 'SELECT * FROM snoozelings WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Check if User Booped Already
    if ($result['boops']) {
    $boops = explode(" ", $result["boops"]);
    $boopNum = count($boops);
    } else {
        $boops = [];
        $boopNum = 0;
    }
    
    if ($boopNum > 0) {
        if (in_array($userId,$boops)) {
            header("Location: ../index");
            die();
        } else {
            foreach ($boops as $boop) {
                $temp = " " . $boop;
                $final .= $temp;
            }
            $final .= " " . $userId;
            $final = trim($final);
        }
    } else {
        $final = $userId;
    }
    
    //Add Boop
    $query = 'UPDATE snoozelings SET boops = :boops WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":boops", $final);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    
    //Redirect
    header("Location: ../pet?id=" . $id);
    
} else {
     header("Location: ../index");
}