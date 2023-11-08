<?php

if (isset($_SESSION["user_id"])) {
$userId = $_SESSION['user_id'];

$query = "SELECT affirmation FROM users WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

echo '<p>' . $result["affirmation"] . '</p>';
} else {
    $query = "SELECT * FROM affirmations";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count = count($results) -1;
    $randNum = rand(0, $count);

echo '<p>' . $results[$randNum]["affirmation"] . '</p>';
}