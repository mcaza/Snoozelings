<?php

//Grab User ID
$userId = $_COOKIE['user_id'];

//Grab Pet Info from Database
$query = "SELECT * FROM users WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

//Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="editprofile?id=' . $userId . '"><<</a>';
echo '</div>';

//Title
echo '<h3 style="margin-bottom: .5rem;">Mail Settings</h3><br>';

echo '<p><i>Disabling Mail Will Still Allow Delivery of Prizes and Rewards</i></p><br>';

echo '<form action="includes/editMailSettings.inc.php" method="post">';

//Raffle Mail
switch ($result['raffleMail']) {
    case "0":
        $no = "selected";
        break;
    case "1":
        $yes = "selected";
        break;
}
echo '<label for="raffle" class="form">Allow Raffle Mail:</label><br>';
echo '<select class="input" name="raffle">';
echo '<option value="1"' . $yes . '>Yes</option>';
echo '<option value="0"' . $no . '>No</option>';
echo '</select><br>';
$yes = "";
$no = "";

//Adoption Mail
switch ($result['adoptionMail']) {
    case "0":
        $no = "selected";
        break;
    case "1":
        $yes = "selected";
        break;
}
echo '<label for="adoption" class="form">Allow Adoption Mail:</label><br>';
echo '<select class="input" name="adoption">';
echo '<option value="1"' . $yes . '>Yes</option>';
echo '<option value="0"' . $no . '>No</option>';
echo '</select><br>';
$yes = "";
$no = "";

//Inspiration Mail
switch ($result['inspirationMail']) {
    case "0":
        $no = "selected";
        break;
    case "1":
        $yes = "selected";
        break;
}
echo '<label for="inspiration" class="form">Allow Inspiration Mail:</label><br>';
echo '<select class="input" name="inspiration">';
echo '<option value="1"' . $yes . '>Yes</option>';
echo '<option value="0"' . $no . '>No</option>';
echo '</select><br>';
$yes = "";
$no = "";

//Allow Messages
echo '<label for="messages" class="form">Allow Messages:</label><br>';
switch ($result['blockMessages']) {
    case "1":
        $no = "selected";
        break;
    case "0":
        $yes = "selected";
        break;
    case "2":
        $friends = "selected";
        break;
}
echo '<select class="input" name="messages">';
echo '<option value="0"' . $yes . '>Yes</option>';
echo '<option value="1"' . $no . '>No</option>';
echo '<option value="2"' . $friends . '>Friends Only</option>';
echo '</select><br>';
$yes = "";
$no = "";
$friends = "";

//Mailbox Color
echo '<label for="mailbox" class="form">Change Mailbox Color:</label><br>';
echo '<select class="input" name="mailbox">';
echo '<option value=""></option>';
echo '<option value="blue">Blue</option>';
echo '<option value="cyan">Cyan</option>';
echo '<option value="orange">Orange</option>';
echo '<option value="purple">Purple</option>';
echo '<option value="red">Red</option>';
echo '</select><br>';

//Blank Field Warning
echo '<p><i>Any Blank Fields Will Not Be Changed</i></p>';

//Submit Button
echo '<button  class="fancyButton">Update Profile</button>';
echo '</form>';

echo '</form>';