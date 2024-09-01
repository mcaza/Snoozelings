<?php 



    if (isset($_SESSION["user_id"])) {
        $userId = $_SESSION['user_id'];
        $query = "SELECT bonded FROM users WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
        $id = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $query = "SELECT name FROM snoozelings WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id['bonded']);
        $stmt->execute();
        $name = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo '<div class="dropdown">
            <button class="menu dropdown dropbtn" id="drop"><a href="profile?id=' . $_SESSION['user_id'] . '">' . $_SESSION["user_username"] . '\'s Abode</a></button>
            <div class="dropdown-content">
                <a href="/collection?id=' . $_SESSION['user_id'] . '">Snoozeling Nests</a>
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
                <a href="shops">Snooze Shops</a>
                <a href="requests">Request Boards</a>
            </div>
        </div>
        <div class="dropdown">
            <button class="menu dropdown dropbtn" id="drop"><a href="games">Fun Stuff</a></button>
            <div class="dropdown-content">
                <a href="raffle">Daily Raffle</a>
                <a href="randomitem">Simon\'s Gifts</a>
                <a href="designer">Snooze Maker</a>
            </div>
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

