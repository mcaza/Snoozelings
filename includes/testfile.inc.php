<?php

require_once '../includes/dbh-inc.php';
require_once '../includes/config_session.inc.php';

//Get Info from parent One
$first = 12;
    $query = 'SELECT * FROM snoozelings WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $first);
    $stmt->execute();
    $one = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Get Info From Parent Two
    $two = 25;
    $query = 'SELECT * FROM snoozelings WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $two);
    $stmt->execute();
    $two = $stmt->fetch(PDO::FETCH_ASSOC);

$query = 'SELECT * FROM colors WHERE name = :name';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $one['noseColor']);
    $stmt->execute();
    $cats1 = $stmt->fetch(PDO::FETCH_ASSOC);
    $mainone = explode(" ", $cats1['categories']);
    array_shift($mainone);
    
    $query = 'SELECT * FROM colors WHERE name = :name';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $two['noseColor']);
    $stmt->execute();
    $cats2 = $stmt->fetch(PDO::FETCH_ASSOC);
    $maintwo = explode(" ", $cats2['categories']);
    array_shift($maintwo);
    $mainColors = array_merge($mainone, $maintwo);
    $mainColors = array_unique($mainColors);
    $mainColors = array_values($mainColors);
        


$subcolors = [];
    foreach ($mainColors as $color) {
        $query = "SELECT * FROM colors WHERE categories LIKE CONCAT('%', :colorSearch, '%')";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":colorSearch", $color);
        $stmt->execute();
        $subs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($subs as $sub) {
            if ($sub['rarity'] === "Rare") {
                
            } else {
                array_push($subcolors, $sub['name']);
            }
        }
    }
    $subcolors = array_unique($subcolors);
    $subcolors = array_values($subcolors);

        $count = count($subcolors) - 1;
        $num = rand(0, $count);
        $noseColor = $subcolors[$num];
echo $noseColor;