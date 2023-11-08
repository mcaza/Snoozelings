<?php
require_once 'includes/config_session.inc.php';
require_once 'includes/dbh-inc.php';
require_once 'includes/signup_view.inc.php';
require_once 'includes/login_view.inc.php';

?>

<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <!-- Dark Top Bar, Snoozeling Text Logo, and Social Media Icons */ -->
    <div class="nav-container">
        <div id="logo">
            <a href="index.html">Snoozelings</a>
        </div>
        <div class="social-container">
            <ul>
                <?php require_once 'includes/socialIcons.inc.php'; ?>
            </ul>
        </div>
    </div>

    <!-- White Secondary Top Bar. Includes Menu and Drop Down Menus -->
    <nav>
        <?php require_once "includes/taskbar.inc.php"; ?>
    </nav>

    <!-- Container for Everything Below the Bars -->
    <div class="body-container">

        <!-- Container for all Left Page Elements -->
        <div class="left-container">
            <div class="mobile-left">
                <div class="bar-container">
                    <h2>Daily Affirmation</h2>
                    
                    <?php require_once 'includes/dailyAffirmation.inc.php'; ?>
                    <p id="date"></p>
                </div>

                <!-- Snoozeling Display Box. Currently Generates Random Snoozeling -->
                <div class="bar-container">
                    <?php require_once 'includes/leftPet.inc.php'; ?>
                    <p id="mood"><strong>Mood:</strong> Happy</p>
                </div>
            </div>

            <div class="mobile-right">
                <!-- Daily Affirmation Box -->



                <!-- Daily Stats -->
                <div class="bar-container">
                    <h2>Daily Records</h2>
                    <p>319 Journal Entries</p>
                    <p>938 Crops Harvested</p>
                    <p>57 Snoozelings Crafted</p>
                    <p>92 Items Crafted</p>
                    <p>593 Total Active Members</p>
                    <p>59 Kindness Coins Rewarded</p>
                </div>
            </div>
        </div>

        <!-- All Main Content -->
        <div class="main-container">
            <h2><?php outputUsername(); ?></h2>
            <h3>Signup</h3>

            <form action="includes/signup.inc.php" method="post">
                <?php 
            signupInputs();
        ?>
                <button>Signup</button>
            </form>
            
            <?php
            checkSignupErrors();
            
            ?>
            
            <h3>Login</h3>
            <form action="includes/login.inc.php" method="post">
                <input type="text" name="usernamelogin" placeholder="Username"><br>
                <input type="password" name="pwdlogin" placeholder="Password"><br>
                <button>Login</button>
            </form>
            
            <?php
            checkLoginErrors();
            ?>
            
            <h3>Logout</h3>
            <form action="includes/logout.inc.php" method="post">
                <button>Logout</button>
            </form>

            
        </div>
    </div>
    <!--End of All Main Content-->



    <!-- Footer Goes Here -->
    <div class="footer-container">
        <div class="footer-texts">
            <ul>
                <li><a href="">Terms of Service</a></li>
                <li><a href="">Code of Conduct</a></li>
                <li><a href="">Privacy Policy</a></li>
                <li><a href="">Contact Us</a></li>
                <li><a href="">Moderator Help</a></li>

            </ul>
        </div>
    </div>


    <!-- Script Link -->
    <script src="main.js"></script>

</body>

</html>
