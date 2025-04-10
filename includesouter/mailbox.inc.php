<?php
//Get User Id
$userId = $_COOKIE['user_id'];
$one = 1;

//Replies
$query = "SELECT * FROM replies WHERE user_id = :id;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$reply = $stmt->fetch(PDO::FETCH_ASSOC);

//Get Mailbox Color
$query = 'SELECT mailbox FROM users WHERE id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$mailbox = $stmt->fetch(PDO::FETCH_ASSOC);

if ($mailbox['mailbox']) {
    $boxcolor = $mailbox['mailbox'];
} else {
    $boxcolor = "red";
}

//Get Page. Assign to 1 if no page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

//Amount Per Page
$perPage = 10;

//Positioning
$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

//Get Mail
$query = 'SELECT * FROM mail WHERE reciever = :id AND sent = :one ORDER BY id DESC LIMIT :start , :perPage';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->bindParam(':start', $start, PDO::PARAM_INT);
$stmt->bindParam(':perPage', $perPage, PDO::PARAM_INT);
$stmt->bindParam(":one", $one);
$stmt->execute();
$mail = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Get Mail Count
$query = 'SELECT * FROM mail WHERE reciever = :id AND sent = :one';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->bindParam(":one", $one);
$stmt->execute();
$amount = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total = count($amount);

//Pages Amount
$pages = ceil($total / $perPage);

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

//Display Mailbox
echo '<div class="mailbox" style="text-align: right;">';
echo '<img src="resources/mailbox' . $boxcolor . '.png" style="height: 100px;">';
echo '</div>';

//Display Mail
echo '<form method="POST" action="includes/deleteMail.inc.php">';
$count = 1;
foreach ($mail as $letter) {
    //Get Sender Username
    $query = 'SELECT username FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $letter['sender']);
    $stmt->execute();
    $sender = $stmt->fetch(PDO::FETCH_ASSOC);
    echo '<a href="mail?id=' . $letter['id'] . '" >';
    echo '<div class="mail">';
    if ($letter['penpalid']) {
        if ($letter['opened'] == "1") {
            echo '<img src="resources/penpalopenletter.png" style="width: 80px;height: 80px;">';
        } else {
            echo '<img src="resources/penpalclosedletter.png" style="width: 80px;height: 80px;">';
        }
    } else {
        if ($letter['opened'] == "1") {
            echo '<img src="resources/openletter.png" style="width: 80px;height: 80px;">';
        } else {
            echo '<img src="resources/closedletter.png" style="width: 80px;height: 80px;">';
        }
    }
    
    echo '<div class="mailInfo">';
    echo '<h4 style="margin-top: .5rem;">' . htmlspecialchars($letter['title']) . '</h4>';
    if ($letter['anon'] == 1) {
        $query = 'SELECT * FROM penpals WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $letter['penpalid']);
        $stmt->execute();
        $penpal = $stmt->fetch(PDO::FETCH_ASSOC);
        echo '<p>From Anonymous Penpal ' . $penpal['sign'] . '</p>';
    } else {
       echo '<p>From ' . htmlspecialchars($sender['username']) . '</p>';
    }
    
    echo '</div>';
    echo '<input type="checkbox" href="" name="' . $count . '" value="' . $letter['id'] . '" style="width: 30px; margin-right: 1rem;">';
    echo '</div>';
    echo '</a>';
    $count++;
}


if ($pages > 1) {
//Pagination
echo '<div class="pagination">';
for ($x = 1; $x <= $pages; $x++) {
    if ($page === $x) {
        $selected = "selected";
    } else {
        $selected = "";
    }
    echo '<a href="?page=' . $x . '" style="font-size: 2rem; margin: 1rem;" class="' . $selected . '">' . $x . '</a>';
}
echo '</div>';
}

echo '<div style="text-align:right;">';
echo '<button  class="redButton" >Delete Mail</button>';
echo '</form>';
echo '</div>';