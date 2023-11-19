<?php

$userId = $_SESSION['user_id'];
$name = $_SESSION['petName'];

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
    
echo '</div>';