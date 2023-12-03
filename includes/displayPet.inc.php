<?php 
function displayPet($pet, $class) {    
    //Pillow Array
    $pillows = ['Blue', 'Green', 'Orange', 'Pink', 'Purple', 'Red', 'Yellow'];
    
    
    echo '<div class="art-container">';
    if ($pet['mainColor']) {
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
    if (strlen($pet['clothesBoth']) > 1) {
    $clothesBoth = explode(' ', $pet['clothesBoth']);
        foreach ($clothesBoth as $clothing) {
            if($clothing === "AngelSet") {
            echo "<div class='${class}'>";
         echo "<img src='Layers/ClothesBottom/" . $clothing . ".png'>";  
            echo "</div>";
        } } }
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
        echo "<img src='Layers/Faces/" . $pet['mood'] . "/Eyes/" . $pet["eyeColor"] . ".png' id = 'Eyesone'>";
        echo "</div>";
        echo "<div class='${class}'>";
        echo "<img src='Layers/Faces/" . $pet['mood'] . "/Lines/" . $pet["mainColor"] . ".png' id = 'Faceone'>";
        echo "</div>";
    
    if ($pet['mood'] === 'Overwhelmed') {
        echo "<div class='${class}'>";
        echo "<img src='Layers/tear.png' id = 'Tearone'>";
        echo "</div>";
    }
        if (strlen($pet['clothesBottom']) > 1) {
        $clothesBottom = explode(' ', $pet['clothesBottom']);
        foreach ($clothesBottom as $clothing) {
            echo "<div class='${class}'>";
         echo "<img src='Layers/ClothesBottom/" . $clothing . ".png'>";  
            echo "</div>";
        } }
        if (strlen($pet['clothesBoth']) > 1) {
    $clothesBoth = explode(' ', $pet['clothesBoth']);
        foreach ($clothesBoth as $clothing) {
            if(!($clothing === "AngelSet")) {
            echo "<div class='${class}'>";
         echo "<img src='Layers/ClothesBottom/" . $clothing . ".png'>";  
            echo "</div>";
        } } }
        echo "<div class='${class}'>";
        if ($pet["hairType"] === "Floof") {
            echo "<img src='Layers/Hair/" . $pet["hairType"] . "/" . $pet["mainColor"] . ".png' id = 'Hairone'>";
        } else {
            echo '<img src="Layers/Hair/' . $pet['hairType'] . "/" . $pet['hairColor'] . '.png" id="Hairone">';
        }
            echo "</div>";
        if ($pet["tailType"] === "Dragon") {
            echo "<div class='${class}'>";
            echo "<img src='Layers/Tail/Dragon/End/" . $pet["tailColor"] . ".png' id = 'Tailone'>";
            echo "</div>";
            echo "<div class='${class}'>";
            echo "<img src='Layers/Tail/Dragon/" . $pet["mainColor"] . ".png' id = 'TailTopone'>";
            echo "</div>";
        } elseif ($pet['tailType'] === "Mermaid" ) {
            echo "<div class='${class}'>";
            echo "<img src='Layers/Tail/Mermaid/" . $pet["mainColor"] . ".png' id = 'TailTopone'>";
            echo "</div>";
        }else {
            echo "<div class='${class}'>";
        echo "<img src='Layers/Tail/" . $pet["tailType"] . "/" . $pet["tailColor"] . ".png' id = 'Tailone'>";
        echo "</div>";
        }
        echo "<div class='${class}'>";
        echo "<img src='Layers/Noses/" . $pet["noseColor"] . ".png' id = 'Noseone'>";
        echo "</div>";
    if (strlen($pet['clothesTop']) > 1) {
    $clothesTop = explode(' ', $pet['clothesTop']);
        foreach ($clothesTop as $clothing) {
            echo "<div class='${class}'>";
         echo "<img src='Layers/ClothesTop/" . $clothing . ".png'>";  
            echo "</div>";
        } }
        if (strlen($pet['clothesBoth']) > 1) {
    $clothesBoth = explode(' ', $pet['clothesBoth']);
        foreach ($clothesBoth as $clothing) {
            if (!($clothing === "AngelSet")) {
            echo "<div class='${class}'>";
         echo "<img src='Layers/ClothesTop/" . $clothing . ".png'>";  
            echo "</div>";
        } } }
        if (strpos($pet["specials"], "Wings") !== false) {
            echo "<div class='${class}'>";
            echo "<img src='Layers/Wings/Pegasus/Top/" . $pet["mainColor"] . ".png' id = 'TopWingone'>";
            echo "</div>";
        }
        if (strlen($pet['clothesBoth']) > 1) {
    $clothesBoth = explode(' ', $pet['clothesBoth']);
        foreach ($clothesBoth as $clothing) {
            if ($clothing === "AngelSet") {
            echo "<div class='${class}'>";
         echo "<img src='Layers/ClothesTop/" . $clothing . ".png'>";  
            echo "</div>";
        } } }
    }
    if ($class === 'tinyPet') {
        echo "<div class='${class}'>";
        echo "<a href='profile?id=" . $pet['owner_id'] . "'><img src='Layers/transparentSquare.png'></a>";
        echo "</div>";
    } elseif (!$pet['mainColor']) {
        echo "<div class='${class}'>";
        echo "<img src='Layers/transparentSquare.png'>";
        echo "</div>";
    }else {
        echo "<div class='${class}'>";
        echo "<a href='pet?id=" . $pet['id'] . "'><img src='Layers/transparentSquare.png'></a>";
        echo "</div>";
    }

        echo "</div>";
                        
}