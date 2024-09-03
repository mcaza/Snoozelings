<?php

declare(strict_types=1);

function checkSignupErrors() {
    if (isset($_SESSION['errors_signup'])) {
        $errors = $_SESSION['errors_signup'];
        
        echo "<br>";
        
        foreach ($errors as $error) {
            echo '<p class="form-error" style="color:#850000">' . $error . '</p><br>';
        }
        
        unset($_SESSION['errors_signup']);
    } elseif (isset($_GET["signup"]) && $_GET["signup"] === "success") {
        echo "<br>";
        echo '<p class="form-success">Signup Success!</p>';
    }
}

function signupInputs() {
    $EACode = $_GET['code'];
    echo "<label for='code'  class='form'>Early Access Code:</label><br>";
    if ($EACode) {
        echo '<input class="input" type="text" name="code" placeholder="From Your Email" value="' . $EACode . '" required><br>';
    } else if (isset($_SESSION["signupData"]["code"]) && !isset($_SESSION["errors_signup"]["code_not_found"]) && !isset($_SESSION["errors_signup"]["code_used"])) {
            echo '<input class="input" type="text" name="code" placeholder="From Your Email" value="' . $_SESSION["signupData"]["code"] . '" required><br>';
        } else {
            echo '<input class="input" type="text" name="code" placeholder="From Your Email" required><br>';
        }
    echo "<label for='username'  class='form'>Username:</label><br>";
        if (isset($_SESSION["signupData"]["username"]) && !isset($_SESSION["errors_signup"]["username_taken"])) {
            echo '<input class="input" type="text" name="username" placeholder="Username" value="' . $_SESSION["signupData"]["username"] . '" required><br>';
        } else {
            echo '<input class="input" type="text" name="username" placeholder="Username" required><br>';
        }
    echo "<label for='pwd'  class='form'>Password:</label><br>";
    echo '<input class="input" type="password" name="pwd" placeholder="Password" required><br>';
    echo "<label for='pwd2'  class='form'>Confirm Password:</label><br>";
    echo '<input class="input" type="password" name="pwd2" placeholder="Password" required><br>';
    echo "<label for='email'  class='form'>Email:</label><br>";
    if (isset($_SESSION["signupData"]["email"]) && !isset($_SESSION["errors_signup"]["email_registered"]) && !isset($_SESSION["errors_signup"]["invalid_email"])) {
            echo '<input  class="input"type="text" name="email" placeholder="Email" value="' . $_SESSION["signupData"]["email"] . '" required><br>';
        } else {
            echo '<input  class="input"type="text" name="email" placeholder="Email" required><br>';
        }
    echo "<label for='birthday'  class='form'>Date of Birth:</label><br>";
    if (isset($_SESSION["signupData"]["birthday"])) {
        echo '<input  class="input"type="date" id="birthday" name="birthday" value="' . $_SESSION["signupData"]["birthday"] . '" max="9999-12-31" required><br>';
    } else {
        echo '<input  class="input"type="date" id="birthday" name="birthday" max="9999-12-31" required><br>';
    }
    echo '<label for="pronouns"  class="form">Your Pronouns:</label><br>';
    echo '<select  class="input" name="pronouns"><br>';
    echo '<option value="Any">Any</option>';
    echo '<option value="He/Him">He/Him</option>';
    echo '<option value="She/Her">She/Her</option>';
    echo '<option value="They/Them">They/Them</option>';
    echo '<option value="She/Them">She/Them</option>';
    echo '<option value="He/Them">He/Them</option>';
    echo '<option value="She/Him">She/Him</option>';
    echo '</select><br>';
    echo '<input  type="checkbox" class="checkBox" name="terms" required>';
    echo '<label class="conditions" for="terms" >I agree to the <a href="terms" target="_blank">Terms and Conditions</a> and <a href="conduct" target="_blank">Code of Conduct</a><label><br>';
    
    unset($_SESSION['signupData']);
     
}
