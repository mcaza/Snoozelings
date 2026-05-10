<?php

require_once 'dbh-inc.php';

//Mark Mail as Sent
$one = 1;
$zero = 0;
$two = 2;
$query = 'UPDATE mail SET sent = :one WHERE sent = :zero';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":zero", $zero);
$stmt->bindParam(":one", $one);
$stmt->execute();

//Mark Blueprints as delivered
$query = 'UPDATE breedings SET status = :one WHERE status = :zero';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":zero", $zero);
$stmt->bindParam(":one", $one);
$stmt->execute();

//Mark Deliveries
$query = 'UPDATE breedings SET status = :one WHERE status = :zero';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":zero", $one);
$stmt->bindParam(":one", $two);
$stmt->execute();