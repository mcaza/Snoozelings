<?php

$userId = $_SESSION['user_id'];
$code = $_GET['code'];

if ($_SESSION['reply']) {
    $reply = $_SESSION['reply'];
    unset($_SESSION['reply']);
}

//Grab Pet Info from Database
$query = "SELECT * FROM users WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

echo '<img class="wideImage" src="resources/wideBarPlaceholder.png">';

//Notification
if ($reply) {
    echo '<div class="returnBar" style="margin-top: 1rem;margin-bottom: 2rem;">';
    echo '<p>' . $reply . '</p>';
    echo '</div>';
}

echo '<h3 style="margin-bottom: 1rem;margin-top: 2rem;">Verify Your Email</h3>';
if ($result['emailVerified'] == 0) {
    echo '<form method="post" action="includes/verifyEmail.inc.php">';
echo '<label for="code" class="form">Enter Your Code:</label><br>';
echo '<input type="text" name="code" class="input" value=' . $code . '><br>';
echo '<button  class="fancyButton">Submit</button>';
echo '</form>';
echo '<hr>';
echo '<h3 style="margin-bottom: 1rem;">Didn\'t Get Your Code?</h3>';
echo '<h4>Please wait 5 minutes before requesting a new code</h4>';
echo '<h4 style="margin-bottom: 2rem;">Sending too many codes at once may cause issues recieving your code.</h4>';
echo '<form method="post" action="includes/newCode.inc.php">';
echo '<button  class="fancyButton">Send Code</button>';
echo '</form>';
} else {
    echo '<p>Your email has already been verified.</p>';
}
