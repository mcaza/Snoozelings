<?php

function verifyErrors() {
    if (isset($_COOKIE['errors_verify'])) {
        $errors = $_COOKIE['errors_verify'];
        
        echo "<br>";
            
        foreach ($errors as $error) {
            echo '<p class="form-error">' . $error . '</p>';
        }   
        
        setcookie("errors_signup", "", time()-3600);
    }
}

