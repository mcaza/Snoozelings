<?php

$id = $_GET['id'];
$userId = $_COOKIE['user_id'];

//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="profile?id=' . $id . '"><<</a>';
echo '</div>';

//Get User Coin Count
$query = "SELECT * FROM users WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$coinCheck = $stmt->fetch(PDO::FETCH_ASSOC);

//Send Message Form
echo '<form method="post" action="includes/sendmail.inc.php">';
echo '<label class="form" for="title">Title:</label><br>';
echo '<input class="input" type="text" name="title" required><br>';
echo '<label class="form" for="reply">Message:</label><br>';
echo '<textarea name="reply" cols="72" class="input" style="height: 20rem;"></textarea><br>';
echo '<input type="hidden" name="to" value="' . $id . '">';
if(intval($coinCheck['coinCount']) > 1) {
    echo '<label class="form" for="speedSend">Would you like to spend 2 Snooze Coins to send using Express Post?</label><br>';
    echo '<select  class="input" name="speedSend"><br>';
    echo '<option value="0">Nope. It can wait until the next Mail Delivery.</option>';
    echo '<option value="1">Express Post for 2 Snooze Coins Please.</option>';
    echo '</select><br>';
}
echo '<button  class="fancyButton">Send Message</button>';
echo '</form>';