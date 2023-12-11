<?php

require_once 'dbh-inc.php';

$now = new DateTime(null, new DateTimezone('UTC'));
$result = $now->format('Y-m-d H:i:s');
$num = 0;
$one = 1;

$query = 'SELECT * FROM adopts WHERE available = :num';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":num", $num);
$stmt->execute();
$snoozelings = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($snoozelings as $pet) {
    if ($result > $pet['datetime']) {
        $query = 'UPDATE adopts SET available = :one WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":one", $one);
        $stmt->bindParam(":id", $pet['id']);
        $stmt->execute();
    }
}
