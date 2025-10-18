<?php

$userId = $_COOKIE['user_id'];
$title = $_COOKIE['title'];
$post = $_COOKIE['post'];
$type = $_GET['type'];

//Check if User is 18+

$query = "SELECT * FROM users WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

 $date = strtotime($result['birthdate']);
    $today = strtotime("-18 year");


    if ($date < $today) {
       $mature = 1;
    } 

if ($type == "news") {
    $news = ' selected ';
} else if ($type == "submissions") {
    $submissions = ' selected ';
} else if ($type == "discussion") {
    $discussion = ' selected ';
} else if ($type == "share") {
    $share = ' selected ';
} else if ($type == "helpcenter") {
    $help = ' selected ';
} else if ($type == "general") {
    $general = ' selected ';
} else if ($type == "virtualpets") {
    $virtualpets = ' selected ';
} else if ($type == "findfriends") {
    $friends = ' selected ';
} else if ($type == "mature") {
    $mature = ' selected ';
} else if ($type == "creative") {
    $creative = ' selected ';
} else if ($type == "roleplay") {
    $roleplay = ' selected ';
} else if ($type == "forumgames") {
    $games = ' selected ';
}


 //Back to Pack Arrows
echo '<div class="leftRightButtons">';
echo '<a href="critterweb"><<</a>';
echo '</div>';

//Title
echo '<h3>Post a Bulletin</h3>';
echo '<p style="margin-top:1.2rem">Only Staff Can Make New Posts on the Critter Web</p>';

//Check for Post
$query = 'SELECT * FROM posts WHERE user_id = :id ORDER BY datetime DESC LIMIT 1';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);


//Check if Posted Today
$num = $result['new'];

if ($num == 1 || $userId == 1) {
    
    //Form
    echo "<form method='POST' action='includes/postBulletin.inc.php' onsubmit=\"return confirm('You can only post 1 topic in the critter web per day.');\">";  

    //Pick Category
    echo '<label style="margin-top: 2rem;" for="type" class="form" required>Category:</label><br>';
    echo '<select class="input"  name="type" style="width: auto;">';
    echo '<option value=""></option>';
    if ($userId == "1") {
    echo '<option value="news" ' . $news . '>News</option>';
    echo '<option value="submissions" ' . $submissions . '>Submissions</option>';
    //echo '<option value="hidden">Hidden</option>';
    }
    
    echo '<option value="discussion" ' . $discussion . '>Game Discussion</option>';
    echo '<option value="share" ' . $share . '>Snoozeling Sharing</option>';
    echo '<option value="helpcenter" ' . $help . '>Help Center</option>';
    echo '<option value="general" ' . $general . '>General Boards</option>';
    echo '<option value="virtualpets" ' . $virtualpets . '>Virtual Pets</option>';
    echo '<option value="findfriends" ' . $friends . '>Find Friendships</option>';
    
    //Mature
    if ($mature == 1) {
        echo '<option value="mature" ' . $mature . '>Mature Boards</option>';
    }
    
    
    
    echo '<option value="creative" ' . $creative . '>Creative Area</option>';
    echo '<option value="roleplay" ' . $roleplay . '>Roleplay Area</option>';
    echo '<option value="forumgames" ' . $games . '>Forum Games</option>';

    
    
    echo '</select><br>';
    
    //Enter Title
    echo '<label style="margin-top: 2rem;" for="title" class="form">Title:</label><br>';
    if ($title) {
        echo '<input class="input" type="text" name="title" value="' . $title . '" required><br>';
    } else {
        echo '<input class="input" type="text" name="title" required><br>';
    }
    
    
    //Enter Text
    echo '<label style="margin-top: 2rem;" for="post" class="form">Post:</label><br>';
    if ($post) {
        echo '<textarea name="post" cols="72" class="input" style="height: 20rem;" required>' . $post . '</textarea><br>';
    } else {
        echo '<textarea name="post" cols="72" class="input" style="height: 20rem;" required></textarea><br>';
    }
    

    //End Form
    echo '<input class="fancyButton" type="submit" name="publish" value="Post" style="margin-right:20px;width:80px;">';
    if ($userId == 1) {
        echo '<input class="fancyButton" type="submit" name="save" value="Preview">';
    }
    
    echo '</form>';
    
    if ($post) {
        echo '<div style="width:70%;margin-left:auto;margin-right:auto;">' . $post . '</div>';
    }
    
} else {
    if ( $result['new'] == "1" || $userId == 1) {
        //Form
    echo "<form method='POST' action='includes/postBulletin.inc.php' onsubmit=\"return confirm('You can only post 1 bulletin board per day.');\">";  

    //Pick Category
    echo '<label style="margin-top: 2rem;" for="type" class="form" required>Category:</label><br>';
    echo '<select class="input"  name="type" style="width: 8rem;">';
    echo '<option value=""></option>';
    if ($userId == "1") {
    echo '<option value="news">News</option>';
    echo '<option value="submissions">Submissions</option>';
    //echo '<option value="hidden">Hidden</option>';
    }
   /* echo '<option value="general">General</option>';
    echo '<option value="fandom">Fandom</option>';
    echo '<option value="artwork">Artwork</option>';
    echo '<option value="roleplay">Roleplay</option>';
    echo '<option value="giveaways">Giveaways</option>';
    echo '<option value="guides">Guides</option>';
    echo '<option value="questions">Questions</option>'; */
    
    //Edit to 1 After Testing
    if ($userId == "1") {
        echo '<option value="official">Official</option>';
    }
    
    echo '</select><br>';
    
    //Enter Title
    echo '<label style="margin-top: 2rem;" for="title" class="form">Title:</label><br>';
    if ($title) {
        echo '<input class="input" type="text" name="title" value="' . $title . '" required><br>';
    } else {
        echo '<input class="input" type="text" name="title" required><br>';
    }
    
    
    //Enter Text
    echo '<label style="margin-top: 2rem;" for="post" class="form">Post:</label><br>';
    if ($post) {
        echo '<textarea name="post" cols="72" class="input" style="height: 20rem;" required>' . $post . '</textarea><br>';
    } else {
        echo '<textarea name="post" cols="72" class="input" style="height: 20rem;" required></textarea><br>';
    }
    

    //End Form
    echo '<button  class="fancyButton" style="width: 8rem;">Post</button>';
    echo '</form>';
    } else {
        echo '<p style="margin-top: 2rem;"><strong>Only Staff Can Make New Posts on the Critter Web</strong></p>';
    }
}
  

