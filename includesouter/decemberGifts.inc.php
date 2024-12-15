<?php

$userId = $_SESSION['user_id'];
$reply = $_SESSION['reply'];
unset($_SESSION['reply']);
date_default_timezone_set('America/Los_Angeles');

$weekday = date('d');
$month = ltrim(date('m'), "0");

//Get User Info
$query = "SELECT decGift FROM users WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$day = $result['decGift'];

//Get Gift Info
$query = "SELECT * FROM decGifts WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $weekday);
$stmt->execute();
$gift = $stmt->fetch(PDO::FETCH_ASSOC);

//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="games"><<</a>';
echo '</div>';

//Session Reply Area
if ($reply) {
    echo '<div class="returnBar" style="margin-top: 1rem;margin-bottom: 1rem;"><p>' . $reply . '</p></div>';
}

//Will have cute snoozeling for alpha. Custom art later. Confused face if already took item.
echo '<div><img style="width: 40%;" src="resources/HolidayCocoa.png"></div>';
echo '<h4>Cocoa\'s Holiday Gifts</h4>';


if ($month == 12) {
    if ($weekday < 25) {
        if ($day < $weekday) {
            if ($weekday < 25) {
            echo '<p>' . $gift['phrase'] . '</p>';
            }
            if ($weekday == 1 || $weekday == 21) {
                $day = ltrim($weekday,"0") . 'st';
            } else if ($weekday == 2 || $weekday == 22) {
                $day = ltrim($weekday,"0") . 'nd';
            } else if ($weekday == 3 || $weekday == 23) {
                $day = ltrim($weekday,"0") . 'rd';
            } else {
                $day = ltrim($weekday,"0") . 'th';
            }
            echo '<button class="fancyButton" style="width: 200px; margin-right: auto; margin-left: auto;margin-bottom: 1.5rem;" onClick="window.location.href=\'../includes/decemberGift.inc.php\'">Dec ' . $day . ' Gift</button>';
        } else {
            echo '<p><i>Today\'s gift can be found in your pack.</i></p>';
            echo '<p><i>Please come back tomorrow.</i></p>';
        }
    } else if ($weekday == 31) {
        if ($day < $weekday) {
            if ($weekday < 25) {
            echo '<p>' . $gift['phrase'] . '</p>';
            }
            if ($weekday == 1 || $weekday == 21) {
                $day = ltrim($weekday,"0") . 'st';
            } else if ($weekday == 2 || $weekday == 22) {
                $day = ltrim($weekday,"0") . 'nd';
            } else if ($weekday == 3 || $weekday == 23) {
                $day = ltrim($weekday,"0") . 'rd';
            } else {
                $day = ltrim($weekday,"0") . 'th';
            }
            echo '<button class="fancyButton" style="width: 200px; margin-right: auto; margin-left: auto;margin-bottom: 1.5rem;" onClick="window.location.href=\'../includes/decemberGift.inc.php\'">Dec ' . $day . ' Gift</button>';
        } else {
            echo '<p><i>Today\'s gift can be found in your pack</i></p>';
            echo '<p><i>See you back next year for even more gifts!</i></p>';
        }
        
    } else {
        if ($day < 25) {
            if ($weekday < 25) {
            echo '<p>' . $gift['phrase'] . '</p>';
            }
            if ($weekday == 1 || $weekday == 21) {
                $day = ltrim($weekday,"0") . 'st';
            } else if ($weekday == 2 || $weekday == 22) {
                $day = ltrim($weekday,"0") . 'nd';
            } else if ($weekday == 3 || $weekday == 23) {
                $day = ltrim($weekday,"0") . 'rd';
            } else {
                $day = ltrim($weekday,"0") . 'th';
            }
            echo '<button class="fancyButton" style="width: 200px; margin-right: auto; margin-left: auto;margin-bottom: 1.5rem;" onClick="window.location.href=\'../includes/decemberGift.inc.php\'">Dec ' . $day . ' Gift</button>';
        } else {
            echo '<p><i>I am taking a break for the holidays.</i></p>';
            echo '<p><i>Please come back on the 31st for your final gift.</i></p>';
        }
    }
} else {
    echo '<p><i>Come back December 1st for more holiday gifts.</i></p>';
}
        
        
        