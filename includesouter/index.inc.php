<?php



if (isset($_COOKIE['user_id'])) {
    
    $userId = $_COOKIE['user_id'];
    $year = date("Y");
    
    $query = "SELECT * FROM replies WHERE user_id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $reply = $stmt->fetch(PDO::FETCH_ASSOC);
    date_default_timezone_set('UTC');


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
    $query = 'SELECT * FROM times';
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $times = $stmt->fetch(PDO::FETCH_ASSOC);
    $now = new DateTime($times['mailone']);
    $result = $now->format('Y-m-d');

    $query = 'SELECT * FROM importantDates';
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $dates = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $check = 0;
    foreach ($dates as $date) {
        if ($date['date'] > $result) {
            $check = 1;
        }
    }

    if ($check == 1) {
        echo '<div class="indexBox">';
        echo '<h4 style="margin-top: 0;margin-bottom: 1.5rem;">Important Dates</h4>';
        foreach ($dates as $date) {
            if ($date['date'] > $result) {
                echo '<p><b>' . $date['name'] . '</b></p><p>' . $date['format'] . '</p>';
            }
        }
        echo '</div>';
    }

    //Todays Birthdays
    $query = 'SELECT * FROM users WHERE birthdayOptOut = 0 ORDER BY MONTH(birthdate), DAY(birthdate)';
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $dates = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $check = 0;
    foreach ($dates as $date) {
        $tester = new DateTime($date['birthdate']);
        if ($tester->format($year . '-m-d') == $now->format('Y-m-d')) {
            $check = 1;
        }
    }

    if ($check == 1) {
        echo '<div class="indexBox">';
        echo '<h4 style="margin-top: 0;margin-bottom: 1.5rem;">Today\'s Birthdays</h4>';
        foreach ($dates as $date) {
            $tester = new DateTime($date['birthdate']);
            if ($tester->format($year . '-m-d') == $now->format('Y-m-d')) {
                echo '<p><b><a href="profile?id=' . $date['id'] . '">' . $date['username'] . '</a></b></p><p>' . $tester->format('F jS') . '</p>';
            }
        }
        echo '</div>';
    }

    //Upcoming Birthdays
    $fiveDays = new DateTime('now');
    $fiveDays->add(new DateInterval('P5D'));



    $tester = new DateTime($dates[1]['birthdate']);
    $tester->format($year . '-m-d');

    $check = 0;
    foreach ($dates as $date) {
        $tester = new DateTime($date['birthdate']);
        if ($tester->format($year . '-m-d') > $now->format('Y-m-d') && $tester->format($year . '-m-d') < $fiveDays->format('Y-m-d')) {
            $check = 1;
        }
    }

    if ($check == 1) {
        echo '<div class="indexBox">';
        echo '<h4 style="margin-top: 0;margin-bottom: 1.5rem;">Upcoming Birthdays</h4>';
             foreach ($dates as $date) {
                $tester = new DateTime($date['birthdate']);
                if ($tester->format($year . '-m-d') > $now->format('Y-m-d') && $tester->format($year . '-m-d') < $fiveDays->format('Y-m-d')) {
                    echo '<p><b><a href="profile?id=' . $date['id'] . '">' . $date['username'] . '</a></b></p><p>' . $tester->format('F jS') . '</p>';
                }
            }

        echo '</div>';
    }
    
    //Resources
    echo '<div class="indexBox">';
    echo '<h4 style="margin-top: 0;margin-bottom: 1.5rem;">Game Resources</h4>';
    echo '<p><a href="gameGuides" class="notif">1. Reference Pages</a></p>';
    echo '<p><a href="https://discord.gg/p6wr4NBrx9" class="notif">2. Discord Server</a></p>';
    echo '</div>';
    
    echo '</div>';

    //Right Column
    echo '<div class="rightColumnHome">';

    //Recent News
    echo '<div class="indexBox">';
    echo '<h3>Recent News</h3>';
    echo '<h4 style="margin-top: 0;">' . $news['title'] . '</h4>';
    echo '<div style="height: 250px; overflow: hidden;">' . nl2br($news['text']) . '</div>';
    echo '<div style="text-align: right; margin-right: 1rem;margin-top: .5rem;margin-bottom: .5rem;"><a style="font-size: 2rem; font-weight: bold" href="post?id=' . $news['id'] . '">Read More >></a></div>';
    echo '</div>';

    //Recent Submissions
    echo '<div class="indexBox">';
    echo '<h3 >Kindness Coins</h3>';
    echo '<h4 style="margin-top: 0;">' . $submissions['title'] . '</h4>';
    echo '<div style="height: 250px; overflow: hidden;">' . nl2br($submissions['text']) . '</div>';
    echo '<div style="text-align: right; margin-right: 1rem;margin-top: .5rem;margin-bottom: .5rem;"><a style="font-size: 2rem; font-weight: bold" href="post?id=' . $submissions['id'] . '">Read More >></a></div>';
    echo '</div>';

    echo '</div>';
    echo '</div>';

} else {
    if ($reply) {
        echo '<div class="returnBar" style="margin-top: 1rem;margin-bottom:2rem;">';
        echo '<p>' . $reply['message'] . '</p>';
        echo '</div>';
        $query = "DELETE FROM replies WHERE user_id = :id;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
    }
    echo '<img src="resources/wip.png" style="width:90%;">';
    echo '<h3 style="font-size:4rem;border-bottom: 2px dashed #827188;padding-bottom:1.5rem;margin-top:1.5rem;">🎉 Welcome Early Access Players 🎉</h3>';
    
    //Collect Snoozelings
    echo '<img src="resources/Banner1.png" style="width:70%">';
    echo '<div style="display: flex;flex-direction: row; flex-wrap: wrap; justify-content: center;">';
    echo '<div style="width: 33%;"><img src="resources/promo2.png" class="adimage"><p><b>Mayor Cocoa</b></p></div>';
    echo '<div style="width: 33%;"><img src="resources/promo6.png" class="adimage"><p><b>Princess Mingi</b></p></div>';
    echo '<div style="width: 33%;"><img src="resources/promo1.png" class="adimage"><p><b>Scrap</b></p></div>';
    echo '</div>';
    echo '<div style="display: flex;flex-direction: row; flex-wrap: wrap; justify-content: center;">';
    echo '<div style="width: 33%;"><img src="resources/promo3.png"  class="adimage"><p><b>Morticia</b></p></div>';
    echo '<div style="width: 33%;"><img src="resources/promo4.png" class="adimage"><p><b>Chizori</b></p></div>';
    echo '<div style="width: 33%;"><img src="resources/promo5.png" class="adimage"><p><b>Tortellini</b></p></div>';
    echo '</div>';
    echo '<p style="border-bottom: 2px dashed #827188;padding-bottom:2rem;"><i>The above Snoozelings were all created during Early Access by various users.</i></p>';
    
    //Self Care Section
    echo '<img src="resources/Banner2.png" style="width:70%">';
    echo '<div style="display: flex;flex-direction: row; flex-wrap: wrap; justify-content: center;">';
    echo '<div style="width:40%;"><img src="resources/promo7.png"  class="adimage" style="border-radius: 15px;border:1px solid #dddddd;"><p><b>Daily Affirmations</b></p></div>';
    echo '<div style="width: 40%;"><img src="resources/promo8.png" class="adimage" style="border-radius: 15px;border:1px solid #dddddd;"><p><b>Keep a Health Journal</b></p></div>';
    echo '</div>';
    echo '<p style="border-bottom: 2px dashed #827188;padding-bottom:2rem;">Take care of yourself to earn coin to buy cute clothes and hair styles for your Snoozeling.</p>';
    
    //Cozy Gaming
    echo '<img src="resources/Banner3.png" style="width:70%">';
    echo '<div style="display: flex;flex-direction: row; flex-wrap: wrap; justify-content: center;">';
    echo '<div style="width:80%;"><img src="resources/promo14.png"  class="adimage" style="border-radius: 25px;border:1px solid #dddddd;"></div>';
    echo '</div>';
    echo '<p style="padding-bottom:2rem;border-bottom: 2px dashed #827188;padding-bottom:2rem;">Plants can be Used to Craft Dyes & Fabric</p>';
    echo '<img src="resources/Banner4.png" style="width:70%">';
    echo '<div style="display: flex;flex-direction: row; flex-wrap: wrap; justify-content: center;">';
    echo '<div style="width:80%;"><img src="resources/promo11.png"  class="adimage" style="border-radius: 25px;border:1px solid #dddddd;"></div>';
    echo '</div>';
    echo '<p style="padding-bottom:2rem;border-bottom: 2px dashed #827188;padding-bottom:2rem;">Create New Clothes, Fabrics, Items, and Designs for Your Snoozelings</p>';
    echo '<img src="resources/Banner5.png" style="width:70%">';
    echo '<div style="display: flex;flex-direction: row; flex-wrap: wrap; justify-content: center;">';
    echo '<div style="width:40%;"><img src="resources/dyes1.png"  class="adimage" style="border-radius: 25px;border:1px solid #dddddd;margin-bottom:12px;"></div>';
    echo '<div style="width:40%;"><img src="resources/Dyes2.png"  class="adimage" style="border-radius: 25px;border:1px solid #dddddd;"></div>';
    echo '</div>';
    echo '<p style="border-bottom: 2px dashed #827188;padding-bottom:2rem;">Dye your Clothes with Over Twenty-Six Custom Colors</p>';
    
    //Alpha Reviews
    echo '<img src="resources/Banner6.png" style="width:70%">';
    echo '<p style="width: 80%; margin-right: auto; margin-left: auto;">As someone who quickly falls out of pet Sims every now and again, Snoozelings honestly just has me coming back and back again for more! the self care features are a wonderful touch and the overall aesthetic of the pets themselves brings a lot of comfort and warmth into the site. The community it has is lovely as well and I\'m very excited to see it grow and evolve!</p>';
    echo '<p style="width: 80%; text-align: right; margin-right: 2rem;">~Alpha Tester #33</p>';
    echo '<hr>';
    echo '<p style="width: 80%; margin-right: auto; margin-left: auto;">The Mental Health and Physical Health focus, I love working on my journal daily and keeping track of my chronic pains. They have helped me a lot ever since starting with the Alpha and it\'s so well done and thought out. And the overall focus on Selfcare is just WONDERFUL.</p>';
    echo '<p style="width: 80%; text-align: right; margin-right: 2rem;">~Alpha Tester #20</p>';
    echo '<hr>';
    echo '<p style="width: 80%; margin-right: auto; margin-left: auto;">I love getting to check in on my snoozeling throughout the day. Even at this early stage I feel like all the timed tasks are really balanced, they\'re just long enough where it doesn\'t feel like forever but still encourages you to get away from the screen for a bit, while also having longer term goals to work towards that absolutely feel within reach. It\'s like neopets but it still gets you to go touch grass hahah! Can\'t wait to see where it goes.</p>';
    echo '<p style="width: 80%; text-align: right; margin-right: 2rem;">~Alpha Tester #42</p>';
    echo '<p style="border-bottom: 2px dashed #827188;padding-bottom:2rem; margin-bottom: 2rem;"></p>';
    
    echo '<img src="resources/Banner8.png" style="width:70%">';
    echo '<p style="font-size: 2rem"><b>Early Access Code Sales:</b> <a href="premiumshop">Open</a></p>';
    echo '<p style="font-size: 2rem"><b>Early Access Launch:</b> September 1st, 2024</p>';
    echo '<p style="font-size: 2rem; border-bottom: 2px dashed #827188;padding-bottom:2rem; margin-bottom: 2rem;"><b>Free Launch:</b> Winter 2025</p>';
    
    
    echo '<img src="resources/Banner7.png" style="width:70%"><br>';
    echo '<p style="border-bottom: 2px dashed #827188;padding-bottom:2rem;"><a href="https://discord.gg/HDs66g7QeJ"><img style="width: 10%;"src="https://static-00.iconduck.com/assets.00/discord-icon-2048x2048-nnt62s2u.png"></a></p>';
    echo '<img src="resources/Banner9.png" style="width:70%"><br>';
    echo '<div style="display:flex;">';
    echo '<div id="mc_embed_shell" style="margin-left:auto;margin-right:auto;color:black;">
      <link href="//cdn-images.mailchimp.com/embedcode/classic-061523.css" rel="stylesheet" type="text/css">
  <style type="text/css">
        #mc_embed_signup{background:#fff; false;clear:left; font:14px Helvetica,Arial,sans-serif; width: 600px;}
        /* Add your own Mailchimp form style overrides in your site stylesheet or in this style block.
           We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
</style>
<div id="mc_embed_signup">
    <form action="https://snoozelings.us14.list-manage.com/subscribe/post?u=bd00f10336c35561599f83e2a&amp;id=5593074c95&amp;f_id=00468de0f0" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank">
        <div id="mc_embed_signup_scroll" style="color:black"><h2>Snoozelings Newsletter</h2>
            <div class="indicates-required"><span class="asterisk">*</span> indicates required</div>
            <div class="mc-field-group"><label for="mce-EMAIL">Email Address <span class="asterisk">*</span></label><input type="email" name="EMAIL" class="required email" id="mce-EMAIL" required="" value=""></div>
        <div id="mce-responses" class="clear foot">
            <div class="response" id="mce-error-response" style="display: none;"></div>
            <div class="response" id="mce-success-response" style="display: none;"></div>
        </div>
    <div aria-hidden="true" style="position: absolute; left: -5000px;">
        /* real people should not fill this in and expect good things - do not remove this or risk form bot signups */
        <input type="text" name="b_bd00f10336c35561599f83e2a_5593074c95" tabindex="-1" value="">
    </div>
        <div class="optionalParent">
            <div class="clear foot">
                <input type="submit" name="subscribe" id="mc-embedded-subscribe" class="button" value="Subscribe">
                <p style="margin: 0px auto;"><a href="http://eepurl.com/iWuWmE" title="Mailchimp - email marketing made easy and fun"><span style="display: inline-block; background-color: transparent; border-radius: 4px;"></span></a></p>
            </div>
        </div>
    </div>
</form>
</div>
<script type="text/javascript" src="//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js"></script><script type="text/javascript">(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]=\'EMAIL\';ftypes[0]=\'email\';fnames[1]=\'FNAME\';ftypes[1]=\'text\';fnames[2]=\'LNAME\';ftypes[2]=\'text\';fnames[3]=\'ADDRESS\';ftypes[3]=\'address\';fnames[4]=\'PHONE\';ftypes[4]=\'phone\';fnames[5]=\'BIRTHDAY\';ftypes[5]=\'birthday\';}(jQuery));var $mcj = jQuery.noConflict(true);</script></div>
';
    echo '<div id="MobileNewsletter"><h3><a href="https://mailchi.mp/45ecadfead88/snoozelings-newsletter">Click Here</a></h3></div>';
    echo '</div>';
}
















