<?php



if (isset($_SESSION['user_id'])) {
    
    $userId = $_SESSION['user_id'];
$username = $_SESSION['user_username'];

//Rollover Time Stuff
$query = 'SELECT * FROM times';
$stmt = $pdo->prepare($query);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

//Date Stuff
$now = new DateTime("now", new DateTimezone('UTC'));
$future_date = new DateTime($result['rotime']);
$interval = $future_date->diff($now);

//Mail 1 Diff
$future_date2 = new DateTime($result['mailone']);
$interval2 = $future_date2->diff($now);

//Mail 2 Diff
$future_date3 = new DateTime($result['mailtwo']);
$interval3 = $future_date3->diff($now);
    
//Mail 3 Diff
$future_date4 = new DateTime($result['mailthree']);
$interval4 = $future_date4->diff($now);

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

echo '<div class="content">';

//Left Column
echo '<div class="leftColumnHome">';

//Bulletin Board Image
echo '<div class="indexBox" id="bulletinBoard">';
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
} elseif ($now < $future_date3) {
    echo '<p>' . $interval3->format("%h hours, %i minutes, %s seconds") . '</p>';
} else {
    echo '<p>' . $interval4->format("%h hours, %i minutes, %s seconds") . '</p>';
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
echo '<p>Coming Soon</p>';
/* echo '<p><b>December 18th</b><br>News Update</p><br>';
echo '<p><b>December 20th</b><br>Alpha Test Last Day</p><br>'; */
echo '</div>';

echo '</div>';

//Right Column
echo '<div class="rightColumnHome">';

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
    
} else {
    if (isset($_SESSION['reply'])) {
    $reply = $_SESSION['reply'];
    unset($_SESSION['reply']);
        echo '<div class="returnBar" style="margin-top: 1rem;margin-bottom:2rem;"><p>' . $reply . '</p></div>';
    }
    echo '<img src="resources/wipwhitebg.png" style="width:90%;">';
    echo '<h3 style="font-size:4rem;border-bottom: 2px dashed #827188;padding-bottom:1.5rem;margin-top:1.5rem;">Coming Soon to All Browsers</h3>';
    
    //Collect Snoozelings
    echo '<h3 style="margin-top: 2rem;margin-bottom:1.5rem;">Collect and Create Snoozelings</h3>';
    echo '<div style="display: flex;flex-direction: row; flex-wrap: wrap; justify-content: center;">';
    echo '<div style="width: 30%;"><img src="resources/promo2.png" class="adimage"><p><b>Pesto</b></p></div>';
    echo '<div style="width: 30%;"><img src="resources/promo6.png" class="adimage"><p><b>Dino Nuggets</b></p></div>';
    echo '<div style="width: 30%;"><img src="resources/promo5.png" class="adimage"><p><b>Bubby</b></p></div>';
    echo '</div>';
    echo '<div style="display: flex;flex-direction: row; flex-wrap: wrap; justify-content: center;">';
    echo '<div style="width: 30%;"><img src="resources/promo4.png"  class="adimage"><p><b>Pearl</b></p></div>';
    echo '<div style="width: 30%;"><img src="resources/promo1.png" class="adimage"><p><b>Meringue</b></p></div>';
    echo '<div style="width: 30%;"><img src="resources/promo3.png" class="adimage"><p><b>Crescendo</b></p></div>';
    echo '</div>';
    echo '<p style="border-bottom: 2px dashed #827188;padding-bottom:2rem;">The above Snoozelings were all created during alpha testing<p>';
    
    //Self Care Section
    echo '<h3 style="margin-top: 2rem;margin-bottom:1.5rem;">Practice Self Care</h3>';
    echo '<div style="display: flex;flex-direction: row; flex-wrap: wrap; justify-content: center;">';
    echo '<div style="width:40%;"><img src="resources/promo7.png"  class="adimage" style="border-radius: 15px;"><p><b>Daily Affirmations</b></p></div>';
    echo '<div style="width: 40%;"><img src="resources/promo8.png" class="adimage"><p><b>Keep a Health Journal</b></p></div>';
    echo '</div>';
    echo '<p style="border-bottom: 2px dashed #827188;padding-bottom:2rem;">Plus Water Reminders, Sleep Tracking, and Journal .pdf Exporting for Appointments<p>';
    
    //Cozy Gaming
    echo '<h3 style="margin-top: 2rem;margin-bottom:1.5rem;">Cozy Pet Simming</h3>';
    echo '<div style="display: flex;flex-direction: row; flex-wrap: wrap; justify-content: center;">';
    echo '<div style="width:80%;"><img src="resources/promo14.png"  class="adimage" style="border-radius: 15px;"><p><b>Farming with a Purpose</b></p></div>';
    echo '</div>';
    echo '<p style="padding-bottom:2rem;">Plants can be Used to Craft Dyes & Fabric<p>';
    echo '<div style="display: flex;flex-direction: row; flex-wrap: wrap; justify-content: center;">';
    echo '<div style="width:80%;"><img src="resources/promo11.png"  class="adimage" style="border-radius: 15px;"><p><b>Pet Crafting Bench</b></p></div>';
    echo '</div>';
    echo '<p style="padding-bottom:2rem;">Create New Clothes, Fabrics, and Tails for Your Snoozelings<p>';
    echo '<div style="display: flex;flex-direction: row; flex-wrap: wrap; justify-content: center;">';
    echo '<div style="width:80%;"><img src="resources/promo13.png"  class="adimage" style="border-radius: 15px;"><p><b>User Contributed Daily Raffle</b></p></div>';
    echo '</div>';
    echo '<p style="border-bottom: 2px dashed #827188;padding-bottom:2rem;">Earn Kindness Coins for Donating and Win Something Cool<p>';
    
    //Alpha Reviews
    echo '<h3 style="margin-top: 2rem;margin-bottom:1.5rem;">Alpha Player Reviews</h3>';
    echo '<p style="width: 80%; margin-right: auto; margin-left: auto;">As someone who quickly falls out of pet Sims every now and again, Snoozelings honestly just has me coming back and back again for more! the self care features are a wonderful touch and the overall aesthetic of the pets themselves brings a lot of comfort and warmth into the site. The community it has is lovely as well and I\'m very excited to see it grow and evolve!</p>';
    echo '<p style="width: 80%; text-align: right; margin-right: 2rem;">~Alpha Tester #33</p>';
    echo '<hr>';
    echo '<p style="width: 80%; margin-right: auto; margin-left: auto;">The Mental Health and Physical Health focus, I love working on my journal daily and keeping track of my chronic pains. They have helped me a lot ever since starting with the Alpha and it\'s so well done and thought out. And the overall focus on Selfcare is just WONDERFUL.</p>';
    echo '<p style="width: 80%; text-align: right; margin-right: 2rem;">~Alpha Tester #20</p>';
    echo '<hr>';
    echo '<p style="width: 80%; margin-right: auto; margin-left: auto;">I love getting to check in on my snoozeling throughout the day. Even at this early stage I feel like all the timed tasks are really balanced, they\'re just long enough where it doesn\'t feel like forever but still encourages you to get away from the screen for a bit, while also having longer term goals to work towards that absolutely feel within reach. It\'s like neopets but it still gets you to go touch grass hahah! Can\'t wait to see where it goes.</p>';
    echo '<p style="width: 80%; text-align: right; margin-right: 2rem;">~Alpha Tester #42</p>';
    echo '<p style="border-bottom: 2px dashed #827188;padding-bottom:2rem; margin-bottom: 2rem;"></p>';
    
    echo '<p style="font-size: 2rem"><b>Early Access Code Sales:</b> Late Dec 2023</p>';
    echo '<p style="font-size: 2rem"><b>Estimated Early Access Launch:</b> August 31st, 2024</p>';
    echo '<p style="font-size: 2rem; border-bottom: 2px dashed #827188;padding-bottom:2rem; margin-bottom: 2rem;"><b>Free Launch:</b> Summer 2025</p>';
    
    echo '<h4 href="https://discord.gg/HDs66g7QeJ">Click to Join Our Discord Server</h4>';
    echo '<a href="https://discord.gg/HDs66g7QeJ"><img style="width: 10%;"src="https://static-00.iconduck.com/assets.00/discord-icon-2048x2048-nnt62s2u.png"></a>';
    echo '<h4>Sign Up for Email Updates</h4>';
    echo '<form method="post" action="includes/addemailnewsletter.inc.php">';
    echo '<input type="text" class="input" name="email"><br>';
    echo '<button  class="fancyButton">Join Email List</button>';
    echo '</form>';
}
















