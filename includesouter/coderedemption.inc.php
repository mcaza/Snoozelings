<?php

$userId = $_COOKIE['user_id'];

$query = "SELECT * FROM replies WHERE user_id = :id;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$reply = $stmt->fetch(PDO::FETCH_ASSOC);

//Top Div
echo '<div class="topShop">';

//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="shops"><<</a>';
echo '</div>';
echo '</div>';

//Session Reply Area
if ($reply) {
    echo '<div class="returnBar" style="margin-top: 1rem;margin-bottom:2rem;">';
    echo '<p>' . $reply['message'] . '</p>';
    echo '</div>';
    $query = "DELETE FROM replies WHERE user_id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
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