<?php
require_once '../includes/dbh-inc.php';
require_once '../includes/config_session.inc.php';
require_once '../includes/signup_view.inc.php';
require_once '../includes/login_view.inc.php';
require_once '../includes/loginRedirect.inc.php';

?>

<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
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
        <div class="main-container"><?php require_once '../includes/news.inc.php'; ?><div  class="bottomPush">
            <div style="margin-bottom: 2rem;"><img class="wideImage" src="resources/wideBarPlaceholder.png"></div>
            <h3 style="margin-bottom:1.5rem">Early Access is Open</h3>
            <?php
            $error = $_GET['error'];
            $code = $_GET['code'];
            $username = $_GET['username'];
            $email = $_GET['email'];
                    
                    //Notification
            if ($error) {
                echo '<div class="returnBar" style="margin-top: 1rem;margin-bottom:2rem;"><p>';
                if ($error == 1) {
                    echo 'You must fill in all fields.';
                } else if ($error == 2) {
                    echo 'Invalid email used.';
                } else if ($error == 3) {
                    echo 'Username already taken.';
                } else if ($error == 4) {
                    echo 'That email is already registered to an account.';
                } else if ($error == 5) {
                    echo 'Your birth date cannot be in the future.';
                } else if ($error == 6) {
                    echo 'You need to be 13 or older to register.';
                } else if ($error == 7) {
                    echo 'Your passwords do not match.';
                } else if ($error == 8) {
                    echo 'Your password must be at least 8 characters in length.';
                } else if ($error == 9) {
                    echo 'You have entered an incorrect early access code.';
                } else if ($error == 10) {
                    echo 'Your early access code has already been used on another account.';
                } else if ($error == 11) {
                    echo 'Please do not enter custom pronouns.';
                }
                echo '</p></div>';

            }
            
            ?>
            <?php 
            
            
            echo '<form action="includes/signup.inc.php" method="post">';
            signupInputs();
        
                echo '<button  class="fancyButton regButton">Register</button>';
            echo '</form>'; 
            ?>
            
            
            
            
        </div>
    </div></div>
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
