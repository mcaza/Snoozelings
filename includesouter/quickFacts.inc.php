<?php

//Grab User ID
$userId = $_SESSION['user_id'];

//Grab Journal Type
$query = 'SELECT * FROM journals WHERE user_id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$journal = $stmt->fetch(PDO::FETCH_ASSOC);

//Get Journal Type
$type = $journal['type'];

//Get all Journal Entries
if ($type == "mentalHealth") {
    $query = 'SELECT * FROM mentalHealthEntries WHERE user_id = :id ORDER by id DESC';
} else if ($type == "pain") {
    $query = 'SELECT * FROM chronicPainEntries WHERE user_id = :id ORDER by id DESC';
} else if ($type == "productivity") {
    $query = 'SELECT * FROM productivityEntries WHERE user_id = :id ORDER by id DESC';
} else if ($type == "generic") {
    $query = 'SELECT * FROM genericEntries WHERE user_id = :id ORDER by id DESC';
}
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$entries = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Bad Scale Function
        function checkBad($num,$word) {
            if ($num < 2) {
                echo '<b>' . $word . ': </b>Extremely Low <i>(' . $num . '/10)</i><br>';
            } else if ($num < 4) {
                echo '<b>' . $word . ': </b>Low <i>(' . $num . '/10)</i><br>';
            } else if ($num < 6) {
                echo '<b>' . $word . ': </b>Moderate <i>(' . $num . '/10)</i><br>';
            } else if ($num < 8) {
                echo '<b>' . $word . ': </b>High <i>(' . $num . '/10)</i><br>';
            } else {
                echo '<b>' . $word . ': </b>Extremely High <i>(' . $num . '/10)</i><br>';
            }
        }

//Good Scale Function
    function checkGood($num,$word) {
            if ($num < 2) {
                echo '<b>' . $word . ': </b>Very Poor <i>(' . $num . '/10)</i><br>';
            } else if ($num < 4) {
                echo '<b>' . $word . ': </b>Poor <i>(' . $num . '/10)</i><br>';
            } else if ($num < 6) {
                echo '<b>' . $word . ': </b>Average <i>(' . $num . '/10)</i><br>';
            } else if ($num < 8) {
                echo '<b>' . $word . ': </b>Good <i>(' . $num . '/10)</i><br>';
            } else {
                echo '<b>' . $word . ': </b>Excellent <i>(' . $num . '/10)</i><br>';
            }
        }

//Quantity Function
    function checkQuantity($num,$word) {
            if ($num < 2) {
                echo '<b>' . $word . ': </b>Very Little <i>(' . $num . '/10)</i><br>';
            } else if ($num < 4) {
                echo '<b>' . $word . ': </b>Not Enough <i>(' . $num . '/10)</i><br>';
            } else if ($num < 6) {
                echo '<b>' . $word . ': </b>Moderate <i>(' . $num . '/10)</i><br>';
            } else if ($num < 8) {
                echo '<b>' . $word . ': </b>Good <i>(' . $num . '/10)</i><br>';
            } else {
                echo '<b>' . $word . ': </b>Possibly Too Much <i> (' . $num . '/10)</i><br>';
            }
        }

//Count Function
function countTimes($word,$cat,$amount,$entries) {
    $count = 1;
    $times = 0;
    foreach ($entries as $entry) {
        if (str_contains($entry[$cat],$word)) {
            $times++;
        }
        $count++;
        if ($count == $amount) {
            break;
        }
    }
    if ($times > 0) {
        echo '<li>' . $word . ' ' . $times . '/' . $amount . ' Days</li>';
    } 
}

//Descriptor Function
function countDescriptions($word,$cat,$amount,$entries) {
    $count = 1;
    $times = 0;
    foreach ($entries as $entry) {
        if (str_contains($entry[$cat],$word)) {
            $times++;
        }
        $count++;
        if ($count == $amount) {
            break;
        }
    }
    if ($times > 2) {
        echo '<li>' . $word . '</li>';
    } 
}

//Find Most Frequent function findMostFrequent($arr)
function findMostFrequent($arr) {
    $freqArray = array_count_values($arr);
    $maxFreq = max($freqArray);
    $mostFrequent = array_search($maxFreq, $freqArray);
    return $mostFrequent;
}

//Calculate Percent
function calculatePercent($numone, $numtwo) {
    return round(($numone / $numtwo) * 100);
}

//Check Habits / Tasks
function countTasks($numone, $numtwo) {
    $newnum = calculatePercent($numone, $numtwo);
    if ($newnum < 20) {
        echo 'Very Low <i>(' . $numone . '/' . $numtwo . ')</i>';
    } else if ($newnum < 40) {
        echo 'Low <i>(' . $numone . '/' . $numtwo . ')</i>';
    } else if ($newnum < 60) {
        echo 'Moderate <i>(' . $numone . '/' . $numtwo . ')</i>';
    } else if ($newnum < 80) {
        echo 'High <i>(' . $numone . '/' . $numtwo . ')</i>';
    } else {
        echo 'Very High <i>(' . $numone . '/' . $numtwo . ')</i>';
    }
}

//Back to Journal Arrows
echo '<div class="leftRightButtons">';
echo '<a href="journal"><<</a>';
echo '</div>';

//Title
echo '<h3 style="margin-bottom:20px;">Journal Statistics</h3>';

