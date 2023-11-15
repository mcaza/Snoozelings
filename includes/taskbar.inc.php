<?php 

$loggedInBar = '<div class="dropdown">
            <button class="menu dropdown dropbtn" id="drop"><a href="profile.php?id=' . $_SESSION['user_id'] . '">' . $_SESSION["user_username"] . '\'s Abode</a></button>
            <div class="dropdown-content">
                <a href="collection?id=' . $_SESSION['user_id'] . '">Snoozeling Nests</a>
                <a href="crafting.html">Crafting Table</a>
                <a href="farm">Farm Plots</a>
                <a href="pack">Fanny Pack</a>
            </div>
        </div>
        <div class="dropdown">
            <button class="menu dropdown dropbtn" id="drop"><a href="snoozeland.html">Snooze Land</a></button>
            <div class="dropdown-content">
                <a href="explore">Exploring</a>
                <a href="adoptionhouse.html">Adoption House</a>
                <a href="shops">Snooze Shops</a>
                <a href="trendytails">Trendy Tails</a>
            </div>
        </div>
        <div class="dropdown">
            <button class="menu dropdown dropbtn" id="drop"><a href="games.html">Mini Games</a></button>
            <div class="dropdown-content">
                <a href="dailyraffle.html">Daily Raffle</a>
                <a href="randomitem">Random Item</a>
            </div>
        </div>
        <div class="dropdown">
            <button class="menu dropdown dropbtn" id="drop"><a href="journal">Self Care</a></button>
            <div class="dropdown-content">
                <a href="journal">Journal</a>
            </div>
        </div>
        <div class="dropdown">
            <button class="menu dropdown dropbtn" id="drop"><a href="selfcare.html">Community</a></button>
            <div class="dropdown-content">
                <a href="mailbox">Mailbox</a>
                <a href="boards">Bulletin Board</a>
            </div>
        </div>
        <div>
            <a href="/includes/logout.inc.php" class="menu">Log Out</a>
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

