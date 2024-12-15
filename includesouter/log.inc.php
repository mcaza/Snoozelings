<?php

if ($_SESSION['user_id']) {
    $userId = $_SESSION['user_id'];
} else {
    header("Location: ../login");
    die();
}