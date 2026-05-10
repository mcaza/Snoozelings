<?php

$query = "SELECT * FROM snoozelings";
$stmt = $pdo->prepare($query);
$stmt->execute();
$snoozelings = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($snoozelings as $snooze) {
    echo '<img src="snoozeImages/' . $snooze['id'] . '.png?timestamp=' . $snooze['timestamp'] . '" style="width:200px">';
}