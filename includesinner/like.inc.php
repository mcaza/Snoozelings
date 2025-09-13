<?php
require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id = $_POST['post'];
    $userId = $_COOKIE['user_id'];
    
    //Get Username 
    $query = 'SELECT * FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $nameCheck = $stmt->fetch(PDO::FETCH_ASSOC);
    
    
    //Check if User has Liked
    //Get UserList
    $query = 'SELECT likers FROM posts WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $users = $stmt->fetch(PDO::FETCH_ASSOC);

    $likers = explode(" ", $users['likers']);
    if (in_array($nameCheck['username'], $likers)) {
            header("Location: ../post?id=" . $id);
    } else {


    //Add Plus 1 Like to Post
      $query = 'UPDATE posts SET likes = likes + 1 WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

    $list = $users['likers'];
    $list .= " " . $nameCheck['username'];
    $list = trim($list);


    //Add Username to Post Likers
    $query = "UPDATE posts SET likers = :likers WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":likers", $list);
    $stmt->execute();

    //Rerout to Post
     header("Location: ../post?id=" . $id);
    }

} else {
header("Location: ../index");
    die();
}