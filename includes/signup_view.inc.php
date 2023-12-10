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
    echo "<label for='username'  class='form'>Username:</label><br>";
        if (isset($_SESSION["signupData"]["username"]) && !isset($_SESSION["errors_signup"]["username_taken"])) {
            echo '<input class="input" type="text" name="username" placeholder="Username" value="' . $_SESSION["signupData"]["username"] . '"><br>';
        } else {
            echo '<input class="input" type="text" name="username" placeholder="Username"><br>';
        }
    echo "<label for='pwd'  class='form'>Password:</label><br>";
    echo '<input class="input" type="password" name="pwd" placeholder="Password"><br>';
    echo "<label for='pwd2'  class='form'>Confirm Password:</label><br>";
    echo '<input class="input" type="password" name="pwd2" placeholder="Password"><br>';
    echo "<label for='email'  class='form'>Email:</label><br>";
    if (isset($_SESSION["signupData"]["email"]) && !isset($_SESSION["errors_signup"]["email_registered"]) && !isset($_SESSION["errors_signup"]["invalid_email"])) {
            echo '<input  class="input"type="text" name="email" placeholder="Email" value="' . $_SESSION["signupData"]["email"] . '"><br>';
        } else {
            echo '<input  class="input"type="text" name="email" placeholder="Email"><br>';
        }
    echo "<label for='birthday'  class='form'>Date of Birth:</label><br>";
    if (isset($_SESSION["signupData"]["birthday"])) {
        echo '<input  class="input"type="date" id="birthday" name="birthday" value="' . $_SESSION["signupData"]["birthday"] . '"><br>';
    } else {
        echo '<input  class="input"type="date" id="birthday" name="birthday"><br>';
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
    echo '<div class="newsletter"><h4>Newsletter</h4><input type="checkbox" class="checkBox" name="newsletter">';
    echo '<label  class="conditions" for="newsletter">I would like to subscribe to the email newsletter.<br> It may contain snoozelings merchandise, sneak peeks, progress pictures, and general news.<br><strong>The newsletter is optional to all players.</strong><label></div><br>';
    
    unset($_SESSION['signupData']);
     
}
