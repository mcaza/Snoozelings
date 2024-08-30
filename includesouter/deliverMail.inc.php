<?php

require_once 'dbh-inc.php';

//Mark Mail as Sent
$one = 1;
$zero = 0;
$query = 'UPDATE mail SET sent = :one WHERE sent = :zero';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":zero", $zero);
$stmt->bindParam(":one", $one);
$stmt->execute();
