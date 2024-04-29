<?php

$userId = $_SESSION['user_id'];
$reply = $_SESSION['reply'];
unset($_SESSION['reply']);

//Notification
if ($reply) {
    echo '<div class="returnBar" style="margin-top: 1rem;margin-bottom:2rem;">';
    echo '<p>' . $reply . '</p>';
    echo '</div>';
}

//Form
echo '<h3 style="margin-bottom:2rem">Secret Early Access Form</h3>';
echo '<form action="includes/earlyaccess.inc.php" method="POST">';
echo '<label class="form" for="email">Email:</label><br>';
echo '<input type="email" name="email" class="input" required><br>';
echo '<label class="form" for="number">ID:</label><br>';
echo '<input type="number" name="number" class="input"><br>';
echo '<button  class="fancyButton">Submit</button>';