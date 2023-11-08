<?php
$userId = $_SESSION['user_id'];

//Grab all the Blueprints From User
$query = "SELECT * FROM blueprints WHERE owner_id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo '<div class="radioStarter">';
foreach ($results as $result) {
    echo '<div>';
    echo '<input type="radio" name="snoozeling" value="' . $result["id"] . '" class="input-hidden />';
    echo '<label for="' . $result["id"] . '">';
    //Display Images
    displayStarter($result, "artStarter");
    echo '</label>';
    echo '</div>';
}
echo '</div>';

function displayStarter($pet, $class) {    
    echo '<div class="art-container">';
    if (strpos($pet["specials"], "Wings") !== false) {
        
            echo "<div class='${class}'>";
            echo "<img src='Layers/Wings/Pegasus/Bottom/" . $pet["mainColor"] . ".png' id = 'BottomWingone'>";
            echo "</div>";
        }
        echo "<div class='${class}'>";
        echo "<img src='Layers/Primary/" . $pet["mainColor"] . ".png' id = 'Primaryone'>";
        echo "</div>";
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
            echo "<img src='Layers/Wings/Pegasus/Top/" . $pet["mainColor"] . ".png' id = 'TopWingone'>";
            echo "</div>";
        }
        echo "<div class='${class}'>";
        echo "<img src='Layers/transparentSquare.png'>";
        echo "</div>";
        
        echo "</div>";
                        
}