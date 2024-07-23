<?php
require_once '../includes/config_session.inc.php';
require_once '../includes/dbh-inc.php';
require_once '../includes/logincheck.inc.php';
require_once '../includes/verifyCheck.inc.php'; 
require_once '../includes/verifySinglePet.inc.php'; 




?>

<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trendy Tails</title>
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
            <?php require_once '../includes/trendytails.inc.php'; ?>
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
    <script>
     document.getElementById('hairChoice').onchange = (event) => {
         var inputText = event.target.value;
         if (inputText === 'Floof') {
             document.getElementById('HairLayer').src = "resources/Trendypoof.png";
         } else if (inputText === "Wave") {
             document.getElementById('HairLayer').src = "resources/Trendywave.png";
         } else if (inputText === "Forelock") {
             document.getElementById('HairLayer').src = "resources/Trendyforelock.png";
         } else if (inputText === "Mohawk") {
             document.getElementById('HairLayer').src = "resources/Trendymohawk.png";
         } else if (inputText === "Mane") {
             document.getElementById('HairLayer').src = "resources/Trendymane.png";
         }   
     }
     
     document.getElementById('TailChoice').onchange = (event) => {
         var inputText = event.target.value;
         if (inputText === 'Dragon') {
             document.getElementById('TailLayer').src = "resources/Trendydragon.png";
         } else if (inputText === "Long") {
             document.getElementById('TailLayer').src = "resources/Trendylong.png";
         } else if (inputText === "Nub") {
             document.getElementById('TailLayer').src = "resources/Trendynub.png";
         } else if (inputText === "Pom") {
             document.getElementById('TailLayer').src = "resources/Trendypom.png";
         }  
     }
    
    </script>

</body>

</html>
