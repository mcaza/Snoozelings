<?php

declare(strict_types=1);

function checkSignupErrors() {
    if (isset($_SESSION['errors_signup'])) {
        $errors = $_SESSION['errors_signup'];
        
        echo "<br>";
        
        foreach ($errors as $error) {
            echo '<p class="form-error">' . $error . '</p>';
        }
        
        unset($_SESSION['errors_signup']);
    } elseif (isset($_GET["signup"]) && $_GET["signup"] === "success") {
        echo "<br>";
        echo '<p class="form-success">Signup Success!</p>';
    }
}

function signupInputs() {
        if (isset($_SESSION["signupData"]["username"]) && !isset($_SESSION["errors_signup"]["username_taken"])) {
            echo '<input type="text" name="username" placeholder="Username" value="' . $_SESSION["signupData"]["username"] . '"><br>';
        } else {
            echo '<input type="text" name="username" placeholder="Username"><br>';
        }
    
    echo '<input type="password" name="pwd" placeholder="Password"><br>';
    
    if (isset($_SESSION["signupData"]["email"]) && !isset($_SESSION["errors_signup"]["email_registered"]) && !isset($_SESSION["errors_signup"]["invalid_email"])) {
            echo '<input type="text" name="email" placeholder="Email" value="' . $_SESSION["signupData"]["email"] . '"><br>';
        } else {
            echo '<input type="text" name="email" placeholder="Email"><br>';
        }
    if (isset($_SESSION["signupData"]["birthday"])) {
        echo '<input type="date" id="birthday" name="birthday" value="' . $_SESSION["signupData"]["birthday"] . '"><br>';
    } else {
        echo '<input type="date" id="birthday" name="birthday"><br>';
    }
    unset($_SESSION['signupData']);
     
}
