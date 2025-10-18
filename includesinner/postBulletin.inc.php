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
    $new = 1;
    
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
    
     if ($_POST['image']) {
        $image = $_POST['image'];
    }
    
    
    if (isset($_POST['publish'])) {
        //Get Date
        $now = new DateTime("now", new DateTimezone('UTC'));
        $formatted = $now->format('Y-m-d H:i:s');

        //Post Bulletin
        if ($snooze) {
            $query = 'INSERT INTO posts (user_id, category, datetime, likes, title, text, new, snoozeling) VALUES (:id, :category, :date, :likes, :title, :text, :new, :snoozeling)';
        } else if ($image) {
            $query = 'INSERT INTO posts (user_id, category, datetime, likes, title, text, new, image) VALUES (:id, :category, :date, :likes, :title, :text, :new, :image)';
        } else {
            $query = 'INSERT INTO posts (user_id, category, datetime, likes, title, text, new) VALUES (:id, :category, :date, :likes, :title, :text, :new)';
        }
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->bindParam(":date", $formatted);
        $stmt->bindParam(":category", $type);
        $stmt->bindParam(":likes", $likes);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":text", $post);
        $stmt->bindParam(":new", $new);
        if ($snooze) {
            $stmt->bindParam(":snoozeling", $snooze);
        }
        if ($image) {
            $stmt->bindParam(":image", $image);
        }
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
