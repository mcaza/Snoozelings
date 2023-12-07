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
    $query = 'SELECT * FROM itemList';
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $itemcount = count($items) + 2;
    for ($i = 1; $i < $itemcount; $i++) {
        if ($_POST[ $i ]) {
            $item = $_POST[$i];
        }
        if ($item) {
            //Get Type
            $type = $items[$i-1]['type'];
            //Adjust Pet Clothes
            switch ($type) {
                case "clothesBottom":
                    $list = explode(" ", $snooze["clothesBottom"]);
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
                break;
                case "clothesTop":
                    $list = explode(" ", $snooze["clothesTop"]);
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
                break;
                case "clothesHoodie":
                    $list = explode(" ", $snooze["clothesHoodie"]);
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
                break;
                case "clothesBoth":
                    $list = explode(" ", $snooze["clothesBoth"]);
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
                break;
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
     
            
                
            //Reset $item
            $item = "";
        }
    }

    //Variable Checks
    //Pronouns
    if ($pronouns) {
        if(!($pronouns === "She/Her" || $pronouns === "He/Him" || $pronouns === "Any" || $pronouns === "They/Them" || $pronouns === "She/Them" || $pronouns === "He/Them")) {
            header("Location: ../editprofile?id=" . $userId);
            die();
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
        }
    }
    //Pet Inspiration
    if ($status) {
        if (!($status === "Closed" || $status === "Open")) {
            header("Location: ../editPet?id=" . $id);
            die();
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
            echo 'test';
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

    //Insert into Pet Table
    $query = "UPDATE snoozelings SET name = :name, pronouns = :pronouns, breedStatus = :status, title = :title WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":pronouns", $pronouns);
    $stmt->bindParam(":status", $status);
    $stmt->bindParam(":title", $title);
    $stmt->execute();
    
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