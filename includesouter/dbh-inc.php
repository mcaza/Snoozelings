<?php

$dsn = 'mysql:host=localhost;dbname=snoozeli_main';
$dbusername = 'snoozeli_admin';
$dbpassword = '@Alpaca303';

try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
