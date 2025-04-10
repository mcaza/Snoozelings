<?php

$userId = $_COOKIE['user_id'];
//Replies
$query = "SELECT * FROM replies WHERE user_id = :id;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$reply = $stmt->fetch(PDO::FETCH_ASSOC);

//Get User Id and Check Staff Position
$userId = $_COOKIE['user_id'];
if ($userId == 1) {
    $position = "admin";
} else {
    //Grab Submitter Username
    $query = 'SELECT staff FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $tempposition = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($tempposition['staff'] == "moderator") {
        $position = "moderator";
    } else {
        $position = "user";
    }
}

//Get Ticket Number
$ticket = $_GET['ticketid'];

//Get Ticket Information
$query = 'SELECT * FROM modtickets WHERE ticketid = :ticketid ORDER BY datetime';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":ticketid", $ticket);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Grab Submitter Username
$query = 'SELECT username FROM users WHERE id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $results[0]['submitter']);
$stmt->execute();
$username = $stmt->fetch(PDO::FETCH_ASSOC);

//Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="stafftickets"><<</a>';
echo '</div>';

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

//Title
echo '<h3>Support Ticket #' . $ticket . '</h3>';

echo '<div style="text-align:left;">';

//Basic Information
if ($username) {
    echo '<p><b>Username: </b><a href="profile?id=' . htmlspecialchars($results[0]['submitter']) . '" target="_blank">' . htmlspecialchars($username['username']) . ' #' . htmlspecialchars($results[0]['submitter']) . '</a></p>';
} else {
    echo '<p><b>Username: </b> No Username Attached</p>';
}
if ($results[0]['email']) {
    echo '<p><b>Email: </b>' . htmlspecialchars($results[0]['email']) . '</p>';
}

//Additional Information (Post, User, Pet, Transfer, Purchase)
echo '<p><b>Type: </b>' . $results[0]['topic'] . '</p>';
if ($results[0]['postid']) {
    echo '<p><b>Post Reported: </b>' . $results[0]['postid'] . '</p>';
}
if ($results[0]['userid']) {
    $query = 'SELECT username FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $results[0]['userid']);
    $stmt->execute();
    $reported = $stmt->fetch(PDO::FETCH_ASSOC);
    echo '<p><b>User Reported: </b><a href="profile?id=' . htmlspecialchars($results[0]['userid']) . '" target="_blank">' . htmlspecialchars($reported['username']) . ' #' . $results[0]['userid'] . '</a></p>';
}
if ($results[0]['petid']) {
    $query = 'SELECT name FROM snoozelings WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $results[0]['petid']);
    $stmt->execute();
    $pet = $stmt->fetch(PDO::FETCH_ASSOC);
    echo '<p><b>Pet Reported: </b><a href="profile?id=' . htmlspecialchars($results[0]['petid']) . '" target="_blank">' . htmlspecialchars($pet['name']) . ' #' . $results[0]['petid'] . '</a></p>';
}
if ($results[0]['transferid']) {
    echo '<p><b>Transfer To: </b>' . $results[0]['transferid'] . '</p>';
}
if ($results[0]['purchaseid']) {
    echo '<p><b>Purchase ID: </b>' . $results[0]['purchaseid'] . '</p>';
}

//Display All Staff Notes
if ($position == "admin" || $position == "moderator") {
    echo '<h1 style="text-align: center;">Staff Notes</h1>';
    $notescheck = false;
    foreach($results as $result) {
        if ($result['notes']) {
            $notescheck = true;
        }
    }
    if ($notescheck) {
        $notescount = 1;
        foreach ($results as $result) {
            if ($result['notes']) {
                echo '<table style="width: 90%;">';
                echo '<tr><th>Staff Note #' . $notescount . '</th></tr>';
                echo '<tr><td>' . nl2br(htmlspecialchars($result['notes'])) . '</tr></td>';
                echo '<tr><td style="text-align: right;">Left by Staff #' . $result['replyid'] . ' at ' . $result['datetime'] . '</td></tr>';
                echo '</table>';
                $notescount++;
            }
        }
    } else {
        echo '<p style="text-align: center;">There are no staff notes.</p><br><br>';
    }
}

