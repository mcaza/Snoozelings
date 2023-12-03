<?php
//Get Values
$userId = $_SESSION['user_id'];
$id = $_GET['id'];

//Get Pet EXP
$query = 'SELECT * FROM snoozelings WHERE id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $id);
$stmt->execute();
$pet = $stmt->fetch(PDO::FETCH_ASSOC);

//Get Job Levels
$exp = $pet['farmEXP'];
    if ($exp < 50) {
        $farmname = "   Level 1 Farmer";
    } elseif ($exp < 150) {
        $farmname = "   Level 2 Farmer";
    } elseif ($exp < 325) {
        $farmname = "   Level 3 Farmer";
    } elseif ($exp < 600) {
        $farmname = "   Level 4 Farmer";
    } elseif ($exp < 1000) {
        $farmname = "   Level 5 Farmer";
    } else {
        $farmname = "   Crop Whisperer";
    }

$exp = $pet['exploreEXP'];
    if ($exp < 50) {
        $explorename = "   Level 1 Explorer";
    } elseif ($exp < 150) {
        $explorename = "   Level 2 Explorer";
    } elseif ($exp < 325) {
        $explorename = "   Level 3 Explorer";
    } elseif ($exp < 600) {
        $explorename = "   Level 4 Explorer";
    } elseif ($exp < 1000) {
        $explorename = "   Level 5 Explorer";
    } else {
        $explorename = "   Grand Adventurer";
    }

$exp = $pet['craftEXP'];
    if ($exp < 50) {
        $craftname = "   Level 1 Crafter";
    } elseif ($exp < 150) {
        $craftname = "   Level 2 Crafter";
    } elseif ($exp < 325) {
        $craftname = "   Level 3 Crafter";
    } elseif ($exp < 600) {
        $craftname = "   Level 4 Crafter";
    } elseif ($exp < 1000) {
        $craftname = "   Level 5 Crafter";
    } else {
        $craftname =    "Hooked on Crafts";
    }

//Back Arrow 
echo '<div class="leftRightButtons">';
echo '<a href="pet?id=' . $id . '"><<</a>';
echo '</div>';

//Title
echo '<h3 style="margin-bottom: 2rem;">Job Selection Page</h3>';

//Form
echo '<form method="POST" action="includes/changeJob.inc.php">';

//Jack of All Trades
echo '<input type="radio" id="jack" value="jack" name="job"><label for="jack" class="jobtitle">   Jack of All Trades</label><br>';
echo '<p style="margin-bottom: 2.5rem;">Can Perform all Jobs, but Earns No Experience Points</p>';

//Farmer Job
$percent = ceil($pet['farmEXP'] / 10);
if ($percent > 5) {
    $input = $percent . '%';
}
echo '<input type="radio" id="Farmer" value="Farmer" name="job" required><label for="Farmer" class="jobtitle">' . $farmname . '</label><br>';
echo '<p>Higher Levels Makes Crops Grow Faster</p>';
//Calculate Values for Each Job. Display Radio Button then Job
echo '<div class="progressbar">';
echo '<div class="innerbar" style="width:' . $percent . '%;">' . $input . '</div>';
echo '</div>';

//Explorer Job
$percent = ceil($pet['exploreEXP'] / 10);
if ($percent > 5) {
    $input = $percent . '%';
}
echo '<input type="radio" id="Explorer" value="Explorer" name="job"><label for="Explorer" class="jobtitle">' . $explorename . '</label><br>';
echo '<p>Higher Level Gives Better Chances to find Multiple Items</p>';
//Calculate Values for Each Job. Display Radio Button then Job
echo '<div class="progressbar">';
echo '<div class="innerbar" style="width:' . $percent . '%;">' . $input . '</div>';
echo '</div>';

//Crafter Job
$percent = ceil($pet['craftEXP'] / 10);
if ($percent > 5) {
    $input = $percent . '%';
}
echo '<input type="radio" id="Crafter" value="Crafter" name="job"><label for="Crafter" class="jobtitle">' . $craftname . '</label><br>';
echo '<p>Higher Level Reduces Crafting Time</p>';
//Calculate Values for Each Job. Display Radio Button then Job
echo '<div class="progressbar">';
echo '<div class="innerbar" style="width:' . $percent . '%;">' . $input . '</div>';
echo '</div>';

//Hidden Pet Value
echo '<input type="hidden" name="id" value="' . $id . '">';

//Enter Button
echo '<div><button class="fancyButton">Change Job</button></div>';
echo '</form>';