<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

//Get Variables
$userId = $_SESSION['user_id'];
$id = $_GET['id'];

//Get Table Info
$query = 'SELECT * FROM craftingtables WHERE user_id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

//Get Recipe Info
$query = 'SELECT * FROM recipes WHERE id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $id);
$stmt->execute();
$recipe = $stmt->fetch(PDO::FETCH_ASSOC);
    
//Check if User is Crafting    
if (!($result['display'] === "")) {
    header("Location: ../index");
    die();
}


//Check if Pet is High Enough Level for Recipe
$query = 'SELECT job, craftEXP, name FROM snoozelings WHERE id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $result['pet_id']);
$stmt->execute();
$pet = $stmt->fetch(PDO::FETCH_ASSOC);

//Check if Pet is Crafter or Jack
if (!($pet['job'] === "jack" || $pet['job'] === "Crafter")) {
    $_SESSION['reply'] = $pet['name'] . ' needs the crafter or jack of all trades profession to craft.';
    header("Location: ../crafting");
    die();
}

if ($pet['job'] === 'jack' && $recipe['level'] > 1) {
    header("Location: ../index");
    die();
} elseif ($pet['job'] === "Crafter") {
    $exp = $pet['craftEXP'];
    if ($exp < 50) {
        if ($recipe['level'] > 1) {
            header("Location: ../index");
            die();
        }
    } elseif ($exp < 150) {
        if ($recipe['level'] > 2) {
            header("Location: ../index");
            die();
        }
    } elseif ($exp < 325) {
        if ($recipe['level'] > 3) {
            header("Location: ../index");
            die();
        }
    } elseif ($exp < 600) {
        if ($recipe['level'] > 4) {
            header("Location: ../index");
            die();
        }
    } elseif ($exp < 1000) {
        if ($recipe['level'] > 5) {
            header("Location: ../index");
            die();
        }
    }
}

//Check if Has Items
$items = explode(" ", $recipe['items']);
$numbers = explode(" ", $recipe['numbers']);
foreach ($items as $item) {
    $query = 'SELECT * FROM items WHERE name = :name AND user_id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":name", $item);
    $stmt->execute();
    $amount = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count = count($amount);
    $key = array_search($item, $items);
    
    if ($count < $numbers[$key]) {
        $_SESSION['reply'] = "You do not have all the needed items to craft this.";
        header("Location: ../crafting");
        die();
    }
}

//Remove Items
foreach ($items as $item) {
    $key = array_search($item, $items);
    for ($i = 0; $i < $numbers[$key]; $i++) {
        $query = 'DELETE FROM items WHERE name = :name and user_id = :id LIMIT 1';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->bindParam(":name", $item);
        $stmt->execute();
    }
}

//Set Time
$now = new DateTime(null, new DateTimezone('UTC'));
$minutes = 15;
$modified = (clone $now)->add(new DateInterval("PT{$minutes}M")); 
$formatted = $modified->format('Y-m-d H:i:s');

//Update Table
$query = 'UPDATE craftingtables SET recipe_id = :recipe, display = :display, name = :name, finishtime = :time WHERE user_id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->bindParam(":recipe", $recipe['id']);
$stmt->bindParam(":display", $recipe['display']);
$stmt->bindParam(":name", $recipe['name']);
$stmt->bindParam(":time", $formatted);
$stmt->execute();

//Reroute
header("Location: ../crafting");




















