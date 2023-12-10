<?php

//Grab User ID
$userId = $_SESSION['user_id'];

//Grab Pet Info from Database
$query = "SELECT * FROM users WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

//Grab Statuses
$query = "SELECT * FROM statuses ORDER BY status";
$stmt = $pdo->prepare($query);
$stmt->execute();
$statuses = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Grab Newest Pet
$query = "SELECT name FROM snoozelings WHERE owner_id = :id ORDER BY id DESC LIMIT 1";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$newSnooze = $stmt->fetch(PDO::FETCH_ASSOC);

//Grab All Pets
$query = "SELECT * FROM snoozelings WHERE owner_id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$snoozelings = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Grab Statuses
$query = "SELECT * FROM farmNames ORDER BY name";
$stmt = $pdo->prepare($query);
$stmt->execute();
$farmNames = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Back Arrow & Title
echo '<div class="leftRightButtons">';
echo '<a href="profile?id=' . $userId . '"><<</a>';
echo '</div>';

echo '<h3 style="margin-bottom: .5rem;">Update Your Profile</h3>';
echo '<form action="includes/editProfile.inc.php" method="post">';

//Pronouns Check
switch ($result['pronouns']) {
    case "Any":
        $any = "selected";
        break;
    case "She/Them":
        $sheThem = "selected";
        break;
    case "She/Her":
        $sheHer = "selected";
        break;
    case "He/Him":
        $heHim = "selected";
        break;
    case "He/Them":
        $heThem = "selected";
        break;
    case "They/Them":
        $theyThem = "selected";
        break;
    case "She/Him":
        $sheHim = "selected";
        break;
}
//Form "Pronouns"
echo '<label for="pronouns"  class="form">Your Pronouns:</label><br>';
echo '<select  class="input" name="pronouns"><br>';
echo '<option value="Any"' . $any . '>Any</option>';
echo '<option value="She/Her"' . $sheHer . '>She/Her</option>';
echo '<option value="He/Him"' . $heHim . '>He/Him</option>';
echo '<option value="They/Them"' . $theyThem . '>They/Them</option>';
echo '<option value="She/Them"' . $sheThem . '>She/Them</option>';
echo '<option value="He/Them"' . $heThem . '>He/Them</option>';
echo '<option value="She/Him"' . $sheHim . '>She/Him</option>';
echo '</select><br>';

//Breeding Status Check
switch ($result['breedStatus']) {
    case "Closed":
        $closed = "selected";
        break;
    case "Open":
        $open = "selected";
        break;
    case "Friends":
        $friends = "selected";
        break;
}

//Status Box
echo '<label for="status" class="form">Change Status:</label><br>';
echo '<select class="input" name="status">';
echo '<option value=""></option>';
foreach ($statuses as $status) {
    $value = intval($status['special']);
    if ($value === 1) {
        
        switch ($status['status']) {
            case "Check out my newest snoozeling: ":
                $nameValue = "Check out my newest snoozeling: " . htmlspecialchars($newSnooze['name']);
                echo "<option value='" . $nameValue . "'>" . $nameValue . "</option>";
                break;
                case "Check out my newest post ":
                //Add Newest Post Later
                echo "<option value='Check out my newest post '>Check out my newest post </option>";
                break;
        }
    } else {
        echo '<option value="' . $status['status'] . '">' . $status['status'] . '</option>';
    }
}
echo '</select><br>';

//Farm Name
echo '<label for="farm" class="form">Change Farm Name:</label><br>';
echo '<select class="input" name="farm">';
echo '<option value=""></option>';
foreach ($farmNames as $name) {
    echo "<option value='" . $name['name'] . "'>" . $name['name'] . "</option>";
}
echo '</select><br>';

//Mailbox Color
echo '<label for="mailbox" class="form">Change Mailbox Color:</label><br>';
echo '<select class="input" name="mailbox">';
echo '<option value=""></option>';
echo '<option value="blue">Blue</option>';
echo '<option value="cyan">Cyan</option>';
echo '<option value="orange">Orange</option>';
echo '<option value="purple">Purple</option>';
echo '<option value="red">Red</option>';
echo '</select><br>';

//Allow Friend Requests
echo '<label for="friends" class="form">Allow Friend Requests:</label><br>';
switch ($result['blockRequests']) {
    case "1":
        $no = "selected";
        break;
    case "0":
        $yes = "selected";
        break;
}
echo '<select class="input" name="friends">';
echo '<option value="0"' . $yes . '>Yes</option>';
echo '<option value="1"' . $no . '>No</option>';
echo '</select><br>';
$yes = "";
$no = "";

//Allow Messages
echo '<label for="messages" class="form">Allow Messages:</label><br>';
switch ($result['blockMessages']) {
    case "1":
        $no = "selected";
        break;
    case "0":
        $yes = "selected";
        break;
}
echo '<select class="input" name="messages">';
echo '<option value="0"' . $yes . '>Yes</option>';
echo '<option value="1"' . $no . '>No</option>';
echo '</select><br>';
$yes = "";
$no = "";

//Bonded Snoozeling
echo '<label for="bonded" class="form">Change Bonded Snoozeling:</label><br>';
echo '<select class="input" name="bonded">';
echo '<option value=""></option>';
foreach ($snoozelings as $pet) {
    echo '<option value="' . $pet['id'] . '">#' . $pet['id'] . ' - ' . $pet['name'] . '</option>';
}
echo '</select><br>';

//Blank Field Warning
echo '<p><i>Any Blank Fields Will Not Be Changed</i></p>';

//Submit Button
echo '<button  class="fancyButton">Update Profile</button>';
echo '</form>';






















