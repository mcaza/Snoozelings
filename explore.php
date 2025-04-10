<?php
require_once '../includes/dbh-inc.php';
require_once '../includes/config_session.inc.php';
require_once '../includes/logincheck.inc.php';
require_once '../includes/verifyCheck.inc.php'; 
require_once '../includes/verifySinglePet.inc.php'; 




?>

<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Go Exploring</title>
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


                <!-- To Do List -->
                <?php if(isset($_COOKIE['user_id'])) {
               echo '<div class="bar-container">
                    <h2>To Do</h2>
                    ';  require_once "../includes/notifications.inc.php"; 
                    echo '<br>
                </div>';
                } ?>

                <!-- Daily Stats -->
                <div class="bar-container">
                    
                    <?php require_once '../includes/dailyRecords.inc.php' ?>
                </div>
            </div>


        <!-- All Main Content -->
        <div class="main-container"><div>
            <?php require_once '../includes/explore.inc.php'; ?>
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
    <script>//Explore Change Banner
var exploreSelect = document.getElementById('exploreArea');
        var value = exploreSelect.value;
        if (value === "Beach") {
        document.getElementById('Beach').style.display = "block";
        document.getElementById('Forest').style.display = "none";
        document.getElementById('Farmland').style.display = "none";
    } else if (value === "Farmland") {
        document.getElementById('Beach').style.display = "none";
        document.getElementById('Forest').style.display = "none";
        document.getElementById('Farmland').style.display = "block";
    } else if (value === "Forest") {
        document.getElementById('Beach').style.display = "none";
        document.getElementById('Forest').style.display = "block";
        document.getElementById('Farmland').style.display = "none";
    } 
document.getElementById('exploreArea').addEventListener('change', function() {
  var value = exploreSelect.value;
     document.getElementById('exploreImage').src = "/resources/" + value + ".png";
   if (value === "Beach") {
        document.getElementById('Beach').style.display = "block";
        document.getElementById('Forest').style.display = "none";
        document.getElementById('Farmland').style.display = "none";
    } else if (value === "Farmland") {
        document.getElementById('Beach').style.display = "none";
        document.getElementById('Forest').style.display = "none";
        document.getElementById('Farmland').style.display = "block";
    } else if (value === "Forest") {
        document.getElementById('Beach').style.display = "none";
        document.getElementById('Forest').style.display = "block";
        document.getElementById('Farmland').style.display = "none";
    } 
});</script>
</body>

</html>
