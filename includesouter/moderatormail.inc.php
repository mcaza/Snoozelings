<?php

if ($_COOKIE['user_id']) {
    $userId = $_COOKIE['user_id'];
    $query = 'SELECT * FROM modtickets WHERE submitter = :id ORDER BY ticketid';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
}


//Replies
$query = "SELECT * FROM replies WHERE user_id = :id;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$reply = $stmt->fetch(PDO::FETCH_ASSOC);

//Mailbox Form
echo '<h3 style="margin-bottom:1.5rem">Moderator Mailbox</h3>';
echo '<form method="post" action="includes/moderatorreport.inc.php" style="margin-bottom:20px;">';

//Notification
if ($reply) {
    echo '<div class="returnBar" style="margin-top: 1rem;margin-bottom:2rem;">';
    echo '<p>' . $reply['message'] . '</p>';
    echo '</div>';
    $query = "DELETE FROM replies WHERE user_id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
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
echo '<option value="Purchase">Digital Purchases</option>';
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

//Email Support
echo '<hr><p>For account or purchase support, you can also email <a href="support@snoozelings.com">support@snoozelings.com</a></p>';

if ($tickets) {
    echo '<h1>Open Tickets</h1>';
    echo '<table style="width: 80%">';
    echo '<tr>';
    echo '<th>Ticket #ID</th>';
    echo '<th>Ticket Type</th>';
    echo '<th>Status</th>';
    echo '</tr>';
    $opencount = 0;
    foreach ($tickets as $ticket) {
        if (intval($ticket['status']) < 2) {
            $opencount++;
                if ($result['waitingreply']) {
            if ($user['mode'] == "Dark") {
                $backgroundcolor = "#3A0002";
                echo '<tr style="background-color: #3A0002;">';
            } else {
                $backgroundcolor = "#FFCCCB";
                echo '<tr style="background-color: #FFCCCB;">';
            }
        } else {
            if ($user['mode'] == "Dark") {
                $backgroundcolor = "#003300";
                echo '<tr style="background-color: #003300;">';
            } else {
                $backgroundcolor = "#D7EED7";
            echo '<tr style="background-color: #D7EED7;">';
            }
            
        }
            if ($ticket['waitingreply'] == 1) {
                $notes = "Waiting on Reply";
            } else {
                $notes = "Waiting for Staff Member";
            }
            echo "<td style='background-color:" . $backgroundcolor . "' ><a href='ticket?ticketid=" . $ticket['ticketid'] . "' style='display: block; width: 100%; height: 100%;'>" . $ticket['ticketid'] . "</a></td>";
            echo "<td style='background-color:" . $backgroundcolor . "' ><a href='ticket?ticketid=" . $ticket['ticketid'] . "' style='display: block; width: 100%; height: 100%;'>" . $ticket['topic'] . "</a></td>";
            echo "<td style='background-color:" . $backgroundcolor . "' ><a href='ticket?ticketid=" . $ticket['ticketid'] . "' style='display: block; width: 100%; height: 100%;'>" . $notes . "</a></td>";
            echo "</tr>";
        }
    }
    if ($opencount == 0) {
        echo '<tr><td colspan="3">There are no open tickets</td></tr>';
    }
    echo '</table>';
    
    echo '<h1>Closed Tickets</h1>';
    echo '<table style="width: 80%">';
    echo '<tr>';
    echo '<th>Ticket #ID</th>';
    echo '<th>Ticket Type</th>';
    echo '<th>Status</th>';
    echo '</tr>';
    $closedcount = 0;
    foreach ($tickets as $ticket) {
        if (intval($ticket['status']) == 2) {
            $closedcount++;
            if ($user['mode'] == "Dark") {
                $backgroundcolor = "#001D3D";
                echo '<tr style="background-color: #001D3D;">';
            } else {
                $backgroundcolor = "#FFCCCB";
                echo '<tr style="background-color: #FFCCCB;">';
            }
            $notes = "Closed Ticket";
            echo "<td style='background-color:" . $backgroundcolor . "' ><a href='ticket?ticketid=" . $ticket['ticketid'] . "' style='display: block; width: 100%; height: 100%;'>" . $ticket['ticketid'] . "</a></td>";
            echo "<td style='background-color:" . $backgroundcolor . "' ><a href='ticket?ticketid=" . $ticket['ticketid'] . "' style='display: block; width: 100%; height: 100%;'>" . $ticket['topic'] . "</a></td>";
            echo "<td style='background-color:" . $backgroundcolor . "' ><a href='ticket?ticketid=" . $ticket['ticketid'] . "' style='display: block; width: 100%; height: 100%;'>" . $notes . "</a></td>";
            echo "</tr>";
        }
    }
     if ($closedcount == 0) {
        echo '<tr><td colspan="3">There are no closed tickets</td></tr>';
    }
    echo '</table>';
}



















