<?php

echo '<div class="nav-container">
        <div id="logo" >';

       
$now = new DateTime('now', new DateTimezone('UTC'));
    $firstDate = $now->format('m');
    if ($firstDate == 10) {
        echo '<a href="/"><img src="resources/wipHalloween.png"></a>';
    } else {
        echo '<a href="/"><img src="resources/wip.png"></a>';
    }
    echo '</div>
        <div class="social-container">
            <ul>';

require_once "../includes/socialIcons.inc.php";
echo '</ul></div></div>';