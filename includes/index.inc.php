<?php

$userId = $_SESSION['user_id'];
$username = $_SESSION['user_username'];

if ($userId) {

//Rollover Time Stuff
$query = 'SELECT * FROM times';
$stmt = $pdo->prepare($query);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

//Date Stuff
$now = new DateTime(null, new DateTimezone('UTC'));
$future_date = new DateTime($result['rotime']);
$interval = $future_date->diff($now);

//Mail 1 Diff
$future_date2 = new DateTime($result['mailone']);
$interval2 = $future_date2->diff($now);

//Mail 2 Diff
$future_date3 = new DateTime($result['mailtwo']);
$interval3 = $future_date3->diff($now);

//Grab Newest News Post
$cat = "news";
$query = 'SELECT * FROM posts WHERE category = :cat ORDER by id DESC LIMIT 1';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":cat", $cat);
$stmt->execute();
$news = $stmt->fetch(PDO::FETCH_ASSOC);

//Grab Newest Submissions Post
$cat = "submissions";
$query = 'SELECT * FROM posts WHERE category = :cat ORDER by id DESC LIMIT 1';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":cat", $cat);
$stmt->execute();
$submissions = $stmt->fetch(PDO::FETCH_ASSOC);

echo '<div style="display: flex;flex-direction:row;justify-content: space-evenly;margin-top: 1rem;">';

//Left Column
echo '<div style="width: 30%; display: flex;flex-direction: column;row-gap:2rem;">';

//Bulletin Board Image
echo '<div class="indexBox">';
echo '<img src="resources/bulletinboard.png" class="shopImg" style="height: 150px;width: auto;">';
echo '</div>';

//Rollover Countdown
echo '<div class="indexBox">';
echo '<h4 style="margin-top: 0;">Rollover</h4>';
echo '<p>' . $interval->format("%h hours, %i minutes, %s seconds") . '</p>';
echo '</div>';

//Mail Countdown
echo '<div class="indexBox">';
echo '<h4 style="margin-top: 0;">Mail Delivery</h4>';
if ($now < $future_date2) {
    echo '<p>' . $interval2->format("%h hours, %i minutes, %s seconds") . '</p>';
} else {
    echo '<p>' . $interval3->format("%h hours, %i minutes, %s seconds") . '</p>';
}

echo '</div>';

//To Do
echo '<div class="indexBox">';
echo '<h4 style="margin-top: 0;">To Do</h4>';
require "../includes/notifications.inc.php"; 
echo '</div>';

//Important Dates
echo '<div class="indexBox">';
echo '<h4 style="margin-top: 0;margin-bottom: 1.5rem;">Important Dates</h4>';
echo '<p><b>December 18th</b><br>News Update</p><br>';
echo '<p><b>December 20th</b><br>Alpha Test Last Day</p><br>';
echo '</div>';

echo '</div>';

//Right Column
echo '<div style="width: 60%; display: flex;flex-direction: column;row-gap:2rem;">';

//Recent News
echo '<div class="indexBox">';
echo '<h3 style="margin-top: 0;border-bottom:2px dashed #827188; padding-bottom: 1rem;margin-bottom: 1rem;">Recent News</h3>';
echo '<h4 style="margin-top: 0;">' . $news['title'] . '</h4>';
echo '<div style="height: 250px; overflow: hidden;">' . nl2br($news['text']) . '</div>';
echo '<div style="text-align: right; margin-right: 1rem;margin-top: .5rem;margin-bottom: .5rem;"><a style="font-size: 2rem; font-weight: bold" href="post?id=' . $news['id'] . '">Read More >></a></div>';
echo '</div>';

//Recent Submissions
echo '<div class="indexBox">';
echo '<h3 style="margin-top: 0;border-bottom:2px dashed #827188; padding-bottom: 1rem;margin-bottom: 1rem;">Kindness Coins</h3>';
echo '<h4 style="margin-top: 0;">' . $submissions['title'] . '</h4>';
echo '<div style="height: 250px; overflow: hidden;">' . nl2br($submissions['text']) . '</div>';
echo '<div style="text-align: right; margin-right: 1rem;margin-top: .5rem;margin-bottom: .5rem;"><a style="font-size: 2rem; font-weight: bold" href="post?id=' . $submissions['id'] . '">Read More >></a></div>';
echo '</div>';

echo '</div>';
echo '</div>';
    
}