<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';
require_once '../../includes/imageFunction.inc.php';


if ($_SERVER["REQUEST_METHOD"] === "POST") {

//Grab Form Variables
$name = $_POST["name"];
$pronouns = $_POST["pronouns"];
$status = $_POST["status"];
$title = $_POST["title"];
$job = $_POST["job"];
$id = $_POST['id'];
$bed = $_POST['bed'];
$mood = $_POST['mood'];
//$showbed = $_POST['showbed'];
$clothing = $_POST['clothing'];
$bio = $_POST['bio'];
$userId = $_COOKIE['user_id'];
    
    $query = "SELECT * FROM users WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Snoozeling Info
            $query = 'SELECT * FROM snoozelings WHERE id = :id';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $snooze = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Snoozeling Own Check
    if (!($snooze['owner_id'] == $userId)) {
        header("Location: ../index");
        die();
    }
    
    if ($clothing) {
    //Remove Clothing
    
    //Clothing Array
    $query = 'SELECT * FROM snoozelings WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $snooze = $stmt->fetch(PDO::FETCH_ASSOC);
    $list = explode(" ", $snooze["clothes"]);
    
    //Check if Dyed
    $dyeCheck = explode(" ", $clothing);
    
    //Get Name of Item
    $query = 'SELECT * FROM itemList WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $dyeCheck[0]);
    $stmt->execute();
    $item = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (count($dyeCheck) > 1) {
        $dye = true;
        $trueName = $item['name'] . $dyeCheck[1];
    } else {
        $dye = false;
        $trueName = $item['name'];
    }
    
    //Snoozeling Info
    $query = 'SELECT clothes, owner_id FROM snoozelings WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $snooze = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Double Check Item is in List
    
    if (in_array($trueName,$list)) {
        
    } else {
        header("Location: ../index");
        die();
    }
    
    //Remove from Snoozeling
    $key = array_search($trueName, $list);
    unset($list[$key]);
    $newList = array_values($list);
    
    if (count($newList) == 0) {
        $final = "";
    } else {
        $final = implode(" ", $newList);
    }
    
    $query = 'UPDATE snoozelings SET clothes = :clothes WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":clothes", $final);
    $stmt->execute();
    
    //Return Item
    if ($item['name'] == "Bandana") {
        $bandana = 'Bandana [' . $color . ']';
    } 
            
    if ($dye == true) {
        $query = "INSERT INTO items (list_id, user_id, name, display, description, type, rarity, canDonate, dye) VALUES (:list, :user, :name, :display, :description, :type, :rarity, :canDonate, :dye);";
    } else {
        $query = "INSERT INTO items (list_id, user_id, name, display, description, type, rarity, canDonate) VALUES (:list, :user, :name, :display, :description, :type, :rarity, :canDonate);";
    }
   $stmt = $pdo->prepare($query);
   $stmt->bindParam(":list", $item['id']);
   $stmt->bindParam(":user", $userId);
   $stmt->bindParam(":name", $item['name']);
   $stmt->bindParam(":display", $item['display']);
   $stmt->bindParam(":description", $item['description']);
    $stmt->bindParam(":type", $item['type']);
    $stmt->bindParam(":rarity", $item['rarity']);
    $stmt->bindParam(":canDonate", $item['canDonate']);
    if ($dye == true) {
        $stmt->bindParam(":dye", $dyeCheck[1]);
    }
    $stmt->execute(); 
    
    
    }
        
    

    //Variable Checks
    //Pronouns
    if ($pronouns) {
        if(!($pronouns === "She/Her" || $pronouns === "He/Him" || $pronouns === "Any" || $pronouns === "They/Them" || $pronouns === "She/Them" || $pronouns === "He/Them" || $pronouns === "She/Him" || $pronouns === "See Bio")) {
            header("Location: ../editprofile?id=" . $userId);
            die();
        } else {
        $query = 'UPDATE snoozelings SET pronouns = :pronouns WHERE id = :id';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":pronouns", $pronouns);
            $stmt->execute();
        }
    } 
    
    //Snoozeling Title
    if ($title) {
        $query = 'SELECT * FROM titles';
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $titles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $check = 0;
        foreach ($titles as $titlecheck) {
            if ($title === $titlecheck['title']) {
                $check = 1;
            }
        }
        if ($title == "Crop Whisperer" && $snooze['farmEXP'] > 999.5) {
            $check = 1;
        }
        if ($title == "Hooked on Crafts" && $snooze['craftEXP'] > 999.5) {
            $check = 1;
        }
        if ($title == "Grand Adventurer" && $snooze['exploreEXP'] > 999.5) {
            $check = 1;
        }
        if ($check == 0) {
            header("Location: ../editPet?id=" . $id);
            die();
        } else {
            $query = 'UPDATE snoozelings SET title = :title WHERE id = :id';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":title", $title);
            $stmt->execute();
        } 
    } 
    
    //Snoozeling Job
    if ($job) {
        $query = 'SELECT * FROM jobs';
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $check = 0;
        foreach ($jobs as $jobcheck) {
            if ($job === $jobcheck['name']) {
                $check = 1;
            }
        }
        if ($check == 0) {
            header("Location: ../editPet?id=" . $id);
            die();
        } else {
            $query = 'UPDATE snoozelings SET work = :work WHERE id = :id';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":work", $job);
            $stmt->execute();
        } 
    } 
    
    //Pet's Mood
    if ($mood) {
        if(!($mood === "Happy" || $mood === "Sleepy" || $mood === "Overwhelmed" || $mood === "Anxious" || $mood === "Cheeky")) {
            header("Location: ../index");
            die();
        }
        
        $query = "UPDATE snoozelings SET mood = :mood WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":mood", $mood);
        $stmt->execute();
    }
    
    //Pet Inspiration
    if ($status) {
        if (!($status === "Closed" || $status === "Open" || $status === "Friends")) {
            header("Location: ../editPet?id=" . $id);
            die();
        } else {
            $query = 'UPDATE snoozelings SET breedStatus = :breedStatus WHERE id = :id';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":breedStatus", $status);
            $stmt->execute();
        }
    } 
    
    //Bed
    if ($bed) {
        if (!($bed === "BlueFree" || $bed === "BrownFree" || $bed === "GreenFree" || $bed === "PinkFree" || $bed === "RedFree" || $bed === "Holiday" || $bed === "Winter")) {
            header("Location: ../editPet?id=" . $id);
            die();
        } else {
            
            if ($bed == "Holiday" || $bed == "Winter") {
                if (!str_contains($user['covers'], $bed)) {
                    header("Location: ../index");
                    die();
                }
            }
            
            $query = 'UPDATE snoozelings SET bedcolor = :bed WHERE id = :id';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":bed", $bed);
            $stmt->execute();
        }
    }
    
    //Showbed
    if ($showbed) {
        if (!($showbed === "1" || $showbed === "2")) {
            header("Location: ../editPet?id=" . $id);
            die();
        } else {
            
            $query = 'UPDATE snoozelings SET showbed = :bed WHERE id = :id';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":bed", $showbed);
            $stmt->execute();
        }
    }
    
    //Update Bio
    if ($bio) {
        if (strlen($bio) > 500) {
                $reply = "The bio entered is longer than 500 characters.";
            $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":user_id", $userId);
            $stmt->bindParam(":message", $reply);
            $stmt->execute();
            header("Location: ../editPet?id=" . $id);
            die();
        } else {
            $query = 'UPDATE snoozelings SET bio = :bio WHERE id = :id';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":bio", $bio);
            $stmt->execute();
        }
    }
    
    if ($name) {
        $query = 'UPDATE snoozelings SET name = :name WHERE id = :id';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":name", $name);
            $stmt->execute();
    }
    
    //Check if Bonded and Adjust Session Name
    $one = intval($user['bonded']);
    $two = intval($id);
    if ($one === $two) {
        setcookie('bonded', htmlspecialchars($name), 60, '/');
    }
    
    
    //Update Image
    resetImage($id, $pdo);
//Redirect to Pet Page
header("Location: ../pet?id=" . $id);
} else {
    header("Location: ../index.php");
}