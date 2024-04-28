<?php

//Get User ID & Mail ID
$id = $_GET['id'];
$userId = $_SESSION['user_id'];

//Get Mail Info
$query = "SELECT * FROM mail WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $id);
$stmt->execute();
$letter = $stmt->fetch(PDO::FETCH_ASSOC);

//Get Sender Username
$query = 'SELECT username, bonded FROM users WHERE id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $letter['sender']);
$stmt->execute();
$sender = $stmt->fetch(PDO::FETCH_ASSOC);

//Mark Mail as Opened
if ($letter['opened'] === "0") {
    $one = 1;
    $query = "UPDATE mail SET opened = :one WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":one", $one);
    $stmt->execute();
}

//Back Arrow 
echo '<div class="leftRightButtons">';
echo '<a href="mailbox"><<</a>';
echo '</div>';

//Box with Message and Info
echo '<div class="letterDisplay">';
echo '<h3>' . htmlspecialchars($letter['title']) . '</h3>';
echo '<p style="font-size: 2rem;"><i>Sent By <a href="profile?id=' . $letter['sender'] . '">' . htmlspecialchars($sender['username']) . '</a></i></p>';
if ($letter['picture']) {
    echo '<img src="resources/' . $letter['picture'] . '.png" style="width: 200px;">';
} else {
    //Grab Bonded Info
    $query = "SELECT * FROM snoozelings WHERE id = :bonded";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":bonded", $sender['bonded']);
    $stmt->execute();
    $pet = $stmt->fetch(PDO::FETCH_ASSOC);
    displayPet($pet, "mailPet");
}
$num = intval($letter['sender']);
if ($num < 2 || $num > 3 && $num < 10) {
    echo '<p style="margin-top: 2rem; width: 70%; margin-right: auto; margin-left: auto;">' . nl2br($letter['message']) . '</p>';
} else {
    echo '<p style="margin-top: 2rem; width: 70%; margin-right: auto; margin-left: auto;">' . nl2br(htmlspecialchars($letter['message'])) . '</p>';
}
echo '</div>';

//Reply Box with Button
if ($num < 3 || $num > 9) {
echo '<hr>';
echo '<form method="POST" action="includes/sendReply.inc.php">';
echo '<label style="margin-top: 1rem;" for="reply" class="form">Send Reply</label><br>';
echo '<textarea name="reply" cols="72" class="input" style="height: 20rem;"></textarea><br>';
echo '<input type="hidden" name="to" value="' . $letter['sender'] . '">';
echo '<input type="hidden" name="title" value="' . $letter['title'] . '">';
echo '<button  class="fancyButton">Send Reply</button>';
echo '</form>';
}

//Delete Button
echo '<hr>';
echo '<div style="text-align: right;">';
echo '<form action="includes/deleteMail.inc.php" method="post">';
echo '<input name="button" value="' . $id . '" type="hidden">';
echo '<button  class="redButton">Delete Letter</button>';
echo '</form>';
echo '</div>';
