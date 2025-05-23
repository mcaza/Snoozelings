<?php 

$userId = $_COOKIE['user_id'];
date_default_timezone_set('America/Los_Angeles');
$month = ltrim(date('m'), "0");


    if (isset($_COOKIE['user_id'])) {
        $userId = $_COOKIE['user_id'];
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
        $id = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $query = "SELECT name FROM snoozelings WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id['bonded']);
        $stmt->execute();
        $name = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($id['homeName']) {
            $home = $id['homeName'];
        } else {
            $home = "Abode";
        }
        
        echo '<div class="dropdown">
            <button class="menu dropdown dropbtn" id="drop"><a href="profile?id=' . $_COOKIE['user_id'] . '">' . $id['username'] . '\'s ' . $home . '</a></button>
            <div class="dropdown-content">
                <a href="/collection?id=' . $_COOKIE['user_id'] . '">Snoozeling Nests</a>
                <a href="/crafting">Crafting Table</a>
                <a href="dyes">Dye Station</a>
                <a href="farm">Farm Plots</a>
                <a href="pack">' . $name['name'] . '\'s Pack</a>
            </div>
        </div>
        <div class="dropdown">
            <button class="menu dropdown dropbtn" id="drop"><a href="snoozevillage">Snooze Village</a></button>
            <div class="dropdown-content">
                <a href="explore">Exploring</a>
                <a href="wishingwell">Wishing Well</a>
                <a href="shops">Snooze Shops</a>
                <a href="requests">Request Board</a>
            </div>
        </div>
        <div class="dropdown">
            <button class="menu dropdown dropbtn" id="drop"><a href="games">Fun Stuff</a></button>
            <div class="dropdown-content">
                <a href="raffle">Daily Raffle</a>
                <a href="randomitem">Simon\'s Gifts</a>';
        
        //Dec Event
        if ($month == 12) {
            echo   '<a href="decemberGifts">Cocoa\'s Gifts</a>';
        }
             
          echo      ' </div>
        </div>
        <div class="dropdown">
            <button class="menu dropdown dropbtn" id="drop"><a href="journal">Self Care</a></button>
            <div class="dropdown-content">
                <a href="journal">Journal</a>
            </div>
        </div>
        <div class="dropdown">
            <button class="menu dropdown dropbtn" id="drop"><a href="community">Community</a></button>
            <div class="dropdown-content">
                <a href="mailbox">Mailbox</a>
                <a href="penpals">Penpal Board</a>
                <a href="critterweb">Critter Web</a>
            </div>
        </div>
        <div class="dropdown">
        <button class="menu dropdown dropbtn" id="drop"><a href="/includes/logout.inc.php">Log Out</a></button>
        </div>';
    } else {
        echo '<div>
        <button class="menu dropdown dropbtn" id="drop"><a href="signup">Sign Up</a></button>
        </div>
        <div>
        <button class="menu dropdown dropbtn" id="drop"><a href="login">Log In</a></button>
        </div>
        <div>
        <button class="menu dropdown dropbtn" id="drop"><a href="helpme">Help Me</a></button>
        </div>
        <div>
        <button class="menu dropdown dropbtn" id="drop"><a href="premiumshop">Code Shop</a></button>
        </div>';
    }

