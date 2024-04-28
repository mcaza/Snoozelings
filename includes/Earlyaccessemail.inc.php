<?php
require_once 'dbh-inc.php';

$msg ='<p>Hey there!!!!<br><br>Our last email was a bit buggy, so we\'ve decided to send this one without any formatting. This should be much easier to read.<br><br>We are emailing you to let you know Snoozelings Shop is now open for Early Access sales and custom items. All the money goes towards making the game: server and art isn\'t cheap. <br><br>We want to make sure our artist is properly compensated for their time. There\'s a lot of art to be made - almost three thousand dollars worth - and we\'ve only raised about 1600$ so far. The server also costs about 110$ USD a month to run even while we\'re working to release the game in Spring. <br><br>If you buy an access code now, you get a chance to select your user ID. Wouldn\'t it be super cool to have a double digit ID? I think so!!<br><br>We are also offering customs for various prices. You can get a custom color, farm name, pet title, pet marking, or clothing item added to the game, specially designed by you! Some customs are as low as 5$ USD.<br><br>The shop can be found <a href="https://ko-fi.com/slothiestudios/shop">here!!!</a>.<br><br>Can\'t wait to see you when the game launches in Spring 2024,<br><br>~Snoozelings</p>';

$title ="Snoozelings EA Shop Open";

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        //From
        $headers .= 'From: Snoozelings <autoreply@snoozelings.com>' . "\r\n";

    $address = "megan.caza@gmail.com";
    mail($address, $title, $msg, $headers);


echo 'Sent';