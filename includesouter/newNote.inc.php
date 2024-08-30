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
    echo '<select class="input" name="difficulty" id="difficulty" required><br>';
    echo '<option value="" disabled="disabled"  selected="selected"></option>';
    echo '<option value="Easy">Easy</option>';
    echo '<option value="Moderate">Moderate</option>';
    echo '<option value="Stressful">Stressful</option>';
    echo '</select><br><br>';
    
    //Post
    echo '<label style="margin-top: 2rem;" for="post" class="form"><b>Send a Reply:</b></label><br>';
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


//List Requests Posted (Closed) (Add in Future)