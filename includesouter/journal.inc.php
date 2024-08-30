<?php

//Grab User ID
$userId = $_SESSION['user_id'];

if ($_SESSION['finish']) {
    $finish = $_SESSION['finish'];
    unset($_SESSION['finish']);
}

//Check for Journals
$query = 'SELECT * FROM journals WHERE user_id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$journal = $stmt->fetch(PDO::FETCH_ASSOC);
if ($journal) {
    $journalCheck = count($journal);
}


//Grab Bonded Pet
$query = 'SELECT * FROM users WHERE id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$bonded = $stmt->fetch(PDO::FETCH_ASSOC);

$query = 'SELECT * FROM snoozelings WHERE id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $bonded['bonded']);
$stmt->execute();
$pet = $stmt->fetch(PDO::FETCH_ASSOC);

//Get Date
$now = new DateTime("now", new DateTimezone('UTC'));
$formatted = $now->format('Y-m-d');
$now = date("M jS, Y", strtotime($formatted));

//Check For Open Entries
if ($journalCheck) {
    if ($journal['type'] === "mentalHealth") {
        $query = 'SELECT * FROM mentalHealthEntries WHERE user_id = :id ORDER BY id DESC LIMIT 1';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
        $latestEntry = $stmt->fetch(PDO::FETCH_ASSOC);
    } else if ($journal['type'] === "pain") {
        $query = 'SELECT * FROM chronicPainEntries WHERE user_id = :id ORDER BY id DESC LIMIT 1';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
        $latestEntry = $stmt->fetch(PDO::FETCH_ASSOC);
    } else if ($journal['type'] == "productivity") {
        $query = 'SELECT * FROM productivityEntries WHERE user_id = :id ORDER BY id DESC LIMIT 1';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
        $latestEntry = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

//Title
echo '<h3>Daily Journal</h3>';

//RowDiv
echo '<div class="journalRow">';

//Left Pet Display
displayPet($pet, "artJournal");

//Journal Display
echo '<div class="journalDisplay">';

//If No journal, Create Journal
//Else If Check for Entry Today. If no entry, Create Entry
//Else If, Show Today's Entry
if (!$journalCheck) {
    //Journal Creation Title & Information
    echo '<h4  style="margin-top: 2rem;">Creating Your First Journal</h4>';
    echo '<p style="margin-top: 2rem;">One of the best things you can do for your health is keep a journal. This gives doctors a better understanding of your condition which makes appointments much less stressful. <br><br>Here in Snooze Village, we want you to take care of yourself. Therefore, everytime you fill out your journal you\'ll recieve 5 gold coins and help contribute to our daily records.</p>';
    echo '<p style="margin-top: 2rem; width: 90%;margin-right: auto;margin-left: auto;margin-bottom: 1rem;"><i>"It\'s easy. And I\'ll be here to help you every step of the way. Let\'s start by choosing a journal type. Then click the button."</i></p>';
    
    //Form to Create Journal
    echo "<form method='POST' action='../includes/createJournal.inc.php' onsubmit=\"return confirm('Are you sure this is the journal type you want? Once chosen, it cannot be changed without erasing all past journal data.');\">";
    echo '<label for="type" class="form">Journal Type:</label><br>';
    echo '<select class="input"  name="type">';
    echo '<option value="mentalHealth">Mental Health</option>';
    echo '<option value="pain">Chronic Pain</option>';
    echo '<option value="productivity">Productivity</option>';
    echo '</select><br>';
    echo '<button  class="fancyButton">Create Journal</button>';
    echo '</form>';
    
} elseif (!$latestEntry || $latestEntry['closed'] == 1) {
    //Journal Display if there's no active entry

    //Get Journal Messages
    $query = 'SELECT * FROM journalMessage';
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $length = count($messages);
    $randomNum = rand(1, $length) -1;
    
    //Display Title with Today's Date
    echo '<h4  style="margin-top: 2rem;">Journal Entry for ' . $now . '</h4>';
    
    //Random Journal Message
    echo '<p  style="margin-top: 2rem; width: 90%;"><i>"' . $messages[$randomNum]['message'] . '"</i></p>';
    
    //Journal Image
    echo '<img src="resources/journal.png" style="width: 300px;"><br>';
    
    //Journal Button
    echo '<button class="fancyButton" onClick="window.location.href=\'/journalentry\'" style="margin-right: 2rem;">Write Journal</button>';
    
    //View Journal Button
    echo '<button class="fancyButton" onClick="hideFunctions()">Past Journals</button>';
    
} elseif ($latestEntry['closed'] == "0") {
    //Check if Any Messages (Earn Coins OR Journal Edit)
    if ($finish == 1) {
        echo '<div class="returnBar" style="margin-top: 1rem;"><p>You earned 5 coins.</p></div>';
    } elseif ($finish == 2) {
        echo '<div class="returnBar" style="margin-top: 1rem;"><p>Your journal has been edited.</p></div>';
    }
    
    //Journal Completed for Today
    echo '<h4  style="margin-top: 2rem;">Journal Completed</h4>';
    
    //Journal Competion Count
    if ($journal['entries'] > 1) {
    echo '<p>You have filled out your journal ' . $journal['entries'] . " times.</p>";
    } else {
        echo '<p>You have filled out your journal 1 time.</p>';
    }
    echo '<p>' . htmlspecialchars($pet['name']) . ' is super proud of you!</p>';
    echo '<img src="resources/journal.png" style="width: 300px;"><br>';
    
    //Edit Journal Button
    echo '<button class="fancyButton" onClick="window.location.href=\'/journaledit\'" style="margin-right: 2rem;">Edit Journal</button>';
    
    //View Journal Button
    echo '<button class="fancyButton" onClick="hideFunctions()">Past Journals</button>';
    
}

echo '</div>';

//End Div
echo '</div>';


echo '<div id="journalFunctions" style="display:none;">';
echo '<hr>';

//Title
echo '<h3>Past Journals</h3><br><br>';

//Buttons
echo '<div style="display:flex;justify-content:space-evenly;">
                <button class="fancyButton" onClick="window.location.href=\'/viewjournals\'">View Journals</button>
                <button class="fancyButton" onClick="window.location.href=\'/quickFacts\'">Quick Statistics</button>';
//echo '<button class="fancyButton" onClick="window.location.href=\'/exportJournal\'">.PDF Export</button>';
echo '</div></div>';











