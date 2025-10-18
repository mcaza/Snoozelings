<?php

$userId = $_COOKIE['user_id'];

//Get Username 
    $query = 'SELECT * FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $nameCheck = $stmt->fetch(PDO::FETCH_ASSOC);

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
    $check = 0;
    
    //Check Likers
    if ($post['likers']) {
        $likers = explode(" ", $post['likers']);
        if (in_array($nameCheck['username'], $likers)) {
            $check = 1;
        }
    }
    
    echo '<div class="leftRightButtons">';
    echo '<a href="critterweb"><<</a>';
    echo '</div>';
    echo '<div class="button-bar">';
    if ($check == 0)  {
        echo "<form method='POST' action='includes/like.inc.php'>";
        echo '<input type="hidden" name="post" value="' . $id . '">';
        echo '<button class="fancyButton">Like</button>';
        echo '</form>';
        //echo '<button class="fancyButton" onClick="window.location.href=\'includes/like.inc.php?id=' . $id . '\'">Like</button>';
    }
    echo '<button class="fancyButton" id="commentButton">Comment</button></div>';
    
    echo '<div class="postSquare">';
    
    //Hidden Form
    echo '<div id="makeComment">';
    echo '<form method="POST" id="comment" name="comment" action="includes/comment.inc.php">';
    if ($post['category'] == "share") {
        //Grab Snoozelings
        $query = 'SELECT * FROM snoozelings WHERE owner_id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
        $pets = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo '<label style="margin-top: 2rem;" for="title" class="form">Attach Snoozeling:</label><br>';
        echo '<select class="input"  name="snooze" style="width: auto;">';
        echo '<option value=""></option>';
        foreach ($pets as $snooze) {
            echo '<option value="' . $snooze['id'] . '">' . $snooze['name'] . '</option>';
        }
        echo '</select>';
        echo '<p style="font-size:12px;margin-top:0;">*Snoozeling is Optional*</p><br>';
    }
    echo '<textarea id="comment" name="comment" rows="10" cols="80"></textarea><br>';
    echo '<input type="hidden" id="postId" name="postId" value="' . $id . '" />';
    echo '<button class="fancyButton">Post Comment</button></div>';
    echo '</div>';
    
    $content = htmlspecialchars($post['text'], ENT_QUOTES);
    
    $turned = array('&lt;b&gt;', '&lt;/b&gt;', '&lt;em&gt;', '&lt;/em&gt;', '&lt;u&gt;', '&lt;/u&gt;', '&lt;ul&gt;', '&lt;/ul&gt;', '&lt;li&gt;', '&lt;/li&gt;', '&lt;ol&gt;', '&lt;/ol&gt;', '&lt;i&gt;', '&lt;/i&gt;', '&lt;h1&gt;', '&lt;/h1&gt;', '&lt;s&gt;', '&lt;/s&gt;', '&lt;pre&gt;', '&lt;/pre&gt;', '&lt;table&gt;', '&lt;/table&gt;', '&lt;tr&gt;', '&lt;/tr&gt;', '&lt;th&gt;', '&lt;/th&gt;', '&lt;td&gt;', '&lt;/td&gt;', '&lt;B&gt;', '&lt;/B&gt;', '&lt;EM&gt;', '&lt;/EM&gt;', '&lt;U&gt;', '&lt;/U&gt;', '&lt;UL&gt;', '&lt;/UL&gt;', '&lt;LI&gt;', '&lt;/LI&gt;', '&lt;OL&gt;', '&lt;/OL&gt;', '&lt;I&gt;', '&lt;/I&gt;', '&lt;H1&gt;', '&lt;/H1&gt;', '&lt;S&gt;', '&lt;/S&gt;', '&lt;PRE&gt;', '&lt;/PRE&gt;', '&lt;TABLE&gt;', '&lt;/TABLE&gt;', '&lt;TR&gt;', '&lt;/TR&gt;', '&lt;TH&gt;', '&lt;/TH&gt;', '&lt;TD&gt;', '&lt;/TD&gt;' );
    $turn_back = array('<b>', '</b>', '<em>', '</em>', '<u>', '</u>', '<ul>', '</ul>', '<li>', '</li>', '<ol>', '</ol>', '<i>', '</i>', '<h1>', '</h1>', '<s>', '</s>', '<pre>', '</pre>', '<table>', '</table>', '<tr>', '</tr>', '<th>', '</th>', '<td>', '</td>', '<b>', '</b>', '<em>', '</em>', '<u>', '</u>', '<ul>', '</ul>', '<li>', '</li>', '<ol>', '</ol>', '<i>', '</i>', '<h1>', '</h1>', '<s>', '</s>', '<pre>', '</pre>', '<table>', '</table>', '<tr>', '</tr>', '<th>', '</th>', '<td>', '</td>');

    $content = str_replace( $turned, $turn_back, $content );
    
    $content = nl2br($content);
    
    echo '<h3>' . htmlspecialchars($post['title']) . '</h3><br>';
    
    if ($post['category'] === 'submissions' || $post['category'] === 'news') {
        echo '<div class="staffpost" style="margin-top: 3rem;margin-bottom: 3rem;width: 70%;margin-left: auto;margin-right: auto;line-height: 2rem;">' . nl2br($post['text']) . '</div>';
    } else {
        echo '<div  class="forumPost">';
        echo '<p>' . $content . '</p>';
        echo '</div>';
    }
    
    if ($post['snoozeling']) {
        $query = "SELECT * FROM snoozelings WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $post['snoozeling']);
        $stmt->execute();
        $petInfo = $stmt->fetch(PDO::FETCH_ASSOC);
        displayPet($petInfo, "art");
        echo '<p><b>' . $petInfo['name'] . '</b></p>';
    }
    echo '</div>';
    
    echo '<hr>';
    
     //Date
    $phpdate = strtotime($post['datetime']);
    $mysqldate = date('m-d-Y',$phpdate);
    echo '<p><b>Posted on ' . $mysqldate . '</b></p>';
    
    echo '<hr style="margin-top: 2rem; margin-bottom: 2rem;">';
    echo '<p><i>' . $post['likes'] . ' Likes, ' . $count . ' Comments</i></p>';
    
    
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
        if ($comment['snoozeling']) { 
            $stmt->bindParam(":id", $comment['snoozeling']);
        } else {
            $stmt->bindParam(":id", $result['bonded']);
        }
        $stmt->execute();
        $pet = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $content = htmlspecialchars($comment['comment'], ENT_QUOTES);
        
        $content = str_replace( $turned, $turn_back, $content );
        
        $content = nl2br($content);
        
        echo '<div class="commentBox">';
        echo '<div class="commentPet" style="border-right: 	#E5E4E2 1px solid;">';
        displayPet($pet, "tinyPet");
        echo '<p style="margin-top: 0;"><b><a href="profile?id=' . $comment['user_id'] . '">' . htmlspecialchars($result['username']) . '</a></b></p>';
        echo '</div>';
        echo '<div class="commentText" >';
        echo '<p>' . $content . '</p>';
        echo '</div>';
        echo '</div>';
    }
    
} else {
     header("Location: boards");
}