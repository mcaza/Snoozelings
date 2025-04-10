<?php

$userId = $_COOKIE['user_id'];

echo '<h3>Community</h3>';

echo '<div class="shopRows" style="column-gap:65px;row-gap:60px;">';

echo '<a href="mailbox" class="shopBox">';
echo '<div>';
echo '<img src="resources/mailIcon.png" class="shopImg" style="width:90%">';
echo '<h4>User Mailbox</h4>';
echo '</div>';
echo '</a>';

echo '<a href="critterweb" class="shopBox">';
echo '<div>';
echo '<img src="resources/critterweb.jpg" class="shopImg" style="width:90%">';
echo '<h4>Critter Web</h4>';
echo '</div>';
echo '</a>';

echo '<a href="penpals" class="shopBox">';
echo '<div >';
echo '<img src="resources/penpalBoard.png" class="shopImg" style="width:90%">';
echo '<h4>Penpal Requests</h4>';
echo '</div>';
echo '</a>';
  


echo '</div>';
