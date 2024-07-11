<?php

$userId = $_SESSION['user_id'];
$id = $_GET['id'];

//Check User Staff Status
$query = 'SELECT staff FROM users WHERE id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$status = $stmt->fetch(PDO::FETCH_ASSOC);

//Check Ticket Access
$query = 'SELECT * FROM modtickets WHERE ticketid = :id LIMIT 1';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $id);
$stmt->execute();
$statustwo = $stmt->fetch(PDO::FETCH_ASSOC);

if ($statustwo['status'] == 1) {
    if ($status == "admin" || $userId == $statustwo['submitter']) {
        
    } else {
        header("Location: ../login");
        die();
    }
} else if ($status['staff'] == "admin" || $status['status'] == "mod" || $userId == $statustwo['submitter']) {
    
} else {
    header("Location: ../login");
    die();
}

