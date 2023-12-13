<?php

$userId = $_SESSION['user_id'];

//Get Journal Type
//Check for Journals
$query = 'SELECT * FROM journals WHERE user_id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$type = $result ['type'];

//Check For Open Entries
    if ($type === "mentalHealth") {
        $query = 'SELECT * FROM mentalHealthEntries WHERE user_id = :id ORDER BY id DESC LIMIT 1';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
        $latestEntry = $stmt->fetch(PDO::FETCH_ASSOC);
    } elseif ($type === "pain") {
        $query = 'SELECT * FROM chronicPainEntries WHERE user_id = :id ORDER BY id DESC LIMIT 1';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
        $latestEntry = $stmt->fetch(PDO::FETCH_ASSOC);
    }
if (!$latestEntry || $latestEntry['closed'] === "1") {
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
        echo '<div class="radioBox" required><input type="radio" name="anxiety" value="1"><label for="anxiety">1</label></div>';
        echo '<div class="radioBox"><input type="radio" name="anxiety" value="2"><label for="anxiety">2</label></div>';
        echo '<div class="radioBox"><input type="radio" name="anxiety" value="3"><label for="anxiety">3</label></div>';
        echo '<div class="radioBox"><input type="radio" name="anxiety" value="4"><label for="anxiety">4</label></div>';
        echo '<div class="radioBox"><input type="radio" name="anxiety" value="5"><label for="anxiety">5</label></div>';
        echo '<div class="radioBox"><input type="radio" name="anxiety" value="6"><label for="anxiety">6</label></div>';
        echo '<div class="radioBox"><input type="radio" name="anxiety" value="7"><label for="anxiety">7</label></div>';
        echo '<div class="radioBox"><input type="radio" name="anxiety" value="8"><label for="anxiety">8</label></div>';
        echo '<div class="radioBox"><input type="radio" name="anxiety" value="9"><label for="anxiety">9</label></div>';
        echo '<div class="radioBox"><input type="radio" name="anxiety" value="10"><label for="anxiety">10</label></div>';
        echo '</div>';
        echo '<p><i>Low to High</i></p>';
        
        //Rate Depression
        echo '<label class="form" style="margin-top: 2rem;">Rate Your Depression:</label><br>';
        //Buttons
        echo '<div class="radioRow">';
        echo '<div class="radioBox" required><input type="radio" name="depression" value="1"><label for="depression">1</label></div>';
        echo '<div class="radioBox"><input type="radio" name="depression" value="2"><label for="depression">2</label></div>';
        echo '<div class="radioBox"><input type="radio" name="depression" value="3"><label for="depression">3</label></div>';
        echo '<div class="radioBox"><input type="radio" name="depression" value="4"><label for="depression">4</label></div>';
        echo '<div class="radioBox"><input type="radio" name="depression" value="5"><label for="depression">5</label></div>';
        echo '<div class="radioBox"><input type="radio" name="depression" value="6"><label for="depression">6</label></div>';
        echo '<div class="radioBox"><input type="radio" name="depression" value="7"><label for="depression">7</label></div>';
        echo '<div class="radioBox"><input type="radio" name="depression" value="8"><label for="depression">8</label></div>';
        echo '<div class="radioBox"><input type="radio" name="depression" value="9"><label for="depression">9</label></div>';
        echo '<div class="radioBox"><input type="radio" name="depression" value="10"><label for="depression">10</label></div>';
        echo '</div>';
        echo '<p><i>Low to High</i></p>';
        
        //Rate Stress
        echo '<label class="form" style="margin-top: 2rem;">Rate Your Stress:</label><br>';
        //Buttons
        echo '<div class="radioRow">';
        echo '<div class="radioBox" required><input type="radio" name="stress" value="1"><label for="stress">1</label></div>';
        echo '<div class="radioBox"><input type="radio" name="stress" value="2"><label for="stress">2</label></div>';
        echo '<div class="radioBox"><input type="radio" name="stress" value="3"><label for="stress">3</label></div>';
        echo '<div class="radioBox"><input type="radio" name="stress" value="4"><label for="stress">4</label></div>';
        echo '<div class="radioBox"><input type="radio" name="stress" value="5"><label for="stress">5</label></div>';
        echo '<div class="radioBox"><input type="radio" name="stress" value="6"><label for="stress">6</label></div>';
        echo '<div class="radioBox"><input type="radio" name="stress" value="7"><label for="stress">7</label></div>';
        echo '<div class="radioBox"><input type="radio" name="stress" value="8"><label for="stress">8</label></div>';
        echo '<div class="radioBox"><input type="radio" name="stress" value="9"><label for="stress">9</label></div>';
        echo '<div class="radioBox"><input type="radio" name="stress" value="10"><label for="stress">10</label></div>';
        echo '</div>';
        echo '<p><i>Low to High</i></p>';
        
        //Rate Productivity
        echo '<label class="form" style="margin-top: 2rem;">Rate Your Productivity:</label><br>';
        //Buttons
        echo '<div class="radioRow">';
        echo '<div class="radioBox" required><input type="radio" name="productivity" value="1"><label for="productivity">1</label></div>';
        echo '<div class="radioBox"><input type="radio" name="productivity" value="2"><label for="productivity">2</label></div>';
        echo '<div class="radioBox"><input type="radio" name="productivity" value="3"><label for="productivity">3</label></div>';
        echo '<div class="radioBox"><input type="radio" name="productivity" value="4"><label for="productivity">4</label></div>';
        echo '<div class="radioBox"><input type="radio" name="productivity" value="5"><label for="productivity">5</label></div>';
        echo '<div class="radioBox"><input type="radio" name="productivity" value="6"><label for="productivity">6</label></div>';
        echo '<div class="radioBox"><input type="radio" name="productivity" value="7"><label for="productivity">7</label></div>';
        echo '<div class="radioBox"><input type="radio" name="productivity" value="8"><label for="productivity">8</label></div>';
        echo '<div class="radioBox"><input type="radio" name="productivity" value="9"><label for="productivity">9</label></div>';
        echo '<div class="radioBox"><input type="radio" name="productivity" value="10"><label for="productivity">10</label></div>';
        echo '</div>';
        echo '<p><i>Low to High</i></p>';
        
        //Rate Physical Health
        echo '<label class="form" style="margin-top: 2rem;">Rate Your Physical Health:</label><br>';
        //Buttons
        echo '<div class="radioRow">';
        echo '<div class="radioBox" required><input type="radio" name="health" value="1"><label for="health">1</label></div>';
        echo '<div class="radioBox"><input type="radio" name="health" value="2"><label for="health">2</label></div>';
        echo '<div class="radioBox"><input type="radio" name="health" value="3"><label for="health">3</label></div>';
        echo '<div class="radioBox"><input type="radio" name="health" value="4"><label for="health">4</label></div>';
        echo '<div class="radioBox"><input type="radio" name="health" value="5"><label for="health">5</label></div>';
        echo '<div class="radioBox"><input type="radio" name="health" value="6"><label for="health">6</label></div>';
        echo '<div class="radioBox"><input type="radio" name="health" value="7"><label for="health">7</label></div>';
        echo '<div class="radioBox"><input type="radio" name="health" value="8"><label for="health">8</label></div>';
        echo '<div class="radioBox"><input type="radio" name="health" value="9"><label for="health">9</label></div>';
        echo '<div class="radioBox"><input type="radio" name="health" value="10"><label for="health">10</label></div>';
        echo '</div>';
        echo '<p><i>Bad to Excellent</i></p>';
        
        //Rate Sleep
        echo '<label class="form" style="margin-top: 2rem;">Rate Your Sleep:</label><br>';
        //Buttons
        echo '<div class="radioRow">';
        echo '<div class="radioBox" required><input type="radio" name="sleep" value="1"><label for="sleep">1</label></div>';
        echo '<div class="radioBox"><input type="radio" name="sleep" value="2"><label for="sleep">2</label></div>';
        echo '<div class="radioBox"><input type="radio" name="sleep" value="3"><label for="sleep">3</label></div>';
        echo '<div class="radioBox"><input type="radio" name="sleep" value="4"><label for="sleep">4</label></div>';
        echo '<div class="radioBox"><input type="radio" name="sleep" value="5"><label for="sleep">5</label></div>';
        echo '<div class="radioBox"><input type="radio" name="sleep" value="6"><label for="sleep">6</label></div>';
        echo '<div class="radioBox"><input type="radio" name="sleep" value="7"><label for="sleep">7</label></div>';
        echo '<div class="radioBox"><input type="radio" name="sleep" value="8"><label for="sleep">8</label></div>';
        echo '<div class="radioBox"><input type="radio" name="sleep" value="9"><label for="sleep">9</label></div>';
        echo '<div class="radioBox"><input type="radio" name="sleep" value="10"><label for="sleep">10</label></div>';
        echo '</div>';
        echo '<p><i>No Sleep to Amazing Sleep</i></p>';
        
        //Rate Water Intake
        echo '<label class="form" style="margin-top: 2rem;">Rate Your Water Intake:</label><br>';
        //Buttons
        echo '<div class="radioRow">';
        echo '<div class="radioBox" required><input type="radio" name="water" value="1"><label for="water">1</label></div>';
        echo '<div class="radioBox"><input type="radio" name="water" value="2"><label for="water">2</label></div>';
        echo '<div class="radioBox"><input type="radio" name="water" value="3"><label for="water">3</label></div>';
        echo '<div class="radioBox"><input type="radio" name="water" value="4"><label for="water">4</label></div>';
        echo '<div class="radioBox"><input type="radio" name="water" value="5"><label for="water">5</label></div>';
        echo '<div class="radioBox"><input type="radio" name="water" value="6"><label for="water">6</label></div>';
        echo '<div class="radioBox"><input type="radio" name="water" value="7"><label for="water">7</label></div>';
        echo '<div class="radioBox"><input type="radio" name="water" value="8"><label for="water">8</label></div>';
        echo '<div class="radioBox"><input type="radio" name="water" value="9"><label for="water">9</label></div>';
        echo '<div class="radioBox"><input type="radio" name="water" value="10"><label for="water">10</label></div>';
        echo '</div>';
        echo '<p><i>No Water to Lots of Water</i></p>';
        
        //List Good Behaviors
        echo '<label class="form" style="margin-top: 2rem;">Did you do any of the following things:</label><br>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="eat" value="eat"><label for="eat">Eaten a Meal</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="washed" value="washed"><label for="washed">Showered or Bathed</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="teeth" value="teeth"><label for="teeth">Brushed Your Teeth</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="chore" value="chore"><label for="chore">Done a Chore</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="walk" value="walk"><label for="walk">Went for a Walk</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="excercise" value="excercise"><label for="excercise">Had Exercise</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="talk" value="talk"><label for="talk">Talked to Friends/Family</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="creative" value="creative"><label for="creative">Made Art or Wrote</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="therapy" value="therapy"><label for="therapy">Went to Therapy</label></div>';
        
        //List Bad Behaviors
        echo '<label class="form" style="margin-top: 2rem;">Did you do any of the following things:</label><br>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="doomscroll" value="doomscroll"><label for="doomscroll">Doomscroll / Too Much Social Media</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="angry" value="angry"><label for="angry">Lash Out at Others</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="alone" value="alone"><label for="alone">Isolate Yourself</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="skip" value="skip"><label for="skip">Stay Home From School/Work</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="shop" value="shop"><label for="shop">Stress Shop / Buy Things you Regret</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="damage" value="damage"><label for="damage">Skin Pick / Bite Nails / Etc</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="hurt" value="hurt"><label for="hurt">Hurt Yourself</label></div>';
        
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
        echo '<div class="radioBox"><input type="radio" name="low" value="1" required><label for="low">1</label></div>';
        echo '<div class="radioBox"><input type="radio" name="low" value="2"><label for="low">2</label></div>';
        echo '<div class="radioBox"><input type="radio" name="low" value="3"><label for="low">3</label></div>';
        echo '<div class="radioBox"><input type="radio" name="low" value="4"><label for="low">4</label></div>';
        echo '<div class="radioBox"><input type="radio" name="low" value="5"><label for="low">5</label></div>';
        echo '<div class="radioBox"><input type="radio" name="low" value="6"><label for="low">6</label></div>';
        echo '<div class="radioBox"><input type="radio" name="low" value="7"><label for="low">7</label></div>';
        echo '<div class="radioBox"><input type="radio" name="low" value="8"><label for="low">8</label></div>';
        echo '<div class="radioBox"><input type="radio" name="low" value="9"><label for="low">9</label></div>';
        echo '<div class="radioBox"><input type="radio" name="low" value="10"><label for="low">10</label></div>';
        echo '</div>';
        echo '<p><i>Low to High</i></p>';
        
        //Rate Highest Pain
        echo '<label class="form" style="margin-top: 1rem;">Rate Your Highest Pain Today:</label><br>';
        //Buttons
        echo '<div class="radioRow">';
        echo '<div class="radioBox"><input type="radio" name="high" value="1" required><label for="high">1</label></div>';
        echo '<div class="radioBox"><input type="radio" name="high" value="2"><label for="high">2</label></div>';
        echo '<div class="radioBox"><input type="radio" name="high" value="3"><label for="high">3</label></div>';
        echo '<div class="radioBox"><input type="radio" name="high" value="4"><label for="high">4</label></div>';
        echo '<div class="radioBox"><input type="radio" name="high" value="5"><label for="high">5</label></div>';
        echo '<div class="radioBox"><input type="radio" name="high" value="6"><label for="high">6</label></div>';
        echo '<div class="radioBox"><input type="radio" name="high" value="7"><label for="high">7</label></div>';
        echo '<div class="radioBox"><input type="radio" name="high" value="8"><label for="high">8</label></div>';
        echo '<div class="radioBox"><input type="radio" name="high" value="9"><label for="high">9</label></div>';
        echo '<div class="radioBox"><input type="radio" name="high" value="10"><label for="high">10</label></div>';
        echo '</div>';
        echo '<p><i>Low to High</i></p>';
        
        //Rate Average Pain
        echo '<label class="form" style="margin-top: 1rem;">Rate Your Average Pain Today:</label><br>';
        //Buttons
        echo '<div class="radioRow">';
        echo '<div class="radioBox"><input type="radio" name="avg" value="1" required><label for="avg">1</label></div>';
        echo '<div class="radioBox"><input type="radio" name="avg" value="2"><label for="avg">2</label></div>';
        echo '<div class="radioBox"><input type="radio" name="avg" value="3"><label for="avg">3</label></div>';
        echo '<div class="radioBox"><input type="radio" name="avg" value="4"><label for="avg">4</label></div>';
        echo '<div class="radioBox"><input type="radio" name="avg" value="5"><label for="avg">5</label></div>';
        echo '<div class="radioBox"><input type="radio" name="avg" value="6"><label for="avg">6</label></div>';
        echo '<div class="radioBox"><input type="radio" name="avg" value="7"><label for="avg">7</label></div>';
        echo '<div class="radioBox"><input type="radio" name="avg" value="8"><label for="avg">8</label></div>';
        echo '<div class="radioBox"><input type="radio" name="avg" value="9"><label for="avg">9</label></div>';
        echo '<div class="radioBox"><input type="radio" name="avg" value="10"><label for="avg">10</label></div>';
        echo '</div>';
        echo '<p><i>Low to High</i></p>';
        
        //Location
        echo '<label class="form" style="margin-top: 2rem;" for="location">Where Was the Pain Located:</label><br>';
        echo '<input class="input" type="text" name="location"><br>';
        
        //Describe
        echo '<label class="form" style="margin-top: 2rem;">How Would You Describe the Pain:</label><br>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="swollen" value="swollen"><label for="swollen">Swollen</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="throbbing" value="throbbing"><label for="throbbing">Throbbing</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="aching" value="aching"><label for="aching">Aching</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="numb" value="numb"><label for="numb">Numb</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="burning" value="burning"><label for="burning">Burning</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="cramping" value="cramping"><label for="cramping">Cramping</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="tight" value="tight"><label for="tight">Tight</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="tender" value="tender"><label for="tender">Tender</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="shooting" value="shooting"><label for="shooting">Shooting / Shocking</label></div>';
        
        //Symptoms
        echo '<label class="form" style="margin-top: 2rem;">Do You Have Any Other Symptoms:</label><br>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="exhaustion" value="exhaustion"><label for="exhaustion">Exhaustion</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="nausea" value="nausea"><label for="nausea">Nausea</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="vomit" value="vomit"><label for="vomit">Vomiting</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="poops" value="poops"><label for="poops">Bad Poops</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="throat" value="throat"><label for="throat">Sore Throat</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="insomnia" value="insomnia"><label for="insomnia">Insomnia</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="bloating" value="bloating"><label for="bloating">Bloating</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="fever" value="fever"><label for="fever">Fever</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="chills" value="chills"><label for="chills">Chills</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="congestion" value="congestion"><label for="congestion">Congestion</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="muscle" value="muscle"><label for="muscle">Muscle Spasms</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="fog" value="fog"><label for="fog">Brain Fog</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="badmood" value="badmood"><label for="badmood">Bad Mood</label></div>';
        echo '<div class="checkboxJournal"><input type="checkbox" name="vertigo" value="vertigo"><label for="vertigo">Vertigo</label></div>';
        
        //Rate Sleep
        echo '<label class="form" style="margin-top: 2rem;">Rate Your Sleep:</label><br>';
        //Buttons
        echo '<div class="radioRow">';
        echo '<div class="radioBox"><input type="radio" name="sleep" value="1" required><label for="sleep">1</label></div>';
        echo '<div class="radioBox"><input type="radio" name="sleep" value="2"><label for="sleep">2</label></div>';
        echo '<div class="radioBox"><input type="radio" name="sleep" value="3"><label for="sleep">3</label></div>';
        echo '<div class="radioBox"><input type="radio" name="sleep" value="4"><label for="sleep">4</label></div>';
        echo '<div class="radioBox"><input type="radio" name="sleep" value="5"><label for="sleep">5</label></div>';
        echo '<div class="radioBox"><input type="radio" name="sleep" value="6"><label for="sleep">6</label></div>';
        echo '<div class="radioBox"><input type="radio" name="sleep" value="7"><label for="sleep">7</label></div>';
        echo '<div class="radioBox"><input type="radio" name="sleep" value="8"><label for="sleep">8</label></div>';
        echo '<div class="radioBox"><input type="radio" name="sleep" value="9"><label for="sleep">9</label></div>';
        echo '<div class="radioBox"><input type="radio" name="sleep" value="10"><label for="sleep">10</label></div>';
        echo '</div>';
        echo '<p><i>No Sleep to Amazing Sleep</i></p>';
        
        //Rate Excercise
        echo '<label class="form" style="margin-top: 2rem;">Rate Your Activity Level:</label><br>';
        //Buttons
        echo '<div class="radioRow">';
        echo '<div class="radioBox"><input type="radio" name="activity" value="1" required><label for="activity">1</label></div>';
        echo '<div class="radioBox"><input type="radio" name="activity" value="2"><label for="activity">2</label></div>';
        echo '<div class="radioBox"><input type="radio" name="activity" value="3"><label for="activity">3</label></div>';
        echo '<div class="radioBox"><input type="radio" name="activity" value="4"><label for="activity">4</label></div>';
        echo '<div class="radioBox"><input type="radio" name="activity" value="5"><label for="activity">5</label></div>';
        echo '<div class="radioBox"><input type="radio" name="activity" value="6"><label for="activity">6</label></div>';
        echo '<div class="radioBox"><input type="radio" name="activity" value="7"><label for="activity">7</label></div>';
        echo '<div class="radioBox"><input type="radio" name="activity" value="8"><label for="activity">8</label></div>';
        echo '<div class="radioBox"><input type="radio" name="activity" value="9"><label for="activity">9</label></div>';
        echo '<div class="radioBox"><input type="radio" name="activity" value="10"><label for="activity">10</label></div>';
        echo '</div>';
        echo '<p><i>Sloth to Overworked</i></p>';
        
        //Rate Water Intake
        echo '<label class="form" style="margin-top: 2rem;">Rate Your Water Intake:</label><br>';
        //Buttons
        echo '<div class="radioRow">';
        echo '<div class="radioBox"><input type="radio" name="water" value="1" required><label for="water">1</label></div>';
        echo '<div class="radioBox"><input type="radio" name="water" value="2"><label for="water">2</label></div>';
        echo '<div class="radioBox"><input type="radio" name="water" value="3"><label for="water">3</label></div>';
        echo '<div class="radioBox"><input type="radio" name="water" value="4"><label for="water">4</label></div>';
        echo '<div class="radioBox"><input type="radio" name="water" value="5"><label for="water">5</label></div>';
        echo '<div class="radioBox"><input type="radio" name="water" value="6"><label for="water">6</label></div>';
        echo '<div class="radioBox"><input type="radio" name="water" value="7"><label for="water">7</label></div>';
        echo '<div class="radioBox"><input type="radio" name="water" value="8"><label for="water">8</label></div>';
        echo '<div class="radioBox"><input type="radio" name="water" value="9"><label for="water">9</label></div>';
        echo '<div class="radioBox"><input type="radio" name="water" value="10"><label for="water">10</label></div>';
        echo '</div>';
        echo '<p><i>No Water to Lots of Water</i></p>';
        
        //Rate Weather
        echo '<label class="form" style="margin-top: 2rem;">How Was the Weather:</label><br>';
        //Buttons
        echo '<div class="radioRow">';
        echo '<div class="radioBox"><input type="radio" name="weather" value="Frozen" required><label for="weather">Frozen</label></div>';
        echo '<div class="radioBox"><input type="radio" name="weather" value="Cold"><label for="weather">Cold  </label></div>';
        echo '<div class="radioBox"><input type="radio" name="weather" value="Mild"><label for="weather">  Mild  </label></div>';
        echo '<div class="radioBox"><input type="radio" name="weather" value="Hot"><label for="weather">  Hot  </label></div>';
        echo '<div class="radioBox"><input type="radio" name="weather" value="Wet"><label for="weather">  Wet  </label></div>';
        echo '<div class="radioBox"><input type="radio" name="weather" value="Dry"><label for="weather">  Dry</label></div>';
        echo '</div>';
        
        //Rate Air Quality
        echo '<label class="form" style="margin-top: 2rem;">How Was the Air Quality:</label><br>';
        //Buttons
        echo '<div class="radioRow">';
        echo '<div class="radioBox"><input type="radio" name="air" value="Sickly" required><label for="air">Sickly</label></div>';
        echo '<div class="radioBox"><input type="radio" name="air" value="Bad"><label for="air">Bad</label></div>';
        echo '<div class="radioBox"><input type="radio" name="air" value="Fine"><label for="air">Fine</label></div>';
        echo '<div class="radioBox"><input type="radio" name="air" value="Good"><label for="air">Good</label></div>';
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
    }
} else {
    header("Location: ../journal.php");
    die();
}