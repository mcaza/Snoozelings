<?php

function verifyErrors() {
    if (isset($_SESSION['errors_verify'])) {
        $errors = $_SESSION['errors_verify'];
        
        echo "<br>";
            
        foreach ($errors as $error) {
            echo '<p class="form-error">' . $error . '</p>';
        }   
        
        unset($_SESSION['errors_signup']);
    }
}

