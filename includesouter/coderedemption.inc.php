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
$today = new DateTime();

$spring = new DateTime('March 20');
$summer = new DateTime('June 20');
$fall = new DateTime('September 22');
$winter = new DateTime('December 21');

if ($today >= $spring && $today < $summer) {
    echo '<img src="resources/snowsummerNPC.png" class="shopImg" style="width: 50%";">';
} else if ($today >= $summer && $today < $fall) {
    echo '<img src="resources/snowsummerNPC.png" class="shopImg" style="width: 50%";">';
} else if ($today >= $fall && $today < $winter) {
    echo '<img src="resources/snowshopsummerNPC.png" class="shopImg" style="width: 50%";">';
} else {
    echo '<img src="resources/snowshopsummerNPC.png" class="shopImg" style="width: 50%";">';
}
echo '<p><i>So many packages!!! I\'ll need your code to find the right one.</i></p><br>';

//Redeem Merch Code
echo '<h1>Merchandise Code:</h1>';
echo '<form method="post" action="includes/merchcode.inc.php">';
echo '<input type="text" id="code" name="code"><br><br>';
echo "<button class='fancyButton'>Submit Code</button>";
echo '</form>';