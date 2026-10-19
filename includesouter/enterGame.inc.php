<?php

//Grab User ID
$userId = $_COOKIE['user_id'];

echo '<h3>Some Final Gameplay Tips</h3><br><br>';

//To Do Section
echo '<div style="width:90%;border: 2px dashed #827188;border-radius: 15px;margin-left:auto;margin-right:auto;display:flex;padding:10px;">';
echo '<div style="width:45%;">';
echo '<img src="resources/ToDoBox.png" style="width:100%;border-radius:10px;">';
echo '</div>';
echo '<div style="margin-left:0px;margin-right:0px;width:60%">';
echo '<h4>Use Your To Do List</h4>';
echo '<p>Your To Do List keeps track of every in game task.<br><br>This way you can focus on playing the game.<br><br><b>On Desktop</b><br>On the Left Sidebar<br><br><b>On Mobile</b><br>Scroll Down</p>';
echo '</div>';
echo '</div>';

//User Settings Section
echo '<br><br><div style="width:90%;border: 2px dashed #827188;border-radius: 15px;margin-left:auto;margin-right:auto;display:flex;padding:10px;">';
echo '<div style="width:45%;">';
echo '<img src="resources/ProfileSettings.png" style="width:100%;border-radius:10px;">';
echo '</div>';
echo '<div style="margin-left:0px;margin-right:0px;width:60%">';
echo '<h4>Customize Your Experience</h4>';
echo '<p>In the Top Right corner on your Profile, you\'ll find the <b>Edit Profile</b> button. Click to open the Edit Profile page.<br><Br>There are many settings available on that page that will help you by customizing your gameplay experience.<br><br><b>Crafting Notification</b><br>This will add a To Do item when your <b>Crafting Table</b> is empty.<br><br><b>Preferred Shortcuts</b><br>Customize the 5 Shortcuts that show on mobile.<br><br><b>Dark Mode</b><br>Enable this option to switch the website into Dark Mode.</p><br>';
echo '</div>';
echo '</div>';

//Adoption House Section
echo '<br><br><div style="width:90%;border: 2px dashed #827188;border-radius: 15px;margin-left:auto;margin-right:auto;display:flex;padding:10px;">';
echo '<div style="width:45%;">';
echo '<img src="resources/AdoptionHouse.png" style="width:100%;border-radius:10px;">';
echo '</div>';
echo '<div style="margin-left:0px;margin-right:0px;width:60%">';
echo '<h4>Adopting a Second Snoozeling</h4>';
echo '<p><b>Pro Tip:</b> Adopting a second snoozeling can help boost your items and coins found while <b>Exploring</b>.<br><br>Creating new snoozelings takes a lot of time and luck to collect the items needed. It\'s not really a new player goal.<br><br>The easiest way to obtain a second snoozeling is actually buying one through the <b>Adoption House</b>.<br><br>Most of these snoozelings are under 30 Snooze Coins.<br><br>All shops can be found under the <b>Snooze Shops</b> menu.<br></p>';
echo '</div>';
echo '</div>';

//Request Board Section
echo '<br><br><div style="width:90%;border: 2px dashed #827188;border-radius: 15px;margin-left:auto;margin-right:auto;display:flex;padding:10px;">';
echo '<div style="width:45%;">';
echo '<img src="resources/RequestBoardTut.png" style="width:90%;border-radius:10px;">';
echo '</div>';
echo '<div style="margin-left:0px;margin-right:0px;width:60%">';
echo '<h4>Request Board</h4>';
echo '<p>Members may request up to two items each day on the <b>Request Board</b> located in <b>Snooze Village</b>.<br><br>The items that you can request are mostly common items like feathers, crops, dyes, and explorer loot.<br><br>The Request Board is completely anonymous, so don\'t worry about asking for too much help.<br><br>More experienced players love helping new players because fulfilling requests helps them to earn <b>Kindness Coins</b>.</p>';
echo '</div>';
echo '</div>';

//Kindness Coins Section
echo '<br><br><div style="width:90%;border: 2px dashed #827188;border-radius: 15px;margin-left:auto;margin-right:auto;display:flex;padding:10px;">';
echo '<div style="width:45%;">';
echo '<img src="resources/KindnessCoins.png" style="width:90%;border-radius:10px;">';
echo '</div>';
echo '<div style="margin-left:0px;margin-right:0px;width:60%">';
echo '<h4>Kindness Coins</h4>';
echo '<p>Kindness Coins are a secondary currency in the game snoozelings with a special <b>Kindness Shop</b>.<br><br>There are many ways to earn Kindness Coins. The most common is fulfilling requests through the Request Board.<br><br>You may also earn Kindness Coins by helping other players or reporting bugs through <b>Moderator Mail</b>.</p>';
echo '</div>';
echo '</div>';
echo '<hr>';
echo '<br><br><img src="snoozeImages/1.png?timestamp=' . $ts['timestamp'] . '" style="width:40%;-webkit-transform: scaleX(-1);transform: scaleX(-1);">';
echo '<h3>Mayor Cocoa Welcomes You</h3><br>';
echo '<p>That\'s all the special advice I have for you today.<br><Br>The most important thing is to remember to be kind to yourself and other players.<br><br>Please remember we are a small development team doing our best.<br><br>We are only human and this game has many responsibilities.<br><Br>We hope you have lots of fun playing Snoozelings.</p><br>';

echo '<form action="../includes/enterGame.inc.php" method="post">';
echo '<button  class="fancyButton">Play Snoozelings</button>';
echo '</form>';