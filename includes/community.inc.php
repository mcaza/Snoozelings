<?php

$userId = $_SESSION['user_id'];

echo '<h3>Community</h3>';

echo '<div class="shopRows" style="justify-content: center;column-gap: 6rem;margin-bottom: 6rem;">';

echo '<a href="index" class="shopBox">';
echo '<div >';
echo '<img src="resources/bulletinboard.png" class="shopImg" style="height: 150px;width: auto;">';
echo '<h4>Bulletin Board</h4>';
echo '</div>';
echo '</a>';

echo '<a href="mailbox" class="shopBox">';
echo '<div>';
echo '<img src="resources/mailboxblue.png" class="shopImg" style="height: 150px;width: auto;">';
echo '<h4>User Mailbox</h4>';
echo '</div>';
echo '</a>';

echo '<a href="critterweb" class="shopBox">';
echo '<div>';
echo '<img src="resources/critterweb.jpg" class="shopImg" style="height: 150px;width: auto;">';
echo '<h4>Critter Web</h4>';
echo '</div>';
echo '</a>';
  


echo '</div>';
