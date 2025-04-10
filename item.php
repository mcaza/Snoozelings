<?php
require_once '../includes/dbh-inc.php';
require_once '../includes/config_session.inc.php';
require_once '../includes/logincheck.inc.php';
require_once '../includes/verifyCheck.inc.php'; 
require_once '../includes/verifySinglePet.inc.php'; 

$id = $_GET['id'];

//Get Item Name
    $query = "SELECT * FROM itemList WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $name = $stmt->fetch(PDO::FETCH_ASSOC);
    $itemName = $name['display'];
    $imageName = $name['name'];

//Get Dyes
$dyelist = [];
for ($i = 0; $i < $count; $i++) {
    foreach ($results as $dye) {
        if ($dye['dye']) {
            array_push($dyelist, $dye['dye']);
        }
    }
}

$dyefix = array_unique($dyelist);


?>

<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $name['display'] ?></title>
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
        <div class="main-container"><div class="bottomPush">
            <?php require_once '../includes/itemPage.inc.php' ?>
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
     document.getElementById('color').onchange = (event) => {
         var inputText = event.target.value;
         var text1 = "items/";
         var text2 = ".png";
         var item = "<?php echo $imageName; ?>";
         if (inputText == "Basic" || inputText == "") {
            var final = text1 + item + text2;
         } else {
            var final = text1 + item + inputText + text2;

         }
         

             document.getElementById('itemicon').src = final;
     }
     

    
    </script>
    <script>
    
     document.getElementById('wish').onchange = (event) => {
         var inputText = event.target.value;
         if (inputText == "item") {
             document.getElementById("item").style.display = "flex";
             document.getElementById("colorPet").style.display = "none";
             document.getElementById("marking").style.display = "none";
         } else if (inputText == "color") {
             document.getElementById("item").style.display = "none";
             document.getElementById("colorPet").style.display = "flex";
             document.getElementById("marking").style.display = "none";
         } else if (inputText == "marking") {
             document.getElementById("item").style.display = "none";
             document.getElementById("colorPet").style.display = "none";
             document.getElementById("marking").style.display = "flex";
         }
     }
    </script>

</body>

</html>
