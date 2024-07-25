<?php

$userId = $_SESSION['user_id'];

//Get Reply
if ($_SESSION['reply']) {
    $reply = $_SESSION['reply'];
    unset($_SESSION['reply']);
}

//Notification
if ($reply) {
    echo '<div class="returnBar" style="margin-top: 1rem;margin-bottom: 2rem;">';
    echo '<p>' . $reply . '</p>';
    echo '</div><br><br>';
}

//Title
echo '<h3>Moderator Mail</h3><br><br>';

//Get Admin Escalated Tickets
$admin = 1;
$query = 'SELECT * FROM modtickets WHERE status = :status ORDER BY ticketid';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":status", $admin);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Display Admin Escalated Tickets
echo '<h1>Admin Escalated</h1>';
echo '<table style="width: 80%">';
echo '<tr>';
echo '<th>Ticket #ID</th>';
echo '<th>Ticket Type</th>';
echo '<th width="70%">Moderator Notes</th>';
echo '</tr>';

//Display Results
$displayarray = [];
foreach ($results as $result) {
    if (!in_array($result['ticketid'], $displayarray)) {
        if ($result['waitingreply']) {
            $backgroundcolor = "#FFCCCB";
            echo '<tr style="background-color: #FFCCCB;">';
        } else {
            $backgroundcolor = "#D7EED7";
            echo '<tr style="background-color: #D7EED7;">';
        }

        if ($result['notes']) {
            $notes = result['notes'];
        } else {
            $notes = "<i>No Current Notes</i>";
        }
        echo "<td style='background-color:" . $backgroundcolor . "' ><a href='ticket?ticketid=" . $result['ticketid'] . "' style='display: block; width: 100%; height: 100%;'>" . $result['ticketid'] . "</a></td>";
        echo "<td style='background-color:" . $backgroundcolor . "' ><a href='ticket?ticketid=" . $result['ticketid'] . "' style='display: block; width: 100%; height: 100%;'>" . $result['topic'] . "</a></td>";
        echo "<td style='background-color:" . $backgroundcolor . "' ><a href='ticket?ticketid=" . $result['ticketid'] . "' style='display: block; width: 100%; height: 100%;'>" . $notes . "</a></td>";
        echo "</tr>";
    }
    array_push($displayarray, $result['ticketid']);
}
echo '</table>';

//Get All Other Tickets
$admin = null;
$query = 'SELECT * FROM modtickets WHERE status = 0 ORDER BY ticketid';
$stmt = $pdo->prepare($query);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Display Admin Escalated Tickets
echo '<h1>Moderator Tickets</h1>';
echo '<table style="width: 80%">';
echo '<tr>';
echo '<th>Ticket #ID</th>';
echo '<th>Ticket Type</th>';
echo '<th width="70%">Moderator Notes</th>';
echo '</tr>';

//Display Results
$displayarray = [];
foreach ($results as $result) {
    if (!in_array($result['ticketid'], $displayarray)) {
        if ($result['waitingreply']) {
            $backgroundcolor = "#FFCCCB";
            echo '<tr style="background-color: #FFCCCB;">';
        } else {
            $backgroundcolor = "#D7EED7";
            echo '<tr style="background-color: #D7EED7;">';
        }

        if ($result['notes']) {
            $notes = result['notes'];
        } else {
            $notes = "<i>No Current Notes</i>";
        }
        echo "<td style='background-color:" . $backgroundcolor . "' ><a href='ticket?ticketid=" . $result['ticketid'] . "' style='display: block; width: 100%; height: 100%;'>" . $result['ticketid'] . "</a></td>";
        echo "<td style='background-color:" . $backgroundcolor . "' ><a href='ticket?ticketid=" . $result['ticketid'] . "' style='display: block; width: 100%; height: 100%;'>" . $result['topic'] . "</a></td>";
        echo "<td style='background-color:" . $backgroundcolor . "' ><a href='ticket?ticketid=" . $result['ticketid'] . "' style='display: block; width: 100%; height: 100%;'>" . $notes . "</a></td>";
        echo "</tr>";
    }
    array_push($displayarray, $result['ticketid']);
}
echo '</table>';






