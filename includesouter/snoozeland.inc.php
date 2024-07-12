<?php

$userId = $_SESSION['user_id'];
$name = $_SESSION['petName'];



echo '<h3>Snooze Land</h3>';

echo '<div class="shopRows" style="justify-content: center;column-gap: 6rem;margin-bottom: 6rem;">';

echo '<a href="explore" class="shopBox">';
echo '<div>';
echo '<img src="resources/squareExploring.png" class="shopImg" style="width: 90%;">';
echo '<h4>Exploring</h4>';
echo '</div>';
echo '</a>';

echo '<a href="shops" class="shopBox">';
echo '<div >';
echo '<img src="resources/squareShops.png" class="shopImg"  style="width: 90%;">';
echo '<h4>Snooze Shops</h4>';
echo '</div>';
echo '</a>';

echo '</div>';
