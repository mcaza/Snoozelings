<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';



if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userId = $_COOKIE['user_id'];
    $pet = $_POST['snoozelingid'];
    if ($_POST['special']) {
        $remove = $_POST['special'];
    } else {
        $greeting = "You did not select a trait to be removed.";
        $reply = $greeting;
        $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":message", $reply);
        $stmt->execute();
        header("Location: ../pack");
    }
    

    
    //Check if They Own Pet
    $query = "SELECT * FROM snoozelings WHERE id = :id AND owner_id = :user";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $pet);
    $stmt->bindParam(":user", $userId);
    $stmt->execute();
    $pet = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($pet) {
        
    } else {
        header("Location: ../index");
        die(); 
    }
    
    //Check if Pet has that Special
    $list = explode(" ", $pet['specials']);
    $list = array_filter($list);
    
    if (in_array($remove,$list)) {

    } else {
        header("Location: ../");
    }
    
    //Check if User has Seam Ripper
    $query = 'SELECT * FROM items WHERE user_id = :id AND list_id = 418';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $check = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($check) {
        //Update Pet's Specials
        //Remove from 1st User
        $key = array_search($remove, $list);
        unset($list[$key]);
        $newList = array_values($list);


        if (count($newList) == 0) {
            $finalList = "";
        } else if (count($newList) == 1) {
            $finalList = $newList[0];
        } else {
            foreach ($newList as $item) {
                $finalList = $finalList . $item . ' ';
            }
            $finalList = trim($finalList);
        }

        
        $query = 'UPDATE snoozelings SET specials = :specials WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $pet['id']);
        $stmt->bindParam(":specials", $finalList);
        $stmt->execute();
        
        //Remove 1 Seam Ripper
        //Delete Item
            $query = 'DELETE FROM items WHERE user_id = :id AND list_id = 418 LIMIT 1';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $userId);
            $stmt->execute();
    
        $greeting = "You have successfully removed " . $remove . ' from ' . $pet['name'] . '.';
        $reply = $greeting;
        $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":message", $reply);
        $stmt->execute();
        header("Location: ../pack");
    } else {
        header("Location: ../index");
        die(); 
    }
    
    
    
} else {
     header("Location: ../");
}
