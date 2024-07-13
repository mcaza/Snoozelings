<?php

$userId = $_SESSION['user_id'];

//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="requests"><<</a>';
echo '</div>';

//Get User Info
$query = "SELECT * FROM users WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

//Get Total Requests
$query = "SELECT * FROM requests WHERE user_id = :id AND fulfilled = 0 AND expired = 0";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$count = count($results);

//Title
echo '<h3>Submit a Request</h3><br>';

//Check if Requests are Maxed
$requests = intval($result['requests']);
if ($requests > 1) {
    echo '<p>You have already submitted the max number of requests today.</p>';
} else if ($count > 5) {
    echo '<p>You have already submitted the max number of requests possible.</p>';
} else {
    //Show Request Form
    echo '<form method="post" action="includes/sendRequest.inc.php">';
    
    echo '<br><label for="item"  class="form">Select Item:</label><br>';
    echo '<select name="item" id="item">';
    echo '<option value="" default selected></option>';
    
    //Cycle Through Requestable Items
    $query = "SELECT * FROM itemList WHERE canRequest = 1 ORDER BY display";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($items as $item) {
        echo '<option value="' . $item['name'] . '">' . $item['display'] . "</option>";
    }
    
    //End Select & Form
    echo '</select><br><br>';
    echo "<button class='fancyButton'>Submit Request</button>";
    echo '</form>';
}

echo '<hr>';

//List Requests Posted (Open)
echo '<table style="width:80%">';
echo '<tr><th>Open Requests</th></tr>';

foreach ($results as $row) {
    echo '<tr><td style="padding:10px;" class="requesthover"><a href="/request?id=' . $row['id'] . '" style="display: block; width: 100%; height: 100%;">Request #' . $row['id'] . ' - ' . $row['displayname'] . '</a></td></tr>';
}

    
echo '</table>';


//List Requests Posted (Closed) (Add in Future)