<?php

$userId = $_COOKIE['user_id'];
$name = $_COOKIE['petName'];
$month = ltrim(date('m'), "0");


echo '<h3>Snooze Activities</h3>';

echo '<div class="shopRows" style="column-gap:65px;row-gap:60px;">';

echo '<a href="raffle" class="shopBox">';
echo '<div>';
echo '<img src="resources/raffleTicket.png" class="shopImg" style="width: 90%;">';
echo '<h4>Kindness Raffle</h4>';
echo '</div>';
echo '</a>';
  
echo '<a href="randomitem" class="shopBox">';
echo '<div >';
echo '<img src="resources/presentBox.png" class="shopImg" style="width: 90%;">';
echo '<h4>Simon\'s Gifts</h4>';
echo '</div>';
echo '</a>';

echo '</div>';
echo '<div class="shopRows">';

if ($month == 12) {
    echo '<a href="decemberGifts" class="shopBox">';
    echo '<div >';
    echo '<img src="resources/HolidayCocoa.png" class="shopImg"  style="width: 90%;">';
    echo '<h4>Cocoa\'s Gifts</h4>';
    echo '</div>';
    echo '</a>';
}
    
echo '</div>';