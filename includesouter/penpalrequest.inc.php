<?php

$userId = $_SESSION['user_id'];
$id = $_GET['id'];

//Get Penpal Information
$query = "SELECT * FROM penpalRequests WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $id);
$stmt->execute();
$request = $stmt->fetch(PDO::FETCH_ASSOC);

//Back to Pack Arrows
echo '<div class="leftRightButtons">';
if ($request['user_id'] == $userId) {
    echo '<a href="newRequest"><<</a>';
} else {
    echo '<a href="penpals"><<</a>';
}
echo '</div>';

//Title
echo '<h1>Penpal Request Number ' . $request['id'] . '</h1>';

//Display Post
if ($request['user'] == $userId) {
    echo '<p style="width:70%;margin-right:auto;margin-left:auto;">' . nl2br(htmlspecialchars($request['post'])) . '</p>';
    echo '<p style="text-align:center;margin-top:15px;"><b>You cannot reply to your own penpal request</b></p>';
} else if ($request['expired'] == 1) {
    echo '<p><b>This inquiry has expired.</b></p>';
} else {
    echo '<p style="width:70%;margin-right:auto;margin-left:auto;">' . nl2br(htmlspecialchars($request['post'])) . '</p>';
    echo '<p style="text-align:center;margin-top:15px;">~ Anonymous</p>';
    echo "<form method='POST' action='includes/replyPenpal.inc.php'>";
    echo '<hr>';
    echo '<label style="margin-top: 2rem;" for="post" class="form"><b>Send a Reply:</b></label><br>';
    echo '<textarea name="post" cols="72" class="input" style="height: 20rem;" required></textarea><br>';
    echo '<input type="hidden" id="request" name="request" value="' . $_GET['id'] . '">';
    echo '<button  class="fancyButton">Send Reply</button>';
    echo '</form>';
}
