<?php

require_once 'dbh-inc.php';

$ts = rand(1111111111,9999999999);
$id = 1;

$query = "UPDATE timestamp SET timestamp = :ts WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $id);
$stmt->bindParam(":ts", $ts);
$stmt->execute();