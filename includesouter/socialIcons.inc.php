<?php

//Get Values
if ($_SESSION['user_id']) {
    $userId = $_SESSION['user_id'];
}


//Grab Shortcut
$query = 'SELECT shortcuts, bonded FROM users WHERE id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$results = $stmt->fetch(PDO::FETCH_ASSOC);

//If Logged in, Show Shortcuts
if ($userId) {

    //If no shortcuts, default
    if (!$results['shortcuts']) {
        echo '<li id="homeshortcut"><a href="/" ><img src="resources/IconHome.png"></a></li>';
        echo '<li><a href="journal" ><img src="resources/IconJournal.png"></a></li>';
        echo '<li><a href="farm" ><img src="resources/IconGarden.png"></a></li>';
        echo '<li><a href="explore" ><img src="resources/IconExplore.png"></a></li>';
        echo '<li><a href="crafting" ><img src="resources/IconCrafting.png"></a></li>';
        echo '<li><a href="mailbox" ><img src="resources/IconMailbox.png"></a></li>';
    } else {
        echo '<li id="homeshortcut"><a href="/" ><img src="resources/IconHome.png"></a></li>';
            
        //Get Bonded ID
        $bonded = $results['bonded'];

        //Else Display Custom Shortcuts
        $shortcutArray = explode(" ", $results['shortcuts']);
        foreach ($shortcutArray as $short) {
            $link = "";
            switch ($short) {
                case "Crafting":
                $link = "crafting";
                break;
                case "Dyes":
                $link = "dyes";
                break;
                case "Explore":
                $link = "explore";
                break;
                case "Garden":
                $link = "farm";
                break;
                case "Journal":
                $link = "journal";
                break;
                case "Mailbox":
                $link = "mailbox";
                break;
                case "Penpals":
                $link = "penpals";
                break;
                case "Snoozeling":
                $link = "pet?id=" . $results['bonded'];
                break;
            }
            echo '<li><a href="' . $link . '" ><img src="resources/Icon' . $short . '.png"></a></li>';
        }
    }
} else {
     echo '<li id="homeshortcut"><a href="/" ><img src="resources/IconHome.png"></a></li>';
    echo '<li><a href="https://ko-fi.com/slothiestudios/goal?g=0" target="_blank"><img src="resources/Kofi.png"></a></li>
                <li><a href="https://discord.gg/bKBzUMwTKh" target="_blank"><img src="resources/Discord.png"></a></li>
                <li><a href="https://twitter.com/SnoozelingsGame" target="_blank"><img src="resources/Twitter.png"></a></li>
                <li><a href="https://www.tumblr.com/snoozelings" target="_blank"><img src="resources/5282552_tumblr_tumblr%20logo_icon.png"></a></li>';
}

/*


        echo '
                '; */