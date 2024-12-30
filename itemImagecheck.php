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
    
                    $query = 'SELECT * FROM itemList';
                    $stmt = $pdo->prepare($query);
                    $stmt->execute();
                    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    echo '<div style="display:flex;flex-wrap:wrap;">';
                    foreach ($items as $item) {
                        echo '<div>';
                        echo '<img src="items/' . $item['name'] . '.png" title="' . $item['id'] . '">';
                        echo '<p><b>' . $item['display'] . '</b></p>';
                        echo '</div>';
                    }
                    echo '</div>';
            echo '<form action="/includes/giveItem.inc.php" method="post">';
            echo '<label for="userid">User Id:</label>';
            echo '<input type="number" id="userid" name="userid"><br>';
            echo '<label for="itemid">Item Id:</label>';
            echo '<input type="number" id="itemid" name="itemid"><br>';
            echo '<button class="fancyButton">Give Item</button>';
            echo '</form>';
            ?>
            
            <?php
            
            echo '<hr>';
            
            $query = 'SELECT * FROM snoozelings';
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $snoozelings = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $query = 'SELECT * FROM users ORDER BY id';
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo '<ul>';
            foreach ($users as $account) {
                $count = 0;
                foreach ($snoozelings as $pet) {
                    if ($account['id'] == $pet['owner_id']) {
                        $count++;
                    }
                }
                echo $count;
                echo $account['petBeds'];
                echo $account['username'] . '<br>';
            }
            
            echo '</ul>';
            
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
