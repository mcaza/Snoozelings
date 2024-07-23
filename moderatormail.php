<?php
require_once '../includes/config_session.inc.php';
require_once '../includes/dbh-inc.php';

?>

<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderator Mail</title>
    <link rel="stylesheet" href="styles.css">
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


                <!-- To Do List -->
                <?php if(isset($_SESSION['user_id'])) {
               echo '<div class="bar-container">
                    <h2>To Do</h2>
                    ';  require_once "../includes/notifications.inc.php"; 
                    echo '<br>
                </div>';
                } ?>

                <!-- Daily Stats -->
                <div class="bar-container">
                    <h2>Daily Records</h2>
                    <?php require_once '../includes/dailyRecords.inc.php' ?>
                </div>
            </div>


        <!-- All Main Content -->
        <div class="main-container"><div  class="bottomPush">
            <?php require_once '../includes/moderatormail.inc.php'; ?>
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

<script>
     document.getElementById('topic').onchange = (event) => {
         var inputText = event.target.value;
         if (inputText === 'Account') {
             document.getElementById("accountdiv").style.display = "block";
             document.getElementById("rulesdiv").style.display = "none";
             document.getElementById("purchasediv").style.display = "none";
             document.getElementById("merchdiv").style.display = "none";
             document.getElementById("bugsdiv").style.display = "none";
             document.getElementById("otherdiv").style.display = "none";
         } else if (inputText === "Rules") {
             document.getElementById("accountdiv").style.display = "none";
             document.getElementById("rulesdiv").style.display = "block";
             document.getElementById("purchasediv").style.display = "none";
             document.getElementById("merchdiv").style.display = "none";
             document.getElementById("bugsdiv").style.display = "none";
             document.getElementById("otherdiv").style.display = "none";
         } else if (inputText === "Purchase") {
             document.getElementById("accountdiv").style.display = "none";
             document.getElementById("rulesdiv").style.display = "none";
             document.getElementById("purchasediv").style.display = "block";
             document.getElementById("merchdiv").style.display = "none";
             document.getElementById("bugsdiv").style.display = "none";
             document.getElementById("otherdiv").style.display = "none";
         } else if (inputText === "Merch") {
             document.getElementById("accountdiv").style.display = "none";
             document.getElementById("rulesdiv").style.display = "none";
             document.getElementById("purchasediv").style.display = "none";
             document.getElementById("merchdiv").style.display = "block";
             document.getElementById("bugsdiv").style.display = "none";
             document.getElementById("otherdiv").style.display = "none";
         } else if (inputText === "Bugs") {
             document.getElementById("accountdiv").style.display = "none";
             document.getElementById("rulesdiv").style.display = "none";
             document.getElementById("purchasediv").style.display = "none";
             document.getElementById("merchdiv").style.display = "none";
             document.getElementById("bugsdiv").style.display = "block";
             document.getElementById("otherdiv").style.display = "none";
         } else if (inputText === "Other") {
             document.getElementById("accountdiv").style.display = "none";
             document.getElementById("rulesdiv").style.display = "none";
             document.getElementById("purchasediv").style.display = "none";
             document.getElementById("merchdiv").style.display = "none";
             document.getElementById("bugsdiv").style.display = "none";
             document.getElementById("otherdiv").style.display = "block";
         } else if (inputText === "") {
             document.getElementById("accountdiv").style.display = "none";
             document.getElementById("rulesdiv").style.display = "none";
             document.getElementById("purchasediv").style.display = "none";
             document.getElementById("merchdiv").style.display = "none";
             document.getElementById("bugsdiv").style.display = "none";
             document.getElementById("otherdiv").style.display = "none";
         }
     }
     
     
    
    </script>
