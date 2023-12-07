<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //Grab Form Variables
    $title = $_POST["title"];
    $post = $_POST["post"];
    $type= $_POST["type"];
    $userId = $_SESSION['user_id'];
    $likes = 0;
    $new = 0;
    
    if (!($type === 'general' || $type === 'media' || $type === 'freebies' || $type === 'artwork' || $type === 'guides' || ($type === 'official' && $userId === "1"))) {
        $_SESSION['title'] = $title;
        $_SESSION['post'] = $post;
        header("Location: ../newPost");
        die();
    }
    
    //Get Date
    $now = new DateTime();
    $formatted = $now->format('Y-m-d H:i:s');
    
    //Post Bulletin
    $query = 'INSERT INTO posts (user_id, category, datetime, likes, title, text, new) VALUES (:id, :category, :date, :likes, :title, :text, :new)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":date", $formatted);
    $stmt->bindParam(":category", $type);
    $stmt->bindParam(":likes", $likes);
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":text", $post);
    $stmt->bindParam(":new", $new);
    $stmt->execute();
    
    //Reroute
    header("Location: ../boards.php");
    
} else {
    header("Location: ../boards.php");
}
