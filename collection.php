<?php
require_once '../includes/config_session.inc.php';
require_once '../includes/dbh-inc.php';
require_once '../includes/verifyCheck.inc.php'; 
require_once '../includes/verifySinglePet.inc.php'; 




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
                <?php require_once '../includes/socialIcons.inc.php'; ?>
            </ul>
        </div>
    </div>

    <!-- White Secondary Top Bar. Includes Menu and Drop Down Menus -->
    <nav>
        <?php require_once "../includes/taskbar.inc.php"; ?>
    </nav>

    <!-- Container for Everything Below the Bars -->
    <div class="body-container">

        <!-- Container for all Left Page Elements -->
        <div class="left-container">
            <div class="mobile-left">
                <div class="bar-container">
                    <h2>Daily Affirmation</h2>
                    
                    <?php require_once '../includes/dailyAffirmation.inc.php'; ?>
                    
                    <p id="date"></p>
                </div>

                <!-- Snoozeling Display Box. Currently Generates Random Snoozeling -->
                <div class="bar-container">
                    <?php require '../includes/leftPet.inc.php'; ?>
                    <p id="mood" onClick="showForm()"><strong>Mood:</strong> Happy</p>
                    <form id="moodForm">
                        <label for="mood">Choose a Mood:</label>
                        <select id="moodSelect" name="mood">
                            <option value="Happy">Happy</option>
                            <option value="Anxious">Anxious</option>
                            <option value="Worried">Worried</option>
                            <option value="Silly">Silly</option>
                            <option value="Overwhelmed">Overwhelmed</option>
                        </select><br>
                        <input type="button" onClick="hideForm()" value="Change Mood">
                    </form>
                </div>
            </div>

            <div class="mobile-right">
                <!-- Daily Affirmation Box -->


                <!-- To Do List -->
                <?php if(isset($_SESSION['user_id'])) {
               echo '<div class="bar-container">
                    <h2>To Do</h2>
                    <?php require_once "../includes/notifications.inc.php"; ?>
                    <button onclick="window.location.href="../includes/clearNotifications.inc.php";" class="taskList" id="clearNotifs">Clear Notifications</button><br><br>
                </div>';
                } ?>

                <!-- Daily Stats -->
                <div class="bar-container">
                    <h2>Daily Records</h2>
                    <?php require_once '../includes/dailyRecords.inc.php' ?>
                </div>
            </div>
        </div>

        <!-- All Main Content -->
        <div class="main-container"><div>
            <?php require_once '../includes/nestContent.php'; ?>
            <script>
    //Profile / Snoozeling / Collection Fix When Only Right Arrow
var leftArrow = document.getElementById('leftArrow');
if (!leftArrow) {
    document.getElementById('onlyOne').style.justifyContent = 'flex-end';
}
    </script>
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
