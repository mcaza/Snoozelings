<?php
require_once '../includes/dbh-inc.php';
require_once '../includes/config_session.inc.php';
require_once '../includes/login_view.inc.php';
require_once '../includes/loginRedirect.inc.php';




?>

<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <?php require_once '../includes/css.inc.php'; ?>
    <?php require_once '../includes/favicon.inc.php'; ?>
</head>

<body>
    <!-- Dark Top Bar, Snoozeling Text Logo, and Social Media Icons */ -->
    <?php require_once "../includes/logo.inc.php"; ?>

    <!-- White Secondary Top Bar. Includes Menu and Drop Down Menus -->
    <nav>
        <?php require_once "../includes/taskbar.inc.php"; ?>
    </nav>

    <!-- Container for Everything Below the Bars -->
    <div class="body-container">

        <!-- Container for all Left Page Elements -->
        <div class="left-container">

                <div class="bar-container">
                    <h2>Daily Affirmation</h2>
                    
                    <?php require_once '../includes/dailyAffirmation.inc.php'; ?>
                    
                    <p id="date"></p>
                </div>

                <!-- Snoozeling Display Box. Currently Generates Random Snoozeling -->
                <div class="bar-container">
                    <?php require '../includes/leftPet.inc.php'; ?>
                </div>

                <!-- Daily Affirmation Box -->

                <!-- Daily Stats -->
                <div class="bar-container">
                    
                    <?php require_once '../includes/dailyRecords.inc.php' ?>
                </div>
            </div>


        <!-- All Main Content -->
        <div class="main-container"><div class="bottomPush">
            <div style="margin-bottom:2rem;"><img class="wideImage" src="resources/wideBarPlaceholder.png"></div>
            <h3 style="margin-bottom:1.5rem">🎉 Welcome Early Access Players 🎉</h3>
            <form action="includes/login.inc.php" method="post">
                <label class='form' for="usernamelogin">Username:</label><br>
                <input class="input" type="text" name="usernamelogin" placeholder="Username"><br>
                <label class='form' for="pwdlogin">Password:</label><br>
                <input class="input" type="password" name="pwdlogin" placeholder="Password"><br>
                <button class="fancyButton regButton">Login</button>
            </form>
            
            <?php
            checkLoginErrors();
            ?>
        </div></div>
    </div>
    <!--End of All Main Content-->



    <!-- Footer Goes Here -->
    
    <div class="footer-container">
        <div class="footer-texts">
            <ul>
                <?php require_once '../includes/bottomBar.inc.php'; ?>
            </ul>
        </div>
    </div>


    <!-- Script Link -->
   <script src="main.js"></script>

</body>

</html>
