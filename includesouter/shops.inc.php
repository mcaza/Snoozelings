<?php

$userId = $_COOKIE['user_id'];
$name = $_COOKIE['petName'];

//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="snoozevillage"><<</a>';
echo '</div>';

echo '<h3>Snooze Shopping</h3>';

echo '<div class="shopRows">';

echo '<a href="seedshop" class="shopBox">';
echo '<div>';
echo '<img src="resources/seedshopNPC.png" class="shopImg" >';
echo '<h4>Sprout\'s Seeds</h4>';
echo '</div>';
echo '</a>';
  
echo '<a href="kindnessshop" class="shopBox">';
echo '<div >';
echo '<img src="resources/kindnessshopNPC.png" class="shopImg">';
echo '<h4>Kindness Boutique</h4>';
echo '</div>';
echo '</a>';

echo '<a href="trendytails" class="shopBox">';
echo '<div >';
echo '<img src="resources/trendyNPCMenu.png" class="shopImg" style="width: 100%";">';
echo '<h4>Trendy Tails</h4>';
echo '</div>';
echo '</a>';



echo '<a href="adoption" class="shopBox">';
echo '<div >';
echo '<img src="resources/adoptshopNPC.png" class="shopImg" style="width: 100%";">';
echo '<h4>Adoption House</h4>';
echo '</div>';
echo '</a>';

echo '<a href="bedShop" class="shopBox">';
echo '<div >';
echo '<img src="resources/bedNPC.png" class="shopImg" style="width: 100%";">';
echo '<h4>Sleepy Head Beds</h4>';
echo '</div>';
echo '</a>';

echo '<a href="stitcher" class="shopBox">';
echo '<div >';
echo '<img src="resources/sewingNPC.png" class="shopImg" style="width: 100%";">';
echo '<h4>Snoozeling Stitcher</h4>';
echo '</div>';
echo '</a>';

echo '<a href="coderedemption" class="shopBox">';
echo '<div >';
$today = new DateTime();

$spring = new DateTime('March 20');
$summer = new DateTime('June 20');
$fall = new DateTime('September 22');
$winter = new DateTime('December 21');

if ($today >= $spring && $today < $summer) {
    echo '<img src="resources/snowsummerNPC.png" class="shopImg" style="width: 100%";">';
} else if ($today >= $summer && $today < $fall) {
    echo '<img src="resources/snowsummerNPC.png" class="shopImg" style="width: 100%";">';
} else if ($today >= $fall && $today < $winter) {
    echo '<img src="resources/snowshopsummerNPC.png" class="shopImg" style="width: 100%";">';
} else {
    echo '<img src="resources/snowshopsummerNPC.png" class="shopImg" style="width: 100%";">';
}
echo '<h4>Code Redemption</h4>';
echo '</div>';
echo '</a>';


    
echo '</div>';