//Original Submission
echo '<h1 style="text-align: center;">Ticket Replies</h1>';
echo '<table style="width: 90%; border-radius: 0;">';
echo '<tr><th>Original Submission - Submitted by <a href="profile?id=' . htmlspecialchars($results[0]['submitter']) . '" target="_blank" style="color: white">' . htmlspecialchars($username['username']) . ' #' . htmlspecialchars($results[0]['submitter']) . '</a></th></tr>';
echo '<tr><td>' . nl2br(htmlspecialchars($results[0]['information'], ENT_QUOTES)) . '</td></tr>';
echo '<tr><td style="text-align: right">' . $results[0]['datetime'] . '</td></tr>';
echo '</table><br>';

//Any Replies
$count = 0;
if (count($results) > 1) {
    foreach ($results as $result) {
        if ($count == 0) {
            $count++;
        } else {
            if ($result['information']) {
                echo '<table style="width: 90%; border-radius: 0;">';

                //Reply if Submitter is Posting
                if ($results[0]['submitter'] == $result['replyid']) {
                   echo '<tr><th>Reply - Submitted by <a href="profile?id=' . htmlspecialchars($results[0]['submitter']) . '" target="_blank" style="color: white">' . htmlspecialchars($username['username']) . ' #' . $results[0]['submitter'] . '</a></th></tr>'; 
                } else {
                    //Reply if Staff Member is Viewing
                    if ($position == "admin" || $position == "moderator") {
                        $query = 'SELECT username FROM users WHERE id = :id';
                        $stmt = $pdo->prepare($query);
                        $stmt->bindParam(":id", $result['replyid']);
                        $stmt->execute();
                        $staff = $stmt->fetch(PDO::FETCH_ASSOC);
                        echo '<tr><th>Staff Reply - Submitted by <a href="profile?id=' . $result['replyid'] . '" target="_blank" style="color: white">' . $staff['username'] . ' #' . $result['replyid'] . '</a></th></tr>'; 
                    } else {
                        //Reply if NOT Staff Member but Post is From Staff Member
                        echo '<tr><th>Staff Reply - Submitted by Staff Member</th></tr>'; 
                    } 
                }
                if ($result['replyid'] == 1) {
                    echo '<tr><td>' . nl2br($result['information']) . '</td></tr>';
                } else {
                    echo '<tr><td>' . nl2br(htmlspecialchars($result['information'], ENT_QUOTES)) . '</td></tr>';
                }
                //Post Information
                
                echo '<tr><td style="text-align: right">' . $result['datetime'] . '</td></tr>';
                echo '</table><br>';
            }
        }
    }
}

//Response Buttons
echo '<hr>';
echo '<div style="display: flex;flex-wrap: wrap;justify-content: space-evenly;">';
if ($results[0]['status'] == 0 || $results[0]['status'] == 1) {
    echo '<button style="width: 100px;" class="fancyButton" id="reply" onclick="reply()">Reply</button>';
}


if ($position == "admin" || $position == "moderator") {
    echo '<button style="width: 100px;" class="fancyButton" id="notes" onclick="notes()">Notes</button>';
    echo '<button style="width: 130px;" class="fancyButton" id="notes" onclick="addinformation()">Information</button>';
    echo '<button style="width: 100px;" class="fancyButton" id="escalate" onclick="escalate()">Escalate</button>';
    echo '<button style="width: 100px;" class="fancyButton" id="close" onclick="closeticket()">Close</button>';
}

//echo '<button style="width: 100px;" class="fancyButton" onClick="window.location.href=\'../includes/closeTicket.inc.php?id=' . $ticket . '\'">Close</button>';
echo '</div><br>';

