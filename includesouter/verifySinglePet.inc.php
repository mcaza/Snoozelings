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
           
       } else if ($tutorial == 3 ) {
           $page = "journal";
           
       }
        
        if ($page) {
            
            header("location: " . $page);
            die();
        }
    

    }


verifySinglePet($pdo);
    
}