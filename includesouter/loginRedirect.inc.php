<?php

function verifySinglePet($pdo) {

//Check for Logged in 
if (isset($_SESSION["user_id"])) {
    
            header("Location:../index.php");
    }
}

verifySinglePet($pdo);