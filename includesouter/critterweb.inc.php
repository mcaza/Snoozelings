<?php

$userId = $_SESSION['user_id'];

echo '<div style="display: flex;justify-content:space-between;flex-direction: row;">';
//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="community"><<</a>';
echo '</div>';

//Post Button (Right)
if ($userId == 1) {
    echo '<div style="text-align: right;"><button  class="fancyButton" onClick="window.location.href=\'newPost\'">New Post</button></div>';
    echo '</div>';
}


//Title
echo '<h3 style="margin-bottom: 3rem">World Wide Critter Web</h3>';

$topics = ['News', 'Submissions' /*, 'General', 'Fandom', 'Artwork', 'Roleplay', 'Giveaways', 'Guides', 'Questions' */];
$descriptions = ['The Official Hub for all Snoozelings News', 'Help Improve Snoozelings and Earn Kindness Coins'/* , 'For Any Kind of Discussion that Doesn\'t Fit Elsewhere', 'Books, Television, Movies. It all goes here. Just be Sure to Mark Spoilers', 'For Art Discussion, Art Commissions, and Art Trades', 'Find Roleplay Buddies and Start a Roleplay Post', 'For Free Art, Free Items, and Other Giveaways', 'Create Snoozelings Guides for Other Players Here', 'Need Help? Ask your Question Here' */];
$count = count($topics);

$round = 1;
foreach ($topics as $topic) {
    if ($round === 1) {
        echo '<a class="critterbox" style="border: 2px dashed #827188; border-radius: 20px 20px 0px 0px;" href="boards?type=' . $topic . '">';
    } elseif ($round === $count) {
        echo '<a class="critterbox" style="border-bottom: 2px dashed #827188; border-left: 2px dashed #827188; border-right: 2px dashed #827188; border-radius: 0px 0px 20px 20px; " href="boards?type=' . $topic . '">';

    } else {
        echo '<a class="critterbox" style="border-left: 2px dashed #827188;border-right: 2px dashed #827188;border-bottom: 2px dashed #827188;" href="boards?type=' . $topic . '">';
    }
    echo '<h4 style="margin-top: 0;text-align: center;">>> ' . $topic . ' <<</h4><br>';
    echo '<p>' . $descriptions[$round -1] . '</p>';
    echo '<p style="margin-top: 1.5rem;"><strong>Read More</strong></p>';
    echo '</a>';
    $round++;
}