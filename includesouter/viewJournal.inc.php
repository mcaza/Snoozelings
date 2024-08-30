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
//echo '<option value="facts">Quick Facts</option>';
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
} else if ($journal['type'] === "productivity") {
    if ($days === "7") {
        $query = 'SELECT * FROM productivityEntries WHERE journal_id = :id  ORDER BY date DESC LIMIT 7';
    } elseif ($days === "14") {
        $query = 'SELECT * FROM productivityEntries WHERE journal_id = :id  ORDER BY date DESC LIMIT 14';
    } elseif ($days === "21") {
        $query = 'SELECT * FROM productivityEntries WHERE journal_id = :id  ORDER BY date DESC LIMIT 21';
    } elseif ($days === "facts") {
        $query = 'SELECT * FROM productivityEntries WHERE journal_id = :id  ORDER BY date DESC';
    } else {
        $query = 'SELECT * FROM productivityEntries WHERE journal_id = :id  ORDER BY date DESC LIMIT 4';
    }
}
$stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $journal['id']);
    $stmt->execute();
    $journals = $stmt->fetchAll(PDO::FETCH_ASSOC);
if ($journal['type'] === "productivity") {
    $journals = array_reverse($journals);
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
    if ($journal['type'] === "productivity") {
        $count = 0;
        $habitOneArray = [];
        $habitTwoArray = [];
        $taskArrayOne = [];
        $taskArrayTwo = [];
        $taskArrayThree = [];
        $taskArrayFour = [];
        $taskArrayFive = [];
        foreach ($journals as $box) {
            if ($box['habitOne']) {
                $habitOne = $box['habitOne'];
            } else if ($habitOne) {

            } else {
                $habitOne = "";
            }
            if ($box['habitTwo']) {
                $habitTwo = $box['habitTwo'];
            } else if ($habitTwo) {

            } else {
                $habitTwo = "";
            }
            array_push($habitOneArray,$habitOne);
            array_push($habitTwoArray,$habitTwo);
            if ($box['taskOne']) {
                array_push($taskArrayOne,$box['taskOne']);
            } else {
                array_push($taskArrayOne,false);
            }
            if ($box['taskTwo']) {
                array_push($taskArrayTwo,$box['taskTwo']);
            } else {
                array_push($taskArrayTwo,false);
            }
            if ($box['taskThree']) {
                array_push($taskArrayThree,$box['taskThree']);
            } else {
                array_push($taskArrayThree,false);
            }
            if ($box['taskFour']) {
                array_push($taskArrayFour,$box['taskFour']);
            } else {
                array_push($taskArrayFour,false);
            }
            if ($box['taskFive']) {
                array_push($taskArrayFive,$box['taskFive']);
            } else {
                array_push($taskArrayFive,false);
            }
        } 
    }
    
    foreach ($journals as $box) {
        if ($journal['type'] === "productivity" && $count == 0) {
            $count++;
        } else {
        //Get Date
        $now = date("M jS, Y", strtotime($box['date']));
        echo '<div class="journalEntry">';
        echo '<h4 style="margin-top: 1.5rem;">' . $now . '</h4>';
        echo "<hr style='margin-bottom: 0;'>";
        echo '<div class="journalInfo">';
        if ($journal['type'] === "pain") {
            echo '<div class="infoBox">';
            echo '<h4 style="">Pain Info</h4>';
            echo '<p><strong>Lowest Pain: </strong>' . $box['lowestPain'] . '</p>';
            echo '<p><strong>Highest Pain: </strong>' . $box['highestPain'] . '</p>';
            echo '<p><strong>Average Pain: </strong>' . $box['averagePain'] . '</p>';
            echo '<p style="margin-bottom: .5rem;"><strong>Pain Location:<br></strong></p>';
            echo '<p style="margin-top: 0;">' . $box['painLocation'] . '</p>';
            echo '<p style="margin-bottom: .5rem;"><strong>Pain Description:<br></strong></p>';
            echo '<p style="margin-top: 0;">' . $box['painDescription'] . '</p>';
            echo '<p style="margin-bottom: .5rem;"><strong>Other Symptoms:<br></strong></p>';
            echo '<p style="margin-top: 0;">' . $box['otherSymptoms'] . '</p>';
            echo '</div>';
            echo '<div class="infoBox">';
            echo '<h4 style="">Possible Causes</h4>';
            echo '<p><strong>Weather: </strong>' . $box['weather'] . '</p>';
            echo '<p><strong>Air Quality: </strong>' . $box['air'] . '</p>';
            echo '<p><strong>Sleep Quality: </strong>' . $box['sleep'] . '</p>';
            echo '<p><strong>Water Amount: </strong>' . $box['water'] . '</p>';
            echo '<p><strong>Activity Amount: </strong>' . $box['physicalActivity'] . '</p>';
            echo '<p><strong>Missed Medication:<br></strong>' . htmlspecialchars($box['missedMeds']) . '</p>';
            echo '</div>';
            echo '<div class="infoBox">';
            echo '<h4 style="">Other</h4>';
            echo '<p><strong>Treatments Attempted:<br></strong>' . htmlspecialchars($box['remedies']) . '</p>';
            echo '<p><strong>Notes:<br></strong>' . htmlspecialchars($box['otherNotes']) . '</p>';
            echo '</div>';
        } else if ($journal['type'] === "mentalHealth") {
            echo '<div class="infoBox">';
            echo '<h4 >Health Info</h4>';
            echo '<p><strong>Anxiety Rating: </strong>' . $box['anxiety'] . '</p>';
            echo '<p><strong>Depression Rating: </strong>' . $box['depression'] . '</p>';
            echo '<p><strong>Stress Rating: </strong>' . $box['stress'] . '</p>';
            echo '<p><strong>Productivity Rating: </strong>' . $box['productivity'] . '</p>';
            echo '<p><strong>Physical Health: </strong>' . $box['physicalHealth'] . '</p>';
            echo '</div>';
            echo '<div class="infoBox">';
            echo '<h4 >Behaviours</h4>';
            echo '<p style="margin-bottom: .5rem;"><strong>Good Stuff: </strong></p>';
            echo '<p style="margin-top: 0;">' . $box['productive'] . '</p>';
            echo '<p style="margin-bottom: .5rem;"><strong>Not So Good Stuff: </strong></p>';
            echo '<p style="margin-top: 0;">' . $box['destructive'] . '</p>';
            echo '</div>';
            echo '<div class="infoBox">';
            echo '<h4 >Possible Causes</h4>';
            echo '<p><strong>Sleep Quality: </strong>' . $box['sleep'] . '</p>';
            echo '<p><strong>Water Amount: </strong>' . $box['water'] . '</p>';
            echo '<p><strong>Missed Medication: </strong>' . htmlspecialchars($box['missedMeds']) . '</p>';
            echo '<p style="margin-bottom: .5rem;"><strong>Stuff That Happened: </strong></p>';
            echo '<p style="margin-top: 0;">' . htmlspecialchars($box['triggers']) . '</p>';
            echo '<p style="margin-bottom: .5rem;"><strong>Notes: </strong></p>';
            echo '<p style="margin-top: 0;">' . htmlspecialchars($box['notes']) . '</p>';
            echo '</div>';
        } else if ($journal['type'] === "productivity") {
            
            echo '<div class="infoBox">';
            echo '<h4 style="">Daily Habits</h4>';
            if ($habitOneArray[$count]) {
                if ($box['habitOneCheck'] == 1) {
                    echo '<p>✔️ ' . $habitOneArray[$count] . '</p>';
                } else {
                    echo '<p>❌ ' . $habitOneArray[$count] . '</p>';
                }
            } else {
                echo '<p><i>No Habits Recorded</i></p>';
            }
            if ($habitTwoArray[$count]) {
                if ($box['habitTwoCheck'] == 1) {
                    echo '<p>✔️ ' . htmlspecialchars($habitTwoArray[$count]) . '</p>';
                } else {
                    echo '<p>❌ ' . htmlspecialchars($habitTwoArray[$count]) . '</p>';
                }
            }
            echo '<hr>';
            echo '<h4 style="">Health Stats</h4>';
            echo '<p><strong>Physical Health: </strong>' . $box['physicalHealth'] . '</p>';
            echo '<p><strong>Mental Health: </strong>' . $box['mentalHealth'] . '</p>';
            echo '<p><strong>Productivity: </strong>' . $box['productivity'] . '</p>';
            echo '<p><strong>Mood: </strong>' . $box['mood'] . '</p>';
            echo '</div>';
            echo '<div class="infoLarge">';
            echo '<h4 style="">Daily Tasks</h4>';
            if ($taskArrayOne[$count-1]) {
                if ($box['oneCheck'] == 1) {
                    echo '<p>✔️ ' . htmlspecialchars($taskArrayOne[$count-1]) . '</p>';
                } else {
                    echo '<p>❌ ' . htmlspecialchars($taskArrayOne[$count-1]) . '</p>';
                }
            } else {
                echo '<p><i>No Tasks Recorded</i></p>';
            }
            if ($taskArrayTwo[$count-1]) {
                if ($box['twoCheck'] == 1) {
                    echo '<p>✔️ ' . htmlspecialchars($taskArrayTwo[$count-1]) . '</p>';
                } else {
                    echo '<p>❌ ' . htmlspecialchars($taskArrayTwo[$count-1]) . '</p>';
                }
            }
            if ($taskArrayThree[$count-1]) {
                if ($box['threeCheck'] == 1) {
                    echo '<p>✔️ ' . htmlspecialchars($taskArrayThree[$count-1]) . '</p>';
                } else {
                    echo '<p>❌ ' . htmlspecialchars($taskArrayThree[$count-1]) . '</p>';
                }
            }
            if ($taskArrayFour[$count-1]) {
                if ($box['fourCheck'] == 1) {
                    echo '<p>✔️ ' . htmlspecialchars($taskArrayFour[$count-1]) . '</p>';
                } else {
                    echo '<p>❌ ' . htmlspecialchars($taskArrayFour[$count-1]) . '</p>';
                }
            }
            if ($taskArrayFive[$count-1]) {
                if ($box['fiveCheck'] == 1) {
                    echo '<p>✔️ ' . htmlspecialchars($taskArrayFive[$count-1]) . '</p>';
                } else {
                    echo '<p>❌ ' . htmlspecialchars($taskArrayFive[$count-1]) . '</p>';
                }
            }
            
            echo '</div>';
            if ($box['weeklyWin']) {
                echo '</div>';
                echo '<div class="journalEntry" style="margin-top:10px;margin-bottom:10px;">';
                echo '<h4 style="margin-top: 1.5rem;">Weekly Review</h4>';
                echo '<div style="width:85%;text-align:left;margin-left:auto;margin-right:auto;">';
                echo '<p><strong>Weekly Win: </strong>' . htmlspecialchars($box['weeklyWin']) . '</p>';
                echo '<p><strong>Weekly Loss: </strong>' . htmlspecialchars($box['weeklyLoss']) . '</p>';
                echo '<p><strong>Learned Lesson: </strong>' . htmlspecialchars($box['learned']) . '</p>';
                echo '<p><strong>Notes: </strong>' . htmlspecialchars($box['notes']) . '</p>';
                echo '</div>';
            }
            
            $count++;
        }
        
        echo '</div>';
        echo '</div>';
    }
    }
}
echo '</div>';

