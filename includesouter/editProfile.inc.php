<?php

//Grab User ID
$userId = $_SESSION['user_id'];
$error = $_SESSION['error'];
unset($_SESSION['error']);

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

//Get House Names
$query = "SELECT * FROM homeNames ORDER BY name";
$stmt = $pdo->prepare($query);
$stmt->execute();
$houseNames = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Get Backpack Names
$query = "SELECT * FROM backpackNames ORDER BY name";
$stmt = $pdo->prepare($query);
$stmt->execute();
$backpackNames = $stmt->fetchAll(PDO::FETCH_ASSOC);


//Top Bar. Back Error Left. Request Button Right
echo '<div style="display: flex;justify-content:space-between;flex-direction: row;">';

//Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="profile?id=' . $userId . '"><<</a>';
echo '</div>';

//Post Button (Right)
echo '<div class="buttonBar">';
echo '<button  class="fancyButton" onClick="window.location.href=\'newsletter\'">Newsletter</button>';


//Verify Email Button
if ($result['emailVerified'] == 0) {
    echo '<button  class="fancyButton" onClick="window.location.href=\'verify\'" style="margin-left:15px;">Verify Email</button>';
}
echo '</div>';
echo '</div>';

//Error
if ($error) {
    echo '<div class="returnBar" style="margin-top: 1rem;">';
    echo '<p>' . $error . '</p>';
    echo '</div><br>';
}

//Title
echo '<h3 style="margin-bottom: .5rem;">Update Your Profile</h3>';
echo '<form action="includes/editProfileCode.inc.php" method="post">';

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

//House Name
echo '<label for="house" class="form">Change House Name:</label><br>';
echo '<select class="input" name="house">';
echo '<option value=""></option>';
foreach ($houseNames as $name) {
    echo "<option value='" . $name['name'] . "'>" . $name['name'] . "</option>";
}
echo '</select><br>';

//Backpack Name
echo '<label for="backpack" class="form">Change Backpack Name:</label><br>';
echo '<select class="input" name="backpack">';
echo '<option value=""></option>';
foreach ($backpackNames as $name) {
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

//Penpal Mail Setting
echo '<label for="penpal" class="form">Penpal Intensity:</label><br>';
switch ($result['penpal']) {
    case "Easy":
        $easy = "selected";
        break;
    case "Moderate":
        $moderate = "selected";
        break;
    case "Stressful":
        $stressful = "selected";
        break;
}
echo '<select class="input" name="penpal">';
echo '<option value="Easy"' . $easy . '>Easy</option>';
echo '<option value="Moderate"' . $moderate . '>Moderate</option>';
echo '<option value="Stressful"' . $stressful . '>Stressful</option>';
echo '</select><br>';
$easy = "";
$moderate = "";
$stressful = "";

//Bonded Snoozeling
echo '<label for="bonded" class="form">Change Bonded Snoozeling:</label><br>';
echo '<select class="input" name="bonded">';
echo '<option value=""></option>';
foreach ($snoozelings as $pet) {
    echo '<option value="' . $pet['id'] . '">#' . $pet['id'] . ' - ' . $pet['name'] . '</option>';
}
echo '</select><br>';

//Shortcuts
echo '<label for="shortcuts" class="form">Preferred Shortcuts:</label><br>';
echo '<input type="checkbox" id="Crafting" name="Crafting" value="Crafting">';
echo '<label style="font-size: 1.7rem;" for="Crafting">Crafting</label><br><br>';
echo '<input type="checkbox" id="Dyes" name="Dyes" value="Dyes">';
echo '<label style="font-size: 1.7rem;" for="Dyes">Dye Station</label><br><br>';
echo '<input type="checkbox" id="Explore" name="Explore" value="Explore">';
echo '<label style="font-size: 1.7rem;" for="Explore">Exploring</label><br><br>';
echo '<input type="checkbox" id="Garden" name="Garden" value="Garden">';
echo '<label style="font-size: 1.7rem;" for="Garden">Farm Plots</label><br><br>';
echo '<input type="checkbox" id="Journal" name="Journal" value="Journal">';
echo '<label style="font-size: 1.7rem;" for="Journal">Health Journal</label><br><br>';
echo '<input type="checkbox" id="Mailbox" name="Mailbox" value="Mailbox">';
echo '<label style="font-size: 1.7rem;" for="Mailbox">Mailbox</label><br><br>';
echo '<input type="checkbox" id="Penpals" name="Penpals" value="Penpals">';
echo '<label style="font-size: 1.7rem;" for="Penpals">Find Penpal</label><br><br>';
echo '<input type="checkbox" id="Snoozeling" name="Snoozeling" value="Snoozeling">';
echo '<label style="font-size: 1.7rem;" for="Snoozeling">Bonded Snoozeling</label><br><br>';
echo '<input type="checkbox" id="Pack" name="Pack" value="Pack">';
echo '<label style="font-size: 1.7rem;" for="Pack">Backpack</label><br><br>';

//Blank Field Warning
echo '<p><i>Any Blank Fields Will Not Be Changed</i></p>';

//Submit Button
echo '<button  class="fancyButton">Update Profile</button>';
echo '</form>';
