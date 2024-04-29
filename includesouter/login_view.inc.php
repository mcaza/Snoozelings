<?php

declare(strict_types=1);

function checkLoginErrors() {
    if (isset($_SESSION['errors_login'])) {
        $errors = $_SESSION['errors_login'];
        
        echo "<br>";
        
        foreach ($errors as $error) {
            echo '<p class="form-error">' . $error . '</p>';
        }
        
        unset($_SESSION['errors_login']);
    } /* elseif (isset($_GET["signup"]) && $_GET["signup"] === "success") {
        echo "<br>";
        echo '<p class="form-success">Signup Success!</p>';
    } */
}

function outputUsername() {
    if (isset($_SESSION["user_id"])) {
        echo "You are logged in as " . $_SESSION["user_username"];
    } else {
        echo "You are not logged in";
    }
}