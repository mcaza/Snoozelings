<?php

if (isset($_SESSION["user_id"])) {
$userId = $_SESSION['user_id'];
}

$query = "SELECT * FROM notifications WHERE user_id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($results as $result) {
        echo '<a href="' . $result["url"] . '" class="taskList">' . $result["message"] . '</a><br>';
    }