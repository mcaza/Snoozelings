<?php

if (isset($_COOKIE['user_id'])) {
    function verifySinglePet($pdo) {
        $userId = $_COOKIE['user_id'];
        $id = $_GET['id'];


    $query = "SELECT * FROM users WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $tutorial = $result['tutorial'];

    
       if ($tutorial < 3) {
            $page = "welcome";
           
       } else if ($tutorial < 6) {
           $page = "pack";
           
       } else if ($tutorial == 6) {
           $page = "farm";
       }
        
        else if ($tutorial == 7) {
           $page = "explore";
       }
        
        else if ($tutorial == 8) {
           $page = "crafting";
       }
        
        else if ($tutorial < 11) {
           $page = "journal";
       }
        
        else if ($tutorial == 11) {
           $page = "pack";
       }
        
        else if ($tutorial == 12) {
           $page = "profile?id=" . $userId;
       }
        
        else if ($tutorial == 13) {
           $page = "enterGame";
       }
        
        if ($page) {
            
            header("location: " . $page);
            die();
        }
    

    }


verifySinglePet($pdo);
    
}