<?php

$userId = $_COOKIE['user_id'];
$id = $_GET['id'];

//Get Request Information
$query = "SELECT * FROM requests WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $id);
$stmt->execute();
$request = $stmt->fetch(PDO::FETCH_ASSOC);

//Back to Pack Arrows
echo '<div class="leftRightButtons">';
if ($request['user_id'] == $userId) {
    echo '<a href="newRequest"><<</a>';
} else {
    echo '<a href="requests"><<</a>';
}
echo '</div>';

//Color Selection
$notesarray = ['#FDDFDF', '#FCF7DE', '#DEFDE0', '#DEF3FD', '#F0Defd'];
$count = count($notesarray)-1;
$rand = rand(0, $count);

//Display Request
echo '<div class="itemPageRow" style="background-color:' . $notesarray[$rand] . ';margin-bottom:20px;">';
echo '<div class="itemPage requestText">';
echo '<h4 id="colortitle" style="margin-top:0;margin-bottom:20px;">Request #' . $id . '</h4>';
echo '<img id="itemicon" src="items/' . $request['name'] . '.png" style="width: 150px;">';
echo '<p style="margin-top:12px">1x ' . $request['displayname'] . '</p>';
echo '</div>';
echo '</div>';

//Check if User has Item
$query = "SELECT * FROM items WHERE list_id = :item AND user_id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":item", $request['item_id']);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$check = $stmt->fetchAll(PDO::FETCH_ASSOC);

$plaincheck = 0;
foreach ($check as $dyecheck) {
    if ($dyecheck['dye']) {
        
    } else {
        $plaincheck = 1;
    }
}

//Display if expired, closed, or fulfill button
if ($request['user_id'] == $userId) {
    $now = new DateTime($request['datetime'], new DateTimezone('UTC'));
    $newtime = $now->format('Y-m-d');
    echo '<h1>This request expires on ' . $newtime . '</h1>';
    echo '<form method="post" action="includes/removeRequest.inc.php" onsubmit="return confirm(\'Are you sure you want to cancel this request?\');">';
    echo '<input type="hidden" id="request" name="request" value="' . $_GET['id'] . '">';
    echo "<button class='redButton'>Cancel Request</button>";
    echo '</form>';
} else if ($request['expired'] == 1) {
    $now = new DateTime($request['datetime'], new DateTimezone('UTC'));
    $newtime = $now->format('Y-m-d');
    
    echo '<h1>This request expired on ' . $newtime . '</h1>';
} else if ($request['fulfilled'] == 1) {
    echo '<h1>This request has already been fulfilled</h1>';
} else if ($check && $plaincheck) {
    echo '<form method="post" action="includes/fulfillrequest.inc.php" onsubmit="return confirm(\'This action will remove 1 ' . strtolower($request['displayname']) . ' from your backpack\');">';
    echo '<input type="hidden" id="request" name="request" value="' . $_GET['id'] . '">';
    echo '<button  class="fancyButton">Fulfill Request</button>';
    echo '</form>';
} else {
    echo '<h1>You do not have any ' . strtolower($request['displayname']) . '</h1>';
}