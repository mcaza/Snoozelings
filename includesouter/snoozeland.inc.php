<?php

$userId = $_SESSION['user_id'];
$name = $_SESSION['petName'];



echo '<h3>Snooze Village</h3>';

echo '<div class="shopRows" style="column-gap:65px;row-gap:60px;">';

echo '<a href="explore" class="shopBox">';
echo '<div>';
echo '<img src="resources/exploringTree.png" class="shopImg" style="width: 90%;">';
echo '<h4>Exploring</h4>';
echo '</div>';
echo '</a>';

echo '<a href="shops" class="shopBox">';
echo '<div >';
echo '<img src="resources/shops.png" class="shopImg"  style="width: 90%;">';
echo '<h4>Snooze Shops</h4>';
echo '</div>';
echo '</a>';

echo '</div>';

echo '<div class="shopRows">';

echo '<a href="requests" class="shopBox">';
echo '<div>';
echo '<img src="resources/requestBoard.png" class="shopImg" style="width: 90%;">';
echo '<h4>Request Board</h4>';
echo '</div>';
echo '</a>';

echo '</div>';