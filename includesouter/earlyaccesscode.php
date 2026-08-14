<?php

$userId = $_COOKIE['user_id'];
$hide = $_GET['hide'];

//Replies
$query = "SELECT * FROM replies WHERE user_id = :id;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$reply = $stmt->fetch(PDO::FETCH_ASSOC);

//Replies
$query = "SELECT * FROM itemList WHERE merch = 1 ORDER BY name";
$stmt = $pdo->prepare($query);
$stmt->execute();
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Notification
if ($reply) {
    echo '<div class="returnBar" style="margin-top: 1rem;margin-bottom:2rem;">';
    echo '<p>' . $reply['message'] . '</p>';
    echo '</div>';
    $query = "DELETE FROM replies WHERE user_id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
}

//Form
echo '<h3 style="margin-bottom:2rem">Secret Early Access Form</h3>';
echo '<form action="includes/earlyaccess.inc.php" method="POST">';
echo '<label class="form" for="email">Email:</label><br>';
echo '<input type="email" name="email" class="input" required><br>';
if ($hide) {
    
} else {
    echo '<label class="form" for="number">ID:</label><br>';
    echo '<input type="number" name="number" class="input"><br>';
}
echo '<button  class="fancyButton">Submit</button>';
echo '</form>';

echo '<hr>';

echo '<h3 style="margin-bottom:2rem">Send Item Code Form</h3>';
echo '<form action="includes/sendItemCode.inc.php" method="POST">';
echo '<label class="form" for="email">Email:</label><br>';
echo '<input type="email" name="email" class="input"><br>';
echo '<label class="form" for="item">Item:</label><br>';
echo '<select  class="input" name="item" id="item" required><br>';
echo '<option value="" disabled="disabled"  selected="selected"></option>';
foreach ($items as $item) {
    echo '<option value="' . $item['name'] . '">' . $item['display'] . '</option>';
}
echo '</select><br>';
echo '<button  class="fancyButton">Submit</button>';
echo '</form>';