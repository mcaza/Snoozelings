<?php

$userId = $_SESSION['user_id'];
$title = $_SESSION['title'];
$post = $_SESSION['post'];
unset($_SESSION['title']);
unset($_SESSION['post']);


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
if (!$result || $userId == 1) {
    
    //Form
    echo "<form method='POST' action='includes/postBulletin.inc.php' onsubmit=\"return confirm('You can only post 1 topic in the critter web per day.');\">";  

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
  

