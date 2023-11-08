<?php 

$loggedInBar = '<div class="dropdown">
            <button class="menu dropdown dropbtn" id="drop"><a href="profile.html">' . $_SESSION["user_username"] . '\'s Abode</a></button>
            <div class="dropdown-content">
                <a href="nests.html">Snoozeling Nests</a>
                <a href="crafting.html">Crafting Table</a>
                <a href="farming.html">Farm Plots</a>
                <a href="">Fanny Pack</a>
            </div>
        </div>
        <div class="dropdown">
            <button class="menu dropdown dropbtn" id="drop"><a href="snoozeland.html">Snooze Land</a></button>
            <div class="dropdown-content">
                <a href="exploring.html">Exploring</a>
                <a href="adoptionhouse.html">Adoption House</a>
                <a href="shops.html">Snooze Shops</a>
                <a href="trendytails.html">Trendy Tails</a>
            </div>
        </div>
        <div class="dropdown">
            <button class="menu dropdown dropbtn" id="drop"><a href="games.html">Mini Games</a></button>
            <div class="dropdown-content">
                <a href="dailyraffle.html">Daily Raffle</a>
                <a href="freeitem.html">Random Item</a>
            </div>
        </div>
        <div class="dropdown">
            <button class="menu dropdown dropbtn" id="drop"><a href="selfcare.html">Self Care</a></button>
            <div class="dropdown-content">
                <a href="journalmenu.html">Journal</a>
                <a href="medicationtracker.html">Med Tracker</a>
            </div>
        </div>
        <div>
            <a href="socialweb.html" class="menu">Social Web</a>
        </div>
        <div>
            <a href="includes/logout.inc.php" class="menu">Log Out</a>
        </div>';

$loggedOutBar = 
        '<div>
            <a href="signup.php" class="menu">Sign Up</a>
        </div>
        <div>
            <a href="login.php" class="menu">Log In</a>
        </div>';
        

    if (isset($_SESSION["user_id"])) {
        echo $loggedInBar;
    } else {
        echo $loggedOutBar;
    }

