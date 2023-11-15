<?php 
function displayPet($pet, $class) {    
    //Pillow Array
    $pillows = ['Blue', 'Green', 'Orange', 'Pink', 'Purple', 'Red', 'Yellow'];
    
    echo '<div class="art-container">';
    if($class === "arttwo") {
        $randomNum = rand(0, count($pillows)-1);
        echo "<div class='${class} pillow'>";
        echo "<img src='Layers/Pillows/" . $pillows[$randomNum] . ".png'>";
        echo "</div>";
    }
    
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
    if (strpos($pet["specials"], "Boots") !== false) {
            echo "<div class='${class}'>";
            echo "<img src='Layers/Markings/Boots/" . $pet["mainColor"] . ".png' id = 'Bootsone'>";
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
        if (strlen($pet['clothesBottom']) > 1) {
        $clothesBottom = explode(' ', $pet['clothesBottom']);
        foreach ($clothesBottom as $clothing) {
            echo "<div class='${class}'>";
         echo "<img src='Layers/ClothesBottom/" . $clothing . ".png'>";  
            echo "</div>";
        } }
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
    if (strlen($pet['clothesBottom']) > 1) {
    $clothesTop = explode(' ', $pet['clothesTop']);
        foreach ($clothesTop as $clothing) {
            echo "<div class='${class}'>";
         echo "<img src='Layers/ClothesTop/" . $clothing . ".png'>";  
            echo "</div>";
        } }
        if (strpos($pet["specials"], "Wings") !== false) {
            echo "<div class='${class}'>";
            echo "<img src='Layers/Wings/Pegasus/Top/" . $pet["mainColor"] . ".png' id = 'TopWingone'>";
            echo "</div>";
        }
        echo "<div class='${class}'>";
        echo "<a href='pet?ID=" . $pet['id'] . "'><img src='Layers/transparentSquare.png'></a>";
        echo "</div>";
        
        echo "</div>";
                        
}