<?php

$userId = $_SESSION['user_id'];

if (!$userId) {
    header("Location: ../login");
    die();
}