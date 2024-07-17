<?php

$userId = $_SESSION['user_id'];
$name = $_SESSION['petName'];

echo '<h3>Snooze Activities</h3>';

echo '<div class="shopRows" style="justify-content: center;column-gap: 6rem;margin-bottom: 6rem;">';

echo '<a href="raffle" class="shopBox">';
echo '<div>';
echo '<img src="resources/SquareRaffle.png" class="shopImg" style="width: 90%;">';
echo '<h4>Kindness Raffle</h4>';
echo '</div>';
echo '</a>';
  
echo '<a href="randomitem" class="shopBox">';
echo '<div >';
echo '<img src="resources/SquareFreeItem.png" class="shopImg" style="width: 90%;">';
echo '<h4>Simon\'s Gifts</h4>';
echo '</div>';
echo '</a>';

echo '</div>';
echo '<div class="shopRows" style="justify-content: center;column-gap: 6rem;">';

echo '<a href="designer" class="shopBox">';
echo '<div >';
echo '<img src="resources/SquareDesigner.png" class="shopImg"  style="width: 90%;">';
echo '<h4>Snooze Maker</h4>';
echo '</div>';
echo '</a>';
    
echo '</div>';