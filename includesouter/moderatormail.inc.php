<?php

if ($_SESSION['user_id']) {
    $userId = $_SESSION['user_id'];
}

if ($_SESSION['reply']) {
    $reply = $_SESSION['reply'];
    unset($_SESSION['reply']);
}

//Mailbox Form
echo '<h3 style="margin-bottom:1.5rem">Moderator Mailbox</h3>';
echo '<form method="post" action="includes/moderatorreport.inc.php">';

//Notification
if ($reply) {
    echo '<div class="returnBar" style="margin-top: 1rem;margin-bottom: 2rem;">';
    echo '<p>' . $reply . '</p>';
    echo '</div><br><br>';
}

//User ID (Input automatically if logged in)
if ($userId) {
     echo '<input type="hidden" id="userId" name="userId" value="' . $userId . '">';
} else {
    echo '<label for="userId"  class="form">Account Number:</label><br>';
    echo '<input type="number" id="userId" name="userId" min="1"><br><br>';
}

//Topic (Account Issues, Online Purchases, Merchandise, Rule Breaking, Bug Report, Other)
echo '<label for="topic"  class="form">Reason for Ticket:</label><br>';
echo '<select name="topic" id="topic">';
echo '<option value="" default selected>Select an Option</option>';
echo '<option value="Account">Account Issues</option>';
echo '<option value="Rules">Rule Breaking</option>';
echo '<option value="Purchase">Digitial Purchases</option>';
echo '<option value="Merch">Merchandise Order</option>';
echo '<option value="Bugs">Bug Report</option>';
echo '<option value="Other">Other</option>';
echo '</select><br><br>';

//Account Issues (Contact Email, Problem)
echo '<div id="accountdiv"  style="display:none">';
echo '<label for="email1"  class="form">Contact Email:</label><br>';
echo '<input type="email" id="emai1l" name="email1"><br><br>';
echo '<label for="information1"  class="form">Information:</label><br>';
echo '<textarea id="information1" name="information1" rows="12" cols="70"></textarea><br><br>';
if ($userId) {
     echo '<p>Since you are logged in, you will be contacted through moderator mailbox.</i></p>';
} else {
     echo '<p>Since you are not logged in, you will be contacted through email.</i></p>';

}
echo "<button class='fancyButton'>Submit Form</button>";
echo '</div>';

//Rule Breaking (Account Reporting, Information)
if ($userId) {
    echo '<div id="rulesdiv"  style="display:none">';
    echo '<label for="reportedaccount"  class="form">Account Number of Reported User:</label><br>';
    echo '<input type="number" id="reportedaccount" name="reportedaccount"><br><br>';
    echo '<label for="information2"  class="form">Information:</label><br>';
    echo '<textarea id="information2" name="information2" rows="12" cols="70"></textarea><br><br>';
    echo '<p>Please include as much information as possible including links, screenshots, and numbers.</p><br><br>';
    echo "<button class='fancyButton'>Submit Form</button>";
    echo '</div>';
} else {
    echo '<div id="rulesdiv"  style="display:none">';
    echo '<p>You must be logged in to report a user.</p>';
    echo '</div>';
}

//Digitial Purchase
echo '<div id="purchasediv"  style="display:none">';
echo '<label for="email3"  class="form">Contact Email:</label><br>';
echo '<input type="email" id="email3" name="email3"><br><br>';
echo '<label for="purchaseid"  class="form">Purchase ID:</label><br>';
echo '<input type="text" id="purchaseid" name="purchaseid"><br><br>';
echo '<label for="information3"  class="form">Information:</label><br>';
echo '<textarea id="information3" name="information3" rows="12" cols="70"></textarea><br><br>';
if ($userId) {
     echo '<p>Since you are logged in, you will be contacted through moderator mailbox.</i></p>';
} else {
     echo '<p>Since you are not logged in, you will be contacted through email.</i></p>';

}
echo "<button class='fancyButton'>Submit Form</button>";
echo '</div>';

//Merch Purchase
echo '<div id="merchdiv"  style="display:none">';
echo '<label for="email4"  class="form">Contact Email:</label><br>';
echo '<input type="email" id="email4" name="email4"><br><br>';
echo '<label for="purchaseid"  class="form">Purchase ID:</label><br>';
echo '<input type="text" id="purchaseid" name="purchaseid"><br><br>';
echo '<label for="information4"  class="form">Information:</label><br>';
echo '<textarea id="information4" name="information4" rows="12" cols="70"></textarea><br><br>';
if ($userId) {
     echo '<p>Since you are logged in, you will be contacted through moderator mailbox.</i></p>';
} else {
     echo '<p>Since you are not logged in, you will be contacted through email.</i></p>';

}
echo "<button class='fancyButton'>Submit Form</button>";
echo '</div>';

//Bug Report
echo '<div id="bugsdiv" style="display:none">';
echo '<label for="information5"  class="form">Information:</label><br>';
echo '<textarea id="information5" name="information5" rows="12" cols="70"></textarea><br><br>';
echo "<button class='fancyButton'>Submit Form</button><br><br>";
echo '<br><h3>Already Known Bugs</h3>';
echo '<p>Please do not report the below bugs.</p>';
echo '</div>';

//Other
echo '<div id="otherdiv"  style="display:none">';
echo '<label for="email6"  class="form">Contact Email:</label><br>';
echo '<input type="email" id="email6" name="email6"><br><br>';
echo '<label for="information6"  class="form">Information:</label><br>';
echo '<textarea id="information6" name="information6" rows="12" cols="70"></textarea><br><br>';
if ($userId) {
     echo '<p>Since you are logged in, you will be contacted through moderator mailbox.</i></p>';
} else {
     echo '<p>Since you are not logged in, you will be contacted through email.</i></p>';

}
echo "<button class='fancyButton'>Submit Form</button>";
echo '</div>';

//End Form
echo '</form>';