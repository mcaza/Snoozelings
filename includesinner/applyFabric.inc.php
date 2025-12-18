<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //Get Values
    $userId = $_COOKIE['user_id'];
    $fabric = $_POST['fabric'];
    $pet = $_POST['pet'];

    
    //Get Item Name
    $query = 'SELECT name FROM items WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $fabric);
    $stmt->execute();
    $fabricid = $stmt->fetch(PDO::FETCH_ASSOC);
    $name = str_replace("Fabric", "", $fabricid['name']);
    
    //Get Pet Name
    $query = 'SELECT * FROM snoozelings WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $pet);
    $stmt->execute();
    $petname = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Check and Remove Specials if Dual Nose / Ear Bands
    if (strpos($petname["specials"], "EarBands") !== false || strpos($petname["specials"], "EarBands") !== false) {
        $list = explode(" ", $petname['specials']);
        if (strpos($petname["specials"], "EarBands")) {
            $remove = "EarBands";
            $key = array_search($remove, $list);
            unset($list[$key]);
            $newList = array_values($list); 
        }
        if (strpos($petname["specials"], "DualNose")) {
            $remove = "DualNose";
            $key = array_search($remove, $newList);
            unset($newList[$key]);
            $newListTwo = array_values($newList); 
        }
            
        if (count($newListTwo) == 0) {
            $finalList = "";
        } else if (count($newListTwo) == 1) {
            $finalList = $newListTwo[0];
        } else {
            $finalList = "";
            foreach ($newListTwo as $item) {
                $finalList = $finalList . $item . ' ';
            }
            $finalList = trim($finalList);
        }
            
        $query = 'UPDATE snoozelings SET specials = :specials WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $pet);
        $stmt->bindParam(":specials", $finalList);
        $stmt->execute();
            

    }
    
    //Apply Fabric to Snoozeling
    $query = "UPDATE snoozelings SET noseColor = :fabric WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":fabric", $name);
    $stmt->bindParam(":id", $pet);
    $stmt->execute();
    
    //Remove Item
    $query = 'DELETE FROM items WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $fabric);
    $stmt->execute(); 
    
    //Set Message and Reroute
    $greeting = $petname['name'] . " loves their new fabric!!";
        $reply = $greeting;
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
    header("Location: ../stitcher?page=fabric");
} else {
header("Location: ../index");
    die();
}

