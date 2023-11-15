<?php

$userId = $_SESSION['user_id'];

if ($_GET['days']) {
    $days = $_GET['days'];
} else {
    $days = 3;
}
$days = $_GET['days'];

//Check Journal Type
$query = 'SELECT * FROM journals WHERE user_id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$journal = $stmt->fetch(PDO::FETCH_ASSOC);

//Back to Pack Arrows
 echo '<div class="leftRightButtons">';
echo '<a href="journal"><<</a>';
echo '</div>';

//Form to Select Amount (Or Quick Facts) GET
echo '<form method="GET">';
echo '<label style="margin-top: 2rem;" for="days" class="form">Days to Display:</label><br>';
echo '<select class="input"  name="days">';
echo '<option value=""></option>';
echo '<option value="3">3 Days</option>';
echo '<option value="7">7 Days</option>';
echo '<option value="14">14 Days</option>';
echo '<option value="21">21 Days</option>';
echo '<option value="facts">Quick Facts</option>';
echo '</select><br><button class="fancyButton">Update</button></form>';

//Grab all Journal Entries For User of that Type Limit $days
if ($journal['type'] === 'pain') {
    if ($days === "7") {
        $query = 'SELECT * FROM chronicPainEntries WHERE journal_id = :id ORDER BY date DESC LIMIT 7';
    } elseif ($days === "14") {
        $query = 'SELECT * FROM chronicPainEntries WHERE journal_id = :id  ORDER BY date DESC LIMIT 14';
    } elseif ($days === "21") {
        $query = 'SELECT * FROM chronicPainEntries WHERE journal_id = :id  ORDER BY date DESC LIMIT 21';
    } elseif ($days === "facts") {
        $query = 'SELECT * FROM chronicPainEntries WHERE journal_id = :id  ORDER BY date DESC';
    } else {
        $query = 'SELECT * FROM chronicPainEntries WHERE journal_id = :id  ORDER BY date DESC LIMIT 3';
    }
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $journal['id']);
    $stmt->execute();
    $journals = $stmt->fetchAll(PDO::FETCH_ASSOC);
} elseif ($journal['type'] === 'mentalHealth') {
    if ($days === "7") {
        $query = 'SELECT * FROM mentalHealthEntries WHERE journal_id = :id  ORDER BY date DESC LIMIT 7';
    } elseif ($days === "14") {
        $query = 'SELECT * FROM mentalHealthEntries WHERE journal_id = :id  ORDER BY date DESC LIMIT 14';
    } elseif ($days === "21") {
        $query = 'SELECT * FROM mentalHealthEntries WHERE journal_id = :id  ORDER BY date DESC LIMIT 21';
    } elseif ($days === "facts") {
        $query = 'SELECT * FROM mentalHealthEntries WHERE journal_id = :id  ORDER BY date DESC';
    } else {
        $query = 'SELECT * FROM mentalHealthEntries WHERE journal_id = :id  ORDER BY date DESC LIMIT 3';
    }
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $journal['id']);
    $stmt->bindParam(":num", $days);
    $stmt->execute();
    $journals = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if (!$days === "facts") {
    echo '<h3>Journal Entries</h3>';
    echo '<div class="journalEntries">';
    foreach ($journals as $journal) {
        //Get Date
        $now = date("M jS, Y", strtotime($journal['date']));
        echo '<div class="journalEntry">';
        echo '<h4>' . $now . '</h4>';
    }
    echo '</div>';
}
if ($days === "facts") {
    //Quick Facts Page
    
} else {
    //Show Entries as Boxes
    echo '<h3 style="margin-top: 2rem; margin-bottom: 2rem;">Journal Entries</h3>';
    echo '<div class="journalEntries">';
    foreach ($journals as $box) {
        //Get Date
        $now = date("M jS, Y", strtotime($box['date']));
        echo '<div class="journalEntry">';
        echo '<h4 style="margin-top: 1.5rem;">' . $now . '</h4>';
        echo "<hr>";
        echo '<div class="journalInfo">';
        if ($journal['type'] === "pain") {
            echo '<h4 style="margin-top:0; margin-bottom: 0;">Pain Info</h4>';
            echo '<p><strong>Lowest Pain: </strong>' . $box['lowestPain'] . '</p>';
            echo '<p><strong>Highest Pain: </strong>' . $box['highestPain'] . '</p>';
            echo '<p><strong>Average Pain: </strong>' . $box['averagePain'] . '</p>';
            echo '<p style="margin-bottom: .5rem;"><strong>Pain Location: </strong></p>';
            echo '<p style="margin-top: 0;">' . $box['painLocation'] . '</p>';
            echo '<p style="margin-bottom: .5rem;"><strong>Pain Description: </strong></p>';
            echo '<p style="margin-top: 0;">' . $box['painDescription'] . '</p>';
            echo '<p style="margin-bottom: .5rem;"><strong>Other Symptoms: </strong></p>';
            echo '<p style="margin-top: 0;">' . $box['otherSymptoms'] . '</p>';
            echo '<hr>';
            echo '<h4 style="margin-top:1.6rem; margin-bottom: 0;">Possible Causes</h4>';
            echo '<p><strong>Weather: </strong>' . $box['weather'] . '</p>';
            echo '<p><strong>Air Quality: </strong>' . $box['air'] . '</p>';
            echo '<p><strong>Sleep Quality: </strong>' . $box['sleep'] . '</p>';
            echo '<p><strong>Water Amount: </strong>' . $box['water'] . '</p>';
            echo '<p><strong>Activity Amount: </strong>' . $box['physicalActivity'] . '</p>';
            echo '<p><strong>Missed Medication: </strong>' . $box['missedMeds'] . '</p>';
            echo '<hr>';
            echo '<h4 style="margin-top:1.6rem; margin-bottom: 0;">Other</h4>';
            echo '<p><strong>Treatments Attempted: </strong>' . $box['remedies'] . '</p>';
            echo '<p><strong>Notes: </strong>' . $box['notes'] . '</p>';
        } elseif ($journal['type'] === "mentalHealth") {
            echo '<h4 style="margin-top:0; margin-bottom: 0;">Health Info</h4>';
            echo '<p><strong>Anxiety Rating: </strong>' . $box['anxiety'] . '</p>';
            echo '<p><strong>Depression Rating: </strong>' . $box['depression'] . '</p>';
            echo '<p><strong>Stress Rating: </strong>' . $box['stress'] . '</p>';
            echo '<p><strong>Productivity Rating: </strong>' . $box['productivity'] . '</p>';
            echo '<p><strong>Physical Health: </strong>' . $box['physicalHealth'] . '</p>';
            echo '<hr>';
            echo '<h4 style="margin-top:0; margin-bottom: 0;">Behaviours</h4>';
            echo '<p style="margin-bottom: .5rem;"><strong>Good Stuff: </strong></p>';
            echo '<p style="margin-top: 0;">' . $box['productive'] . '</p>';
            echo '<p style="margin-bottom: .5rem;"><strong>Not So Good Stuff: </strong></p>';
            echo '<p style="margin-top: 0;">' . $box['destructive'] . '</p>';
            echo '<hr>';
            echo '<h4 style="margin-top:0; margin-bottom: 0;">Possible Causes</h4>';
            echo '<p><strong>Sleep Quality: </strong>' . $box['sleep'] . '</p>';
            echo '<p><strong>Water Amount: </strong>' . $box['water'] . '</p>';
            echo '<p><strong>Missed Medication: </strong>' . $box['missedMeds'] . '</p>';
            echo '<p style="margin-bottom: .5rem;"><strong>Stuff That Happened: </strong></p>';
            echo '<p style="margin-top: 0;">' . $box['triggers'] . '</p>';
            echo '<p style="margin-bottom: .5rem;"><strong>Notes: </strong></p>';
            echo '<p style="margin-top: 0;">' . $box['notes'] . '</p>';
        }
        
        echo '</div>';
        echo '</div>';
    }
}
echo '</div>';

