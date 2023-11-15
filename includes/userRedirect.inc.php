<?php
function ownerRedirect($pdo) {
//Get Pet ID and Owner ID
$id = $_GET['ID'];
$userId = $_SESSION['user_id'];

//Check if they Match. If not, redirect
if ($userId === $id) {
    
} else {
    header("Location: ../profile?id=" . $id);
}
}

ownerRedirect($pdo);