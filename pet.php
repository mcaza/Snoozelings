<?php
require_once '../includes/config_session.inc.php';
require_once '../includes/dbh-inc.php';
require_once '../includes/verifyCheck.inc.php'; 
require_once '../includes/verifySinglePet.inc.php'; 


$id = $_GET['id'];

//Pet Name
$query = 'SELECT name FROM snoozelings WHERE id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$result['name']?></title>
    <link rel="stylesheet" href="styles.css">
    <?php require_once '../includes/favicon.inc.php'; ?>
</head>

<body>
    <!-- Dark Top Bar, Snoozeling Text Logo, and Social Media Icons */ -->
    <div class="nav-container">
        <div id="logo">
            <a href="index">Snoozelings</a>
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
            <?php 
            //User Navigation
            echo '<div id="onlyOne" class="leftRightButtons">';
            if ($id > 1) {
                echo '<a id="leftArrow" href="pet?ID=' . ($id - 1) . '"><<</a>';
            }
            echo '<a href="pet?ID=' . ($id + 1) . '">>></a>';
            echo '</div>'; ?>
            <?php require_once '../includes/petPageButtons.inc.php'; ?>
            <div class="petrow rowone">
                <div class="petinfo-container">
                    <?php require_once '../includes/petTitle.inc.php'; ?>
                    <div class="trophies info">
                        <h4>Trophies</h4>
                    </div>
                </div>
                <div class="art-container">
                    <?php require_once '../includes/largePet.inc.php'; ?>
                </div>
            </div>
            <hr>
            <div class="petrow rowtwo">
                <div class="physicalInfo info">
                    <h4>Plushie Build</h4>
                    <?php require_once '../includes/plushieBuild.inc.php'; ?>
                </div>
                <div class="itemsBox">
                    <div class="itemsapplied info">
                        <h4>Applied Trinkets</h4>
                    </div>
                    <div class="apparel info">
                        <h4>Snooze Clothes</h4>
                        <p class="testinfo" id="clothes"></p>
                    </div>
                </div>
            </div></div>
            <hr>
            <div id="bottomSpace">

            </div>
        </div>
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
    //Profile / Snoozeling / Collection Fix When Only Right Arrow
var leftArrow = document.getElementById('leftArrow');
if (!leftArrow) {
    document.getElementById('onlyOne').style.justifyContent = 'flex-end';
}
    </script>

</body>

</html>