if ($type == "mentalHealth") {
    
    //Last 7 Days
    if (count($entries) > 6) {
        echo '<div class="journalEntry">';
        echo '<h1>Last Seven Entries</h1>';
        $count = 1;
        $num = 7;
        $anx = 0;
        $dep = 0;
        $str = 0;
        $hea = 0;
        $pro = 0;
        $sle = 0;
        $wat = 0;
        foreach ($entries as $entry) {
            $anx += $entry['anxiety'];
            $dep += $entry['depression'];
            $str += $entry['stress'];
            $hea += $entry['physicalHealth'];
            $pro += $entry['productivity'];
            $sle += $entry['sleep'];
            $wat += $entry['water'];
            $count++;
            if ($count == $num) {
                break;
            }
        }
        
        $anx = round($anx / $num, 1);
        $dep = round($dep / $num, 1);
        $str = round($str / $num, 1);
        $hea = round($hea / $num, 1);
        $pro = round($pro / $num, 1);
        $sle = round($sle / $num, 1);
        $wat = round($wat / $num, 1);
        
        
        echo '<p style="text-align:left;">';
        checkBad($anx,"Anxiety");
        checkBad($dep,"Depression");
        checkBad($str,"Stress");
        echo '<br>';
        checkGood($hea,"Physical Health");
        checkGood($pro,"Productivity");
        echo '<br>';
        checkQuantity($sle,"Sleep Amount");
        checkQuantity($wat,"Water Consumption");
        echo '<br><b>Good Habits: </b></p>';
        echo '<ul style="text-align:left;">';
        countTimes("Ate a Meal","productive",$num,$entries);
        countTimes("Showered/Bathed","productive",$num,$entries);
        countTimes("Brushed Teeth","productive",$num,$entries);
        countTimes("Did a Chore","productive",$num,$entries);
        countTimes("Went for a Walk","productive",$num,$entries);
        countTimes("Did Some Excercise","productive",$num,$entries);
        countTimes("Talked To Friends/Family","productive",$num,$entries);
        countTimes("Made Some Art","productive",$num,$entries);
        countTimes("Went to Therapy","productive",$num,$entries);
        echo '</ul>';
        echo '<p style="text-align:left;"><b>Bad Habits: </b></p>';
        echo '<ul style="text-align:left;">';
        countTimes("Doomscrolled","destructive",$num,$entries);
        countTimes("Lashed Out at Others","destructive",$num,$entries);
        countTimes("Isolated Myself","destructive",$num,$entries);
        countTimes("Stayed Home from School/Work","destructive",$num,$entries);
        countTimes("Spent Recklessly","destructive",$num,$entries);
        countTimes("Picked at my Body","destructive",$num,$entries);
        countTimes("Hurt Myself","destructive",$num,$entries);
        echo '<ul>';
        echo '</div>';
        
    } else {
        echo '<p><i>You need at least 7 days of journal entries to use this feature.</i></p>';
    }
    
    //Last 30 Days
    if (count($entries) > 29) {
        echo '<div class="journalEntry">';
        echo '<h1>Last Thirty Entries</h1>';
        $count = 1;
        $num = 30;
        $anx = 0;
        $dep = 0;
        $str = 0;
        $hea = 0;
        $pro = 0;
        $sle = 0;
        $wat = 0;
        foreach ($entries as $entry) {
            $anx += $entry['anxiety'];
            $dep += $entry['depression'];
            $str += $entry['stress'];
            $hea += $entry['physicalHealth'];
            $pro += $entry['productivity'];
            $sle += $entry['sleep'];
            $wat += $entry['water'];
            $count++;
            if ($count == $num) {
                break;
            }
        }
        
        $anx = round($anx / $num, 1);
        $dep = round($dep / $num, 1);
        $str = round($str / $num, 1);
        $hea = round($hea / $num, 1);
        $pro = round($pro / $num, 1);
        $sle = round($sle / $num, 1);
        $wat = round($wat / $num, 1);
        
        
        echo '<p style="text-align:left;">';
        checkBad($anx,"Anxiety");
        checkBad($dep,"Depression");
        checkBad($str,"Stress");
        echo '<br>';
        checkGood($hea,"Physical Health");
        checkGood($pro,"Productivity");
        echo '<br>';
        checkQuantity($sle,"Sleep Amount");
        checkQuantity($wat,"Water Consumption");
        echo '<br><b>Good Habits: </b></p>';
        echo '<ul style="text-align:left;">';
        countTimes("Ate a Meal","productive",$num,$entries);
        countTimes("Showered/Bathed","productive",$num,$entries);
        countTimes("Brushed Teeth","productive",$num,$entries);
        countTimes("Did a Chore","productive",$num,$entries);
        countTimes("Went for a Walk","productive",$num,$entries);
        countTimes("Did Some Excercise","productive",$num,$entries);
        countTimes("Talked To Friends/Family","productive",$num,$entries);
        countTimes("Made Some Art","productive",$num,$entries);
        countTimes("Went to Therapy","productive",$num,$entries);
        echo '</ul>';
        echo '<p style="text-align:left;"><b>Bad Habits: </b></p>';
        echo '<ul style="text-align:left;">';
        countTimes("Doomscrolled","destructive",$num,$entries);
        countTimes("Lashed Out at Others","destructive",$num,$entries);
        countTimes("Isolated Myself","destructive",$num,$entries);
        countTimes("Stayed Home from School/Work","destructive",$num,$entries);
        countTimes("Spent Recklessly","destructive",$num,$entries);
        countTimes("Picked at my Body","destructive",$num,$entries);
        countTimes("Hurt Myself","destructive",$num,$entries);
        echo '</ul>';
        echo '</div>';
        
    }
    
    //Last 90 Days
    if (count($entries) > 89) {
        echo '<div class="journalEntry">';
        echo '<h1>Last Ninety Entries</h1>';
        $count = 1;
        $num = 90;
        $anx = 0;
        $dep = 0;
        $str = 0;
        $hea = 0;
        $pro = 0;
        $sle = 0;
        $wat = 0;
        foreach ($entries as $entry) {
            $anx += $entry['anxiety'];
            $dep += $entry['depression'];
            $str += $entry['stress'];
            $hea += $entry['physicalHealth'];
            $pro += $entry['productivity'];
            $sle += $entry['sleep'];
            $wat += $entry['water'];
            $count++;
            if ($count == $num) {
                break;
            }
        }
        
        $anx = round($anx / $num, 1);
        $dep = round($dep / $num, 1);
        $str = round($str / $num, 1);
        $hea = round($hea / $num, 1);
        $pro = round($pro / $num, 1);
        $sle = round($sle / $num, 1);
        $wat = round($wat / $num, 1);
        
        
        echo '<p style="text-align:left;">';
        checkBad($anx,"Anxiety");
        checkBad($dep,"Depression");
        checkBad($str,"Stress");
        echo '<br>';
        checkGood($hea,"Physical Health");
        checkGood($pro,"Productivity");
        echo '<br>';
        checkQuantity($sle,"Sleep Amount");
        checkQuantity($wat,"Water Consumption");
        echo '<br><b>Good Habits: </b></p>';
        echo '<ul style="text-align:left;">';
        countTimes("Ate a Meal","productive",$num,$entries);
        countTimes("Showered/Bathed","productive",$num,$entries);
        countTimes("Brushed Teeth","productive",$num,$entries);
        countTimes("Did a Chore","productive",$num,$entries);
        countTimes("Went for a Walk","productive",$num,$entries);
        countTimes("Did Some Excercise","productive",$num,$entries);
        countTimes("Talked To Friends/Family","productive",$num,$entries);
        countTimes("Made Some Art","productive",$num,$entries);
        countTimes("Went to Therapy","productive",$num,$entries);
        echo '</ul>';
        echo '<p style="text-align:left;"><b>Bad Habits: </b></p>';
        echo '<ul style="text-align:left;">';
        countTimes("Doomscrolled","destructive",$num,$entries);
        countTimes("Lashed Out at Others","destructive",$num,$entries);
        countTimes("Isolated Myself","destructive",$num,$entries);
        countTimes("Stayed Home from School/Work","destructive",$num,$entries);
        countTimes("Spent Recklessly","destructive",$num,$entries);
        countTimes("Picked at my Body","destructive",$num,$entries);
        countTimes("Hurt Myself","destructive",$num,$entries);
        echo '</ul>';
        echo '</div>';
        
    }
    
    //Last 30 Days
    if (count($entries) > 364) {
        echo '<div class="journalEntry">';
        echo '<h1>Last Three Hundred Sixty Five Entries</h1>';
        $count = 1;
        $num = 365;
        $anx = 0;
        $dep = 0;
        $str = 0;
        $hea = 0;
        $pro = 0;
        $sle = 0;
        $wat = 0;
        foreach ($entries as $entry) {
            $anx += $entry['anxiety'];
            $dep += $entry['depression'];
            $str += $entry['stress'];
            $hea += $entry['physicalHealth'];
            $pro += $entry['productivity'];
            $sle += $entry['sleep'];
            $wat += $entry['water'];
            $count++;
            if ($count == $num) {
                break;
            }
        }
        
        $anx = round($anx / $num, 1);
        $dep = round($dep / $num, 1);
        $str = round($str / $num, 1);
        $hea = round($hea / $num, 1);
        $pro = round($pro / $num, 1);
        $sle = round($sle / $num, 1);
        $wat = round($wat / $num, 1);
        
        
        echo '<p style="text-align:left;">';
        checkBad($anx,"Anxiety");
        checkBad($dep,"Depression");
        checkBad($str,"Stress");
        echo '<br>';
        checkGood($hea,"Physical Health");
        checkGood($pro,"Productivity");
        echo '<br>';
        checkQuantity($sle,"Sleep Amount");
        checkQuantity($wat,"Water Consumption");
        echo '<br><b>Good Habits: </b></p>';
        echo '<ul style="text-align:left;">';
        countTimes("Ate a Meal","productive",$num,$entries);
        countTimes("Showered/Bathed","productive",$num,$entries);
        countTimes("Brushed Teeth","productive",$num,$entries);
        countTimes("Did a Chore","productive",$num,$entries);
        countTimes("Went for a Walk","productive",$num,$entries);
        countTimes("Did Some Excercise","productive",$num,$entries);
        countTimes("Talked To Friends/Family","productive",$num,$entries);
        countTimes("Made Some Art","productive",$num,$entries);
        countTimes("Went to Therapy","productive",$num,$entries);
        echo '</ul>';
        echo '<p style="text-align:left;"><b>Bad Habits: </b></p>';
        echo '<ul style="text-align:left;">';
        countTimes("Doomscrolled","destructive",$num,$entries);
        countTimes("Lashed Out at Others","destructive",$num,$entries);
        countTimes("Isolated Myself","destructive",$num,$entries);
        countTimes("Stayed Home from School/Work","destructive",$num,$entries);
        countTimes("Spent Recklessly","destructive",$num,$entries);
        countTimes("Picked at my Body","destructive",$num,$entries);
        countTimes("Hurt Myself","destructive",$num,$entries);
        echo '</ul>';
        echo '</div>';
        
    }
    
} else if ($type == "pain") {
    
    //Last 7 Days
    if (count($entries) > 6) {
        echo '<div class="journalEntry">';
        echo '<h1>Last Seven Entries</h1>';
        $count = 1;
        $num = 7;
        $low = 0;
        $hig = 0;
        $avg = 0;
        $sle = 0;
        $wat = 0;
        $phy = 0;
        foreach ($entries as $entry) {
            $low += $entry['lowestPain'];
            $hig += $entry['highestPain'];
            $avg += $entry['averagePain'];
            $phy += $entry['physicalActivity'];
            $sle += $entry['sleep'];
            $wat += $entry['water'];
            $count++;
            if ($count == $num) {
                break;
            }
        }
        
        $low = round($low / $num, 1);
        $hig = round($hig / $num, 1);
        $avg = round($avg / $num, 1);
        $phy = round($phy / $num, 1);
        $sle = round($sle / $num, 1);
        $wat = round($wat / $num, 1);
        
        echo '<p style="text-align:left;">';
        checkBad($low,"Lowest Pain");
        checkBad($hig,"Highest Pain");
        checkBad($avg,"Average Pain");
        echo '<br>';
        checkQuantity($sle,"Sleep Amount");
        checkQuantity($wat,"Water Consumption");
        checkQuantity($phy,"Physical Activity");
        echo '<br><b>Common Pain Descriptors: </b></p>';
        echo '<ul style="text-align:left;">';
        countDescriptions("Swollen","painDescription",$num,$entries);
        countDescriptions("Throbbing","painDescription",$num,$entries);
        countDescriptions("Aching","painDescription",$num,$entries);
        countDescriptions("Numb","painDescription",$num,$entries);
        countDescriptions("Burning","painDescription",$num,$entries);
        countDescriptions("Cramping","painDescription",$num,$entries);
        countDescriptions("Tight","painDescription",$num,$entries);
        countDescriptions("Tender","painDescription",$num,$entries);
        countDescriptions("Shooting","painDescription",$num,$entries);
        echo '</ul>';
        echo '<p style="text-align:left;"><b>Other Common Symptoms: </b></p>';
        echo '<ul style="text-align:left;">';
        countDescriptions("Exhaustion","otherSymptoms",$num,$entries);
        countDescriptions("Nausea","otherSymptoms",$num,$entries);
        countDescriptions("Vomiting","otherSymptoms",$num,$entries);
        countDescriptions("Bad Poops","otherSymptoms",$num,$entries);
        countDescriptions("Sore Throat","otherSymptoms",$num,$entries);
        countDescriptions("Insomnia","otherSymptoms",$num,$entries);
        countDescriptions("Bloating","otherSymptoms",$num,$entries);
        countDescriptions("Fever","otherSymptoms",$num,$entries);
        countDescriptions("Chills","otherSymptoms",$num,$entries);
        countDescriptions("Congestion","otherSymptoms",$num,$entries);
        countDescriptions("Muscle Spasms","otherSymptoms",$num,$entries);
        countDescriptions("Brain Fog","otherSymptoms",$num,$entries);
        countDescriptions("Bad Mood","otherSymptoms",$num,$entries);
        countDescriptions("Vertigo","otherSymptoms",$num,$entries);
        echo '</ul>';
        echo '</div>';
    } else {
        echo '<p><i>You need at least 7 days of journal entries to use this feature.</i></p>';
    }
    
    //Last 30 Days
    if (count($entries) > 29) {
        echo '<div class="journalEntry">';
        echo '<h1>Last Thirty Entries</h1>';
        $count = 1;
        $num = 30;
        $low = 0;
        $hig = 0;
        $avg = 0;
        $sle = 0;
        $wat = 0;
        $phy = 0;
        foreach ($entries as $entry) {
            $low += $entry['lowestPain'];
            $hig += $entry['highestPain'];
            $avg += $entry['averagePain'];
            $phy += $entry['physicalActivity'];
            $sle += $entry['sleep'];
            $wat += $entry['water'];
            $count++;
            if ($count == $num) {
                break;
            }
        }
        
        $low = round($low / $num, 1);
        $hig = round($hig / $num, 1);
        $avg = round($avg / $num, 1);
        $phy = round($phy / $num, 1);
        $sle = round($sle / $num, 1);
        $wat = round($wat / $num, 1);
        
        echo '<p style="text-align:left;">';
        checkBad($low,"Lowest Pain");
        checkBad($hig,"Highest Pain");
        checkBad($avg,"Average Pain");
        echo '<br>';
        checkQuantity($sle,"Sleep Amount");
        checkQuantity($wat,"Water Consumption");
        checkQuantity($phy,"Physical Activity");
        echo '<br><b>Common Pain Descriptors: </b></p>';
        echo '<ul style="text-align:left;">';
        countDescriptions("Swollen","painDescription",$num,$entries);
        countDescriptions("Throbbing","painDescription",$num,$entries);
        countDescriptions("Aching","painDescription",$num,$entries);
        countDescriptions("Numb","painDescription",$num,$entries);
        countDescriptions("Burning","painDescription",$num,$entries);
        countDescriptions("Cramping","painDescription",$num,$entries);
        countDescriptions("Tight","painDescription",$num,$entries);
        countDescriptions("Tender","painDescription",$num,$entries);
        countDescriptions("Shooting","painDescription",$num,$entries);
        echo '</ul>';
        echo '<p style="text-align:left;"><b>Other Common Symptoms: </b></p>';
        echo '<ul style="text-align:left;">';
        countDescriptions("Exhaustion","otherSymptoms",$num,$entries);
        countDescriptions("Nausea","otherSymptoms",$num,$entries);
        countDescriptions("Vomiting","otherSymptoms",$num,$entries);
        countDescriptions("Bad Poops","otherSymptoms",$num,$entries);
        countDescriptions("Sore Throat","otherSymptoms",$num,$entries);
        countDescriptions("Insomnia","otherSymptoms",$num,$entries);
        countDescriptions("Bloating","otherSymptoms",$num,$entries);
        countDescriptions("Fever","otherSymptoms",$num,$entries);
        countDescriptions("Chills","otherSymptoms",$num,$entries);
        countDescriptions("Congestion","otherSymptoms",$num,$entries);
        countDescriptions("Muscle Spasms","otherSymptoms",$num,$entries);
        countDescriptions("Brain Fog","otherSymptoms",$num,$entries);
        countDescriptions("Bad Mood","otherSymptoms",$num,$entries);
        countDescriptions("Vertigo","otherSymptoms",$num,$entries);
        echo '</ul>';
        echo '</div>';
        
    }
    
    //Last 90 Days
    if (count($entries) > 89) {
        echo '<div class="journalEntry">';
        echo '<h1>Last Ninety Entries</h1>';
        $count = 1;
        $num = 90;
        $low = 0;
        $hig = 0;
        $avg = 0;
        $sle = 0;
        $wat = 0;
        $phy = 0;
        foreach ($entries as $entry) {
            $low += $entry['lowestPain'];
            $hig += $entry['highestPain'];
            $avg += $entry['averagePain'];
            $phy += $entry['physicalActivity'];
            $sle += $entry['sleep'];
            $wat += $entry['water'];
            $count++;
            if ($count == $num) {
                break;
            }
        }
        
        $low = round($low / $num, 1);
        $hig = round($hig / $num, 1);
        $avg = round($avg / $num, 1);
        $phy = round($phy / $num, 1);
        $sle = round($sle / $num, 1);
        $wat = round($wat / $num, 1);
        
        echo '<p style="text-align:left;">';
        checkBad($low,"Lowest Pain");
        checkBad($hig,"Highest Pain");
        checkBad($avg,"Average Pain");
        echo '<br>';
        checkQuantity($sle,"Sleep Amount");
        checkQuantity($wat,"Water Consumption");
        checkQuantity($phy,"Physical Activity");
        echo '<br><b>Common Pain Descriptors: </b></p>';
        echo '<ul style="text-align:left;">';
        countDescriptions("Swollen","painDescription",$num,$entries);
        countDescriptions("Throbbing","painDescription",$num,$entries);
        countDescriptions("Aching","painDescription",$num,$entries);
        countDescriptions("Numb","painDescription",$num,$entries);
        countDescriptions("Burning","painDescription",$num,$entries);
        countDescriptions("Cramping","painDescription",$num,$entries);
        countDescriptions("Tight","painDescription",$num,$entries);
        countDescriptions("Tender","painDescription",$num,$entries);
        countDescriptions("Shooting","painDescription",$num,$entries);
        echo '</ul>';
        echo '<p style="text-align:left;"><b>Other Common Symptoms: </b></p>';
        echo '<ul style="text-align:left;">';
        countDescriptions("Exhaustion","otherSymptoms",$num,$entries);
        countDescriptions("Nausea","otherSymptoms",$num,$entries);
        countDescriptions("Vomiting","otherSymptoms",$num,$entries);
        countDescriptions("Bad Poops","otherSymptoms",$num,$entries);
        countDescriptions("Sore Throat","otherSymptoms",$num,$entries);
        countDescriptions("Insomnia","otherSymptoms",$num,$entries);
        countDescriptions("Bloating","otherSymptoms",$num,$entries);
        countDescriptions("Fever","otherSymptoms",$num,$entries);
        countDescriptions("Chills","otherSymptoms",$num,$entries);
        countDescriptions("Congestion","otherSymptoms",$num,$entries);
        countDescriptions("Muscle Spasms","otherSymptoms",$num,$entries);
        countDescriptions("Brain Fog","otherSymptoms",$num,$entries);
        countDescriptions("Bad Mood","otherSymptoms",$num,$entries);
        countDescriptions("Vertigo","otherSymptoms",$num,$entries);
        echo '</ul>';
        echo '</div>';
        
    }
    
    //Last 365 Days
    if (count($entries) > 364) {
        echo '<div class="journalEntry">';
        echo '<h1>Last Three Hundred Sixty Five Entries</h1>';
        $count = 1;
        $num = 365;
        $low = 0;
        $hig = 0;
        $avg = 0;
        $sle = 0;
        $wat = 0;
        $phy = 0;
        foreach ($entries as $entry) {
            $low += $entry['lowestPain'];
            $hig += $entry['highestPain'];
            $avg += $entry['averagePain'];
            $phy += $entry['physicalActivity'];
            $sle += $entry['sleep'];
            $wat += $entry['water'];
            $count++;
            if ($count == $num) {
                break;
            }
        }
        
        $low = round($low / $num, 1);
        $hig = round($hig / $num, 1);
        $avg = round($avg / $num, 1);
        $phy = round($phy / $num, 1);
        $sle = round($sle / $num, 1);
        $wat = round($wat / $num, 1);
        
        echo '<p style="text-align:left;">';
        checkBad($low,"Lowest Pain");
        checkBad($hig,"Highest Pain");
        checkBad($avg,"Average Pain");
        echo '<br>';
        checkQuantity($sle,"Sleep Amount");
        checkQuantity($wat,"Water Consumption");
        checkQuantity($phy,"Physical Activity");
        echo '<br><b>Common Pain Descriptors: </b></p>';
        echo '<ul style="text-align:left;">';
        countDescriptions("Swollen","painDescription",$num,$entries);
        countDescriptions("Throbbing","painDescription",$num,$entries);
        countDescriptions("Aching","painDescription",$num,$entries);
        countDescriptions("Numb","painDescription",$num,$entries);
        countDescriptions("Burning","painDescription",$num,$entries);
        countDescriptions("Cramping","painDescription",$num,$entries);
        countDescriptions("Tight","painDescription",$num,$entries);
        countDescriptions("Tender","painDescription",$num,$entries);
        countDescriptions("Shooting","painDescription",$num,$entries);
        echo '</ul>';
        echo '<p style="text-align:left;"><b>Other Common Symptoms: </b></p>';
        echo '<ul style="text-align:left;">';
        countDescriptions("Exhaustion","otherSymptoms",$num,$entries);
        countDescriptions("Nausea","otherSymptoms",$num,$entries);
        countDescriptions("Vomiting","otherSymptoms",$num,$entries);
        countDescriptions("Bad Poops","otherSymptoms",$num,$entries);
        countDescriptions("Sore Throat","otherSymptoms",$num,$entries);
        countDescriptions("Insomnia","otherSymptoms",$num,$entries);
        countDescriptions("Bloating","otherSymptoms",$num,$entries);
        countDescriptions("Fever","otherSymptoms",$num,$entries);
        countDescriptions("Chills","otherSymptoms",$num,$entries);
        countDescriptions("Congestion","otherSymptoms",$num,$entries);
        countDescriptions("Muscle Spasms","otherSymptoms",$num,$entries);
        countDescriptions("Brain Fog","otherSymptoms",$num,$entries);
        countDescriptions("Bad Mood","otherSymptoms",$num,$entries);
        countDescriptions("Vertigo","otherSymptoms",$num,$entries);
        echo '</ul>';
        echo '</div>';
        
    }
} else if ($type == "productivity") {
    if (count($entries) > 6) {
        echo '<p style="margin-bottom:12px;"><i>The more journals completed, the more accurate your data will be.</i></p>';
    }
    if (count($entries) > 6) {
        echo '<div class="journalEntry">';
        echo '<h1>Last Seven Entries</h1>';
        
        $count = 1;
        $num = 7;
        $totaltasks = 0;
        $doneTasks = 0;
        $doneHabits = 0;
        $phy = 0;
        $men = 0;
        $pro = 0;
        $moo = 0;
        
        foreach ($entries as $entry) {
            $phy += $entry['physicalHealth'];
            $men += $entry['mentalHealth'];
            $pro += $entry['productivity'];
            $moo += $entry['mood'];
            $count++;
            if ($count == $num) {
                break;
            }
        }
        
        $phy = round($phy / $num, 1);
        $men = round($men / $num, 1);
        $pro = round($pro / $num, 1);
        $moo = round($moo / $num, 1);
        
        //Calculate Habit Total
        $habitCount = $num * 2;
        if (count($entries) == $num) {
            $habitCount - 2;
        }
        
        //Count Finished Habits
        $habitComplete = 0;
        $counter = 0;
        foreach ($entries as $entry) {
            if ($counter == 7) {
                break;
            }
            if ($entry['habitOneCheck'] == 1) {
                $habitComplete++;
            }
            if ($entry['habitTwoCheck'] == 1) {
                $habitComplete++;
            }
            $counter++;
        }
        
        //Calculate Tasks
        $tasks = 0;
        $taskComplete = 0;
        foreach ($entries as $entry) {
            if (date('w', strtotime($entry['date'])) == 6 || date('w', strtotime($entry['date'])) == 7) {
                $tasks = $tasks + 3;
                if ($entry['oneCheck'] == 1) {
                    $taskComplete++;
                }
                if ($entry['twoCheck'] == 1) {
                    $taskComplete++;
                }
                if ($entry['threeCheck'] == 1) {
                    $taskComplete++;
                }
            } else {
                $tasks = $tasks + 5;
                if ($entry['oneCheck'] == 1) {
                    $taskComplete++;
                }
                if ($entry['twoCheck'] == 1) {
                    $taskComplete++;
                }
                if ($entry['threeCheck'] == 1) {
                    $taskComplete++;
                }
                if ($entry['fourCheck'] == 1) {
                    $taskComplete++;
                }
                if ($entry['fiveCheck'] == 1) {
                    $taskComplete++;
                }
            }
        }
        
        //Display Text
        echo '<p style="text-align:left;"><b>Habit Score: </b>';
        countTasks($habitComplete, $habitCount);
        echo '<br><b>Habit Percentage: </b>';
        $percent = calculatePercent($habitComplete, $habitCount);
        echo $percent . '%<br><br>';
        echo '<b>Task Score: </b>';
        countTasks($taskComplete, $tasks);
        echo '<br><b>Task Percentage: </b>';
        $percent = calculatePercent($taskComplete, $tasks);
        echo $percent . '%<br><br>';
        checkGood($phy,"Physical Health");
        checkGood($men,"Mental Health");
        echo '<br>';
        checkGood($pro,"Productivity");
        checkGood($moo,"Mood");
        echo '</p>';
        
        
        echo '</div>';
    
    } else {
        echo '<p><i>You need at least 7 days of journal entries to use this feature.</i></p>';
    }
    
    if (count($entries) > 29) {
        echo '<div class="journalEntry">';
        echo '<h1>Last Thirty Entries</h1>';
        
        $count = 1;
        $num = 30;
        $totaltasks = 0;
        $doneTasks = 0;
        $doneHabits = 0;
        $phy = 0;
        $men = 0;
        $pro = 0;
        $moo = 0;
        
        foreach ($entries as $entry) {
            $phy += $entry['physicalHealth'];
            $men += $entry['mentalHealth'];
            $pro += $entry['productivity'];
            $moo += $entry['mood'];
            $count++;
            if ($count == $num) {
                break;
            }
        }
        
        $phy = round($phy / $num, 1);
        $men = round($men / $num, 1);
        $pro = round($pro / $num, 1);
        $moo = round($moo / $num, 1);
        
        //Calculate Habit Total
        $habitCount = $num * 2;
        if (count($entries) == $num) {
            $habitCount - 2;
        }
        
        
        //Count Finished Habits
        $habitComplete = 0;
        foreach ($entries as $entry) {
            if ($entry['habitOneCheck'] == 1) {
                $habitComplete++;
            }
            if ($entry['habitTwoCheck'] == 1) {
                $habitComplete++;
            }
            
        }
        
        //Calculate Tasks
        $tasks = 0;
        $taskComplete = 0;
        foreach ($entries as $entry) {
            if (date('w', strtotime($entry['date'])) == 6 || date('w', strtotime($entry['date'])) == 7) {
                $tasks = $tasks + 3;
                if ($entry['oneCheck'] == 1) {
                    $taskComplete++;
                }
                if ($entry['twoCheck'] == 1) {
                    $taskComplete++;
                }
                if ($entry['threeCheck'] == 1) {
                    $taskComplete++;
                }
            } else {
                $tasks = $tasks + 5;
                if ($entry['oneCheck'] == 1) {
                    $taskComplete++;
                }
                if ($entry['twoCheck'] == 1) {
                    $taskComplete++;
                }
                if ($entry['threeCheck'] == 1) {
                    $taskComplete++;
                }
                if ($entry['fourCheck'] == 1) {
                    $taskComplete++;
                }
                if ($entry['fiveCheck'] == 1) {
                    $taskComplete++;
                }
            }
        }
        
        //Display Text
        echo '<p style="text-align:left;"><b>Habit Score: </b>';
        countTasks($habitComplete, $habitCount);
        echo '<br><b>Habit Percentage: </b>';
        $percent = calculatePercent($habitComplete, $habitCount);
        echo $percent . '%<br><br>';
        echo '<b>Task Score: </b>';
        countTasks($taskComplete, $tasks);
        echo '<br><b>Task Percentage: </b>';
        $percent = calculatePercent($taskComplete, $tasks);
        echo $percent . '%<br><br>';
        checkGood($phy,"Physical Health");
        checkGood($men,"Mental Health");
        echo '<br>';
        checkGood($pro,"Productivity");
        checkGood($moo,"Mood");
        echo '</p>';
        
        
        echo '</div>';
    
    }
    
    if (count($entries) > 89) {
        echo '<div class="journalEntry">';
        echo '<h1>Last Ninety Entries</h1>';
        
        $count = 1;
        $num = 90;
        $totaltasks = 0;
        $doneTasks = 0;
        $doneHabits = 0;
        $phy = 0;
        $men = 0;
        $pro = 0;
        $moo = 0;
        
        foreach ($entries as $entry) {
            $phy += $entry['physicalHealth'];
            $men += $entry['mentalHealth'];
            $pro += $entry['productivity'];
            $moo += $entry['mood'];
            $count++;
            if ($count == $num) {
                break;
            }
        }
        
        $phy = round($phy / $num, 1);
        $men = round($men / $num, 1);
        $pro = round($pro / $num, 1);
        $moo = round($moo / $num, 1);
        
        //Calculate Habit Total
        $habitCount = $num * 2;
        if (count($entries) == $num) {
            $habitCount - 2;
        }
        
        
        //Count Finished Habits
        $habitComplete = 0;
        foreach ($entries as $entry) {
            if ($entry['habitOneCheck'] == 1) {
                $habitComplete++;
            }
            if ($entry['habitTwoCheck'] == 1) {
                $habitComplete++;
            }
            
        }
        
        //Calculate Tasks
        $tasks = 0;
        $taskComplete = 0;
        foreach ($entries as $entry) {
            if (date('w', strtotime($entry['date'])) == 6 || date('w', strtotime($entry['date'])) == 7) {
                $tasks = $tasks + 3;
                if ($entry['oneCheck'] == 1) {
                    $taskComplete++;
                }
                if ($entry['twoCheck'] == 1) {
                    $taskComplete++;
                }
                if ($entry['threeCheck'] == 1) {
                    $taskComplete++;
                }
            } else {
                $tasks = $tasks + 5;
                if ($entry['oneCheck'] == 1) {
                    $taskComplete++;
                }
                if ($entry['twoCheck'] == 1) {
                    $taskComplete++;
                }
                if ($entry['threeCheck'] == 1) {
                    $taskComplete++;
                }
                if ($entry['fourCheck'] == 1) {
                    $taskComplete++;
                }
                if ($entry['fiveCheck'] == 1) {
                    $taskComplete++;
                }
            }
        }
        
        //Display Text
        echo '<p style="text-align:left;"><b>Habit Score: </b>';
        countTasks($habitComplete, $habitCount);
        echo '<br><b>Habit Percentage: </b>';
        $percent = calculatePercent($habitComplete, $habitCount);
        echo $percent . '%<br><br>';
        echo '<b>Task Score: </b>';
        countTasks($taskComplete, $tasks);
        echo '<br><b>Task Percentage: </b>';
        $percent = calculatePercent($taskComplete, $tasks);
        echo $percent . '%<br><br>';
        checkGood($phy,"Physical Health");
        checkGood($men,"Mental Health");
        echo '<br>';
        checkGood($pro,"Productivity");
        checkGood($moo,"Mood");
        echo '</p>';
        
        
        echo '</div>';
    
    }
    
    if (count($entries) > 364) {
        echo '<div class="journalEntry">';
        echo '<h1>Last Three Hundred Sixty Five Entries</h1>';
        
        $count = 1;
        $num = 365;
        $totaltasks = 0;
        $doneTasks = 0;
        $doneHabits = 0;
        $phy = 0;
        $men = 0;
        $pro = 0;
        $moo = 0;
        
        foreach ($entries as $entry) {
            $phy += $entry['physicalHealth'];
            $men += $entry['mentalHealth'];
            $pro += $entry['productivity'];
            $moo += $entry['mood'];
            $count++;
            if ($count == $num) {
                break;
            }
        }
        
        $phy = round($phy / $num, 1);
        $men = round($men / $num, 1);
        $pro = round($pro / $num, 1);
        $moo = round($moo / $num, 1);
        
        //Calculate Habit Total
        $habitCount = $num * 2;
        if (count($entries) == $num) {
            $habitCount - 2;
        }
        
        
        //Count Finished Habits
        $habitComplete = 0;
        foreach ($entries as $entry) {
            if ($entry['habitOneCheck'] == 1) {
                $habitComplete++;
            }
            if ($entry['habitTwoCheck'] == 1) {
                $habitComplete++;
            }
            
        }
        
        //Calculate Tasks
        $tasks = 0;
        $taskComplete = 0;
        foreach ($entries as $entry) {
            if (date('w', strtotime($entry['date'])) == 6 || date('w', strtotime($entry['date'])) == 7) {
                $tasks = $tasks + 3;
                if ($entry['oneCheck'] == 1) {
                    $taskComplete++;
                }
                if ($entry['twoCheck'] == 1) {
                    $taskComplete++;
                }
                if ($entry['threeCheck'] == 1) {
                    $taskComplete++;
                }
            } else {
                $tasks = $tasks + 5;
                if ($entry['oneCheck'] == 1) {
                    $taskComplete++;
                }
                if ($entry['twoCheck'] == 1) {
                    $taskComplete++;
                }
                if ($entry['threeCheck'] == 1) {
                    $taskComplete++;
                }
                if ($entry['fourCheck'] == 1) {
                    $taskComplete++;
                }
                if ($entry['fiveCheck'] == 1) {
                    $taskComplete++;
                }
            }
        }
        
        //Display Text
        echo '<p style="text-align:left;"><b>Habit Score: </b>';
        countTasks($habitComplete, $habitCount);
        echo '<br><b>Habit Percentage: </b>';
        $percent = calculatePercent($habitComplete, $habitCount);
        echo $percent . '%<br><br>';
        echo '<b>Task Score: </b>';
        countTasks($taskComplete, $tasks);
        echo '<br><b>Task Percentage: </b>';
        $percent = calculatePercent($taskComplete, $tasks);
        echo $percent . '%<br><br>';
        checkGood($phy,"Physical Health");
        checkGood($men,"Mental Health");
        echo '<br>';
        checkGood($pro,"Productivity");
        checkGood($moo,"Mood");
        echo '</p>';
        
        
        echo '</div>';
    
    }
} else if ($type == "generic") {
    //Last 7 Days
    if (count($entries) > 6) {
        echo '<div class="journalEntry">';
        echo '<h1>Last Seven Entries</h1>';
        $count = 1;
        $num = 7;
        $phy = 0;
        $men = 0;
        $emo = 0;
        $spi = 0;
        $soc = 0;
        $eat = 0;
        $exe = 0;
        $sle = 0;
        $wat = 0;
        foreach ($entries as $entry) {
            $phy += $entry['physicalHealth'];
            $men += $entry['mentalHealth'];
            $emo += $entry['emotionalHealth'];
            $spi += $entry['spiritualHealth'];
            $soc += $entry['socialHealth'];
            $eat += $entry['eating'];
            $exe += $entry['excercise'];
            $sle += $entry['sleeping'];
            $wat += $entry['water'];
            $count++;
            if ($count == $num) {
                break;
            }
        }
        
        $phy = round($phy / $num, 1);
        $men = round($men / $num, 1);
        $emo = round($emo / $num, 1);
        $spi = round($spi / $num, 1);
        $soc = round($soc / $num, 1);
        $eat = round($eat / $num, 1);
        $exe = round($exe / $num, 1);
        $sle = round($sle / $num, 1);
        $wat = round($wat / $num, 1);
        
        echo '<p style="text-align:left;">';
        checkBad($phy,"Physical Health");
        checkBad($men, "Mental Health");
        checkBad($emo,"Emotional Health");
        checkBad($spi,"Spiritual Health");
        checkBad($soc,"Social Health");
        echo '<br>';
        checkQuantity($eat,"Food Wellness");
        checkQuantity($exe,"Exercise Amount");
        checkQuantity($sle,"Sleep Amount");
        checkQuantity($wat,"Water Consumption");

        echo '</div>';
    } else {
        echo '<p><i>You need at least 7 days of journal entries to use this feature.</i></p>';
    }
    
    //Last 30 Days
    if (count($entries) > 29) {
        echo '<div class="journalEntry">';
        echo '<h1>Last Seven Entries</h1>';
        $count = 1;
        $num = 30;
        $phy = 0;
        $men = 0;
        $emo = 0;
        $spi = 0;
        $soc = 0;
        $eat = 0;
        $exe = 0;
        $sle = 0;
        $wat = 0;
        foreach ($entries as $entry) {
            $phy += $entry['physicalHealth'];
            $men += $entry['mentalHealth'];
            $emo += $entry['emotionalHealth'];
            $spi += $entry['spiritualHealth'];
            $soc += $entry['socialHealth'];
            $eat += $entry['eating'];
            $exe += $entry['excercise'];
            $sle += $entry['sleeping'];
            $wat += $entry['water'];
            $count++;
            if ($count == $num) {
                break;
            }
        }
        
        $phy = round($phy / $num, 1);
        $men = round($men / $num, 1);
        $emo = round($emo / $num, 1);
        $spi = round($spi / $num, 1);
        $soc = round($soc / $num, 1);
        $eat = round($eat / $num, 1);
        $exe = round($exe / $num, 1);
        $sle = round($sle / $num, 1);
        $wat = round($wat / $num, 1);
        
        echo '<p style="text-align:left;">';
        checkBad($phy,"Physical Health");
        checkBad($men, "Mental Health");
        checkBad($emo,"Emotional Health");
        checkBad($spi,"Spiritual Health");
        checkBad($soc,"Social Health");
        echo '<br>';
        checkQuantity($eat,"Food Wellness");
        checkQuantity($exe,"Exercise Amount");
        checkQuantity($sle,"Sleep Amount");
        checkQuantity($wat,"Water Consumption");

        echo '</div>';
    }
    
    //Last 90 Days
    if (count($entries) > 89) {
        echo '<div class="journalEntry">';
        echo '<h1>Last Seven Entries</h1>';
        $count = 1;
        $num = 90;
        $phy = 0;
        $men = 0;
        $emo = 0;
        $spi = 0;
        $soc = 0;
        $eat = 0;
        $exe = 0;
        $sle = 0;
        $wat = 0;
        foreach ($entries as $entry) {
            $phy += $entry['physicalHealth'];
            $men += $entry['mentalHealth'];
            $emo += $entry['emotionalHealth'];
            $spi += $entry['spiritualHealth'];
            $soc += $entry['socialHealth'];
            $eat += $entry['eating'];
            $exe += $entry['excercise'];
            $sle += $entry['sleeping'];
            $wat += $entry['water'];
            $count++;
            if ($count == $num) {
                break;
            }
        }
        
        $phy = round($phy / $num, 1);
        $men = round($men / $num, 1);
        $emo = round($emo / $num, 1);
        $spi = round($spi / $num, 1);
        $soc = round($soc / $num, 1);
        $eat = round($eat / $num, 1);
        $exe = round($exe / $num, 1);
        $sle = round($sle / $num, 1);
        $wat = round($wat / $num, 1);
        
        echo '<p style="text-align:left;">';
        checkBad($phy,"Physical Health");
        checkBad($men, "Mental Health");
        checkBad($emo,"Emotional Health");
        checkBad($spi,"Spiritual Health");
        checkBad($soc,"Social Health");
        echo '<br>';
        checkQuantity($eat,"Food Wellness");
        checkQuantity($exe,"Exercise Amount");
        checkQuantity($sle,"Sleep Amount");
        checkQuantity($wat,"Water Consumption");

        echo '</div>';
    }
    
    //Last 365 Days
    if (count($entries) > 364) {
        echo '<div class="journalEntry">';
        echo '<h1>Last Seven Entries</h1>';
        $count = 1;
        $num = 365;
        $phy = 0;
        $men = 0;
        $emo = 0;
        $spi = 0;
        $soc = 0;
        $eat = 0;
        $exe = 0;
        $sle = 0;
        $wat = 0;
        foreach ($entries as $entry) {
            $phy += $entry['physicalHealth'];
            $men += $entry['mentalHealth'];
            $emo += $entry['emotionalHealth'];
            $spi += $entry['spiritualHealth'];
            $soc += $entry['socialHealth'];
            $eat += $entry['eating'];
            $exe += $entry['excercise'];
            $sle += $entry['sleeping'];
            $wat += $entry['water'];
            $count++;
            if ($count == $num) {
                break;
            }
        }
        
        $phy = round($phy / $num, 1);
        $men = round($men / $num, 1);
        $emo = round($emo / $num, 1);
        $spi = round($spi / $num, 1);
        $soc = round($soc / $num, 1);
        $eat = round($eat / $num, 1);
        $exe = round($exe / $num, 1);
        $sle = round($sle / $num, 1);
        $wat = round($wat / $num, 1);
        
        echo '<p style="text-align:left;">';
        checkBad($phy,"Physical Health");
        checkBad($men, "Mental Health");
        checkBad($emo,"Emotional Health");
        checkBad($spi,"Spiritual Health");
        checkBad($soc,"Social Health");
        echo '<br>';
        checkQuantity($eat,"Food Wellness");
        checkQuantity($exe,"Exercise Amount");
        checkQuantity($sle,"Sleep Amount");
        checkQuantity($wat,"Water Consumption");

        echo '</div>';
    }
    
    
    
    
    
    
}





