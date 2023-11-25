<?php

$id = $_GET['id'];

function checkMessageStatus($id, $pdo) {
    $query = 'SELECT blockMessages FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result['blockMessages'] === "1") {
        header("Location: ../index");
    }
}

checkMessageStatus($id, $pdo);