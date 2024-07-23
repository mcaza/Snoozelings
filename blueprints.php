<?php
require_once '../includes/config_session.inc.php';
require_once '../includes/dbh-inc.php';
require_once '../includes/logincheck.inc.php';
require_once '../includes/verifyCheck.inc.php'; 
require_once '../includes/verifySinglePet.inc.php'; 
require_once '../includes/blueprintCheck.inc.php';




?>

<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blueprint Selection</title>
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
            <?php require_once '../includes/blueprints.inc.php'; ?>
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
     <script>function changeColour(value)
{ 
    switch(value)
    {
        case '1':
            document.getElementById('section1').style.backgroundColor = "#EBE5F6";
            document.getElementById('section2').style.backgroundColor = "transparent";
            document.getElementById('section3').style.backgroundColor = "transparent";
            document.getElementById('section4').style.backgroundColor = "transparent";
            document.getElementById('section5').style.backgroundColor = "transparent";
            document.getElementById('section6').style.backgroundColor = "transparent";
            document.getElementById('section7').style.backgroundColor = "transparent";
            document.getElementById('section8').style.backgroundColor = "transparent";
            document.getElementById('section9').style.backgroundColor = "transparent";
            document.getElementById('section10').style.backgroundColor = "transparent";
        break;
        case '2':
            document.getElementById('section1').style.backgroundColor = "transparent";
            document.getElementById('section2').style.backgroundColor = "#EBE5F6";
            document.getElementById('section3').style.backgroundColor = "transparent";
            document.getElementById('section4').style.backgroundColor = "transparent";
            document.getElementById('section5').style.backgroundColor = "transparent";
            document.getElementById('section6').style.backgroundColor = "transparent";
            document.getElementById('section7').style.backgroundColor = "transparent";
            document.getElementById('section8').style.backgroundColor = "transparent";
            document.getElementById('section9').style.backgroundColor = "transparent";
            document.getElementById('section10').style.backgroundColor = "transparent";
        break;
        case '3':
            document.getElementById('section1').style.backgroundColor = "transparent";
            document.getElementById('section2').style.backgroundColor = "transparent";
            document.getElementById('section3').style.backgroundColor = "#EBE5F6";
            document.getElementById('section4').style.backgroundColor = "transparent";
            document.getElementById('section5').style.backgroundColor = "transparent";
            document.getElementById('section6').style.backgroundColor = "transparent";
            document.getElementById('section7').style.backgroundColor = "transparent";
            document.getElementById('section8').style.backgroundColor = "transparent";
            document.getElementById('section9').style.backgroundColor = "transparent";
            document.getElementById('section10').style.backgroundColor = "transparent";
        break;
        case '4':
            document.getElementById('section1').style.backgroundColor = "transparent";
            document.getElementById('section2').style.backgroundColor = "transparent";
            document.getElementById('section3').style.backgroundColor = "transparent";
            document.getElementById('section4').style.backgroundColor = "#EBE5F6";
            document.getElementById('section5').style.backgroundColor = "transparent";
            document.getElementById('section6').style.backgroundColor = "transparent";
            document.getElementById('section7').style.backgroundColor = "transparent";
            document.getElementById('section8').style.backgroundColor = "transparent";
            document.getElementById('section9').style.backgroundColor = "transparent";
            document.getElementById('section10').style.backgroundColor = "transparent";
        break;
        case '5':
            document.getElementById('section1').style.backgroundColor = "transparent";
            document.getElementById('section2').style.backgroundColor = "transparent";
            document.getElementById('section3').style.backgroundColor = "transparent";
            document.getElementById('section4').style.backgroundColor = "transparent";
            document.getElementById('section5').style.backgroundColor = "#EBE5F6";
            document.getElementById('section6').style.backgroundColor = "transparent";
            document.getElementById('section7').style.backgroundColor = "transparent";
            document.getElementById('section8').style.backgroundColor = "transparent";
            document.getElementById('section9').style.backgroundColor = "transparent";
            document.getElementById('section10').style.backgroundColor = "transparent";
        break;
        case '6':
            document.getElementById('section1').style.backgroundColor = "transparent";
            document.getElementById('section2').style.backgroundColor = "transparent";
            document.getElementById('section3').style.backgroundColor = "transparent";
            document.getElementById('section4').style.backgroundColor = "transparent";
            document.getElementById('section5').style.backgroundColor = "transparent";
            document.getElementById('section6').style.backgroundColor = "#EBE5F6";
            document.getElementById('section7').style.backgroundColor = "transparent";
            document.getElementById('section8').style.backgroundColor = "transparent";
            document.getElementById('section9').style.backgroundColor = "transparent";
            document.getElementById('section10').style.backgroundColor = "transparent";
        break;
            case '7':
            document.getElementById('section1').style.backgroundColor = "transparent";
            document.getElementById('section2').style.backgroundColor = "transparent";
            document.getElementById('section3').style.backgroundColor = "transparent";
            document.getElementById('section4').style.backgroundColor = "transparent";
            document.getElementById('section5').style.backgroundColor = "transparent";
            document.getElementById('section6').style.backgroundColor = "transparent";
            document.getElementById('section7').style.backgroundColor = "#EBE5F6";
            document.getElementById('section8').style.backgroundColor = "transparent";
            document.getElementById('section9').style.backgroundColor = "transparent";
            document.getElementById('section10').style.backgroundColor = "transparent";
        break;
            case '8':
            document.getElementById('section1').style.backgroundColor = "transparent";
            document.getElementById('section2').style.backgroundColor = "transparent";
            document.getElementById('section3').style.backgroundColor = "transparent";
            document.getElementById('section4').style.backgroundColor = "transparent";
            document.getElementById('section5').style.backgroundColor = "transparent";
            document.getElementById('section6').style.backgroundColor = "transparent";
            document.getElementById('section7').style.backgroundColor = "transparent";
            document.getElementById('section8').style.backgroundColor = "#EBE5F6";
            document.getElementById('section9').style.backgroundColor = "transparent";
            document.getElementById('section10').style.backgroundColor = "transparent";
        break;
            case '9':
            document.getElementById('section1').style.backgroundColor = "transparent";
            document.getElementById('section2').style.backgroundColor = "transparent";
            document.getElementById('section3').style.backgroundColor = "transparent";
            document.getElementById('section4').style.backgroundColor = "transparent";
            document.getElementById('section5').style.backgroundColor = "transparent";
            document.getElementById('section6').style.backgroundColor = "transparent";
            document.getElementById('section7').style.backgroundColor = "transparent";
            document.getElementById('section8').style.backgroundColor = "transparent";
            document.getElementById('section9').style.backgroundColor = "#EBE5F6";
            document.getElementById('section10').style.backgroundColor = "transparent";
        break;
            case '10':
            document.getElementById('section1').style.backgroundColor = "transparent";
            document.getElementById('section2').style.backgroundColor = "transparent";
            document.getElementById('section3').style.backgroundColor = "transparent";
            document.getElementById('section4').style.backgroundColor = "transparent";
            document.getElementById('section5').style.backgroundColor = "transparent";
            document.getElementById('section6').style.backgroundColor = "transparent";
            document.getElementById('section7').style.backgroundColor = "transparent";
            document.getElementById('section8').style.backgroundColor = "transparent";
            document.getElementById('section9').style.backgroundColor = "transparent";
            document.getElementById('section10').style.backgroundColor = "#EBE5F6";
        break;
    }
    
}</script>


</body>

</html>
