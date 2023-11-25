<?php
function ownerRedirect($pdo) {
//Get Pet ID and Owner ID
$id = $_GET['id'];
$userId = $_SESSION['user_id'];

//Check if they Match. If not, redirect
if ($userId === $id) {
    
} else {
    header("Location: ../profile?id=" . $id);
}
}

ownerRedirect($pdo);