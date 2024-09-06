<?php

$userId = $_SESSION['user_id'];

//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="penpals"><<</a>';
echo '</div>';

//Get User Info
$query = "SELECT * FROM users WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

//Get all Penpal Notes
$query = "SELECT * FROM penpalRequests WHERE user = :id AND closed = 0 AND expired = 0";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Title
echo '<h3>Submit a Note</h3><br>';

//Check if Requests are Maxed
$requests = intval($result['requests']);
if (intval($result['penpalRequests']) > 0) {
    echo '<p>You have already submitted the max number of requests today.</p>';
} else {
    //Show Request Form
    echo '<form method="post" action="includes/sendNote.inc.php">';
    
    //Select Difficulty
    echo '<br><label for="difficulty"  class="form">Select Emotional Difficulty:</label><br>';
    echo '<select class="input" name="difficulty" id="difficulty" required>';
    echo '<option value="" disabled="disabled"  selected="selected"></option>';
    echo '<option value="Easy">Easy</option>';
    echo '<option value="Moderate">Moderate</option>';
    echo '<option value="Stressful">Stressful</option>';
    echo '</select><br><br>';
    
    //Post
    echo '<label style="margin-top: 2rem;" for="post" class="form"><b>Type Your Note:</b></label><br>';
    echo '<textarea name="post" cols="72" class="input" style="height: 20rem;" required></textarea><br>';
    
    //End Select & Form
    
    echo "<button class='fancyButton'>Submit Note</button>";
    echo '</form>';
}

echo '<hr>';

//List Requests Posted (Open)
echo '<table style="width:80%">';
echo '<tr><th>Open Requests</th></tr>';

foreach ($results as $row) {
    echo '<tr><td style="padding:10px;" class="requesthover"><a href="/penpalrequest?id=' . $row['id'] . '" style="display: block; width: 100%; height: 100%;">Request #' . $row['id'] . '</a></td></tr>';
}

    
echo '</table>';

//Penpal Mail Setting
echo '<form action="includes/penpalSetting.inc.php" method="post">';
echo '<hr>';
echo '<label for="penpal" class="form">Penpal Intensity:</label><br>';
switch ($result['penpal']) {
    case "Easy":
        $easy = "selected";
        break;
    case "Moderate":
        $moderate = "selected";
        break;
    case "Stressful":
        $stressful = "selected";
        break;
}
echo '<select class="input" name="penpal" id="penpal">';
echo '<option value="Easy"' . $easy . '>Easy</option>';
echo '<option value="Moderate"' . $moderate . '>Moderate</option>';
echo '<option value="Stressful"' . $stressful . '>Stressful</option>';
echo '</select>';
$easy = "";
$moderate = "";
$stressful = "";

//Breeding Status Javascript
if ($result['penpal'] === "Easy") {
    echo '<div id="penpalInfoDiv"><p id="penpalInfo" style="margin-top: 0" >Penpal requests that are fun, easy going, non triggering, etc.</p></div>';
} elseif ($result['penpal'] === "Moderate") {
    echo '<div id="penpalInfoDiv"><p id="penpalInfo" style="margin-top: 0" >Penpal requests may contain pg-13 fandom conent, roleplay requests, harder topics, etc.</p></div>';
} else if ($result['penpal'] === "Stressful") {
    echo '<div id="penpalInfoDiv"><p id="penpalInfo" style="margin-top: 0" >Penpal requests may contain triggering topics such as arguments, loss, medical frustrations, etc.</p></div>';
} else {
    echo '<div id="penpalInfoDiv"><p id="penpalInfo" style="margin-top: 0" >Penpal requests that are fun, easy going, non triggering, etc.</p></div>';
}
//Submit Button
echo '<button  class="fancyButton">Update Setting</button>';
echo '</form>';
echo '<hr>';


//List Requests Posted (Closed) (Add in Future)