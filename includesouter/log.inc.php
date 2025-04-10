<?php

if ($_COOKIE['user_id']) {
    $userId = $_COOKIE['user_id'];
} else {
    header("Location: ../login");
    die();
}