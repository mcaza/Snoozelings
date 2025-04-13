<?php

require_once 'dbh-inc.php';

$cat = "Common";
$query = "SELECT * FROM colors WHERE rarity = :cat";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":cat", $cat);
$stmt->execute();
$colors = $stmt->fetchAll(PDO::FETCH_ASSOC);

$type = "stain";
$query = "SELECT * FROM itemList WHERE type= :type";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":type", $type);
$stmt->execute();
$itemList = $stmt->fetchAll(PDO::FETCH_ASSOC);

/*
foreach ($colors as $color) {
    //Check if Already Color
    $temp = 0;
    $tempName = "Stain" . $color['name'];
    foreach ($itemList as $check) {
        if ($tempName == $check['name']) {
            $temp = 1;
        }
    }
    
    //If not color, add as color
    if ($temp == 0) {
        $fullName = "Stain: " . $color['display'];
        $description = 'Used to permanently dye a snoozeling\'s fur to the ' . $color['display'] . ' color.';
        $type = "stain";
        $rarity = "uncommon";
        $zero = 0;
        $tooltip = "Found by dropping an old coin into the wishing well.";
        $query = "INSERT INTO itemList (name, display, description, type, rarity, canDonate, canWin, canDye, multiples, tooltip) VALUES (:name, :display, :description, :type, :rarity, :canDonate, :canWin, :canDye, :multiples, :tooltip);";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":name", $tempName);
        $stmt->bindParam(":display", $fullName);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":type", $type);
        $stmt->bindParam(":rarity", $rarity);
        $stmt->bindParam(":canDonate", $zero);
        $stmt->bindParam(":canWin", $zero);
        $stmt->bindParam(":canDye", $zero);
        $stmt->bindParam(":multiples", $fullName);
        $stmt->bindParam(":tooltip", $tooltip);
        $stmt->execute();
    }
}

*/

//Fix Color Names

    foreach ($itemList as $color) {
        $tempName = str_replace("Stain","",$color['display']);
        $newName = "Stain: " . $tempName;
        $query = "UPDATE itemList SET display = :name WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":name", $newName);
        $stmt->bindParam(":id", $color['id']);
        $stmt->execute();
    }

echo 'Script Ended';


