if ($position == "admin" || $position == "moderator") {
    //Reply Form
    echo '<div id="replyform" style="text-align: center; display: none;" >';
    echo '<form method="post" action="includes/replyTicket.inc.php">';
    echo '<input type="hidden" name="userid" id="userid" value="' . $userId . '">';
    echo '<input type="hidden" name="ticket" id="ticket" value="' . $ticket . '">';
    echo '<label for="notes"  class="form">Reply to Ticket:</label><br>';
    echo '<p>Reply to the user if you need any additional information.</p>';
    echo '<textarea id="information1" name="information1" rows="12" cols="70"></textarea><br><br>';
    echo '<button class="fancyButton" id="escalate">Submit Reply</button>';
    echo '</form>';
    echo '</div>';

    //Notes Form
        echo '<div id="notesform" style="text-align: center; display: none;" >';
        echo '<form method="post" action="includes/notesTicket.inc.php">';
        echo '<input type="hidden" name="userid" id="userid" value="' . $userId . '">';
        echo '<input type="hidden" name="ticket" id="ticket" value="' . $ticket . '">';
        echo '<label for="notes"  class="form">Staff Notes:</label><br>';
        echo '<p>Notes cannot be viewed by users. They are only visible to staff.</p>';
        echo '<textarea id="information1" name="information1" rows="12" cols="70"></textarea><br><br>';
        echo '<button class="fancyButton" id="escalate">Submit Notes</button>';
        echo '</form>';
        echo '</div>';

    //Add Information
        echo '<div id="informationform" style="text-align: center; display: none;" >';
        echo '<form method="post" action="includes/informationTicket.inc.php">';
        echo '<input type="hidden" name="userid" id="userid" value="' . $userId . '">';
        echo '<input type="hidden" name="ticket" id="ticket" value="' . $ticket . '">';
        echo '<br><p>Fill the necessary fields. Leave the other fields blank.</p><br>';
        echo '<label for="user"  class="form">Reported User ID:</label><br>';
        echo '<input type="number" name="user" id="user"><br><br>';
        echo '<label for="pet"  class="form">Reported Pet ID:</label><br>';
        echo '<input type="number" name="pet" id="pet"><br><br>';
        echo '<label for="transfer"  class="form">Transfer to User:</label><br>';
        echo '<input type="text" name="transfer" id="transfer"><br><br>';
        echo '<label for="purchase"  class="form">Purchase ID:</label><br>';
        echo '<input type="text" name="purchase" id="purchase"><br><br>';
        echo '<button class="fancyButton" id="escalate">Submit Notes</button>';
        echo '</form>';
        echo '</div>';

    //Escalate to Admin
        echo '<div id="escalateform" style="text-align: center; display: none;" >';
        echo '<form action="includes/escalateTicket.inc.php" method="post" onsubmit="return confirm(\'Are you sure you want to escalate this ticket?\');">';
        echo '<input type="hidden" name="ticket" id="ticket" value="' . $ticket . '">';
        echo '<button class="redButton" id="escalate">Press to Escalate Ticket</button>';
        echo '</form>';
        echo '</div>';

    //Close Ticket
        echo '<div id="closeform" style="text-align: center; display: none;" >';
        echo '<form action="includes/closeTicket.inc.php" method="post" onsubmit="return confirm(\'Are you sure you want to close this ticket?\');">';
        echo '<input type="hidden" name="ticket" id="ticket" value="' . $ticket . '">';
        echo '<button class="redButton" id="escalate">Press to Close Ticket</button>';
        echo '</form>';
        echo '</div>';
    
} else if ($results[0]['status'] == 0 || $results[0]['status'] == 1) {
    echo '<div id="replyform" style="text-align: center;" >';
    echo '<form method="post" action="includes/replyTicket.inc.php">';
    echo '<input type="hidden" name="userid" id="userid" value="' . $userId . '">';
    echo '<input type="hidden" name="ticket" id="ticket" value="' . $ticket . '">';
    echo '<label for="notes"  class="form">Reply to Ticket:</label><br>';
    echo '<p>Please be as detailed as possible in your reply.</p>';
    echo '<textarea id="information1" name="information1" rows="12" cols="70"></textarea><br><br>';
    echo '<button class="fancyButton" id="escalate">Submit Reply</button>';
    echo '</form>';
    echo '</div>';
}

echo '</div>';













