<?php
require_once '../includes/config_session.inc.php';
require_once '../includes/dbh-inc.php';
require_once '../includes/logincheck.inc.php';
require_once '../includes/adminCheck.inc.php';





?>

<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
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
                    
                    <?php require_once '../includes/dailyRecords.inc.php' ?>
                </div>
            </div>


        <!-- All Main Content -->
        <div class="main-container"><div  class="bottomPush">
            <?php
    
                    $query = 'SELECT * FROM users ORDER BY cropsHarvested DESC LIMIT 5';
                    $stmt = $pdo->prepare($query);
                    $stmt->execute();
                    $crops = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    $query = 'SELECT * FROM users ORDER BY itemsCrafted DESC LIMIT 5';
                    $stmt = $pdo->prepare($query);
                    $stmt->execute();
                    $crafts = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    $query = 'SELECT * FROM users ORDER BY explores DESC LIMIT 5';
                    $stmt = $pdo->prepare($query);
                    $stmt->execute();
                    $explores = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    $query = 'SELECT * FROM users ORDER BY requestsFilled DESC LIMIT 5';
                    $stmt = $pdo->prepare($query);
                    $stmt->execute();
                    $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    $query = 'SELECT * FROM users ORDER BY itemsBought DESC LIMIT 5';
                    $stmt = $pdo->prepare($query);
                    $stmt->execute();
                    $buys = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    echo '<h1 style="text-align:left">Crops Harvested</h1>';
                    echo '<ol style="text-align:left;font-size:15px;">';
                    foreach ($crops as $crop) {
                        echo '<li><a href="/profile?id='  . $user['id'] . '">' . $crop['username'] . '</a> - <i>' . $crop['cropsHarvested'] . ' Harvests</i></li>';
                    }
                    echo '</ol>';
                    
                    echo '<h1 style="text-align:left">Crafts Crafted</h1>';
                    echo '<ol style="text-align:left;font-size:15px;">';
                    foreach ($crafts as $craft) {
                        echo '<li><a href="/profile?id='  . $user['id'] . '">' . $craft['username'] . '</a> - <i>' . $craft['itemsCrafted'] . ' Crafts</i></li>';
                    }
                    echo '</ol>';
                    
                    echo '<h1 style="text-align:left">Explores Taken</h1>';
                    echo '<ol style="text-align:left;font-size:15px;">';
                    foreach ($explores as $explore) {
                        echo '<li><a href="/profile?id='  . $user['id'] . '">' . $explore['username'] . '</a> - <i>' . $explore['explores'] . ' Explores</i></li>';
                    }
                    echo '</ol>';
                    
                    echo '<h1 style="text-align:left">Requests Filled</h1>';
                    echo '<ol style="text-align:left;font-size:15px;">';
                    foreach ($requests as $request) {
                        echo '<li><a href="/profile?id='  . $user['id'] . '">' . $request['username'] . '</a> - <i>' . $request['requestsFilled'] . ' Requests</i></li>';
                    }
                    echo '</ol>';
                    
                    echo '<h1 style="text-align:left">Purchases Bought</h1>';
                    echo '<ol style="text-align:left;font-size:15px;">';
                    foreach ($buys as $buy) {
                        echo '<li><a href="/profile?id='  . $user['id'] . '">' . $buy['username'] . '</a> - <i>' . $buy['itemsBought'] . ' Purchases</i></li>';
                    }
                    echo '</ol>';
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