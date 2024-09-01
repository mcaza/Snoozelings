<?php

$userId = $_SESSION['user_id'];


//Get Journal Type
//Check for Journals
$query = 'SELECT * FROM journals WHERE user_id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$type = $result['type'];

//Check For Open Entries
    if ($type === "mentalHealth") {
        $query = 'SELECT * FROM mentalHealthEntries WHERE user_id = :id ORDER BY id DESC LIMIT 1';
    } else if ($type === "pain") {
        $query = 'SELECT * FROM chronicPainEntries WHERE user_id = :id ORDER BY id DESC LIMIT 1';  
    } else if ($type === "productivity") {
        $query = 'SELECT * FROM productivityEntries WHERE user_id = :id ORDER BY id DESC LIMIT 1';  
    }
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$latestEntry = $stmt->fetch(PDO::FETCH_ASSOC);

 if (!$latestEntry || $latestEntry['closed'] == "1") {
//Back to Pack Arrows
echo '<div class="leftRightButtons">';
echo '<a href="journal"><<</a>';
echo '</div>';
     
    //Check Type of Journal
    if ($type === "mentalHealth") {
        echo "<form method='POST' action='includes/entryMentalHealth.inc.php' onsubmit=\"return confirm('Please confirm there is no identifying information');\">";    
        
        //Rate Anxiety
        echo '<label class="form" style="margin-top: 1rem;">Rate Your Anxiety:</label><br>';
        //Buttons
        echo '<div class="radioRow">';
        echo '<div class="radioBox" ><input type="radio" name="anxiety" value="1" id="anx1" required><label for="anx1">1</label></div>';
        echo '<div class="radioBox"><input type="radio" name="anxiety" value="2" id="anx2"><label for="anx2">2</label></div>';
        echo '<div class="radioBox"><input type="radio" name="anxiety" value="3" id="anx3"><label for="anx3">3</label></div>';
        echo '<div class="radioBox"><input type="radio" name="anxiety" value="4" id="anx4"><label for="anx4">4</label></div>';
        echo '<div class="radioBox"><input type="radio" name="anxiety" value="5" id="anx5"><label for="anx5">5</label></div>';
        echo '<div class="radioBox"><input type="radio" name="anxiety" value="6" id="anx6"><label for="anx6">6</label></div>';
        echo '<div class="radioBox"><input type="radio" name="anxiety" value="7" id="anx7"><label for="anx7">7</label></div>';
        echo '<div class="radioBox"><input type="radio" name="anxiety" value="8" id="anx8"><label for="anx8">8</label></div>';
        echo '<div class="radioBox"><input type="radio" name="anxiety" value="9" id="anx9"><label for="anx9">9</label></div>';
        echo '<div class="radioBox"><input type="radio" name="anxiety" value="10" id="anx10"><label for="anx10">10</label></div>';
        echo '</div>';
        echo '<p><i>Low to High</i></p>';
        
        //Rate Depression
        echo '<label class="form" style="margin-top: 2rem;">Rate Your Depression:</label><br>';
        //Buttons
        echo '<div class="radioRow">';
        echo '<div class="radioBox" ><input type="radio" name="depression" value="1" required id="dep1"><label for="dep1">1</label></div>';
        echo '<div class="radioBox"><input type="radio" name="depression" value="2" id="dep2"><label for="dep2">2</label></div>';
        echo '<div class="radioBox"><input type="radio" name="depression" value="3" id="dep3"><label for="dep3">3</label></div>';
        echo '<div class="radioBox"><input type="radio" name="depression" value="4" id="dep4"><label for="dep4">4</label></div>';
        echo '<div class="radioBox"><input type="radio" name="depression" value="5" id="dep5"><label for="dep5">5</label></div>';
        echo '<div class="radioBox"><input type="radio" name="depression" value="6" id="dep6"><label for="dep6">6</label></div>';
        echo '<div class="radioBox"><input type="radio" name="depression" value="7" id="dep7"><label for="dep7">7</label></div>';
        echo '<div class="radioBox"><input type="radio" name="depression" value="8" id="dep8"><label for="dep8">8</label></div>';
        echo '<div class="radioBox"><input type="radio" name="depression" value="9" id="dep9"><label for="dep9">9</label></div>';
        echo '<div class="radioBox"><input type="radio" name="depression" value="10" id="dep10"><label for="dep10">10</label></div>';
        echo '</div>';
        echo '<p><i>Low to High</i></p>';
        
        //Rate Stress
        echo '<label class="form" style="margin-top: 2rem;">Rate Your Stress:</label><br>';
        //Buttons
        echo '<div class="radioRow">';
        echo '<div class="radioBox" ><input type="radio" name="stress" value="1" required id="str1"><label for="str1">1</label></div>';
        echo '<div class="radioBox"><input type="radio" name="stress" value="2" id="str2"><label for="str2">2</label></div>';
        echo '<div class="radioBox"><input type="radio" name="stress" value="3" id="str3"><label for="str3">3</label></div>';
        echo '<div class="radioBox"><input type="radio" name="stress" value="4" id="str4"><label for="str4">4</label></div>';
        echo '<div class="radioBox"><input type="radio" name="stress" value="5" id="str5"><label for="str5">5</label></div>';
        echo '<div class="radioBox"><input type="radio" name="stress" value="6" id="str6"><label for="str6">6</label></div>';
        echo '<div class="radioBox"><input type="radio" name="stress" value="7" id="str7"><label for="str7">7</label></div>';
        echo '<div class="radioBox"><input type="radio" name="stress" value="8" id="str8"><label for="str8">8</label></div>';
        echo '<div class="radioBox"><input type="radio" name="stress" value="9" id="str9"><label for="str9">9</label></div>';
        echo '<div class="radioBox"><input type="radio" name="stress" value="10" id="str10"><label for="str10">10</label></div>';
        echo '</div>';
        echo '<p><i>Low to High</i></p>';
        
        //Rate Productivity
        echo '<label class="form" style="margin-top: 2rem;">Rate Your Productivity:</label><br>';
        //Buttons
        echo '<div class="radioRow">';
        echo '<div class="radioBox"><input type="radio" name="productivity" value="1" required id="pro1"><label for="pro1">1</label></div>';
        echo '<div class="radioBox"><input type="radio" name="productivity" value="2" id="pro2"><label for="pro2">2</label></div>';
        echo '<div class="radioBox"><input type="radio" name="productivity" value="3" id="pro3"><label for="pro3">3</label></div>';
        echo '<div class="radioBox"><input type="radio" name="productivity" value="4" id="pro4"><label for="pro4">4</label></div>';
        echo '<div class="radioBox"><input type="radio" name="productivity" value="5" id="pro5"><label for="pro5">5</label></div>';
        echo '<div class="radioBox"><input type="radio" name="productivity" value="6" id="pro6"><label for="pro6">6</label></div>';
        echo '<div class="radioBox"><input type="radio" name="productivity" value="7" id="pro7"><label for="pro7">7</label></div>';
        echo '<div class="radioBox"><input type="radio" name="productivity" value="8" id="pro8"><label for="pro8">8</label></div>';
        echo '<div class="radioBox"><input type="radio" name="productivity" value="9" id="pro9"><label for="pro9">9</label></div>';
        echo '<div class="radioBox"><input type="radio" name="productivity" value="10" id="pro10"><label for="pro10">10</label></div>';
        echo '</div>';
        echo '<p><i>Low to High</i></p>';
        
        //Rate Physical Health
        echo '<label class="form" style="margin-top: 2rem;">Rate Your Physical Health:</label><br>';
        //Buttons
        echo '<div class="radioRow">';
        echo '<div class="radioBox" ><input type="radio" name="health" value="1" required id="hea1"><label for="hea1">1</label></div>';
        echo '<div class="radioBox"><input type="radio" name="health" value="2" id="hea2"><label for="hea2">2</label></div>';
        echo '<div class="radioBox"><input type="radio" name="health" value="3" id="hea3"><label for="hea3">3</label></div>';
        echo '<div class="radioBox"><input type="radio" name="health" value="4" id="hea4"><label for="hea4">4</label></div>';
        echo '<div class="radioBox"><input type="radio" name="health" value="5" id="hea5"><label for="hea5">5</label></div>';
        echo '<div class="radioBox"><input type="radio" name="health" value="6" id="hea6"><label for="hea6">6</label></div>';
        echo '<div class="radioBox"><input type="radio" name="health" value="7" id="hea7"><label for="hea7">7</label></div>';
        echo '<div class="radioBox"><input type="radio" name="health" value="8" id="hea8"><label for="hea8">8</label></div>';
        echo '<div class="radioBox"><input type="radio" name="health" value="9" id="hea9"><label for="hea9">9</label></div>';
        echo '<div class="radioBox"><input type="radio" name="health" value="10" id="hea10"><label for="hea10">10</label></div>';
        echo '</div>';
        echo '<p><i>Bad to Excellent</i></p>';
        
        //Rate Sleep
        echo '<label class="form" style="margin-top: 2rem;">Rate Your Sleep:</label><br>';
        //Buttons
        echo '<div class="radioRow">';
        echo '<div class="radioBox" ><input type="radio" name="sleep" value="1" required id="sle1"><label for="sle1">1</label></div>';
        echo '<div class="radioBox"><input type="radio" name="sleep" value="2" id="sle2"><label for="sle2">2</label></div>';
        echo '<div class="radioBox"><input type="radio" name="sleep" value="3" id="sle3"><label for="sle3">3</label></div>';
        echo '<div class="radioBox"><input type="radio" name="sleep" value="4" id="sle4"><label for="sle4">4</label></div>';
        echo '<div class="radioBox"><input type="radio" name="sleep" value="5" id="sle5"><label for="sle5">5</label></div>';
        echo '<div class="radioBox"><input type="radio" name="sleep" value="6" id="sle6"><label for="sle6">6</label></div>';
        echo '<div class="radioBox"><input type="radio" name="sleep" value="7" id="sle7"><label for="sle7">7</label></div>';
        echo '<div class="radioBox"><input type="radio" name="sleep" value="8" id="sle8"><label for="sle8">8</label></div>';
        echo '<div class="radioBox"><input type="radio" name="sleep" value="9" id="sle9"><label for="sle9">9</label></div>';
        echo '<div class="radioBox"><input type="radio" name="sleep" value="10" id="sle10"><label for="sle10">10</label></div>';
        echo '</div>';
        echo '<p><i>No Sleep to Amazing Sleep</i></p>';
        
        //Rate Water Intake
        echo '<label class="form" style="margin-top: 2rem;">Rate Your Water Intake:</label><br>';
        //Buttons
        echo '<div class="radioRow">';
        echo '<div class="radioBox" ><input type="radio" name="water" value="1" required id="wat1"><label for="wat1">1</label></div>';
        echo '<div class="radioBox"><input type="radio" name="water" value="2" id="wat2"><label for="wat2">2</label></div>';
        echo '<div class="radioBox"><input type="radio" name="water" value="3" id="wat3"><label for="wat3">3</label></div>';
        echo '<div class="radioBox"><input type="radio" name="water" value="4" id="wat4"><label for="wat4">4</label></div>';
        echo '<div class="radioBox"><input type="radio" name="water" value="5" id="wat5"><label for="wat5">5</label></div>';
        echo '<div class="radioBox"><input type="radio" name="water" value="6" id="wat6"><label for="wat6">6</label></div>';
        echo '<div class="radioBox"><input type="radio" name="water" value="7" id="wat7"><label for="wat7">7</label></div>';
        echo '<div class="radioBox"><input type="radio" name="water" value="8" id="wat8"><label for="wat8">8</label></div>';
        echo '<div class="radioBox"><input type="radio" name="water" value="9" id="wat9"><label for="wat9">9</label></div>';
        echo '<div class="radioBox"><input type="radio" name="water" value="10" id="wat10"><label for="wat10">10</label></div>';
        echo '</div>';
        echo '<p><i>No Water to Lots of Water</i></p>';
        
        //List Good Behaviors
        echo '<label class="form" style="margin-top: 2rem;">Did you do any of the following things:</label><br>';
        echo '<p><i>Check All That Apply</i></p>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="eat" value="eat" id="eat"><label for="eat">Eaten a Meal</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="washed" value="washed" id="washed"><label for="washed">Showered or Bathed</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="teeth" value="teeth" id="teeth"><label for="teeth">Brushed Your Teeth</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="chore" value="chore" id="chore"><label for="chore">Done a Chore</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="walk" value="walk" id="walk"><label for="walk">Went for a Walk</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="excercise" value="excercise" id="excercise"><label for="excercise">Had Exercise</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="talk" value="talk" id="talk"><label for="talk" i>Talked to Friends/Family</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="creative" value="creative" id="creative"><label for="creative">Made Art or Wrote</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="therapy" value="therapy" id="therapy"><label for="therapy">Went to Therapy</label></div>';
        
        //List Bad Behaviors
        echo '<label class="form" style="margin-top: 2rem;">Did you do any of the following things:</label><br>';
        echo '<p><i>Check All That Apply</i></p>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="doomscroll" value="doomscroll" id="doomscroll"><label for="doomscroll">Doomscroll / Too Much Social Media</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="angry" value="angry" id="angry"><label for="angry">Lash Out at Others</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="alone" value="alone" id="alone"><label for="alone">Isolate Yourself</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="skip" value="skip" id="skip"><label for="skip">Stay Home From School/Work</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="shop" value="shop" id="shop"><label for="shop">Stress Shop / Buy Things you Regret</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="damage" value="damage" id="damage"><label for="damage">Skin Pick / Bite Nails / Etc</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="hurt" value="hurt" id="hurt"><label for="hurt">Hurt Yourself</label></div>';
        
        //Medications
        echo '<label class="form" style="margin-top: 2rem;" for="meds">List Any Meds you Forgot to Take:</label><br>';
        echo '<input class="input" type="text" name="meds"><br>';
        echo '<p><i>Leave Box Empty if you Took Them All</i></p>';
        
        //Triggers
        echo '<label class="form" style="margin-top: 2rem;" for="triggers">Did Anything Happen that Upset You:</label><br>';
        echo '<input class="input" type="text" name="triggers"><br>';
        
        //Notes
        echo '<label class="form" style="margin-top: 2rem;" for="notes">Any Other Notes:</label><br>';
        echo '<input class="input" type="text" name="notes"><br>';
        
        echo '<button  class="fancyButton">Submit</button>';
        echo '</form>';
    } elseif ($type === "pain") {
        echo "<form method='POST' action='includes/entryPain.inc.php' onsubmit=\"return confirm('Please confirm there is no identifying information');\">";   
        
        //Rate Lowest Pain
        echo '<label class="form" style="margin-top: 1rem;">Rate Your Lowest Pain Today:</label><br>';
        //Buttons
        echo '<div class="radioRow">';
        echo '<div class="radioBox"><input type="radio" name="low" value="1" required id="low1"><label for="low1">1</label></div>';
        echo '<div class="radioBox"><input type="radio" name="low" value="2" id="low2"><label for="low2">2</label></div>';
        echo '<div class="radioBox"><input type="radio" name="low" value="3" id="low3"><label for="low3">3</label></div>';
        echo '<div class="radioBox"><input type="radio" name="low" value="4" id="low4"><label for="low4">4</label></div>';
        echo '<div class="radioBox"><input type="radio" name="low" value="5" id="low5"><label for="low5">5</label></div>';
        echo '<div class="radioBox"><input type="radio" name="low" value="6" id="low6"><label for="low6">6</label></div>';
        echo '<div class="radioBox"><input type="radio" name="low" value="7" id="low7"><label for="low7">7</label></div>';
        echo '<div class="radioBox"><input type="radio" name="low" value="8" id="low8"><label for="low8">8</label></div>';
        echo '<div class="radioBox"><input type="radio" name="low" value="9" id="low9"><label for="low9">9</label></div>';
        echo '<div class="radioBox"><input type="radio" name="low" value="10" id="low10"><label for="low10">10</label></div>';
        echo '</div>';
        echo '<p><i>Low to High</i></p>';
        
        //Rate Highest Pain
        echo '<label class="form" style="margin-top: 1rem;">Rate Your Highest Pain Today:</label><br>';
        //Buttons
        echo '<div class="radioRow">';
        echo '<div class="radioBox"><input type="radio" name="high" value="1" required id="hig1"><label for="hig1">1</label></div>';
        echo '<div class="radioBox"><input type="radio" name="high" value="2" id="hig2"><label for="hig2">2</label></div>';
        echo '<div class="radioBox"><input type="radio" name="high" value="3" id="hig3"><label for="hig3">3</label></div>';
        echo '<div class="radioBox"><input type="radio" name="high" value="4" id="hig4"><label for="hig4">4</label></div>';
        echo '<div class="radioBox"><input type="radio" name="high" value="5" id="hig5"><label for="hig5">5</label></div>';
        echo '<div class="radioBox"><input type="radio" name="high" value="6" id="hig6"><label for="hig6">6</label></div>';
        echo '<div class="radioBox"><input type="radio" name="high" value="7" id="hig7"><label for="hig7">7</label></div>';
        echo '<div class="radioBox"><input type="radio" name="high" value="8" id="hig8"><label for="hig8">8</label></div>';
        echo '<div class="radioBox"><input type="radio" name="high" value="9" id="hig9"><label for="hig9">9</label></div>';
        echo '<div class="radioBox"><input type="radio" name="high" value="10" id="hig10"><label for="hig10">10</label></div>';
        echo '</div>';
        echo '<p><i>Low to High</i></p>';
        
        //Rate Average Pain
        echo '<label class="form" style="margin-top: 1rem;">Rate Your Average Pain Today:</label><br>';
        //Buttons
        echo '<div class="radioRow">';
        echo '<div class="radioBox"><input type="radio" name="avg" value="1" required id="avg1"><label for="avg1">1</label></div>';
        echo '<div class="radioBox"><input type="radio" name="avg" value="2" id="avg2"><label for="avg2">2</label></div>';
        echo '<div class="radioBox"><input type="radio" name="avg" value="3" id="avg3"><label for="avg3">3</label></div>';
        echo '<div class="radioBox"><input type="radio" name="avg" value="4" id="avg4"><label for="avg4">4</label></div>';
        echo '<div class="radioBox"><input type="radio" name="avg" value="5" id="avg5"><label for="avg5">5</label></div>';
        echo '<div class="radioBox"><input type="radio" name="avg" value="6" id="avg6"><label for="avg6">6</label></div>';
        echo '<div class="radioBox"><input type="radio" name="avg" value="7" id="avg7"><label for="avg7">7</label></div>';
        echo '<div class="radioBox"><input type="radio" name="avg" value="8" id="avg8"><label for="avg8">8</label></div>';
        echo '<div class="radioBox"><input type="radio" name="avg" value="9" id="avg9"><label for="avg9">9</label></div>';
        echo '<div class="radioBox"><input type="radio" name="avg" value="10" id="avg10"><label for="avg10">10</label></div>';
        echo '</div>';
        echo '<p><i>Low to High</i></p>';
        
        //Location
        echo '<label class="form" style="margin-top: 2rem;" for="location">Where Was the Pain Located:</label><br>';
        echo '<input class="input" type="text" name="location"><br>';
        
        //Describe
        echo '<label class="form" style="margin-top: 2rem;">How Would You Describe the Pain:</label><br>';
        echo '<p><i>Check All That Apply</i></p>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="swollen" value="swollen" id="swollen"><label for="swollen">Swollen</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="throbbing" value="throbbing" id="throbbing"><label for="throbbing">Throbbing</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="aching" value="aching" id="aching"><label for="aching">Aching</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="numb" value="numb" id="numb"><label for="numb">Numb</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="burning" value="burning" id="burning"><label for="burning">Burning</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="cramping" value="cramping" id="cramping"><label for="cramping">Cramping</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="tight" value="tight" id="tight"><label for="tight">Tight</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="tender" value="tender" id="tender"><label for="tender">Tender</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="shooting" value="shooting" id="shooting"><label for="shooting">Shooting / Shocking</label></div>';
        
        //Symptoms
        echo '<label class="form" style="margin-top: 2rem;">Do You Have Any Other Symptoms:</label><br>';
        echo '<p><i>Check All That Apply</i></p>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="exhaustion" value="exhaustion" id="exhaustion"><label for="exhaustion">Exhaustion</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="nausea" value="nausea" id="nausea"><label for="nausea" >Nausea</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="vomit" value="vomit" id="vomit"><label for="vomit" >Vomiting</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="poops" value="poops" id="poops"><label for="poops" >Bad Poops</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="throat" value="throat" id="throat"><label for="throat" >Sore Throat</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="insomnia" value="insomnia" id="insomnia"><label for="insomnia">Insomnia</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="bloating" value="bloating"  id="bloating"><label for="bloating">Bloating</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="fever" value="fever" id="fever"><label for="fever" >Fever</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="chills" value="chills" id="chills"><label for="chills" >Chills</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="congestion" value="congestion" id="congestion"><label for="congestion">Congestion</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="muscle" value="muscle" id="muscle"><label for="muscle">Muscle Spasms</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="fog" value="fog" id="fog"><label for="fog">Brain Fog</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="badmood" value="badmood" id="badmood"><label for="badmood">Bad Mood</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="vertigo" value="vertigo" id="vertigo"><label for="vertigo">Vertigo</label></div>';
        
        //Rate Sleep
        echo '<label class="form" style="margin-top: 2rem;">Rate Your Sleep:</label><br>';
        //Buttons
        echo '<div class="radioRow">';
        echo '<div class="radioBox" ><input type="radio" name="sleep" value="1" required id="sle1"><label for="sle1">1</label></div>';
        echo '<div class="radioBox"><input type="radio" name="sleep" value="2" id="sle2"><label for="sle2">2</label></div>';
        echo '<div class="radioBox"><input type="radio" name="sleep" value="3" id="sle3"><label for="sle3">3</label></div>';
        echo '<div class="radioBox"><input type="radio" name="sleep" value="4" id="sle4"><label for="sle4">4</label></div>';
        echo '<div class="radioBox"><input type="radio" name="sleep" value="5" id="sle5"><label for="sle5">5</label></div>';
        echo '<div class="radioBox"><input type="radio" name="sleep" value="6" id="sle6"><label for="sle6">6</label></div>';
        echo '<div class="radioBox"><input type="radio" name="sleep" value="7" id="sle7"><label for="sle7">7</label></div>';
        echo '<div class="radioBox"><input type="radio" name="sleep" value="8" id="sle8"><label for="sle8">8</label></div>';
        echo '<div class="radioBox"><input type="radio" name="sleep" value="9" id="sle9"><label for="sle9">9</label></div>';
        echo '<div class="radioBox"><input type="radio" name="sleep" value="10" id="sle10"><label for="sle10">10</label></div>';
        echo '</div>';
        echo '<p><i>No Sleep to Amazing Sleep</i></p>';
        
        //Rate Excercise
        echo '<label class="form" style="margin-top: 2rem;">Rate Your Activity Level:</label><br>';
        //Buttons
        echo '<div class="radioRow">';
        echo '<div class="radioBox"><input type="radio" name="activity" value="1" required id="act1"><label for="act1">1</label></div>';
        echo '<div class="radioBox"><input type="radio" name="activity" value="2" id="act2"><label for="act2">2</label></div>';
        echo '<div class="radioBox"><input type="radio" name="activity" value="3" id="act3"><label for="act3">3</label></div>';
        echo '<div class="radioBox"><input type="radio" name="activity" value="4" id="act4"><label for="act4">4</label></div>';
        echo '<div class="radioBox"><input type="radio" name="activity" value="5" id="act5"><label for="act5">5</label></div>';
        echo '<div class="radioBox"><input type="radio" name="activity" value="6" id="act6"><label for="act6">6</label></div>';
        echo '<div class="radioBox"><input type="radio" name="activity" value="7" id="act7"><label for="act7">7</label></div>';
        echo '<div class="radioBox"><input type="radio" name="activity" value="8" id="act8"><label for="act8">8</label></div>';
        echo '<div class="radioBox"><input type="radio" name="activity" value="9" id="act9"><label for="act9">9</label></div>';
        echo '<div class="radioBox"><input type="radio" name="activity" value="10" id="act10"><label for="act10">10</label></div>';
        echo '</div>';
        echo '<p><i>Sloth to Overworked</i></p>';
        
        //Rate Water Intake
        echo '<label class="form" style="margin-top: 2rem;">Rate Your Water Intake:</label><br>';
        //Buttons
        echo '<div class="radioRow">';
        echo '<div class="radioBox" ><input type="radio" name="water" value="1" required id="wat1"><label for="wat1">1</label></div>';
        echo '<div class="radioBox"><input type="radio" name="water" value="2" id="wat2"><label for="wat2">2</label></div>';
        echo '<div class="radioBox"><input type="radio" name="water" value="3" id="wat3"><label for="wat3">3</label></div>';
        echo '<div class="radioBox"><input type="radio" name="water" value="4" id="wat4"><label for="wat4">4</label></div>';
        echo '<div class="radioBox"><input type="radio" name="water" value="5" id="wat5"><label for="wat5">5</label></div>';
        echo '<div class="radioBox"><input type="radio" name="water" value="6" id="wat6"><label for="wat6">6</label></div>';
        echo '<div class="radioBox"><input type="radio" name="water" value="7" id="wat7"><label for="wat7">7</label></div>';
        echo '<div class="radioBox"><input type="radio" name="water" value="8" id="wat8"><label for="wat8">8</label></div>';
        echo '<div class="radioBox"><input type="radio" name="water" value="9" id="wat9"><label for="wat9">9</label></div>';
        echo '<div class="radioBox"><input type="radio" name="water" value="10" id="wat10"><label for="wat10">10</label></div>';
        echo '</div>';
        echo '<p><i>No Water to Lots of Water</i></p>';
        
        //Rate Weather
        echo '<label class="form" style="margin-top: 2rem;">How Was the Weather:</label><br>';
        //Buttons
        echo '<div class="radioRow">';
        echo '<div class="radioBox"><input type="radio" name="weather" value="Frozen" required id="frozen"><label for="frozen">Frozen</label></div>';
        echo '<div class="radioBox"><input type="radio" name="weather" value="Cold" id="cold"><label for="cold">Cold  </label></div>';
        echo '<div class="radioBox"><input type="radio" name="weather" value="Mild" id="mild"><label for="mild">  Mild  </label></div>';
        echo '<div class="radioBox"><input type="radio" name="weather" value="Hot" id="hot"><label for="hot">  Hot  </label></div>';
        echo '<div class="radioBox"><input type="radio" name="weather" value="Wet" id="wet"><label for="wet">  Wet  </label></div>';
        echo '<div class="radioBox"><input type="radio" name="weather" value="Dry" id="dry"><label for="dry">  Dry</label></div>';
        echo '</div>';
        
        //Rate Air Quality
        echo '<label class="form" style="margin-top: 2rem;">How Was the Air Quality:</label><br>';
        //Buttons
        echo '<div class="radioRow">';
        echo '<div class="radioBox"><input type="radio" name="air" value="Sickly" required id="sickly"><label for="sickly">Sickly</label></div>';
        echo '<div class="radioBox"><input type="radio" name="air" value="Bad" id="bad"><label for="bad">Bad</label></div>';
        echo '<div class="radioBox"><input type="radio" name="air" value="Fine" id="fine"><label for="fine">Fine</label></div>';
        echo '<div class="radioBox"><input type="radio" name="air" value="Good" id="good"><label for="good">Good</label></div>';
        echo '</div>';
        
        //Medications
        echo '<label class="form" style="margin-top: 2rem;" for="remedy">List any As Needed Medicine Taken Today:</label><br>';
        echo '<input class="input" type="text" name="remedy"><br>';
        echo '<p><i>Also Included Physio & Stretches</i></p>';
        
        //Medications
        echo '<label class="form" style="margin-top: 2rem;" for="meds">List Any Meds you Forgot to Take:</label><br>';
        echo '<input class="input" type="text" name="meds"><br>';
        echo '<p><i>Also Included Physio & Stretches</i></p>';
        echo '<p><i>Leave Box Empty if you Took Them All</i></p>';
        
        //Notes
        echo '<label class="form" style="margin-top: 2rem;" for="notes">Any Other Notes:</label><br>';
        echo '<input class="input" type="text" name="notes"><br>';
        
        echo '<button  class="fancyButton">Submit</button>';
        echo '</form>'; 
    } else if ($type == "productivity") {
     echo "<form method='POST' action='includes/entryProductivity.inc.php' onsubmit=\"return confirm('Please confirm there is no identifying information');\">"; 
     if ($latestEntry) {
         echo '<h3>Today</h3><br>';
         echo '<h1>Most Important Task of the Day</h1>';
         echo '<div class="checkboxJournal"><input type="checkbox" name="oneCheck" value="oneCheck" id="oneCheck"><label for="oneCheck">' . htmlspecialchars($latestEntry['taskOne']) . '</label></div><br>';
         echo '<h1>Secondary Tasks of Importance</h1>';
         echo '<div class="checkboxJournal"><input type="checkbox" name="twoCheck" value="twoCheck" id="twoCheck"><label for="twoCheck">' . htmlspecialchars($latestEntry['taskTwo']) . '</label></div>';
         echo '<div class="checkboxJournal"><input type="checkbox" name="threeCheck" value="threeCheck" id="threeCheck"><label for="threeCheck">' . htmlspecialchars($latestEntry['taskThree']) . '</label></div><br>';
         if ($latestEntry['taskFour'] || $latestEntry['taskFive']) {
             echo '<h1>Less Important Tasks</h1>';
             echo '<div class="checkboxJournal"><input type="checkbox" name="fourCheck" value="fourCheck" id="fourCheck"><label for="fourCheck">' . htmlspecialchars($latestEntry['taskFour']) . '</label></div>';
             echo '<div class="checkboxJournal"><input type="checkbox" name="fiveCheck" value="fiveCheck" id="fiveCheck"><label for="fiveCheck">' . htmlspecialchars($latestEntry['taskFive']) . '</label></div><br>';
         }
         
        //Rate Productivity
        echo '<label class="form" style="margin-top: 2rem;">Rate Your Productivity:</label><br>';
        //Buttons
        echo '<div class="radioRow">';
        echo '<div class="radioBox"><input type="radio" name="productivity" value="1" required id="pro1"><label for="pro1">1</label></div>';
        echo '<div class="radioBox"><input type="radio" name="productivity" value="2" id="pro2"><label for="pro2">2</label></div>';
        echo '<div class="radioBox"><input type="radio" name="productivity" value="3" id="pro3"><label for="pro3">3</label></div>';
        echo '<div class="radioBox"><input type="radio" name="productivity" value="4" id="pro4"><label for="pro4">4</label></div>';
        echo '<div class="radioBox"><input type="radio" name="productivity" value="5" id="pro5"><label for="pro5">5</label></div>';
        echo '<div class="radioBox"><input type="radio" name="productivity" value="6" id="pro6"><label for="pro6">6</label></div>';
        echo '<div class="radioBox"><input type="radio" name="productivity" value="7" id="pro7"><label for="pro7">7</label></div>';
        echo '<div class="radioBox"><input type="radio" name="productivity" value="8" id="pro8"><label for="pro8">8</label></div>';
        echo '<div class="radioBox"><input type="radio" name="productivity" value="9" id="pro9"><label for="pro9">9</label></div>';
        echo '<div class="radioBox"><input type="radio" name="productivity" value="10" id="pro10"><label for="pro10">10</label></div>';
        echo '</div>';
        echo '<p><i>Not Productive to Super Productive</i></p>';
         
        //Rate Mood
        echo '<label class="form" style="margin-top: 2rem;">Rate Your Mood:</label><br>';
        //Buttons
        echo '<div class="radioRow">';
        echo '<div class="radioBox"><input type="radio" name="mood" value="1" required id="mood1"><label for="mood1">1</label></div>';
        echo '<div class="radioBox"><input type="radio" name="mood" value="2" id="mood2"><label for="mood2">2</label></div>';
        echo '<div class="radioBox"><input type="radio" name="mood" value="3" id="mood3"><label for="mood3">3</label></div>';
        echo '<div class="radioBox"><input type="radio" name="mood" value="4" id="mood4"><label for="mood4">4</label></div>';
        echo '<div class="radioBox"><input type="radio" name="mood" value="5" id="mood5"><label for="mood5">5</label></div>';
        echo '<div class="radioBox"><input type="radio" name="mood" value="6" id="mood6"><label for="mood6">6</label></div>';
        echo '<div class="radioBox"><input type="radio" name="mood" value="7" id="mood7"><label for="mood7">7</label></div>';
        echo '<div class="radioBox"><input type="radio" name="mood" value="8" id="mood8"><label for="mood8">8</label></div>';
        echo '<div class="radioBox"><input type="radio" name="mood" value="9" id="mood9"><label for="mood9">9</label></div>';
        echo '<div class="radioBox"><input type="radio" name="mood" value="10" id="mood10"><label for="mood10">10</label></div>';
        echo '</div>';
        echo '<p><i>Horrible Mood to Spectacular Mood</i></p>';
         
        //Rate Physical Health
        echo '<label class="form" style="margin-top: 2rem;">Rate Your Physical Health:</label><br>';
        //Buttons
        echo '<div class="radioRow">';
        echo '<div class="radioBox" ><input type="radio" name="health" value="1" required id="hea1"><label for="hea1">1</label></div>';
        echo '<div class="radioBox"><input type="radio" name="health" value="2" id="hea2"><label for="hea2">2</label></div>';
        echo '<div class="radioBox"><input type="radio" name="health" value="3" id="hea3"><label for="hea3">3</label></div>';
        echo '<div class="radioBox"><input type="radio" name="health" value="4" id="hea4"><label for="hea4">4</label></div>';
        echo '<div class="radioBox"><input type="radio" name="health" value="5" id="hea5"><label for="hea5">5</label></div>';
        echo '<div class="radioBox"><input type="radio" name="health" value="6" id="hea6"><label for="hea6">6</label></div>';
        echo '<div class="radioBox"><input type="radio" name="health" value="7" id="hea7"><label for="hea7">7</label></div>';
        echo '<div class="radioBox"><input type="radio" name="health" value="8" id="hea8"><label for="hea8">8</label></div>';
        echo '<div class="radioBox"><input type="radio" name="health" value="9" id="hea9"><label for="hea9">9</label></div>';
        echo '<div class="radioBox"><input type="radio" name="health" value="10" id="hea10"><label for="hea10">10</label></div>';
        echo '</div>';
        echo '<p><i>Bad to Excellent</i></p>';
         
         //Rate Mental Health
        echo '<label class="form" style="margin-top: 2rem;">Rate Your Mental Health:</label><br>';
        //Buttons
        echo '<div class="radioRow">';
        echo '<div class="radioBox" ><input type="radio" name="mental" value="1" required id="men1"><label for="men1">1</label></div>';
        echo '<div class="radioBox"><input type="radio" name="mental" value="2" id="men2"><label for="men2">2</label></div>';
        echo '<div class="radioBox"><input type="radio" name="mental" value="3" id="men3"><label for="men3">3</label></div>';
        echo '<div class="radioBox"><input type="radio" name="mental" value="4" id="men4"><label for="men4">4</label></div>';
        echo '<div class="radioBox"><input type="radio" name="mental" value="5" id="men5"><label for="men5">5</label></div>';
        echo '<div class="radioBox"><input type="radio" name="mental" value="6" id="men6"><label for="men6">6</label></div>';
        echo '<div class="radioBox"><input type="radio" name="mental" value="7" id="men7"><label for="men7">7</label></div>';
        echo '<div class="radioBox"><input type="radio" name="mental" value="8" id="men8"><label for="men8">8</label></div>';
        echo '<div class="radioBox"><input type="radio" name="mental" value="9" id="men9"><label for="men9">9</label></div>';
        echo '<div class="radioBox"><input type="radio" name="mental" value="10" id="men10"><label for="men10">10</label></div>';
        echo '</div>';
        echo '<p><i>Bad to Excellent</i></p>';
        
        //Check for Habits
        $query = 'SELECT * FROM productivityEntries WHERE user_id = :id ORDER BY id DESC LIMIT 7'; 
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
        $habits = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($habits as $habit) {
            if ($habit['habitOne']) {
                $habitOne = htmlspecialchars($habit['habitOne']);
                $habitTwo = htmlspecialchars($habit['habitTwo']);
                break;
            }
        }
        if ($habitOne) {
            echo '<h1>Check All Completed Habits</h1>';
            echo '<div class="checkboxJournal"><input type="checkbox" name="habitCheckOne" value="habitCheckOne" id="habitCheckOne"><label for="habitCheckOne"> ' . htmlspecialchars($habitOne) . '</label></div>';
            echo '<div class="checkboxJournal"><input type="checkbox" name="habitCheckTwo" value="habitCheckTwo" id="habitCheckTwo"><label for="habitCheckTwo"> ' . htmlspecialchars($habitTwo) . '</label></div>';
        }
         //Notes
         echo '<label class="form" style="margin-top: 2rem;margin-bottom:0;" for="notes" ><b>Notes:</b></label><br>';
         echo '<input class="input" type="text" name="notes"><br>';
         echo '<hr>';
     }
        
        echo '<h3>Tomorrow</h3><br>';
        //Task One
        echo '<label class="form" style="margin-top: 2rem;margin-bottom:0;" for="tomorrowTaskOne" ><b>Most Important Task:</b></label><br>';
        echo '<p><i>If this was the only thing you did tomorrow, you\'d be satisfied</i></p>';
        echo '<input class="input" type="text" name="tomorrowTaskOne" required><br>';
        
        //Task Two & Three
        echo '<label class="form" style="margin-top: 2rem;margin-bottom:0;" ><b>Secondary Tasks:</b></label><br>';
        echo '<p><i>Completion of these tasks will make the day even better</i></p>';
        echo '<input class="input" type="text" name="tomorrowTaskTwo" required><br>';
        echo '<input class="input" type="text" name="tomorrowTaskThree" required><br>';
        
        if (date('w', strtotime($date)) != 5 && date('w', strtotime($date)) != 6) {
            //Task Four & Five
            echo '<label class="form" style="margin-top: 2rem;margin-bottom:0;" ><b>Less Important Tasks:</b></label><br>';
            echo '<p><i>To be completed only after completing the tasks above</i></p>';
            echo '<input class="input" type="text" name="tomorrowTaskFour" required><br>';
            echo '<input class="input" type="text" name="tomorrowTaskFive" required><br>';
        }
        
        echo '<hr>';
        if (date('w', strtotime($date)) == 7) {
            echo '<h3>Next Week</h3><br>';
            echo '<label class="form" style="margin-top: 2rem;margin-bottom:0;" ><b>Next Week\'s Habits:</b></label><br>';
            echo '<input class="input" type="text" name="newHabitOne" required><br>';
            echo '<input class="input" type="text" name="neaHabitTwo" required><br>';
            
            echo '<label class="form" style="margin-top: 2rem;margin-bottom:0;" ><b>Weekly Wins:</b></label><br>';
            echo '<p><i>Reflect on the past week. What wins are you proud of?</i></p>';
            echo '<input class="input" type="text" name="weeklyWins" required><br>';
            
            echo '<label class="form" style="margin-top: 2rem;margin-bottom:0;" ><b>Weekly Losses:</b></label><br>';
            echo '<p><i>Reflect on the past week. What tasks fell through your planning?</i></p>';
            echo '<input class="input" type="text" name="weeklyLoses" required><br>';
            
            echo '<label class="form" style="margin-top: 2rem;margin-bottom:0;" ><b>Weekly Lesson:</b></label><br>';
            echo '<p><i>Reflect on the past week. What lessons did you learn this week?</i></p>';
            echo '<input class="input" type="text" name="weeklyLesson" required><br>';
        }
    echo '<button  class="fancyButton">Submit</button>';
     echo "</form>";
 } 
} else {
    header("Location: ../journal.php");
    die();
}
