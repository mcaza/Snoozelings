<?php

$userId = $_SESSION['user_id'];

if ($_SESSION['reply']) {
    $reply = $_SESSION['reply'];
    unset($_SESSION['reply']);
}

//Top Div
echo '<div class="topShop">';

//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="shops"><<</a>';
echo '</div>';
echo '</div>';

//Session Reply Area
if ($reply) {
    echo '<div class="returnBar" style="margin-top: 1rem;"><p>' . $reply . '</p></div><br>';
}

//Show Image. Change Later
echo '<img src="resources/snowNPC.png" style="width: 40%;">';
echo '<p><i>So many packages!!! I\'ll need your code to find the right one.</i></p><br>';

//Redeem Merch Code
echo '<h1>Merchandise Code:</h1>';
echo '<form method="post" action="includes/merchcode.inc.php">';
echo '<input type="text" id="code" name="code"><br><br>';
echo "<button class='fancyButton'>Submit Code</button>";
echo '</form>';