<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

//Get Variables
    $userId = $_COOKIE['user_id'];
    $post = $_POST['postId'];
    $comment = $_POST['comment'];
    
    if ($_POST['snooze']) {
        $snooze = $_POST['snooze'];
        
        //Check if Owned by Owner
        $query = 'SELECT * FROM snoozelings WHERE owner_id = :owner AND id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":owner", $userId);
        $stmt->bindParam(":id", $snooze);
        $stmt->execute();
        $snoozecheck = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($snoozecheck) {
            
        } else {
            header("Location: ../newPost");
            die();
        }
    }
    
    //Insert Comment
    if ($snooze) {
        $query = "INSERT INTO comments (post_id, user_id, comment, snoozeling) VALUES (:post, :id, :comment, :snoozeling)";
    } else {
        $query = "INSERT INTO comments (post_id, user_id, comment) VALUES (:post, :id, :comment)";
    }
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":post", $post);
    $stmt->bindParam(":comment", $comment);
    if ($snooze) {
        $stmt->bindParam(":snoozeling", $snooze);
    }
    $stmt->execute();
    //Return
    header("Location: ../post.php?id=" . $post);
    
} else {
header("Location: ../boards.php");
    die();
}

