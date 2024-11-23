<?php 
function displayPet($pet, $class) {
    
    if (!$pet['mood']) {
        $mood = "Happy";
    } else {
        $mood = $pet['mood'];
    }
    
    echo '<div class="art-container">';
    if ($pet['mainColor']) {
    if($class === "arttwo" || ($class === "artlarge" && $pet['showbed'] == "1")) {
        echo "<div class='${class}'>";
        echo "<img src='Layers/Beds/Back/" . $pet['bedcolor'] . ".png'>";
        echo "</div>";
    } 
    
    if (strpos($pet["specials"], "FeatheredWings") !== false) {
        
            echo "<div class='${class}'>";
            echo "<img src='Layers/Wings/Pegasus/Bottom/" . $pet["mainColor"] . ".png' id = 'BottomWingone'>";
            echo "</div>";
        }
        if (strpos($pet["specials"], "BugWings") !== false) {
        
            echo "<div class='${class}'>";
            echo "<img src='Layers/Wings/BugWingBottom.png' id = 'BottomWingone'>";
            echo "</div>";
        }
    if (strlen($pet['clothesBoth']) > 1) {
    $clothesBoth = explode(' ', $pet['clothesBoth']);
        foreach ($clothesBoth as $clothing) {
            if($clothing === "AngelSet" || $clothing === "AngelWings" || $clothing === "ImpHorns") {
            echo "<div class='${class}'>";
         echo "<img src='Layers/ClothesBottom/" . $clothing . ".png'>";  
            echo "</div>";
        } } }
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
        if (strpos($pet["specials"], "Hearts") !== false) {
            echo "<div class='${class}'>";
            echo "<img src='Layers/Markings/Hearts/" . $pet["mainColor"] . ".png' id = 'Heartsone'>";
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
        if (strpos($pet["specials"], "Skeleton") !== false) {
            echo "<div class='${class}'>";
            echo "<img src='Layers/Skeleton.png' id = 'Skeleton1'>";
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
        $mothArray = ['MothFluffRed','MothFluffOrange','MothFluffYellow','MothFluffGreen','MothFluffBlue','MothFluffPurple','MothFluffBlack','MothFluffBrown','MothFluffPink','MothFluffGold','MothFluffSilver','MothFluffPastelPink','MothFluffPastelBrown','MothFluffPastelPurple','MothFluffPastelBlue','MothFluffTeal','MothFluffBlueberry','MothFluffGooseberry','MothFluffAceLove','MothFluffAnyLove','MothFluffAroLove','MothFluffDoubleLove','MothFluffFemaleLove','MothFluffFluidSelf','MothFluffMaleLove','MothFluffNewSelf','MothFluffRainbowLove','MothFluffUniqueSelf','MothFluffSpooky','MothFluff'];
        foreach ($mothArray as $moth) {
            if (strpos($pet["specials"], $moth) !== false) {
                $mothtype = $moth;
                break;
            }
        }
        if ($mothtype) {
            echo "<div class='${class}'>";
        echo "<img src='Layers/Other/MothFluff/Behind/" . $moth . ".png' id = 'BackFluffOne'>";
        echo "</div>";
        }
        
        if($mood != "Cheeky") {
            echo "<div class='${class}'>";
            echo "<img src='Layers/Faces/" . $mood . "/Eyes/" . $pet["eyeColor"] . ".png' id = 'Eyesone'>";
            echo "</div>";
            if (strpos($pet["specials"],"TinyTooth")) {
                echo "<div class='${class}'>";
                echo "<img src='Layers/Faces/" . $mood . "/TinyTooth.png' id = 'Toothone'>";
                echo "</div>";
            }
            echo "<div class='${class}'>";
            echo "<img src='Layers/Faces/" . $mood . "/Lines/" . $pet["mainColor"] . ".png' id = 'Faceone'>";
            echo "</div>";

            if ($pet['mood'] === 'Overwhelmed') {
                echo "<div class='${class}'>";
                echo "<img src='Layers/tear.png' id = 'Tearone'>";
                echo "</div>";
            }
        }
        
        
        
        
        
        if ($pet["tailType"] === "Dragon") {
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
                if(!($clothing === "AngelSet" || $clothing === "AngelWings" || $clothing === "ImpHorns")) {
                echo "<div class='${class}'>";
             echo "<img src='Layers/ClothesBottom/" . $clothing . ".png'>";  
                echo "</div>";
            } } }
            if ($pet['clothesHoodie']) {
                $clothesHoodies = explode(' ', $pet['clothesHoodie']);
                foreach ($clothesHoodies as $clothing) {
                    echo "<div class='${class}'>";
                 echo "<img src='Layers/ClothesBottom/" . $clothing . ".png'>";  
                    echo "</div>";
                } 
            }
             if (strlen($pet['clothesTop']) > 1 && strpos($pet["clothesTop"], "SpikedBracelet") !== false) {
    $clothesTop = explode(' ', $pet['clothesTop']);
        foreach ($clothesTop as $clothing) {
            if ($clothing == "SpikedBracelet") {
                echo "<div class='${class}'>";
            echo "<img src='Layers/ClothesTop/" . $clothing . ".png'>";  
            echo "</div>";
            }
        } }
            if(($class === "arttwo") || ($class === "artlarge" && $pet['showbed'] == "1")) {
                echo "<div class='${class}'>";
                echo "<img src='Layers/Beds/Front/" . $pet['bedcolor'] . ".png'>";
                echo "</div>";
            }
            echo "<div class='${class}'>";
            echo "<img src='Layers/Tail/Dragon/End/" . $pet["tailColor"] . ".png' id = 'Tailone'>";
            echo "</div>";
            echo "<div class='${class}'>";
            echo "<img src='Layers/Tail/Dragon/" . $pet["mainColor"] . ".png' id = 'TailTopone'>";
            echo "</div>";
        } elseif ($pet['tailType'] === "Mermaid" ) {
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
                if(!($clothing === "AngelSet" || $clothing === "AngelWings" || $clothing === "ImpHorns")) {
                echo "<div class='${class}'>";
             echo "<img src='Layers/ClothesBottom/" . $clothing . ".png'>";  
                echo "</div>";
            } } }
            if ($pet['clothesHoodie']) {
                $clothesHoodies = explode(' ', $pet['clothesHoodie']);
                foreach ($clothesHoodies as $clothing) {
                    echo "<div class='${class}'>";
                 echo "<img src='Layers/ClothesBottom/" . $clothing . ".png'>";  
                    echo "</div>";
                } 
            }
             if (strlen($pet['clothesTop']) > 1 && strpos($pet["clothesTop"], "SpikedBracelet") !== false) {
    $clothesTop = explode(' ', $pet['clothesTop']);
        foreach ($clothesTop as $clothing) {
            if ($clothing == "SpikedBracelet") {
                echo "<div class='${class}'>";
            echo "<img src='Layers/ClothesTop/" . $clothing . ".png'>";  
            echo "</div>";
            }
        } }
            if(($class === "arttwo") || ($class === "artlarge" && $pet['showbed'] == "1")) {
                echo "<div class='${class}'>";
                echo "<img src='Layers/Beds/Front/" . $pet['bedcolor'] . ".png'>";
                echo "</div>";
            }
            echo "<div class='${class}'>";
            echo "<img src='Layers/Tail/Mermaid/" . $pet["mainColor"] . ".png' id = 'TailTopone'>";
            echo "</div>";
        } else if ($pet['tailType'] == "Pom" ) {
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
                if(!($clothing === "AngelSet" || $clothing === "AngelWings" || $clothing === "ImpHorns")) {
                echo "<div class='${class}'>";
             echo "<img src='Layers/ClothesBottom/" . $clothing . ".png'>";  
                echo "</div>";
            } } }
            if ($pet['clothesHoodie']) {
                $clothesHoodies = explode(' ', $pet['clothesHoodie']);
                foreach ($clothesHoodies as $clothing) {
                    echo "<div class='${class}'>";
                 echo "<img src='Layers/ClothesBottom/" . $clothing . ".png'>";  
                    echo "</div>";
                } 
            }
        echo "<div class='${class}'>";
            echo "<img src='Layers/Tail/" . $pet["tailType"] . "/" . $pet["tailColor"] . ".png' id = 'Tailone'>";
            echo "</div>";
             if (strlen($pet['clothesTop']) > 1 && strpos($pet["clothesTop"], "SpikedBracelet") !== false) {
    $clothesTop = explode(' ', $pet['clothesTop']);
        foreach ($clothesTop as $clothing) {
            if ($clothing == "SpikedBracelet") {
                echo "<div class='${class}'>";
            echo "<img src='Layers/ClothesTop/" . $clothing . ".png'>";  
            echo "</div>";
            }
        } }
            if(($class === "arttwo") || ($class === "artlarge" && $pet['showbed'] == "1")) {
                echo "<div class='${class}'>";
                echo "<img src='Layers/Beds/Front/" . $pet['bedcolor'] . ".png'>";
                echo "</div>";
            }
            
        } else if ($pet['tailType'] == "Panther") {
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
                if(!($clothing === "AngelSet" || $clothing === "AngelWings" || $clothing === "ImpHorns")) {
                echo "<div class='${class}'>";
             echo "<img src='Layers/ClothesBottom/" . $clothing . ".png'>";  
                echo "</div>";
            } } }
            if ($pet['clothesHoodie']) {
                $clothesHoodies = explode(' ', $pet['clothesHoodie']);
                foreach ($clothesHoodies as $clothing) {
                    echo "<div class='${class}'>";
                 echo "<img src='Layers/ClothesBottom/" . $clothing . ".png'>";  
                    echo "</div>";
                } 
            }
             if (strlen($pet['clothesTop']) > 1 && strpos($pet["clothesTop"], "SpikedBracelet") !== false) {
    $clothesTop = explode(' ', $pet['clothesTop']);
        foreach ($clothesTop as $clothing) {
            if ($clothing == "SpikedBracelet") {
                echo "<div class='${class}'>";
            echo "<img src='Layers/ClothesTop/" . $clothing . ".png'>";  
            echo "</div>";
            }
        } }
            if(($class === "arttwo") || ($class === "artlarge" && $pet['showbed'] == "1")) {
                echo "<div class='${class}'>";
                echo "<img src='Layers/Beds/Front/" . $pet['bedcolor'] . ".png'>";
                echo "</div>";
            }
            echo "<div class='${class}'>";
            echo "<img src='Layers/Tail/" . $pet["tailType"] . "/" . $pet["tailColor"] . ".png' id = 'Tailone'>";
            echo "</div>";
        
        } else if ($pet['tailType'] == "Lizard") {
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
                if(!($clothing === "AngelSet" || $clothing === "AngelWings" || $clothing === "ImpHorns")) {
                echo "<div class='${class}'>";
             echo "<img src='Layers/ClothesBottom/" . $clothing . ".png'>";  
                echo "</div>";
            } } }
            if ($pet['clothesHoodie']) {
                $clothesHoodies = explode(' ', $pet['clothesHoodie']);
                foreach ($clothesHoodies as $clothing) {
                    echo "<div class='${class}'>";
                 echo "<img src='Layers/ClothesBottom/" . $clothing . ".png'>";  
                    echo "</div>";
                } 
            }
             if (strlen($pet['clothesTop']) > 1 && strpos($pet["clothesTop"], "SpikedBracelet") !== false) {
    $clothesTop = explode(' ', $pet['clothesTop']);
        foreach ($clothesTop as $clothing) {
            if ($clothing == "SpikedBracelet") {
                echo "<div class='${class}'>";
            echo "<img src='Layers/ClothesTop/" . $clothing . ".png'>";  
            echo "</div>";
            }
        } }
            if(($class === "arttwo") || ($class === "artlarge" && $pet['showbed'] == "1")) {
                echo "<div class='${class}'>";
                echo "<img src='Layers/Beds/Front/" . $pet['bedcolor'] . ".png'>";
                echo "</div>";
            }
            echo "<div class='${class}'>";
            echo "<img src='Layers/Tail/Lizard/Spikes/" . $pet["tailColor"] . ".png' id = 'Tailone'>";
            echo "</div>";
            echo "<div class='${class}'>";
            echo "<img src='Layers/Tail/Lizard/" . $pet["mainColor"] . ".png' id = 'TailTopone'>";
            echo "</div>";
        } else {
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
                if(!($clothing === "AngelSet" || $clothing === "AngelWings" || $clothing === "ImpHorns")) {
                echo "<div class='${class}'>";
             echo "<img src='Layers/ClothesBottom/" . $clothing . ".png'>";  
                echo "</div>";
            } } }
            if ($pet['clothesHoodie']) {
                $clothesHoodies = explode(' ', $pet['clothesHoodie']);
                foreach ($clothesHoodies as $clothing) {
                    echo "<div class='${class}'>";
                 echo "<img src='Layers/ClothesBottom/" . $clothing . ".png'>";  
                    echo "</div>";
                } 
            }
            echo "<div class='${class}'>";
            echo "<img src='Layers/Tail/" . $pet["tailType"] . "/" . $pet["tailColor"] . ".png' id = 'Tailone'>";
            echo "</div>";
             if (strlen($pet['clothesTop']) > 1 && strpos($pet["clothesTop"], "SpikedBracelet") !== false) {
    $clothesTop = explode(' ', $pet['clothesTop']);
        foreach ($clothesTop as $clothing) {
            if ($clothing == "SpikedBracelet") {
                echo "<div class='${class}'>";
            echo "<img src='Layers/ClothesTop/" . $clothing . ".png'>";  
            echo "</div>";
            }
        } }
        if(($class === "arttwo") || ($class === "artlarge" && $pet['showbed'] == "1")) {
                echo "<div class='${class}'>";
                echo "<img src='Layers/Beds/Front/" . $pet['bedcolor'] . ".png'>";
                echo "</div>";
            }
        }
        
        echo "<div class='${class}'>";
        if (!$pet['clothesHoodie']) {
        if ($pet["hairType"] === "Floof") {
            echo "<img src='Layers/Hair/" . $pet["hairType"] . "/" . $pet["mainColor"] . ".png' id = 'Hairone'>";
        } else {
            if (strpos($pet["specials"], "FeatheredWings") !== false && $pet["hairType"] == "Knitted") {
                
            } else {
            echo '<img src="Layers/Hair/' . $pet['hairType'] . "/" . $pet['hairColor'] . '.png" id="Hairone">';
            }
        } }
            echo "</div>";
            
        }
    
    $clothesTop = explode(' ', $pet['clothesTop']);
        foreach ($clothesTop as $clothing) {
    if ($mood == "Cheeky" && str_contains($clothing, "Bandana")) {
        echo "<div class='${class}'>";
                echo "<img src='Layers/ClothesTop/" . $clothing . ".png'>";  
                echo "</div>";
    } }
    
    if($mood == "Cheeky") {
        echo "<div class='${class}'>";
            echo "<img src='Layers/Faces/" . $mood . "/Tongue/" . $pet["noseColor"] . ".png' id = 'Tongueone'>";
            echo "</div>";    
        if (strpos($pet["specials"],"TinyTooth")) {
                echo "<div class='${class}'>";
                echo "<img src='Layers/Faces/" . $mood . "/TinyTooth.png' id = 'Toothone'>";
                echo "</div>";
            }
        
        echo "<div class='${class}'>";
            echo "<img src='Layers/Faces/" . $mood . "/Lines/" . $pet["mainColor"] . ".png' id = 'Faceone'>";
            echo "</div>";
            
            
        } 
    
    if ($mothtype) {
            echo "<div class='${class}'>";
        echo "<img src='Layers/Other/MothFluff/" . $moth . ".png' id = 'FrontFluffOne'>";
        echo "</div>";
        }

        echo "<div class='${class}'>";
        echo "<img src='Layers/Noses/" . $pet["noseColor"] . ".png' id = 'Noseone'>";
        echo "</div>";
    
    if (strlen($pet['clothesTop']) > 1) {
    $clothesTop = explode(' ', $pet['clothesTop']);
        foreach ($clothesTop as $clothing) {
            if ($clothing == "SpikedBracelet" || ($mood == "Cheeky" && str_contains($clothing, "Bandana"))) {
                
            } else {
                echo "<div class='${class}'>";
                echo "<img src='Layers/ClothesTop/" . $clothing . ".png'>";  
                echo "</div>";
            }
            
        } }
   
        if (strlen($pet['clothesBoth']) > 1) {
    $clothesBoth = explode(' ', $pet['clothesBoth']);
        foreach ($clothesBoth as $clothing) {
            if (!($clothing === "AngelSet" || $clothing === "AngelWings" || $clothing === "ImpHorns")) {
            echo "<div class='${class}'>";
         echo "<img src='Layers/ClothesTop/" . $clothing . ".png'>";  
            echo "</div>";
        } } }
    
    if (strpos($pet["specials"], "BugWings") !== false) {
        
            echo "<div class='${class}'>";
            echo "<img src='Layers/Wings/BugWingTop.png' id = 'TopWingone'>";
            echo "</div>";
        }
        if (strpos($pet["specials"], "FeatheredWings") !== false) {
            echo "<div class='${class}'>";
            echo "<img src='Layers/Wings/Pegasus/Top/" . $pet["mainColor"] . ".png' id = 'TopWingone'>";
            echo "</div>";
            if ($pet["hairType"] === "Knitted" && strlen($pet['clothesHoodie']) < 1) {
                echo "<div class='${class}'>";
                echo '<img src="Layers/Hair/Knitted/' . $pet['hairColor'] . '.png" id="Hairone">';
                echo "</div>";
            } else {
                
            }
        }
    if (strlen($pet['clothesBoth']) > 1 && strpos($pet["clothesBoth"], "RamHorns") !== false) {
    $clothesTop = explode(' ', $pet['clothesBoth']);
        foreach ($clothesTop as $clothing) {
            if ($clothing == "RamHorns") {
                echo "<div class='${class}'>";
                echo "<img src='Layers/ClothesTop/" . $clothing . ".png'>";  
                echo "</div>";
            }
            
        } }

        
        
        if ($pet['clothesHoodie']) {
            $clothesHoodies = explode(' ', $pet['clothesHoodie']);
        foreach ($clothesHoodies as $clothing) {
            echo "<div class='${class}'>";
         echo "<img src='Layers/ClothesTop/" . $clothing . ".png'>";  
            echo "</div>";
        } 
        }
        if (strlen($pet['clothesBoth']) > 1) {
    $clothesBoth = explode(' ', $pet['clothesBoth']);
        foreach ($clothesBoth as $clothing) {
            if ($clothing === "AngelSet" || $clothing === "AngelWings" || $clothing === "ImpHorns") {
            echo "<div class='${class}'>";
         echo "<img src='Layers/ClothesTop/" . $clothing . ".png'>";  
            echo "</div>";
        } }
    }

    if ($class === 'tinyPet') {
        echo "<div class='${class}'>";
        echo "<a href='profile?id=" . $pet['owner_id'] . "'><img src='Layers/transparentSquare.png'></a>";
        echo "</div>";
    } else if (!$pet['mainColor'] || $class === "artcrafting" || $class === "artfriends" || $class === "mailPetAnon") {
        echo "<div class='${class}'>";
        echo "<img src='Layers/transparentSquare.png'>";
        echo "</div>";
    } else {
        echo "<div class='${class}'>";
        echo "<a href='pet?id=" . $pet['id'] . "'><img src='Layers/transparentSquare.png'></a>";
        echo "</div>";
    }

        echo "</div>";
                        
}