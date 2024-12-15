<?php

require_once 'dbh-inc.php';

$now = new DateTime('now', new DateTimezone('UTC'));
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

$query = 'SELECT * FROM adopts WHERE available = :num';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":num", $one);
$stmt->execute();
$snoozelings = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($snoozelings as $pet) {
    $query = 'SELECT * FROM snoozelings WHERE id = :num';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":num", $pet['pet_id']);
    $stmt->execute();
    $check = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($check['owner_id'] == 0) {
        
    } else {
        $query = 'DELETE FROM adopts WHERE pet_id = :num';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":num", $pet['pet_id']);
        $stmt->execute();
        $check = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}