<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

//Grab Form Variables
$name = $_POST["name"];
$pronouns = $_POST["pronouns"];
$status = $_POST["status"];
$title = $_POST["title"];
$id = $_POST['id'];
$bed = $_POST['bed'];
$showbed = $_POST['showbed'];
$bio = $_POST['bio'];
$userId = $_SESSION['user_id'];
    
    //Snoozeling Info
            $query = 'SELECT clothesBottom, clothesTop, clothesHoodie, clothesBoth, owner_id FROM snoozelings WHERE id = :id';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $snooze = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Snoozeling Own Check
    if (!($snooze['owner_id'] === $userId)) {
        header("Location: ../index");
        die();
    }
    
    //Remove Clothing
    $clothesarray = [];
    $query = 'SELECT * FROM itemList';
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $itemcount = count($items) + 2;
    for ($i = 1; $i < $itemcount; $i++) {
        if ($_POST[$i]) {
            $item = $_POST[$i];
            array_push($clothesarray, $item);
            $item = "";
        } }
        foreach ($clothesarray as $item) {
            
            //Snoozeling Info
            $query = 'SELECT clothesBottom, clothesTop, clothesHoodie, clothesBoth, owner_id FROM snoozelings WHERE id = :id';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $snooze = $stmt->fetch(PDO::FETCH_ASSOC);
            $i = $item;
            //Get Type
            $type = $items[$i-1]['type'];
            //Adjust Pet Clothes
            if ($type === "clothesBottom") {
                    $list = explode(" ", $snooze["clothesBottom"]);
                    //Check if Still Equipt
                    $temp = $items[$i-1]['name'];
                    if(!in_array($temp, $list)) {
                        header("Location: ../index");
                        die();
                    }
                    if (count($list) === 1) {
                        $final = "";
                    } else {
                        $key = array_search($items[$i-1]['name'], $list);
                        unset($list[$key]);
                        $newList = array_values($list);
                        if (count($newList) === 1) {
                            $final = $newList[0];
                        } else {
                            $final = implode(" ", $newList);
                        }
                    }
                    $query = 'UPDATE snoozelings SET clothesBottom = :clothes WHERE id = :id';
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(":id", $id);
                    $stmt->bindParam(":clothes", $final);
                    $stmt->execute();
                    $final = "";
                    $list = "";
                    $newList = "";
            } elseif ($type === "clothesTop") {
                    $list = explode(" ", $snooze["clothesTop"]);
                //Check if Still Equipt
                    $temp = $items[$i-1]['name'];
                    if(!in_array($temp, $list)) {
                        header("Location: ../index");
                        die();
                    }
                    if (count($list) === 1) {
                        $final = "";
                    } else {
                        $key = array_search($items[$i-1]['name'], $list);
                        unset($list[$key]);
                        $newList = array_values($list);
                        if (count($newList) === 1) {
                            $final = $newList[0];
                        } else {
                            $final = implode(" ", $newList);
                        }
                    }
                    $query = 'UPDATE snoozelings SET clothesTop = :clothes WHERE id = :id';
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(":id", $id);
                    $stmt->bindParam(":clothes", $final);
                    $stmt->execute();
                    $final = "";
                    $list = "";
                    $newList = "";
            } elseif ($type === "clothesHoodie") {
                    $list = explode(" ", $snooze["clothesHoodie"]);
                //Check if Still Equipt
                    $temp = $items[$i-1]['name'];
                    if(!in_array($temp, $list)) {
                        header("Location: ../index");
                        die();
                    }
                    if (count($list) === 1) {
                        $final = "";
                    } else {
                        $key = array_search($items[$i-1]['name'], $list);
                        unset($list[$key]);
                        $newList = array_values($list);
                        if (count($newList) === 1) {
                            $final = $newList[0];
                        } else {
                            $final = implode(" ", $newList);
                        }
                    }
                    $query = 'UPDATE snoozelings SET clothesHoodie = :clothes WHERE id = :id';
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(":id", $id);
                    $stmt->bindParam(":clothes", $final);
                    $stmt->execute();
                    $final = "";
                    $list = "";
                    $newList = "";
            } elseif ($type === "clothesBoth") {
                    $list = explode(" ", $snooze["clothesBoth"]);
                //Check if Still Equipt
                    $temp = $items[$i-1]['name'];
                    if(!in_array($temp, $list)) {
                        header("Location: ../index");
                        die();
                    }
                    if (count($list) === 1) {
                        $final = "";
                    } else {
                        $key = array_search($items[$i-1]['name'], $list);
                        unset($list[$key]);
                        $newList = array_values($list);
                        if (count($newList) === 1) {
                            $final = $newList[0];
                        } else {
                            $final = implode(" ", $newList);
                        }
                    }
                    $query = 'UPDATE snoozelings SET clothesBoth = :clothes WHERE id = :id';
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(":id", $id);
                    $stmt->bindParam(":clothes", $final);
                    $stmt->execute();
                    $final = "";
                    $list = "";
                    $newList = "";
            }
            
        
      //Return Item
            $query = 'SELECT * FROM itemList WHERE id = :id';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $item);
            $stmt->execute();
            $iteminfo = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $query = "INSERT INTO items (list_id, user_id, name, display, description, type, rarity, canDonate) VALUES (:list, :user, :name, :display, :description, :type, :rarity, :canDonate);";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":list", $item);
            $stmt->bindParam(":user", $userId);
            $stmt->bindParam(":name", $iteminfo['name']);
            $stmt->bindParam(":display", $iteminfo['display']);
            $stmt->bindParam(":description", $iteminfo['description']);
            $stmt->bindParam(":type", $iteminfo['type']);
            $stmt->bindParam(":rarity", $iteminfo['rarity']);
            $stmt->bindParam(":canDonate", $iteminfo['canDonate']);
            $stmt->execute(); 
        } 
            
            
     
            
                
            //Reset $item
            $item = "";
        
    

    //Variable Checks
    //Pronouns
    if ($pronouns) {
        if(!($pronouns === "She/Her" || $pronouns === "He/Him" || $pronouns === "Any" || $pronouns === "They/Them" || $pronouns === "She/Them" || $pronouns === "He/Them" || $pronouns === "She/Him")) {
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
        foreach ($titles as $titl) {
            if ($title === $titl['title']) {
                $check = 1;
            }
        }
        if ($check === 0) {
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
    //Pet Inspiration
    if ($status) {
        if (!($status === "Closed" || $status === "Open")) {
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
        if (!($bed === "BlueFree" || $bed === "BrownFree" || $bed === "GreenFree" || $bed === "PinkFree" || $bed === "RedFree")) {
            header("Location: ../editPet?id=" . $id);
            die();
        } else {
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
            $_SESSION['reply'] = "The bio entered is longer than 500 characters.";
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
    $query = "SELECT bonded FROM users WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $one = intval($result['bonded']);
    $two = intval($id);
    if ($one === $two) {
    $_SESSION['bonded'] = htmlspecialchars($name);
    }
    
//Redirect to Pet Page
header("Location: ../pet?id=" . $id);
} else {
    header("Location: ../index.php");
}