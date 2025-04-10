<?php

$code = $_GET['code'];
$error = $_GET['error'];
$reset = $_GET['reset'];



echo '<img class="wideImage" src="resources/wideBarPlaceholder.png">';

//Notification
if ($error || $reset) {
    echo '<div class="returnBar" style="margin-top: 1rem;margin-bottom:2rem;"><p>';
    if ($reset == 1) {
        echo 'A password reset code has been sent to the email on file.';
    } else if ($error == 1) {
        echo 'You must enter both your email and username to change your password.';
    } else if ($error == 2) {
        echo 'There is no account associated with that email.';
    } else if ($error == 3) {
        echo 'That username and email do not match. Please try again.';
    } else if ($error == 4) {
        echo 'There is no account associated with that email.';
    } else if ($reset == 2) {
        echo 'An email has been sent containing your username.';
    }
    else if ($error == 5) {
        echo 'You must enter both the code, password, and confirm your password.';
    } else if ($error == 6) {
        echo 'The temporary code you entered is incorrect.';
    } else if ($error == 7) {
        echo 'The passwords entered do not match.';
    } else if ($error == 8) {
        echo 'Your password must be at least 8 characters long.';
    } else if ($reset == 3) {
        echo 'Your password has been reset. You may now log in.';
    }
    echo '</p></div>';

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