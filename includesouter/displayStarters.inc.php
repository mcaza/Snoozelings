<?php
$userId = $_COOKIE['user_id'];

//Grab all the Blueprints From User
$query = "SELECT * FROM blueprints WHERE owner_id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo '<div class="radioStarter">';
$count = 1;
foreach ($results as $result) {
    echo '<div id="section' . $count . '" class="boxStarter">';
    echo '<input onClick="changeColour(\'' . $count . '\')" type="radio" id ="button' . $count . '" name="snoozeling" value="' . $result["id"] . '" style="margin-top: 1rem"  />';
    echo '<label for="button' . $count . '">';
    //Display Images
    displayStarter($result, "artStarter");
    echo '</label>';
    echo '</div>';
    $count++;
}
echo '</div>';

function displayStarter($pet, $class) {    
    
    echo '<div class="art-container">';
    if (strpos($pet["specials"], "Wings") !== false) {
            echo "<div class='${class}'>";
            echo "<img src='Layers/Wings/Pegasus/Bottom/" . $pet["mainColor"] . ".png' id = 'Wingsbottomone'>";
            echo "</div>";
        }
        echo "<div class='${class}'>";
        echo "<img src='Layers/Primary/" . $pet["mainColor"] . ".png' id = 'Primaryone'>";
        echo "</div>";
    if (strpos($pet["specials"], "Cupid") !== false) {
            echo "<div class='${class}'>";
            echo "<img src='Layers/Markings/Cupid/" . $pet["mainColor"] . ".png' id = 'Cupidone'>";
            echo "</div>";
        }
    
    if (strpos($pet["specials"], "Spots") !== false) {
            echo "<div class='${class}'>";
            echo "<img src='Layers/Markings/Spots/" . $pet["mainColor"] . ".png' id = 'Spotsone'>";
            echo "</div>";
        }
    if (strpos($pet["specials"], "Belly") !== false) {
            echo "<div class='${class}'>";
            echo "<img src='Layers/Markings/Belly/" . $pet["mainColor"] . ".png' id = 'Bellyone'>";
            echo "</div>";
        }
    if (strpos($pet["specials"], "Boots") !== false) {
            echo "<div class='${class}'>";
            echo "<img src='Layers/Markings/Boots/" . $pet["mainColor"] . ".png' id = 'Bootsone'>";
            echo "</div>";
        }
    if (strpos($pet["specials"], "Sublimation") !== false) {
            echo "<div class='${class}'>";
            echo "<img src='Layers/Markings/Sublimation/" . $pet["mainColor"] . ".png' id = 'Sublimationone'>";
            echo "</div>";
        }
    if (strpos($pet["specials"], "EarTip") !== false) {
            echo "<div class='${class}'>";
            echo "<img src='Layers/Other/EarTip.png' id = 'EarTipone'>";
            echo "</div>";
        }
        echo "<div class='${class}'>";
        echo "<img src='Layers/Ear/" . $pet["noseColor"] . ".png' id = 'Earone'>";
        echo "</div>";
        echo "<div class='${class}'>";
        echo "<img src='Layers/MainLines/" . $pet["mainColor"] . ".png' id = 'Mainlinesone'>";
        echo "</div>";
        echo "<div class='${class}'>";
        echo "<img src='Layers/Faces/Happy/Eyes/" . $pet["eyeColor"] . ".png' id = 'Eyesone'>";
        echo "</div>";
        echo "<div class='${class}'>";
        echo "<img src='Layers/Faces/Happy/Lines/" . $pet["mainColor"] . ".png' id = 'Faceone'>";
        echo "</div>";
        echo "<div class='${class}'>";
        if ($pet["hairType"] === "Floof") {
        echo "<img src='Layers/Hair/" . $pet["hairType"] . "/" . $pet["mainColor"] . ".png' id = 'Hairone'>";
        } else {
            echo "<img src='Layers/Hair/" . $pet["hairType"] . "/" . $pet["hairColor"] . ".png' id = 'Hairone'>";
        }
        echo "</div>";
        if ($pet["tailType"] === "Dragon") {
            echo "<div class='${class}'>";
            echo "<img src='Layers/Tail/Dragon/End/" . $pet["tailColor"] . ".png' id = 'Tailone'>";
            echo "</div>";
            echo "<div class='${class}'>";
            echo "<img src='Layers/Tail/Dragon/" . $pet["mainColor"] . ".png' id = 'TailTopone'>";
            echo "</div>";
        } else {
            echo "<div class='${class}'>";
        echo "<img src='Layers/Tail/" . $pet["tailType"] . "/" . $pet["tailColor"] . ".png' id = 'Tailone'>";
        echo "</div>";
        }
        echo "<div class='${class}'>";
        echo "<img src='Layers/Noses/" . $pet["noseColor"] . ".png' id = 'Noseone'>";
        echo "</div>";
    if (strpos($pet["specials"], "Wings") !== false) {
            echo "<div class='${class}'>";
            echo "<img src='Layers/Wings/Pegasus/Top/" . $pet["mainColor"] . ".png' id = 'Wingstopone'>";
            echo "</div>";
        }
        echo "<div class='${class}'>";
        echo "<img src='Layers/transparentSquare.png'>";
        echo "</div>";
        
        echo "</div>";
                        
}