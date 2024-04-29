<?php

$userId = $_SESSION['user_id'];
$username = $_SESSION['user_username'];

$id = $_GET['id'];


//Get Post Information

$query = "SELECT * FROM posts WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $id);
$stmt->execute();
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if ($post) {
    //Grab All Comments
    $query = "SELECT * FROM comments WHERE post_id = :id ORDER BY id DESC";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count = count($comments);
    
    //Check Likers
    $likers = explode(" ", $post['likers']);
    if (in_array($username, $likers)) {
        $check = true;
    }
    
    
    echo '<div class="leftRightButtons">';
    echo '<a href="boards"><<</a>';
    echo '</div>';
        echo '<div class="button-bar">';
    if (!$check)  {
        echo '                <button class="fancyButton" onClick="window.location.href=\'includes/like.inc.php?id=' . $id . '\'">Like</button>';
    }
    echo '<button class="fancyButton" id="commentButton">Comment</button></div>';
    
    echo '<div class="postSquare">';
    
    //Hidden Form
    echo '<div id="makeComment">';
    echo '<form method="POST" id="comment" name="comment" action="includes/comment.inc.php">';
    echo '<textarea id="comment" name="comment" rows="10" cols="80"></textarea><br>';
    echo '<input type="hidden" id="postId" name="postId" value="' . $id . '" />';
    echo '<button class="fancyButton">Post Comment</button></div>';
    echo '</div>';
    
    
    echo '<h3>' . htmlspecialchars($post['title']) . '</h3>';
    if ($post['category'] === 'submissions' || $post['category'] === 'news') {
        echo '<div class="staffpost" style="margin-top: 3rem;margin-bottom: 3rem;width: 70%;margin-left: auto;margin-right: auto;line-height: 2rem;">' . nl2br($post['text']) . '</div>';
    } else {
        echo '<p style="margin-top: 3rem;margin-bottom: 3rem;width: 70%;margin-left: auto;margin-right: auto;line-height: 2rem;">' . nl2br(htmlspecialchars($post['text'])) . '</p>';
    }
    
    echo '<p><i>' . $post['likes'] . ' Likes, ' . $count . ' Comments</i></p>';
    echo '</div>';
    
    echo '<hr style="margin-top: 2rem; margin-bottom: 2rem;">';
    
    
    foreach ($comments as $comment) {
        //Get Bonded Pet Number
        $query = 'SELECT bonded, username FROM users WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $comment['user_id']);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        //Get Pet Information
        $query = 'SELECT * FROM snoozelings WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $result['bonded']);
        $stmt->execute();
        $pet = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo '<div class="commentBox">';
        echo '<div class="commentPet" style="border-right: 	#E5E4E2 1px solid;">';
        displayPet($pet, "tinyPet");
        echo '<p style="margin-top: 0;"><b><a href="profile?id=' . $comment['user_id'] . '">' . htmlspecialchars($result['username']) . '</a></b></p>';
        echo '</div>';
        echo '<div class="commentText" >';
        echo '<p>' . nl2br(htmlspecialchars($comment['comment'])) . '</p>';
        echo '</div>';
        echo '</div>';
    }
    
} else {
     header("Location: boards");
}