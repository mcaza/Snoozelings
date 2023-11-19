<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

//Get Variables
    $userId = $_SESSION['user_id'];
    $post = $_POST['postId'];
    $comment = $_POST['comment'];
    
    //Insert Comment
    $query = "INSERT INTO comments (post_id, user_id, comment) VALUES (:post, :id, :comment)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":post", $post);
    $stmt->bindParam(":comment", $comment);
    $stmt->execute();
    //Return
    header("Location: ../post.php?id=" . $post);
    
} else {
header("Location: ../boards.php");
    die();
}

