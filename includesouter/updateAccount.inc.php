<?php

//Get Values
$userId = $_COOKIE['user_id'];

//Replies
$query = "SELECT * FROM replies WHERE user_id = :id;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$reply = $stmt->fetch(PDO::FETCH_ASSOC);


//Newsletter Status
$query = 'SELECT * FROM users WHERE id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if ($user['newsletter'] === 1) {
    $yes = "selected";
} else {
    $no = "selected";
}


//Back Arrow & Title
echo '<div class="leftRightButtons">';
echo '<a href="profile?id=' . $userId . '"><<</a>';
echo '</div>';
echo '<h3>Update Your Account</h3>';

//Notification
if ($reply) {
    echo '<div class="returnBar" style="margin-top: 1rem;margin-bottom:2rem;">';
    echo '<p>' . $reply['message'] . '</p>';
    echo '</div>';
    $query = "DELETE FROM replies WHERE user_id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
}

echo '<hr>';

//Change Username
echo '<h4>Change Username</h4>';
echo '<form method="post" action="includes/changeusername.inc.php">';
echo '<label class="form" for="username" style="margin-top: 1rem;">New Username:</label><br>';
echo '<input class="input" type="text" name="username" id="username"><br>';
echo '<label class="form" for="password" style="margin-top: 1rem;">Current Password:</label><br>';
echo '<input class="input" type="text" name="password" id="password"><br>';
echo '<button  class="fancyButton">Submit</button>';
echo '</form>';
echo '<hr>';

//Change Email
echo '<h4>Change Email</h4>';
echo '<form method="post" action="includes/changeemail.inc.php">';
echo '<label class="form" for="email" style="margin-top: 1rem;">New Email:</label><br>';
echo '<input class="input" type="text" name="email" id="email"><br>';
echo '<label class="form" for="password" style="margin-top: 1rem;">Current Password:</label><br>';
echo '<input class="input" type="text" name="password" id="password"><br>';
echo '<button  class="fancyButton">Submit</button>';
echo '</form>';
echo '<hr>';

//Change Password
echo '<h4>Change Password</h4>';
echo '<form method="post" action="includes/changepassword.inc.php">';
echo '<label class="form" for="pwd" style="margin-top: 1rem;">New Password:</label><br>';
echo '<input class="input" type="text" name="pwd" id="pwd"><br>';
echo '<label class="form" for="pwdtwo" style="margin-top: 1rem;">Confirm New Password:</label><br>';
echo '<input class="input" type="text" name="pwdtwo" id="pwdtwo"><br>';
echo '<label class="form" for="password" style="margin-top: 1rem;">Old Password:</label><br>';
echo '<input class="input" type="text" name="password" id="password"><br>';
echo '<button  class="fancyButton">Submit</button>';
echo '</form>';
echo '<hr>';
    
//Toggle Newsletter
echo '<h4>Newsletter Status</h4>';
echo '<label class="form" for="pwd" style="margin-top: 1rem;">Subscribe to Newsletter:</label><br>';
echo '<form method="post" action="includes/newsletter.inc.php">';
echo '<select  class="input" name="status" id="newsletter"><br>';
echo '<option value="1"' . $yes . '>Yes</option>';
echo '<option value="0"' . $no . '>No</option>';
echo '</select><br>';
echo '<button  class="fancyButton">Submit</button>';
echo '</form>';









