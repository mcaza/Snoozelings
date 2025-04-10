<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //Grab Form Variables
    $title = $_POST["title"];
    $post = $_POST["post"];
    $type= $_POST["type"];
    $userId = $_COOKIE['user_id'];
    $likes = 0;
    $new = 0;
    
    if (isset($_POST['publish'])) {
        if (!($type === 'general' || $type === 'fandom' || $type === 'artwork' || $type === 'roleplay' || $type === 'giveaways' || $type === 'guides' || $type === 'questions' || ($type === 'news' && $userId == "1") || ($type === 'submissions' && $userId == "1" || ($type === 'hidden' && $userId == "1")))) {
            setcookie('title', $title, 0, '/');
            setcookie('post', $post, 0, '/');
            header("Location: ../newPost");
            die();
        }
    }
    
    if (isset($_POST['publish'])) {
        //Get Date
        $now = new DateTime("now", new DateTimezone('UTC'));
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

        //Get Bulletin ID
        $query = 'SELECT id FROM posts WHERE user_id = :id ORDER BY id DESC LIMIT 1';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
        $id = $stmt->fetch(PDO::FETCH_ASSOC);

        //Reroute
        header("Location: ../post?id=" . $id['id']);
    }
    elseif (isset($_POST['save'])) {

        setcookie('post', $post, 0, '/');
        setcookie('title', $title, 0, '/');
        setcookie('type', $type, 0, '/');
        
        //Reroute
        header("Location: ../newPost");
    }
    
    
    
} else {
    header("Location: ../index");
}
