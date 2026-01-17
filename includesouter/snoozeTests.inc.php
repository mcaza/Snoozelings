<?php

require_once 'imageFunction.inc.php';

$userId = $_COOKIE['user_id'];

//Get Pet Info For Testing
if (isset($_GET['id'])) {
    $num = $_GET['id'];
} else {
    $num = 1;
}

resetImage($num, $pdo);

$ts = rand(1111111111,9999999999);

//Display Image
echo '<img src="snoozeImages/' . $num . '.png?timestamp=' . $ts . '" style="width:400px;height:auto;">';
































