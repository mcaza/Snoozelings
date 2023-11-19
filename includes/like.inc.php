<?php
require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

$id = $_GET['id'];
$username = $_SESSION['user_username'];

//Check if User has Liked
//Get UserList
$query = 'SELECT likers FROM posts WHERE id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $id);
$stmt->execute();
$users = $stmt->fetch(PDO::FETCH_ASSOC);

$likers = explode(" ", $users['likers']);
if (in_array($username, $likers)) {
        header("Location: ../post?id=" . $id);
} else {


//Add Plus 1 Like to Post
  $query = 'UPDATE posts SET likes = likes + 1 WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();


$list .= " " . $username;
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