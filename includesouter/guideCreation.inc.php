<?php

//Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="gameGuides"><<</a>';
echo '</div>';

echo '<h3>Snoozeling Creation Guide</h3>';

echo '<h2 style="text-align:center;margin-left:30px;">Basic Information</h2>';

echo '<p style="text-align:center;margin: 0px 40px 15px 30px;">Creating Snoozelings is our game\'s version of a breeding system.<br><br><b>New snoozelings are not created through eggs or other biological means.</b><br><br>Since snoozelings are stuffed animals, new snoozelings need to be stitched by the snoozeling stitcher: Minky.<br><br>To create a new snoozeling, you will need 1 <b><i>Sewing Kit</i></b> and at least 1 <b><i>Blueprint</i></b>.<br><br>Though the more <b><i>Blueprints</i></b> used <i>(Up to 10)</i>, the more choices you get.</p>';

echo '<div style="display:flex;justify-content: center;">';
echo '<div>';
echo '<img src="items/SewingKit.png" style="width:60%">';
echo '<p><b>Sewing Kit</b></p>';
echo '</div>';
echo '<div>';
echo '<img src="items/Blueprint.png" style="width:60%">';
echo '<p><b>Blueprint</b></p>';
echo '</div>';
echo '</div>';

echo '<hr>';

echo '<h2 style="text-align:center;margin-left:30px;">Where to Find Sewing Kits?</h2>';

echo '<p style="text-align:center;margin: 0px 40px 15px 100px;">Sewing Kits are a very rare item to keep a sustainable flow of snoozelings.</p>';

echo '<ul style="text-align:left;">';
echo '<li>Rare Drop When Exploring</li>';
echo '<li>Medium Chance Drop from Chests</li>';
echo '<li>Buy for 10 Kindness Coins</li>';
echo '<li>Use a Wish Token</li>';
echo '</ul>';

echo '<p style="text-align:center;margin: 0px 40px 15px 30px;"><b>Player Tip:</b> Consider adopting a Snoozeling from the <a href="adoption">Adoption House</a> while you search for a Sewing Kit.</p>';

echo '<hr>';

echo '<h2 style="text-align:center;margin-left:30px;">Snoozeling Trait & Color Calculation</h2>';

echo '<p style="margin-top:0px;"><a href="guideColorCalculator" class="notif">Use this Calculator for all Color Calculations</a><br><br><b>Step 1 - </b>Calculate Main Color Based on Main Color Traits: Color, Category, Hue<br><br><b>Step 2 - </b>Calculate Eye Color Based on Eye Color Traits: Color, Category, Hue<br><br><b>Step 3 - </b>Check if Snoozeling has Fabric. If they do, color calculations are based on the most similar color.<br><br><b><i>Note:</b> Fabrics can no longer be passed down through Snoozeling creation</i><br><br><b>Step 4 - </b>Calculate Nose/Ear Color Based on Skin Color Traits: Color, Category, Hue<br><br><b>Step 5 - </b>Calculate Hair Color Based on Hair Color Traits: Color, Category, Hue<br><br><b>Step 6 - </b>Calculate Tail Color Based on Tail Color Traits: Color, Category, Hue<br><br><b>Step 7 - </b>Calculate Hair & Tail Style. 50% Chance from Each Parent.<br><br><b>Step 8 - </b>Calculate Special Traits<br><br>Both Parents Have Trait = 75% Chance to Pass<br><Br>Single Parent Has Trait = 45% Chance to Pass</p><br><br>';