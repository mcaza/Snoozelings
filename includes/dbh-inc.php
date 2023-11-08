<?php

$dsn = 'mysql:host=localhost;dbname=dbhqxgfglc8n8i';
$dbusername = 'uqhyq8z2arsrm';
$dbpassword = 'gq2|4_45dfc`';

try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
