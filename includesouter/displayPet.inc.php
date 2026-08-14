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
    } }
    
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
        
        if (strpos($pet["specials"], "Collie") !== false) {
            echo "<div class='${class}'>";
            echo "<img src='Layers/Other/Collie.png' id = 'Collieone'>";
            echo "</div>";
        }
        
        if (strpos($pet["specials"], "Foxy") !== false) {
            echo "<div class='${class}'>";
            echo "<img src='Layers/Markings/Foxy/" . $pet["mainColor"] . ".png' id = 'Foxyone'>";
            echo "</div>";
        }
        
        
        
        if (strpos($pet["specials"], "EarTip") !== false) {
            echo "<div class='${class}'>";
            echo "<img src='Layers/Other/EarTip.png' id = 'EarTipone'>";
            echo "</div>";
        }
    
        if (strpos($pet["specials"], "Skeleton") !== false) {
            echo "<div class='${class}'>";
            echo "<img src='Layers/Skeleton.png' id = 'Skeleton1'>";
            echo "</div>";
        }
    
        if (strpos($pet["specials"], "Flurry") !== false) {
            echo "<div class='${class}'>";
            echo "<img src='Layers/Markings/Flurry/" . $pet["mainColor"] . ".png' id = 'Flurrone'>";
            echo "</div>";
        }
    
    if (strpos($pet["specials"], "Scales") !== false) {
            echo "<div class='${class}'>";
            echo "<img src='Layers/Markings/Scales/" . $pet["mainColor"] . ".png' id = 'Scalesone'>";
            echo "</div>";
        }
    
    if (strpos($pet["specials"], "Belly") !== false) {
            echo "<div class='${class}'>";
            echo "<img src='Layers/Markings/Belly/" . $pet["mainColor"] . ".png' id = 'Bellyone'>";
            echo "</div>";
        }
        
        //Ears
        if(strpos($pet["specials"], "EarBands") !== false) {
            echo "<div class='${class}'>";
            echo "<img src='Layers/Other/EarBands/" . $pet["noseColor"] . ".png' id = 'Earone'>";
            echo "</div>";
        } else {
            echo "<div class='${class}'>";
            echo "<img src='Layers/Ear/" . $pet["noseColor"] . ".png' id = 'Earone'>";
            echo "</div>";
        }
        
        
        
        
        
        if($mood != "Cheeky") {            
            echo "<div class='${class}'>";
            echo "<img src='Layers/Faces/" . $mood . "/Eyes/" . $pet["eyeColor"] . ".png' id = 'Eyesone'>";
            echo "</div>";
            if (strpos($pet["specials"],"TinyTooth") !== false) {
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
        
        echo "<div class='${class}'>";
        echo "<img src='Layers/MainLines/" . $pet["mainColor"] . ".png' id = 'Mainlinesone'>";
        echo "</div>";
        
        $mothArray = ['MothFluffRed','MothFluffOrange','MothFluffYellow','MothFluffGreen','MothFluffPurple','MothFluffBlack','MothFluffBrown','MothFluffPink','MothFluffGold','MothFluffSilver','MothFluffPastelPink','MothFluffPastelBrown','MothFluffPastelPurple','MothFluffPastelBlue','MothFluffTeal','MothFluffBlueberry','MothFluffGooseberry','MothFluffAceLove','MothFluffAnyLove','MothFluffAroLove','MothFluffDoubleLove','MothFluffFemaleLove','MothFluffFluidSelf','MothFluffMaleLove','MothFluffNewSelf','MothFluffRainbowLove','MothFluffUniqueSelf','MothFluffSpooky','MothFluffBlue','MothFluffDisabilityPride','MothFluff'];
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
        
        
        
        
        if (strpos($pet["specials"], "NoTail") !== false) {



        if(($class === "arttwo") || ($class === "artlarge" && $pet['showbed'] == "1")) {
                echo "<div class='${class}'>";
                echo "<img src='Layers/Beds/Front/" . $pet['bedcolor'] . ".png'>";
                echo "</div>";
            }
            
        } else if ($pet["tailType"] === "Dragon") {


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


            if(($class === "arttwo") || ($class === "artlarge" && $pet['showbed'] == "1")) {
                echo "<div class='${class}'>";
                echo "<img src='Layers/Beds/Front/" . $pet['bedcolor'] . ".png'>";
                echo "</div>";
            }
            echo "<div class='${class}'>";
            echo "<img src='Layers/Tail/Mermaid/" . $pet["mainColor"] . ".png' id = 'TailTopone'>";
            echo "</div>";
            

        } else if ($pet['tailType'] == "Pom" ) {


        echo "<div class='${class}'>";
            echo "<img src='Layers/Tail/" . $pet["tailType"] . "/" . $pet["tailColor"] . ".png' id = 'Tailone'>";
            echo "</div>";

            if(($class === "arttwo") || ($class === "artlarge" && $pet['showbed'] == "1")) {
                echo "<div class='${class}'>";
                echo "<img src='Layers/Beds/Front/" . $pet['bedcolor'] . ".png'>";
                echo "</div>";
            }
            
        } else if ($pet['tailType'] == "Panther" || $pet['tailType'] == "Holiday" || $pet['tailType'] == "Braid") {


            if(($class === "arttwo") || ($class === "artlarge" && $pet['showbed'] == "1")) {
                echo "<div class='${class}'>";
                echo "<img src='Layers/Beds/Front/" . $pet['bedcolor'] . ".png'>";
                echo "</div>";
            }
            echo "<div class='${class}'>";
            echo "<img src='Layers/Tail/" . $pet["tailType"] . "/" . $pet["tailColor"] . ".png' id = 'Tailone'>";
            echo "</div>";
        

        } else if ($pet['tailType'] == "Lizard") {

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
            

        } else if ($pet['tailType'] == "Tailless") {
            

        if(($class === "arttwo") || ($class === "artlarge" && $pet['showbed'] == "1")) {
                echo "<div class='${class}'>";
                echo "<img src='Layers/Beds/Front/" . $pet['bedcolor'] . ".png'>";
                echo "</div>";
            }
            

        } else {

            echo "<div class='${class}'>";
            echo "<img src='Layers/Tail/" . $pet["tailType"] . "/" . $pet["tailColor"] . ".png' id = 'Tailone'>";
            echo "</div>";

        if(($class === "arttwo") || ($class === "artlarge" && $pet['showbed'] == "1")) {
                echo "<div class='${class}'>";
                echo "<img src='Layers/Beds/Front/" . $pet['bedcolor'] . ".png'>";
                echo "</div>";
            }
            

        }
        

    

    
    if($mood == "Cheeky") {
        echo "<div class='${class}'>";
            echo "<img src='Layers/Faces/" . $mood . "/Tongue/" . $pet["noseColor"] . ".png' id = 'Tongueone'>";
            echo "</div>";    
        if (strpos($pet["specials"],"TinyTooth") !== false) {
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
        
        //Nose
    if (strpos($pet["specials"], "DualNose") !== false) {
        
        $fabrics = ['PurplePlaid','GoldHearts','PastelPinkDots','PastelBlueDots','PastelPurpleDots','Forest','Ocean','CowGrey','CowBlue','CowBrown','CowPink','SilverHearts','PastelBrownDots','Leaves','Acorns','PinkPetals','Waves','PastelShapes','RetroFloor','Spooky','Mistletoe','HolidayBlanket','HolidayTreats'];
        
        if (in_array($pet['noseColor'],$fabrics)) {
            echo "<div class='${class}'>";
            echo "<img src='Layers/Noses/" . $pet["noseColor"] . ".png' id = 'Noseone'>";
            echo "</div>";
        } else {
            echo "<div class='${class}'>";
            echo "<img src='Layers/Other/DualNose/" . $pet["noseColor"] . ".png' id = 'Noseone'>";
            echo "</div>";
        }
    } else {
        echo "<div class='${class}'>";
        echo "<img src='Layers/Noses/" . $pet["noseColor"] . ".png' id = 'Noseone'>";
        echo "</div>";
    }
        
    

   

    
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


    echo "<div class='${class}'>";
                echo '<img src="Layers/Hair/' . $pet['hairType'] . '/' . $pet['hairColor'] . '.png" id="Hairone">';
                echo "</div>";
        
        



    if ($class === 'tinyPet') {
        echo "<div class='${class}'>";
        echo "<a href='profile?id=" . $pet['owner_id'] . "'><img src='Layers/transparentSquare.png'></a>";
        echo "</div>";
    } else if (!$pet['mainColor'] || $class === "artcrafting" || $class === "artfriends" || $class === "mailPetAnon" || $class === "artStarter") {
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
