<?php
require_once '../includes/dbh-inc.php';
require_once '../includes/config_session.inc.php';
require_once '../includes/verifyCheck.inc.php'; 
require_once '../includes/verifySinglePet.inc.php'; 




?>

<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Snoozelings Maker</title>
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
        <div class="main-container"><?php require_once '../includes/news.inc.php'; ?><div  class="bottomPush">
            <?php require_once '../includes/designer.inc.php'; ?>
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
    
 document.getElementById('mainColor').onchange = (event) => {
     var inputText = event.target.value;
     document.getElementById('Primarydesigner').src = "Layers/Primary/" + inputText + ".png";
     document.getElementById('Mainlinesdesigner').src = "Layers/MainLines/" + inputText + ".png";
     document.getElementById('Facedesigner').src = "Layers/Faces/Happy/Lines/" + inputText + ".png";
     var type = document.getElementById('hairType').value;
        if (type === 'Floof') {
            document.getElementById('Hairdesigner').src = "Layers/Hair/Floof/" + inputText + ".png";
        }
     var type = document.getElementById('tailType').value;
        if (type === 'Dragon') {
            document.getElementById('TailTopdesigner').src = "Layers/Tail/Dragon/" + inputText + ".png";
        } else if (type === 'Mermaid') {
            document.getElementById('TailTopdesigner').src = "Layers/Tail/Mermaid/" + inputText + ".png";
        } else if (type === 'Lizard') {
            document.getElementById('TailTopdesigner').src = "Layers/Tail/Lizard/" + inputText + ".png";
        }
     var checkBox = document.getElementById("belly");
        if (checkBox.checked == true) {
            document.getElementById('Bellydesigner').src = "Layers/Markings/Belly/" + inputText + ".png";
        }
     var checkBox = document.getElementById("boots");
        if (checkBox.checked == true) {
            document.getElementById('Bootsdesigner').src = "Layers/Markings/Boots/" + inputText + ".png";
        }
     var checkBox = document.getElementById("spots");
        if (checkBox.checked == true) {
            document.getElementById('Spotsdesigner').src = "Layers/Markings/Spots/" + inputText + ".png";
        }
     var checkBox = document.getElementById("wings");
        if (checkBox.checked == true) {
            document.getElementById('TopWingdesigner').src = "Layers/Wings/Pegasus/Top/" + inputText + ".png";
            document.getElementById('BottomWingdesigner').src = "Layers/Wings/Pegasus/Bottom/" + inputText + ".png";
        }
     var checkBox = document.getElementById("sublimation");
        if (checkBox.checked == true) {
            document.getElementById('Sublimationdesigner').src = "Layers/Markings/Sublimation/" + inputText + ".png";
        }
     var checkBox = document.getElementById("cupid");
        if (checkBox.checked == true) {
            document.getElementById('Cupiddesigner').src = "Layers/Markings/Cupid/" + inputText + ".png";
        }
     var checkBox = document.getElementById("foxy");
        if (checkBox.checked == true) {
            document.getElementById('Foxydesigner').src = "Layers/Markings/Foxy/" + inputText + ".png";
        }
     var checkBox = document.getElementById("scales");
        if (checkBox.checked == true) {
            document.getElementById('Scalesdesigner').src = "Layers/Markings/Scales/" + inputText + ".png";
        }
 }
 
 document.getElementById('skinColor').onchange = (event) => {
     var inputText = event.target.value;
     document.getElementById('Eardesigner').src = "Layers/Ear/" + inputText + ".png";
     document.getElementById('Nosedesigner').src = "Layers/Noses/" + inputText + ".png";
 }
 
  document.getElementById('eyeColor').onchange = (event) => {
     var inputText = event.target.value;
     document.getElementById('Eyesdesigner').src = "Layers/Faces/Happy/Eyes/" + inputText + ".png";
 }
  
    document.getElementById('hairColor').onchange = (event) => {
     var inputText = event.target.value;
        var type = document.getElementById('hairType').value;
        if (type === 'Floof') {
            var mainColor = document.getElementById('mainColor').value;
            document.getElementById('Hairdesigner').src = "Layers/Hair/Floof/" + mainColor + ".png";
        } else {
            document.getElementById('Hairdesigner').src = "Layers/Hair/" + type + "/" + inputText + ".png";
        }
    }
    document.getElementById('hairType').onchange = (event) => {
     var inputText = event.target.value;
        var color = document.getElementById('hairColor').value;
        if (inputText === 'Floof') {
            var mainColor = document.getElementById('mainColor').value;
            document.getElementById('Hairdesigner').src = "Layers/Hair/Floof/" + mainColor + ".png";
        } else {
            document.getElementById('Hairdesigner').src = "Layers/Hair/" + inputText + "/" + color + ".png";
        }
 }
    
    document.getElementById('tailType').onchange = (event) => {
     var inputText = event.target.value;
        var color = document.getElementById('tailColor').value;
        if (inputText === 'Dragon') {
            var mainColor = document.getElementById('mainColor').value;
            document.getElementById('Taildesigner').src = "Layers/Tail/Dragon/End/" + color + ".png";
            document.getElementById('TailTopdesigner').src = "Layers/Tail/Dragon/" + mainColor + ".png";
        } else if (inputText === 'Mermaid') {
            var mainColor = document.getElementById('mainColor').value;
            document.getElementById('Taildesigner').src = "Layers/Tail/" + inputText + "/" + mainColor + ".png";
            document.getElementById('TailTopdesigner').src = "";
        } else if (inputText === 'Lizard') {
            var mainColor = document.getElementById('mainColor').value;
            document.getElementById('Taildesigner').src = "Layers/Tail/Lizard/Spikes/" + color + ".png";
            document.getElementById('TailTopdesigner').src = "Layers/Tail/Lizard/" + mainColor + ".png";
        } else {
            document.getElementById('Taildesigner').src = "Layers/Tail/" + inputText + "/" + color + ".png";
            document.getElementById('TailTopdesigner').src = "";
        }
 }
    
    document.getElementById('tailColor').onchange = (event) => {
     var inputText = event.target.value;
        var type = document.getElementById('tailType').value;
        if (type === 'Dragon') {
            var mainColor = document.getElementById('mainColor').value;
            document.getElementById('Taildesigner').src = "Layers/Tail/Dragon/End/" + inputText + ".png";
            document.getElementById('TailTopdesigner').src = "Layers/Tail/Dragon/" + mainColor + ".png";
        } else if (type === 'Mermaid') {
            var mainColor = document.getElementById('mainColor').value;
            document.getElementById('Taildesigner').src = "Layers/Tail/" + type + "/" + mainColor + ".png";
            document.getElementById('TailTopdesigner').src = "";
        } else if (type === 'Lizard') {
            var mainColor = document.getElementById('mainColor').value;
            document.getElementById('Taildesigner').src = "Layers/Tail/Lizard/Spikes/" + inputText + ".png";
            document.getElementById('TailTopdesigner').src = "Layers/Tail/Lizard/" + mainColor + ".png";
        } else {
            document.getElementById('Taildesigner').src = "Layers/Tail/" + type + "/" + inputText + ".png";
            document.getElementById('TailTopdesigner').src = "";
        }
 }
    
    document.getElementById('belly').onchange = (event) => {
        var mainColor = document.getElementById('mainColor').value;
        var checkBox = document.getElementById("belly");
        if (checkBox.checked == true) {
            document.getElementById('Bellydesigner').src = "Layers/Markings/Belly/" + mainColor + ".png";
        } else {
            document.getElementById('Bellydesigner').src = "";
        }
 }
    
    document.getElementById('boots').onchange = (event) => {
        var mainColor = document.getElementById('mainColor').value;
        var checkBox = document.getElementById("boots");
        if (checkBox.checked == true) {
            document.getElementById('Bootsdesigner').src = "Layers/Markings/Boots/" + mainColor + ".png";
        } else {
            document.getElementById('Bootsdesigner').src = "";
        }
 }
    
    document.getElementById('mothFluff').onchange = (event) => {
        
     var inputText = event.target.value;
        if (inputText == "NoFluff") {
            document.getElementById('TopMothdesigner').src = "";
            document.getElementById('BottomMothdesigner').src = "";
        } else {
            document.getElementById('TopMothdesigner').src = "Layers/Other/MothFluff/" + inputText + ".png";
            document.getElementById('BottomMothdesigner').src = "Layers/Other/MothFluff/Behind/" + inputText + ".png";
        }
     
 }
    
    document.getElementById('spots').onchange = (event) => {
        var mainColor = document.getElementById('mainColor').value;
        var checkBox = document.getElementById("spots");
        if (checkBox.checked == true) {
            document.getElementById('Spotsdesigner').src = "Layers/Markings/Spots/" + mainColor + ".png";
        } else {
            document.getElementById('Spotsdesigner').src = "";
        }
 }
    
    document.getElementById('cupid').onchange = (event) => {
        var mainColor = document.getElementById('mainColor').value;
        var checkBox = document.getElementById("cupid");
        if (checkBox.checked == true) {
            document.getElementById('Cupiddesigner').src = "Layers/Markings/Cupid/" + mainColor + ".png";
        } else {
            document.getElementById('Cupiddesigner').src = "";
        }
 }
    
    document.getElementById('sublimation').onchange = (event) => {
        var mainColor = document.getElementById('mainColor').value;
        var checkBox = document.getElementById("sublimation");
        if (checkBox.checked == true) {
            document.getElementById('Sublimationdesigner').src = "Layers/Markings/Sublimation/" + mainColor + ".png";
        } else {
            document.getElementById('Sublimationdesigner').src = "";
        }
 }
    
    document.getElementById('collie').onchange = (event) => {
        var checkBox = document.getElementById("collie");
        if (checkBox.checked == true) {
            document.getElementById('Colliedesigner').src = "Layers/Other/Collie.png";
        } else {
            document.getElementById('Colliedesigner').src = "";
        }
    }
    
    document.getElementById('foxy').onchange = (event) => {
        var mainColor = document.getElementById('mainColor').value;
        var checkBox = document.getElementById("foxy");
        if (checkBox.checked == true) {
            document.getElementById('Foxydesigner').src = "Layers/Markings/Foxy/" + mainColor + ".png";
        } else {
            document.getElementById('Foxydesigner').src = "";
        }
 }
    
    document.getElementById('scales').onchange = (event) => {
        var mainColor = document.getElementById('mainColor').value;
        var checkBox = document.getElementById("scales");
        if (checkBox.checked == true) {
            document.getElementById('Scalesdesigner').src = "Layers/Markings/Scales/" + mainColor + ".png";
        } else {
            document.getElementById('Scalesdesigner').src = "";
        }
 }
    
    document.getElementById('wings').onchange = (event) => {
        var mainColor = document.getElementById('mainColor').value;
        var checkBox = document.getElementById("wings");
        if (checkBox.checked == true) {
            document.getElementById('TopWingdesigner').src = "Layers/Wings/Pegasus/Top/" + mainColor + ".png";
            
            document.getElementById('BottomWingdesigner').src = "Layers/Wings/Pegasus/Bottom/" + mainColor + ".png";
        } else {
            document.getElementById('TopWingdesigner').src = "";
            document.getElementById('BottomWingdesigner').src = "";
        }
    }
        
        document.getElementById('eartip').onchange = (event) => {
        var checkBox = document.getElementById("eartip");
        if (checkBox.checked == true) {
            document.getElementById('Eartipdesigner').src = "Layers/Other/EarTip.png";
        } else {
            document.getElementById('Eartipdesigner').src = "";
        }
    }
        
        document.getElementById('skeleton').onchange = (event) => {
        var checkBox = document.getElementById("skeleton");
        if (checkBox.checked == true) {
            document.getElementById('Skeletondesigner').src = "Layers/Skeleton.png";
        } else {
            document.getElementById('Skeletondesigner').src = "";
        }
    }
        
        document.getElementById('bugwings').onchange = (event) => {
        var checkBox = document.getElementById("bugwings");
        if (checkBox.checked == true) {
            document.getElementById('Topbugdesigner').src = "Layers/Wings/BugWingTop.png";
            document.getElementById('Bottombugdesigner').src = "Layers/Wings/BugWingBottom.png";
        } else {
            document.getElementById('Topbugdesigner').src = "";
            document.getElementById('Bottombugdesigner').src = "";
        }
    }
        
        document.getElementById('tooth').onchange = (event) => {
        var checkBox = document.getElementById("tooth");
        if (checkBox.checked == true) {
            document.getElementById('Tinytoothdesigner').src = "Layers/Faces/Happy/TinyTooth.png";
        } else {
            document.getElementById('Tinytoothdesigner').src = "";
        }
    }
 
    
    </script>

</body>

</html>


