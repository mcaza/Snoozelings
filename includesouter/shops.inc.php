<?php

$userId = $_SESSION['user_id'];
$name = $_SESSION['petName'];

//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="snoozeland"><<</a>';
echo '</div>';

echo '<h3>Snooze Shops</h3>';

echo '<div class="shopRows">';

echo '<a href="seedshop" class="shopBox">';
echo '<div>';
echo '<img src="resources/seedNPC.png" class="shopImg" >';
echo '<h4>Seed Shop</h4>';
echo '</div>';
echo '</a>';
  
echo '<a href="kindnessshop" class="shopBox">';
echo '<div >';
echo '<img src="resources/kindnessNPC.png" class="shopImg">';
echo '<h4>Kindness Shop</h4>';
echo '</div>';
echo '</a>';

echo '<a href="stitcher" class="shopBox">';
echo '<div >';
echo '<img src="resources/sewingNPC.png" class="shopImg" style="width: 100%";">';
echo '<h4>Snoozeling Stitcher</h4>';
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
echo '<img src="resources/adoptNPC.png" class="shopImg" style="width: 100%";">';
echo '<h4>Adoption House</h4>';
echo '</div>';
echo '</a>';

echo '<a href="coderedemption" class="shopBox">';
echo '<div >';
echo '<img src="resources/snowNPC.png" class="shopImg" style="width: 100%";">';
echo '<h4>Code Redemption</h4>';
echo '</div>';
echo '</a>';
    
echo '</div>';