<?php

$userId = $_SESSION['user_id'];

 //Back to Pack Arrows
 echo '<div class="leftRightButtons">';
echo '<a href="boards"><<</a>';
echo '</div>';

//Title
echo '<h3>Post a Bulletin</h3>';
echo '<p style="margin-top:1.2rem">You can only post 1 bulletin each day.</p>';

//Check for Post
$query = 'SELECT * FROM posts WHERE user_id = :id ORDER BY datetime DESC LIMIT 1';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

//Check if Posted Today
$num = intval($result['new']);
if (!$num === 0) {
    echo '<p style="margin-top: 2rem;"><strong>You have already posted on the bulletin board today.</strong></p>';
} else {
    //Form
    echo "<form method='POST' action='includes/postBulletin.inc.php' onsubmit=\"return confirm('You can only post 1 journal per day.');\">";  

    //Pick Category
    echo '<label style="margin-top: 2rem;" for="type" class="form">Category:</label><br>';
    echo '<select class="input"  name="type" style="width: 8rem;">';
    echo '<option value=""></option>';
    echo '<option value="general">General</option>';
    echo '<option value="freebies">Freebies</option>';
    
    //Edit to 1 After Testing
    if ($userId === "4") {
        echo '<option value="official">Official</option>';
    }
    
    echo '</select><br>';
    
    //Enter Title
    echo '<label style="margin-top: 2rem;" for="title" class="form">Title:</label><br>';
    echo '<input class="input" type="text" name="title"><br>';
    
    //Enter Text
    echo '<label style="margin-top: 2rem;" for="post" class="form">Post:</label><br>';
    echo '<textarea class="input" name="post" style="width: 50rem;" rows="80"></textarea><br>';

    //End Form
    echo '<button  class="fancyButton" style="width: 8rem;">Post</button>';
    echo '</form>';
}
  

