<?php

$code = $_GET['code'];
if ($_SESSION['reply']) {
    $reply = $_SESSION['reply'];
    unset($_SESSION['reply']);
}

echo '<img class="wideImage" src="resources/wideBarPlaceholder.png">';

//Notification
if ($reply) {
    echo '<div class="returnBar" style="margin-top: 1rem;margin-bottom: 2rem;">';
    echo '<p>' . $reply . '</p>';
    echo '</div>';
}

echo '<h3 style="margin-bottom: 1rem;margin-top: 2rem;">Lost Username</h3>';
echo '<form method="post" action="includes/lostUsername.inc.php">';
echo '<label for="email" class="form">Enter Your Email:</label><br>';
echo '<input type="text" name="email" class="input" ><br>';
echo '<button  class="fancyButton">Submit</button>';
echo '</form>';

echo '<hr>';

echo '<h3 style="margin-bottom: 1rem;margin-top: 2rem;">Lost Password</h3>';
echo '<form method="post" action="includes/lostPassword.inc.php">';
echo '<label for="email" class="form">Enter Your Email:</label><br>';
echo '<input type="text" name="email" class="input" ><br>';
echo '<label for="username" class="form">Enter Your Username:</label><br>';
echo '<input type="text" name="username" class="input" ><br>';
echo '<button  class="fancyButton">Submit</button>';
echo '</form>';

echo '<hr>';

echo '<h3 style="margin-bottom: 1rem;margin-top: 2rem;">Reset Password</h3>';
echo '<form method="post" action="includes/resetPassword.inc.php">';
echo '<label for="code" class="form" >Code (From Email):</label><br>';
echo '<input type="text" name="code" class="input" value="' . $code . '"><br>';
echo '<label for="password" class="form">New Password:</label><br>';
echo '<input type="password" name="password" class="input" ><br>';
echo '<label for="two" class="form">Confirm New Password:</label><br>';
echo '<input type="password" name="two" class="input" ><br>';
echo '<button  class="fancyButton">Submit</button>';
echo '</form>';