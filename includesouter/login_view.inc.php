<?php

declare(strict_types=1);

function checkLoginErrors() {
    if (isset($_COOKIE['errors_login'])) {
        $errors = $_COOKIE['errors_login'];
        
        echo "<br>";
        
        foreach ($errors as $error) {
            echo '<p class="form-error">' . $error . '</p>';
        }
        setcookie("errors_login", "", time()-3600);
    } /* elseif (isset($_GET["signup"]) && $_GET["signup"] === "success") {
        echo "<br>";
        echo '<p class="form-success">Signup Success!</p>';
    } */
}

function outputUsername() {
    if (isset($_COOKIE["user_id"])) {
        echo "You are logged in as " . $_COOKIE["user_username"];
    } else {
        echo "You are not logged in";
    }
}