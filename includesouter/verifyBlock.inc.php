<?php

function verifyBlock($pdo) {
    $userId = $_COOKIE['user_id'];
    $id = $_GET['id'];
    
    
    //Get Blocked List
    $query = 'SELECT * FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $userId);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $blocks = explode(" ", $user['blockedBy']);
    
    $query = "SELECT * FROM posts WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    
    if(in_array($post['user_id'], $blocks)) {
        header("Location:../index");
        die();
    }

}

verifyBlock($pdo);

