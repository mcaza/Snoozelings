<?php
require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

$userId = $_SESSION['user_id'];

//Get User Info
$query = "SELECT dailyPrize FROM users WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);


$number = intval($result['dailyPrize']);
if ($number === 0) {
//Get All Items
$num = 1;
$query = "SELECT * FROM itemList WHERE canWin = :num";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":num", $num);
$stmt->execute();
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Roll Items
$count = count($items);
$randomNum = rand(0, $count - 1);

//Insert Items
$query = "INSERT INTO items (list_id, user_id, name, display, description, type, rarity, canDonate) VALUES (:list, :user, :name, :display, :description, :type, :rarity, :canDonate);";
        $stmt = $pdo->prepare($query);
    $stmt->bindParam(":list", $items[$randomNum]['id']);
    $stmt->bindParam(":user", $userId);
    $stmt->bindParam(":name", $items[$randomNum]['name']);
    $stmt->bindParam(":display", $items[$randomNum]['display']);
    $stmt->bindParam(":description", $items[$randomNum]['description']);
    $stmt->bindParam(":type", $items[$randomNum]['type']);
    $stmt->bindParam(":rarity", $items[$randomNum]['rarity']);
    $stmt->bindParam(":canDonate", $items[$randomNum]['canDonate']);
    $stmt->execute(); 
    
 //Change User dailyPrize to 1
$query = "UPDATE users SET dailyPrize = :num WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->bindParam(":num", $num);
$stmt->execute(); 

//Redirect
    $_SESSION['reply'] = "You have received the following item: " . $items[$randomNum]['display'];
    header("Location: ../randomitem");
} else {
    header("Location: ../randomitem");
}