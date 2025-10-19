<?php

function verifyAge($pdo) {
    $userId = $_COOKIE['user_id'];
    $var = $_GET['id'];
    $type = $_GET['type'];


    $query = "SELECT * FROM posts WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $var);
    $stmt->execute();
    $post = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($post['category'] == "mature" || $type == "Mature") {
        
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $date = strtotime($result['birthdate']);
        $today = strtotime("-18 year");
        
        
        
        if ($date < $today) {
               $mature = 1;
        } 

        if ($mature == false) {
            header("Location:../index");
            die();
        }
        
        
    }

}

verifyAge($pdo);

