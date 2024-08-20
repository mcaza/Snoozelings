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
        echo '<li>' . $word . ' ' . $times . '/7 Days</li>';
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
            if ($count == 7) {
                break;
            }
        }
        
        $anx = round($anx / 7, 1);
        $dep = round($dep / 7, 1);
        $str = round($str / 7, 1);
        $hea = round($hea / 7, 1);
        $pro = round($pro / 7, 1);
        $sle = round($sle / 7, 1);
        $wat = round($wat / 7, 1);
        
        
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
        countTimes("Ate a Meal","productive",7,$entries);
        countTimes("Showered/Bathed","productive",7,$entries);
        countTimes("Brushed Teeth","productive",7,$entries);
        countTimes("Did a Chore","productive",7,$entries);
        countTimes("Went for a Walk","productive",7,$entries);
        countTimes("Did Some Excercise","productive",7,$entries);
        countTimes("Talked To Friends/Family","productive",7,$entries);
        countTimes("Made Some Art","productive",7,$entries);
        countTimes("Went to Therapy","productive",7,$entries);
        echo '</ul>';
        echo '<p style="text-align:left;"><b>Bad Habits: </b></p>';
        echo '<ul style="text-align:left;">';
        countTimes("Doomscrolled","destructive",7,$entries);
        countTimes("Lashed Out at Others","destructive",7,$entries);
        countTimes("Isolated Myself","destructive",7,$entries);
        countTimes("Stayed Home from School/Work","destructive",7,$entries);
        countTimes("Spent Recklessly","destructive",7,$entries);
        countTimes("Picked at my Body","destructive",7,$entries);
        countTimes("Hurt Myself","destructive",7,$entries);
        echo '/<ul>';
        echo '</div>';
        
    } else {
        echo '<p><i>You need at least 7 days of journal entries to use this feature.</i></p>';
    }
    
    //Last 30 Days
    if (count($entries) > 29) {
        echo '<div class="journalEntry">';
        echo '<h1>Last Thirty Entries</h1>';
        $count = 1;
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
            if ($count == 30) {
                break;
            }
        }
        
        $anx = round($anx / 30, 1);
        $dep = round($dep / 30, 1);
        $str = round($str / 30, 1);
        $hea = round($hea / 30, 1);
        $pro = round($pro / 30, 1);
        $sle = round($sle / 30, 1);
        $wat = round($wat / 30, 1);
        
        
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
        countTimes("Ate a Meal","productive",30,$entries);
        countTimes("Showered/Bathed","productive",30,$entries);
        countTimes("Brushed Teeth","productive",30,$entries);
        countTimes("Did a Chore","productive",30,$entries);
        countTimes("Went for a Walk","productive",30,$entries);
        countTimes("Did Some Excercise","productive",30,$entries);
        countTimes("Talked To Friends/Family","productive",30,$entries);
        countTimes("Made Some Art","productive",30,$entries);
        countTimes("Went to Therapy","productive",30,$entries);
        echo '</ul>';
        echo '<p style="text-align:left;"><b>Bad Habits: </b></p>';
        echo '<ul style="text-align:left;">';
        countTimes("Doomscrolled","destructive",30,$entries);
        countTimes("Lashed Out at Others","destructive",30,$entries);
        countTimes("Isolated Myself","destructive",30,$entries);
        countTimes("Stayed Home from School/Work","destructive",30,$entries);
        countTimes("Spent Recklessly","destructive",30,$entries);
        countTimes("Picked at my Body","destructive",30,$entries);
        countTimes("Hurt Myself","destructive",30,$entries);
        echo '</ul>';
        echo '</div>';
        
    }
    
    //Last 90 Days
    if (count($entries) > 89) {
        echo '<div class="journalEntry">';
        echo '<h1>Last Ninety Entries</h1>';
        $count = 1;
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
            if ($count == 90) {
                break;
            }
        }
        
        $anx = round($anx / 90, 1);
        $dep = round($dep / 90, 1);
        $str = round($str / 90, 1);
        $hea = round($hea / 90, 1);
        $pro = round($pro / 90, 1);
        $sle = round($sle / 90, 1);
        $wat = round($wat / 90, 1);
        
        
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
        countTimes("Ate a Meal","productive",90,$entries);
        countTimes("Showered/Bathed","productive",90,$entries);
        countTimes("Brushed Teeth","productive",90,$entries);
        countTimes("Did a Chore","productive",90,$entries);
        countTimes("Went for a Walk","productive",90,$entries);
        countTimes("Did Some Excercise","productive",90,$entries);
        countTimes("Talked To Friends/Family","productive",90,$entries);
        countTimes("Made Some Art","productive",90,$entries);
        countTimes("Went to Therapy","productive",90,$entries);
        echo '</ul>';
        echo '<p style="text-align:left;"><b>Bad Habits: </b></p>';
        echo '<ul style="text-align:left;">';
        countTimes("Doomscrolled","destructive",90,$entries);
        countTimes("Lashed Out at Others","destructive",90,$entries);
        countTimes("Isolated Myself","destructive",90,$entries);
        countTimes("Stayed Home from School/Work","destructive",90,$entries);
        countTimes("Spent Recklessly","destructive",90,$entries);
        countTimes("Picked at my Body","destructive",90,$entries);
        countTimes("Hurt Myself","destructive",90,$entries);
        echo '</ul>';
        echo '</div>';
        
    }
    
    //Last 30 Days
    if (count($entries) > 364) {
        echo '<div class="journalEntry">';
        echo '<h1>Last Three Hundred Sixty Five Entries</h1>';
        $count = 1;
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
            if ($count == 365) {
                break;
            }
        }
        
        $anx = round($anx / 365, 1);
        $dep = round($dep / 365, 1);
        $str = round($str / 365, 1);
        $hea = round($hea / 365, 1);
        $pro = round($pro / 365, 1);
        $sle = round($sle / 365, 1);
        $wat = round($wat / 365, 1);
        
        
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
        countTimes("Ate a Meal","productive",365,$entries);
        countTimes("Showered/Bathed","productive",365,$entries);
        countTimes("Brushed Teeth","productive",365,$entries);
        countTimes("Did a Chore","productive",365,$entries);
        countTimes("Went for a Walk","productive",365,$entries);
        countTimes("Did Some Excercise","productive",365,$entries);
        countTimes("Talked To Friends/Family","productive",365,$entries);
        countTimes("Made Some Art","productive",365,$entries);
        countTimes("Went to Therapy","productive",365,$entries);
        echo '</ul>';
        echo '<p style="text-align:left;"><b>Bad Habits: </b></p>';
        echo '<ul style="text-align:left;">';
        countTimes("Doomscrolled","destructive",365,$entries);
        countTimes("Lashed Out at Others","destructive",365,$entries);
        countTimes("Isolated Myself","destructive",365,$entries);
        countTimes("Stayed Home from School/Work","destructive",365,$entries);
        countTimes("Spent Recklessly","destructive",365,$entries);
        countTimes("Picked at my Body","destructive",365,$entries);
        countTimes("Hurt Myself","destructive",365,$entries);
        echo '</ul>';
        echo '</div>';
        
    }
    
} else if ($type == "pain") {
    
    //Last 7 Days
    if (count($entries) > 6) {
        echo '<div class="journalEntry">';
        echo '<h1>Last Seven Entries</h1>';
        $count = 1;
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
            if ($count == 7) {
                break;
            }
        }
        
        $low = round($low / 7, 1);
        $hig = round($hig / 7, 1);
        $avg = round($avg / 7, 1);
        $phy = round($phy / 7, 1);
        $sle = round($sle / 7, 1);
        $wat = round($wat / 7, 1);
        
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
        countDescriptions("Swollen","painDescription",7,$entries);
        countDescriptions("Throbbing","painDescription",7,$entries);
        countDescriptions("Aching","painDescription",7,$entries);
        countDescriptions("Numb","painDescription",7,$entries);
        countDescriptions("Burning","painDescription",7,$entries);
        countDescriptions("Cramping","painDescription",7,$entries);
        countDescriptions("Tight","painDescription",7,$entries);
        countDescriptions("Tender","painDescription",7,$entries);
        countDescriptions("Shooting","painDescription",7,$entries);
        echo '</ul>';
        echo '<p style="text-align:left;"><b>Other Common Symptoms: </b></p>';
        echo '<ul style="text-align:left;">';
        countDescriptions("Exhaustion","otherSymptoms",7,$entries);
        countDescriptions("Nausea","otherSymptoms",7,$entries);
        countDescriptions("Vomiting","otherSymptoms",7,$entries);
        countDescriptions("Bad Poops","otherSymptoms",7,$entries);
        countDescriptions("Sore Throat","otherSymptoms",7,$entries);
        countDescriptions("Insomnia","otherSymptoms",7,$entries);
        countDescriptions("Bloating","otherSymptoms",7,$entries);
        countDescriptions("Fever","otherSymptoms",7,$entries);
        countDescriptions("Chills","otherSymptoms",7,$entries);
        countDescriptions("Congestion","otherSymptoms",7,$entries);
        countDescriptions("Muscle Spasms","otherSymptoms",7,$entries);
        countDescriptions("Brain Fog","otherSymptoms",7,$entries);
        countDescriptions("Bad Mood","otherSymptoms",7,$entries);
        countDescriptions("Vertigo","otherSymptoms",7,$entries);
        echo '</ul>';
        echo '</div>';
    } else {
        echo '<p><i>You need at least 7 days of journal entries to use this feature.</i></p>';
    }
}