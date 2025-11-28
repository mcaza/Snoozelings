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
        
        if (strpos($pet["specials"], "Scales") !== false) {
            echo "<div class='${class}'>";
            echo "<img src='Layers/Markings/Scales/" . $pet["mainColor"] . ".png' id = 'Scalesone'>";
            echo "</div>";
        }
        
        if (strpos($pet["specials"], "EarTip") !== false) {
            echo "<div class='${class}'>";
            echo "<img src='Layers/Other/EarTip.png' id = 'EarTipone'>";
            echo "</div>";
        }
        
        //Ears
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
        
        $mothArray = ['MothFluffRed','MothFluffOrange','MothFluffYellow','MothFluffGreen','MothFluffPurple','MothFluffBlack','MothFluffBrown','MothFluffPink','MothFluffGold','MothFluffSilver','MothFluffPastelPink','MothFluffPastelBrown','MothFluffPastelPurple','MothFluffPastelBlue','MothFluffTeal','MothFluffBlueberry','MothFluffGooseberry','MothFluffAceLove','MothFluffAnyLove','MothFluffAroLove','MothFluffDoubleLove','MothFluffFemaleLove','MothFluffFluidSelf','MothFluffMaleLove','MothFluffNewSelf','MothFluffRainbowLove','MothFluffUniqueSelf','MothFluffSpooky','MothFluffBlue','MothFluff'];
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
                if (strpos($pet["clothesTop"], "Collar") !== false) {
                    $collarCheck = explode(' ', $pet['clothesTop']);
                    foreach ($collarCheck as $collar) {
                        if (strpos($pet["clothesTop"], "Collar") !== false) {
                            echo "<div class='${class}'>";
                        echo "<img src='Layers/ClothesTop/" . $collar . ".png'>";  
                        echo "</div>";
                        }
                    }
                }
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
            
            //Cloak Fix
            foreach ($clothesBoth as $clothing) {
                if (strpos($pet["clothesBoth"], "Cloak") !== false) {
                    echo "<div class='${class}'>";
                     echo "<img src='Layers/ClothesBottom/" . $clothing . ".png'>";  
                        echo "</div>";
                }
            }
        } else if ($pet["tailType"] === "Dragon") {
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
                if (strpos($pet["clothesTop"], "Collar") !== false) {
                    $collarCheck = explode(' ', $pet['clothesTop']);
                    foreach ($collarCheck as $collar) {
                        if (strpos($pet["clothesTop"], "Collar") !== false) {
                            echo "<div class='${class}'>";
                        echo "<img src='Layers/ClothesTop/" . $collar . ".png'>";  
                        echo "</div>";
                        }
                    }
                }
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
            
            //Cloak Fix
            foreach ($clothesBoth as $clothing) {
                if (strpos($pet["clothesBoth"], "Cloak") !== false) {
                    echo "<div class='${class}'>";
                     echo "<img src='Layers/ClothesBottom/" . $clothing . ".png'>";  
                        echo "</div>";
                }
            }
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
                if (strpos($pet["clothesTop"], "Collar") !== false) {
                    $collarCheck = explode(' ', $pet['clothesTop']);
                    foreach ($collarCheck as $collar) {
                        if (strpos($pet["clothesTop"], "Collar") !== false) {
                            echo "<div class='${class}'>";
                        echo "<img src='Layers/ClothesTop/" . $collar . ".png'>";  
                        echo "</div>";
                        }
                    }
                }
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
            
            //Cloak Fix
            foreach ($clothesBoth as $clothing) {
                if (strpos($pet["clothesBoth"], "Cloak") !== false) {
                    echo "<div class='${class}'>";
                     echo "<img src='Layers/ClothesBottom/" . $clothing . ".png'>";  
                        echo "</div>";
                }
            }
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
                if (strpos($pet["clothesTop"], "Collar") !== false) {
                    $collarCheck = explode(' ', $pet['clothesTop']);
                    foreach ($collarCheck as $collar) {
                        if (strpos($pet["clothesTop"], "Collar") !== false) {
                            echo "<div class='${class}'>";
                        echo "<img src='Layers/ClothesTop/" . $collar . ".png'>";  
                        echo "</div>";
                        }
                    }
                }
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
            
        } else if ($pet['tailType'] == "Panther" || $pet['tailType'] == "Holiday" || $pet['tailType'] == "Braid") {
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
                if (strpos($pet["clothesTop"], "Collar") !== false) {
                    $collarCheck = explode(' ', $pet['clothesTop']);
                    foreach ($collarCheck as $collar) {
                        if (strpos($pet["clothesTop"], "Collar") !== false) {
                            echo "<div class='${class}'>";
                        echo "<img src='Layers/ClothesTop/" . $collar . ".png'>";  
                        echo "</div>";
                        }
                    }
                }
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
        
            //Cloak Fix
            foreach ($clothesBoth as $clothing) {
                if (strpos($pet["clothesBoth"], "Cloak") !== false) {
                    echo "<div class='${class}'>";
                     echo "<img src='Layers/ClothesBottom/" . $clothing . ".png'>";  
                        echo "</div>";
                }
            }
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
                if (strpos($pet["clothesTop"], "Collar") !== false) {
                    $collarCheck = explode(' ', $pet['clothesTop']);
                    foreach ($collarCheck as $collar) {
                        if (strpos($pet["clothesTop"], "Collar") !== false) {
                            echo "<div class='${class}'>";
                        echo "<img src='Layers/ClothesTop/" . $collar . ".png'>";  
                        echo "</div>";
                        }
                    }
                }
                
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
            
            //Cloak Fix
            foreach ($clothesBoth as $clothing) {
                if (strpos($pet["clothesBoth"], "Cloak") !== false) {
                    echo "<div class='${class}'>";
                     echo "<img src='Layers/ClothesBottom/" . $clothing . ".png'>";  
                        echo "</div>";
                }
            }
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
                if (strpos($pet["clothesTop"], "Collar") !== false) {
                    $collarCheck = explode(' ', $pet['clothesTop']);
                    foreach ($collarCheck as $collar) {
                        if (strpos($pet["clothesTop"], "Collar") !== false) {
                            echo "<div class='${class}'>";
                        echo "<img src='Layers/ClothesTop/" . $collar . ".png'>";  
                        echo "</div>";
                        }
                    }
                }
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
            
            //Cloak Fix
            foreach ($clothesBoth as $clothing) {
                if (strpos($pet["clothesBoth"], "Cloak") !== false) {
                    echo "<div class='${class}'>";
                     echo "<img src='Layers/ClothesBottom/" . $clothing . ".png'>";  
                        echo "</div>";
                }
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
        
    
    if (strlen($pet['clothesTop']) > 1) {
    $clothesTop = explode(' ', $pet['clothesTop']);
        foreach ($clothesTop as $clothing) {
            if ($clothing == "SpikedBracelet" || ($mood == "Cheeky" && str_contains($clothing, "Bandana")) || (str_contains($clothing, "Collar") && $pet['clothesHoodie'])) {
                
            } else {
                echo "<div class='${class}'>";
                echo "<img src='Layers/ClothesTop/" . $clothing . ".png'>";  
                echo "</div>";
            }
            
        } }
   
        if (strlen($pet['clothesBoth']) > 1) {
    $clothesBoth = explode(' ', $pet['clothesBoth']);
        foreach ($clothesBoth as $clothing) {
            if (!($clothing === "AngelSet" || $clothing === "AngelWings" || $clothing === "ImpHorns" || str_contains($clothing, "Sweater"))) {
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
    
    if (strlen($pet['clothesBoth']) > 1 && strpos($pet["clothesBoth"], "Sweater") !== false) {
    $clothesTop = explode(' ', $pet['clothesBoth']);
        foreach ($clothesTop as $clothing) {
            if (str_contains($clothing, "Sweater")) {
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
    if ($pet['hairType'] == "Holiday" || $pet['hairType'] == "Braid" || $pet['hairType'] == "Knitted") {
        $hairCheck = 1;
    }
        if (strlen($pet['clothesBoth']) > 1) {
    $clothesBoth = explode(' ', $pet['clothesBoth']);
        foreach ($clothesBoth as $clothing) {
            if ($clothing === "AngelSet" || $clothing === "AngelWings" || $clothing === "ImpHorns" || $clothing === "TwiggyAntlers" || $clothing === "DeerAntlers" || str_contains($clothing,"Cloak")) {
            echo "<div class='${class}'>";
            echo "<img src='Layers/ClothesTop/" . $clothing . ".png'>";  
            echo "</div>";
        } else if (str_contains($clothing, "Sweater")) {
                echo "<div class='${class}'>";
            echo "<img src='Layers/ClothesTop/" . $clothing . ".png'>";  
            echo "</div>";
                if ($hairCheck == 1) {
                echo "<div class='${class}'>";
                echo '<img src="Layers/Hair/' . $pet['hairType'] . '/' . $pet['hairColor'] . '.png" id="Hairone">';
                echo "</div>";
                }
            } 
            
         if (str_contains($clothing,"Cloak") && $hairCheck == 1) {
                echo "<div class='${class}'>";
                echo '<img src="Layers/Hair/' . $pet['hairType'] . '/' . $pet['hairColor'] . '.png" id="Hairone">';
                echo "</div>";
            } 
        }
    }

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

function singleImage($pet) {
        
    if (!$pet['mood']) {
        $mood = "Happy";
    } else {
        $mood = $pet['mood'];
    }
        
    //Image Start
    $bg = 'Layers/transparentSquare.png';

    $numberOfImages = 3;
    $x = 1250;
    $y = 1250;
    $background = imagecreatefrompng($bg);
    
    imageAlphaBlending($background, true);
    imageSaveAlpha($background, true);
    
    $outputImage = $background;
    
    $dest = 'snoozelings/' . $pet['id'] . '.png';
        
    if ($pet['mainColor']) {
    //Bed Code
        
    /* if($class === "arttwo" || ($class === "artlarge" && $pet['showbed'] == "1")) {
        echo "<div class='${class}'>";
        echo "<img src='Layers/Beds/Back/" . $pet['bedcolor'] . ".png'>";
        echo "</div>";
    } */
    
    //Wings
    if (strpos($pet["specials"], "FeatheredWings") !== false) {
            $url = 'Layers/Wings/Pegasus/Bottom/' . $pet['mainColor'] . '.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);
        }
        if (strpos($pet["specials"], "BugWings") !== false) {
            $url = 'Layers/Wings/BugWingBottom.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);
        }
        
    //Bottom Wing Accessories or Horns
    if (strlen($pet['clothesBoth']) > 1) {
    $clothesBoth = explode(' ', $pet['clothesBoth']);
        foreach ($clothesBoth as $clothing) {
            if($clothing === "AngelSet" || $clothing === "AngelWings" || $clothing === "ImpHorns") {
                $url = 'Layers/ClothesBottom/' . $clothing . '.png';
                $image = imagecreatefrompng($url);
                imagecopy($outputImage,$image,0,0,0,0, $x, $y);
            } 
        } 
    }
        //Primary Color
        $url = 'Layers/Primary/' . $pet['mainColor'] . '.png';
        $image = imagecreatefrompng($url);
        imagecopy($outputImage,$image,0,0,0,0, $x, $y);
        
        //Markings
        if (strpos($pet["specials"], "Cupid") !== false) {
            $url = 'Layers/Markings/Cupid/' . $pet['mainColor'] . '.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);
        }

    
    if (strpos($pet["specials"], "Spots") !== false) {
            $url = 'Layers/Markings/Spots/' . $pet['mainColor'] . '.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);
        }

    
    if (strpos($pet["specials"], "Boots") !== false) {
            $url = 'Layers/Markings/Boots/' . $pet['mainColor'] . '.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);
        }
        if (strpos($pet["specials"], "Sublimation") !== false) {
            $url = 'Layers/Markings/Sublimation/' . $pet['mainColor'] . '.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);
        }
        
        if (strpos($pet["specials"], "Collie") !== false) {
            $url = 'Layers/Other/Collie.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);
        }
        
        if (strpos($pet["specials"], "Foxy") !== false) {
            $url = 'Layers/Markings/Foxy/' . $pet['mainColor'] . '.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);
        }
        
        if (strpos($pet["specials"], "Scales") !== false) {
            $url = 'Layers/Markings/Scales/' . $pet['noseColor'] . '.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);
        }
        
        if (strpos($pet["specials"], "EarTip") !== false) {
            $url = 'Layers/Other/EarTip.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);
        }
                                                

        if (strpos($pet["specials"], "Skeleton") !== false) {
            $url = 'Layers/Skeleton.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);
        }

        if (strpos($pet["specials"], "Belly") !== false) {
            $url = 'Layers/Markings/Belly/' . $pet['mainColor'] . '.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);
        }
        

        //Ear Color
        $url = 'Layers/Ear/' . $pet['noseColor'] . '.png';
        $image = imagecreatefrompng($url);
        imagecopy($outputImage,$image,0,0,0,0, $x, $y);
        
        //Main Lines
        $url = 'Layers/MainLines/' . $pet['mainColor'] . '.png';
        $image = imagecreatefrompng($url);
        imagecopy($outputImage,$image,0,0,0,0, $x, $y);
        
        //MothFluff
        $mothArray = ['MothFluffRed','MothFluffOrange','MothFluffYellow','MothFluffGreen','MothFluffPurple','MothFluffBlack','MothFluffBrown','MothFluffPink','MothFluffGold','MothFluffSilver','MothFluffPastelPink','MothFluffPastelBrown','MothFluffPastelPurple','MothFluffPastelBlue','MothFluffTeal','MothFluffBlueberry','MothFluffGooseberry','MothFluffAceLove','MothFluffAnyLove','MothFluffAroLove','MothFluffDoubleLove','MothFluffFemaleLove','MothFluffFluidSelf','MothFluffMaleLove','MothFluffNewSelf','MothFluffRainbowLove','MothFluffUniqueSelf','MothFluffSpooky','MothFluffBlue','MothFluff'];
        foreach ($mothArray as $moth) {
            if (strpos($pet["specials"], $moth) !== false) {
                $mothtype = $moth;
                break;
            }
        }
        if ($mothtype) {  
            $url = 'Layers/Other/MothFluff/Behind/' . $moth . '.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);
        }
        
        //Not Cheeky Face
        if($mood !== "Cheeky") {
            $url = 'Layers/Faces/' . $mood . '/Eyes/' .  $pet['eyeColor'] . '.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);
            
            //Tiny Tooth
            if (strpos($pet["specials"],"TinyTooth") !== false) {
                $url = 'Layers/Faces/' . $mood . '/TinyTooth.png';
                $image = imagecreatefrompng($url);
                imagecopy($outputImage,$image,0,0,0,0, $x, $y);      
            }
            $url = 'Layers/Faces/' . $mood . '/Lines/' .  $pet['mainColor'] . '.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);

            if ($pet['mood'] === 'Overwhelmed') {
                $url = 'Layers/tear.png';
                $image = imagecreatefrompng($url);
                imagecopy($outputImage,$image,0,0,0,0, $x, $y); 

            }
        }
        
        
        
        
        //Different Tails = Different Orders
        if ($pet["tailType"] === "Dragon") {
            //Dragon Tail
            if (strlen($pet['clothesBottom']) > 1) {
            $clothesBottom = explode(' ', $pet['clothesBottom']);
            foreach ($clothesBottom as $clothing) {
                $url = 'Layers/ClothesBottom/' . $clothing . '.png';
                $image = imagecreatefrompng($url);
                imagecopy($outputImage,$image,0,0,0,0, $x, $y);
            } }
            if (strlen($pet['clothesBoth']) > 1) {
            $clothesBoth = explode(' ', $pet['clothesBoth']);
            foreach ($clothesBoth as $clothing) {
                if(!($clothing === "AngelSet" || $clothing === "AngelWings" || $clothing === "ImpHorns")) {
                    $url = 'Layers/ClothesBottom/' . $clothing . '.png';
                    $image = imagecreatefrompng($url);
                    imagecopy($outputImage,$image,0,0,0,0, $x, $y);
            } } }
            if ($pet['clothesHoodie']) {
                if (strpos($pet["clothesTop"], "Collar") !== false) {
                    $collarCheck = explode(' ', $pet['clothesTop']);
                    foreach ($collarCheck as $collar) {
                        if (strpos($pet["clothesTop"], "Collar") !== false) {
                            $url = 'Layers/ClothesTop/' . $collar . '.png';
                        $image = imagecreatefrompng($url);
                        imagecopy($outputImage,$image,0,0,0,0, $x, $y);
                        }
                    }
                }
                $clothesHoodies = explode(' ', $pet['clothesHoodie']);
                foreach ($clothesHoodies as $clothing) {
                    $url = 'Layers/ClothesBottom/' . $clothing . '.png';
                    $image = imagecreatefrompng($url);
                    imagecopy($outputImage,$image,0,0,0,0, $x, $y);
                } 
            }
             if (strlen($pet['clothesTop']) > 1 && strpos($pet["clothesTop"], "SpikedBracelet") !== false) {
    $clothesTop = explode(' ', $pet['clothesTop']);
        foreach ($clothesTop as $clothing) {
            if ($clothing == "SpikedBracelet") {
                $url = 'Layers/ClothesTop/' . $clothing . '.png';
                $image = imagecreatefrompng($url);
                imagecopy($outputImage,$image,0,0,0,0, $x, $y);
            }
        } }
            //Bed Code
            /* if(($class === "arttwo") || ($class === "artlarge" && $pet['showbed'] == "1")) {
                echo "<div class='${class}'>";
                echo "<img src='Layers/Beds/Front/" . $pet['bedcolor'] . ".png'>";
                echo "</div>";
            } */
            $url = 'Layers/Tail/Dragon/End/' .  $pet['tailColor'] . '.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);
            $url = 'Layers/Tail/Dragon/' .  $pet['mainColor'] . '.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);

        } elseif ($pet['tailType'] === "Mermaid" ) {
            //Mermaid Tail
            if (strlen($pet['clothesBottom']) > 1) {
            $clothesBottom = explode(' ', $pet['clothesBottom']);
            foreach ($clothesBottom as $clothing) {
                $url = 'Layers/ClothesBottom/' . $clothing . '.png';
                $image = imagecreatefrompng($url);
                imagecopy($outputImage,$image,0,0,0,0, $x, $y);
            } }
            if (strlen($pet['clothesBoth']) > 1) {
            $clothesBoth = explode(' ', $pet['clothesBoth']);
            foreach ($clothesBoth as $clothing) {
                if(!($clothing === "AngelSet" || $clothing === "AngelWings" || $clothing === "ImpHorns")) {
                    $url = 'Layers/ClothesBottom/' . $clothing . '.png';
                    $image = imagecreatefrompng($url);
                    imagecopy($outputImage,$image,0,0,0,0, $x, $y);
            } } }
            if ($pet['clothesHoodie']) {
                if (strpos($pet["clothesTop"], "Collar") !== false) {
                    $collarCheck = explode(' ', $pet['clothesTop']);
                    foreach ($collarCheck as $collar) {
                        if (strpos($pet["clothesTop"], "Collar") !== false) {
                            $url = 'Layers/ClothesTop/' . $collar . '.png';
                        $image = imagecreatefrompng($url);
                        imagecopy($outputImage,$image,0,0,0,0, $x, $y);
                        }
                    }
                }
                $clothesHoodies = explode(' ', $pet['clothesHoodie']);
                foreach ($clothesHoodies as $clothing) {
                   $url = 'Layers/ClothesBottom/' . $clothing . '.png';
                    $image = imagecreatefrompng($url);
                    imagecopy($outputImage,$image,0,0,0,0, $x, $y);
                } 
            }
             if (strlen($pet['clothesTop']) > 1 && strpos($pet["clothesTop"], "SpikedBracelet") !== false) {
    $clothesTop = explode(' ', $pet['clothesTop']);
        foreach ($clothesTop as $clothing) {
            if ($clothing == "SpikedBracelet") {
                $url = 'Layers/ClothesTop/' . $clothing . '.png';
                $image = imagecreatefrompng($url);
                imagecopy($outputImage,$image,0,0,0,0, $x, $y);
            }
        } }
            
            //Bed Code
            /* if(($class === "arttwo") || ($class === "artlarge" && $pet['showbed'] == "1")) {
                echo "<div class='${class}'>";
                echo "<img src='Layers/Beds/Front/" . $pet['bedcolor'] . ".png'>";
                echo "</div>";
            } */
            $url = 'Layers/Tail/Mermaid/' .  $pet['mainColor'] . '.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);
            
        } else if ($pet['tailType'] == "Pom" ) {
            if (strlen($pet['clothesBottom']) > 1) {
            $clothesBottom = explode(' ', $pet['clothesBottom']);
            foreach ($clothesBottom as $clothing) {
                $url = 'Layers/ClothesBottom/' . $clothing . '.png';
                $image = imagecreatefrompng($url);
                imagecopy($outputImage,$image,0,0,0,0, $x, $y);
            } }
            if (strlen($pet['clothesBoth']) > 1) {
        $clothesBoth = explode(' ', $pet['clothesBoth']);
            foreach ($clothesBoth as $clothing) {
                if(!($clothing === "AngelSet" || $clothing === "AngelWings" || $clothing === "ImpHorns")) {
                    $url = 'Layers/ClothesBottom/' . $clothing . '.png';
                    $image = imagecreatefrompng($url);
                    imagecopy($outputImage,$image,0,0,0,0, $x, $y);
            } } }
            if ($pet['clothesHoodie']) {
                if (strpos($pet["clothesTop"], "Collar") !== false) {
                    $collarCheck = explode(' ', $pet['clothesTop']);
                    foreach ($collarCheck as $collar) {
                        if (strpos($pet["clothesTop"], "Collar") !== false) {
                            $url = 'Layers/ClothesTop/' . $collar . '.png';
                        $image = imagecreatefrompng($url);
                        imagecopy($outputImage,$image,0,0,0,0, $x, $y);
                        }
                    }
                }
                $clothesHoodies = explode(' ', $pet['clothesHoodie']);
                foreach ($clothesHoodies as $clothing) {
                    $url = 'Layers/ClothesBottom/' . $clothing . '.png';
                    $image = imagecreatefrompng($url);
                    imagecopy($outputImage,$image,0,0,0,0, $x, $y);
                } 
            }
            $url = 'Layers/Tail/Pom/' .  $pet['tailColor'] . '.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);
             if (strlen($pet['clothesTop']) > 1 && strpos($pet["clothesTop"], "SpikedBracelet") !== false) {
    $clothesTop = explode(' ', $pet['clothesTop']);
        foreach ($clothesTop as $clothing) {
            if ($clothing == "SpikedBracelet") {
                $url = 'Layers/ClothesTop/' . $clothing . '.png';
                $image = imagecreatefrompng($url);
                imagecopy($outputImage,$image,0,0,0,0, $x, $y);
            }
        } }
            
            //Bed Code
            /* if(($class === "arttwo") || ($class === "artlarge" && $pet['showbed'] == "1")) {
                echo "<div class='${class}'>";
                echo "<img src='Layers/Beds/Front/" . $pet['bedcolor'] . ".png'>";
                echo "</div>";
            } */
            
        } else if ($pet['tailType'] == "Panther" || $pet['tailType'] == "Holiday" || $pet['tailType'] == "Braid") {
            //Panther or Holiday Tail
            if (strlen($pet['clothesBottom']) > 1) {
            $clothesBottom = explode(' ', $pet['clothesBottom']);
            foreach ($clothesBottom as $clothing) {
                $url = 'Layers/ClothesBottom/' . $clothing . '.png';
                $image = imagecreatefrompng($url);
                imagecopy($outputImage,$image,0,0,0,0, $x, $y);
            } }
            if (strlen($pet['clothesBoth']) > 1) {
        $clothesBoth = explode(' ', $pet['clothesBoth']);
            foreach ($clothesBoth as $clothing) {
                if(!($clothing === "AngelSet" || $clothing === "AngelWings" || $clothing === "ImpHorns")) {
                    $url = 'Layers/ClothesBottom/' . $clothing . '.png';
                    $image = imagecreatefrompng($url);
                    imagecopy($outputImage,$image,0,0,0,0, $x, $y);
            } } }
            if ($pet['clothesHoodie']) {
                if (strpos($pet["clothesTop"], "Collar") !== false) {
                    $collarCheck = explode(' ', $pet['clothesTop']);
                    foreach ($collarCheck as $collar) {
                        if (strpos($pet["clothesTop"], "Collar") !== false) {
                            $url = 'Layers/ClothesTop/' . $collar . '.png';
                        $image = imagecreatefrompng($url);
                        imagecopy($outputImage,$image,0,0,0,0, $x, $y);
                        }
                    }
                }
                $clothesHoodies = explode(' ', $pet['clothesHoodie']);
                foreach ($clothesHoodies as $clothing) {
                    $url = 'Layers/ClothesBottom/' . $clothing . '.png';
                    $image = imagecreatefrompng($url);
                    imagecopy($outputImage,$image,0,0,0,0, $x, $y);
                } 
            }
             if (strlen($pet['clothesTop']) > 1 && strpos($pet["clothesTop"], "SpikedBracelet") !== false) {
    $clothesTop = explode(' ', $pet['clothesTop']);
        foreach ($clothesTop as $clothing) {
            if ($clothing == "SpikedBracelet") {
                $url = 'Layers/ClothesTop/' . $clothing . '.png';
                $image = imagecreatefrompng($url);
                imagecopy($outputImage,$image,0,0,0,0, $x, $y);
            }
        } }
            
            //Bed Code
            /* if(($class === "arttwo") || ($class === "artlarge" && $pet['showbed'] == "1")) {
                echo "<div class='${class}'>";
                echo "<img src='Layers/Beds/Front/" . $pet['bedcolor'] . ".png'>";
                echo "</div>";
            } */
            
            $url = 'Layers/Tail/' . $pet["tailType"] . '/' .  $pet['tailColor'] . '.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);
        
        } else if ($pet['tailType'] == "Lizard") {
            //Lizard Type
            if (strlen($pet['clothesBottom']) > 1) {
            $clothesBottom = explode(' ', $pet['clothesBottom']);
            foreach ($clothesBottom as $clothing) {
                $url = 'Layers/ClothesBottom/' . $clothing . '.png';
                $image = imagecreatefrompng($url);
                imagecopy($outputImage,$image,0,0,0,0, $x, $y);
            } }
            if (strlen($pet['clothesBoth']) > 1) {
            $clothesBoth = explode(' ', $pet['clothesBoth']);
            foreach ($clothesBoth as $clothing) {
                if(!($clothing === "AngelSet" || $clothing === "AngelWings" || $clothing === "ImpHorns")) {
                    $url = 'Layers/ClothesBottom/' . $clothing . '.png';
                    $image = imagecreatefrompng($url);
                    imagecopy($outputImage,$image,0,0,0,0, $x, $y);
            } } }
            if ($pet['clothesHoodie']) {
                if (strpos($pet["clothesTop"], "Collar") !== false) {
                    $collarCheck = explode(' ', $pet['clothesTop']);
                    foreach ($collarCheck as $collar) {
                        if (strpos($pet["clothesTop"], "Collar") !== false) {
                            $url = 'Layers/ClothesTop/' . $collar . '.png';
                        $image = imagecreatefrompng($url);
                        imagecopy($outputImage,$image,0,0,0,0, $x, $y);
                        }
                    }
                }
                $clothesHoodies = explode(' ', $pet['clothesHoodie']);
                foreach ($clothesHoodies as $clothing) {
                    $url = 'Layers/ClothesBottom/' . $clothing . '.png';
                    $image = imagecreatefrompng($url);
                    imagecopy($outputImage,$image,0,0,0,0, $x, $y);
                } 
            }
             if (strlen($pet['clothesTop']) > 1 && strpos($pet["clothesTop"], "SpikedBracelet") !== false) {
    $clothesTop = explode(' ', $pet['clothesTop']);
        foreach ($clothesTop as $clothing) {
            if ($clothing == "SpikedBracelet") {
                $url = 'Layers/ClothesTop/' . $clothing . '.png';
                $image = imagecreatefrompng($url);
                imagecopy($outputImage,$image,0,0,0,0, $x, $y);
            }
        } }
            
            //Bed Code
            /* if(($class === "arttwo") || ($class === "artlarge" && $pet['showbed'] == "1")) {
                echo "<div class='${class}'>";
                echo "<img src='Layers/Beds/Front/" . $pet['bedcolor'] . ".png'>";
                echo "</div>";
            } */
            
            $url = 'Layers/Tail/Lizard/Spikes/' .  $pet['tailColor'] . '.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);
            $url = 'Layers/Tail/Lizard/' .  $pet['mainColor'] . '.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);
        } else {
            //Any Other Tail
        if (strlen($pet['clothesBottom']) > 1) {
            $clothesBottom = explode(' ', $pet['clothesBottom']);
            foreach ($clothesBottom as $clothing) {
                $url = 'Layers/ClothesBottom/' . $clothing . '.png';
                $image = imagecreatefrompng($url);
                imagecopy($outputImage,$image,0,0,0,0, $x, $y);
            } }
            if (strlen($pet['clothesBoth']) > 1) {
        $clothesBoth = explode(' ', $pet['clothesBoth']);
            foreach ($clothesBoth as $clothing) {
                if(!($clothing === "AngelSet" || $clothing === "AngelWings" || $clothing === "ImpHorns")) {
                    $url = 'Layers/ClothesBottom/' . $clothing . '.png';
                    $image = imagecreatefrompng($url);
                    imagecopy($outputImage,$image,0,0,0,0, $x, $y);
            } } }
            if ($pet['clothesHoodie']) {
                if (strpos($pet["clothesTop"], "Collar") !== false) {
                    $collarCheck = explode(' ', $pet['clothesTop']);
                    foreach ($collarCheck as $collar) {
                        if (strpos($pet["clothesTop"], "Collar") !== false) {
                            $url = 'Layers/ClothesTop/' . $collar . '.png';
                        $image = imagecreatefrompng($url);
                        imagecopy($outputImage,$image,0,0,0,0, $x, $y);
                        }
                    }
                }
                $clothesHoodies = explode(' ', $pet['clothesHoodie']);
                foreach ($clothesHoodies as $clothing) {
                    $url = 'Layers/ClothesBottom/' . $clothing . '.png';
                    $image = imagecreatefrompng($url);
                    imagecopy($outputImage,$image,0,0,0,0, $x, $y);
                } 
            }
            
            $url = 'Layers/Tail/' . $pet["tailType"] . '/' .  $pet['tailColor'] . '.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);

             if (strlen($pet['clothesTop']) > 1 && strpos($pet["clothesTop"], "SpikedBracelet") !== false) {
    $clothesTop = explode(' ', $pet['clothesTop']);
        foreach ($clothesTop as $clothing) {
            if ($clothing == "SpikedBracelet") {
                    $url = 'Layers/ClothesTop/' . $clothing . '.png';
                    $image = imagecreatefrompng($url);
                    imagecopy($outputImage,$image,0,0,0,0, $x, $y);
            }
        } }
            
        //Bed Code
        /* if(($class === "arttwo") || ($class === "artlarge" && $pet['showbed'] == "1")) {
                echo "<div class='${class}'>";
                echo "<img src='Layers/Beds/Front/" . $pet['bedcolor'] . ".png'>";
                echo "</div>";
            }
     */
        }
        
        //Hair Code
        if (!$pet['clothesHoodie']) {
        if ($pet["hairType"] === "Floof") {
            $url = 'Layers/Hair/' . $pet["hairType"] . '/' .  $pet['mainColor'] . '.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);
        } else {
            if (strpos($pet["specials"], "FeatheredWings") !== false && $pet["hairType"] == "Knitted") {
                
            } else {
            $url = 'Layers/Hair/' . $pet["hairType"] . '/' .  $pet['hairColor'] . '.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);
            }
        } }
            
        }
    
    //Bandana Code
    $clothesTop = explode(' ', $pet['clothesTop']);
        foreach ($clothesTop as $clothing) {
    if ($mood == "Cheeky" && str_contains($clothing, "Bandana")) {
        $url = 'Layers/ClothesTop/' . $clothing . '.png';
        $image = imagecreatefrompng($url);
        imagecopy($outputImage,$image,0,0,0,0, $x, $y);
    } }
    
    //Cheeky Expression
    if($mood == "Cheeky") {
        $url = 'Layers/Faces/Cheeky/Tongue/' . $pet['noseColor'] . '.png';
        $image = imagecreatefrompng($url);
        imagecopy($outputImage,$image,0,0,0,0, $x, $y); 
        if (strpos($pet["specials"],"TinyTooth") !== false) {
                $url = 'Layers/Faces/Cheeky/TinyTooth.png';
                $image = imagecreatefrompng($url);
                imagecopy($outputImage,$image,0,0,0,0, $x, $y); 
            }
        
        $url = 'Layers/Faces/Cheeky/Tongue/' . $pet['noseColor'] . '.png';
        $image = imagecreatefrompng($url);
        imagecopy($outputImage,$image,0,0,0,0, $x, $y);    
        } 
    
    //Front Mothfluff
    if ($mothtype) {
        $url = 'Layers/Other/MothFluff/' . $moth . '.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);
        }

        //Noses
        $url = 'Layers/Noses/' . $pet['noseColor'] . '.png';
        $image = imagecreatefrompng($url);
        imagecopy($outputImage,$image,0,0,0,0, $x, $y);
    
    //Non Bandana / Spiked Bracelet Top Clothing
    if (strlen($pet['clothesTop']) > 1) {
    $clothesTop = explode(' ', $pet['clothesTop']);
        foreach ($clothesTop as $clothing) {
            if ($clothing == "SpikedBracelet" || ($mood == "Cheeky" && str_contains($clothing, "Bandana")) || (str_contains($clothing, "Collar") && $pet['clothesHoodie'])) {
                
            } else {
                $url = 'Layers/ClothesTop/' . $clothing . '.png';
                $image = imagecreatefrompng($url);
                imagecopy($outputImage,$image,0,0,0,0, $x, $y);

            }
            
        } }
   
    //Top Layer of Both Clothing
        if (strlen($pet['clothesBoth']) > 1) {
    $clothesBoth = explode(' ', $pet['clothesBoth']);
        foreach ($clothesBoth as $clothing) {
            if (!($clothing === "AngelSet" || $clothing === "AngelWings" || $clothing === "ImpHorns" || str_contains($clothing, "Sweater") || str_contains($clothing, "Cloak"))) {
                $url = 'Layers/ClothesTop/' . $clothing . '.png';
                $image = imagecreatefrompng($url);
                imagecopy($outputImage,$image,0,0,0,0, $x, $y); 
        } } }
    
    //Wings
    if (strpos($pet["specials"], "BugWings") !== false) {
            $url = 'Layers/Wings/BugWingTop.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);
        }
        if (strpos($pet["specials"], "FeatheredWings") !== false) {
            $url = 'Layers/Wings/Pegasus/Top/' . $pet['mainColor'] . '.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);
            if ($pet["hairType"] === "Knitted" && strlen($pet['clothesHoodie']) < 1) {
                $url = 'Layers/Hair/Knitted/' . $pet['hairColor'] . '.png';
                $image = imagecreatefrompng($url);
                imagecopy($outputImage,$image,0,0,0,0, $x, $y);
            } else {
                
            }
        }
    
    //Ram Horns
    if (strlen($pet['clothesBoth']) > 1 && strpos($pet["clothesBoth"], "RamHorns") !== false) {
    $clothesTop = explode(' ', $pet['clothesBoth']);
        foreach ($clothesTop as $clothing) {
            if ($clothing == "RamHorns") {
                $url = 'Layers/ClothesTop/' . $clothing . '.png';
                $image = imagecreatefrompng($url);
                imagecopy($outputImage,$image,0,0,0,0, $x, $y);
            }
            
        } }
    
    //Holiday Sweater Fix
    if (strlen($pet['clothesBoth']) > 1 && strpos($pet["clothesBoth"], "Sweater") !== false) {
    $clothesTop = explode(' ', $pet['clothesBoth']);
        foreach ($clothesTop as $clothing) {
            if (str_contains($clothing, "Sweater")) {
                $url = 'Layers/ClothesTop/' . $clothing . '.png';
                $image = imagecreatefrompng($url);
                imagecopy($outputImage,$image,0,0,0,0, $x, $y);
            }
            
        } }

        
        //Clothes Hoodie Top
        if ($pet['clothesHoodie']) {
            $clothesHoodies = explode(' ', $pet['clothesHoodie']);
        foreach ($clothesHoodies as $clothing) {
            $url = 'Layers/ClothesTop/' . $clothing . '.png';
                $image = imagecreatefrompng($url);
                imagecopy($outputImage,$image,0,0,0,0, $x, $y);
        } 
    }
    
    if ($pet['hairType'] == "Holiday" || $pet['hairType'] == "Braid" || $pet['hairType'] == "Knitted") {
        $hairCheck = 1;
    }
        if (strlen($pet['clothesBoth']) > 1) {
    $clothesBoth = explode(' ', $pet['clothesBoth']);
        foreach ($clothesBoth as $clothing) {
            if ($clothing === "AngelSet" || $clothing === "AngelWings" || $clothing === "ImpHorns" || $clothing === "TwiggyAntlers" || $clothing === "DeerAntlers" || str_contains($clothing, "Cloak")) {
            $url = 'Layers/ClothesTop/' . $clothing . '.png';
                $image = imagecreatefrompng($url);
                imagecopy($outputImage,$image,0,0,0,0, $x, $y);
        } else if (str_contains($clothing, "Sweater")) {
                $url = 'Layers/ClothesTop/' . $clothing . '.png';
                $image = imagecreatefrompng($url);
                imagecopy($outputImage,$image,0,0,0,0, $x, $y);
                if ($hairCheck == 1) {
                $url = 'Layers/Hair/' . $pet['hairType'] . '/' . $pet['hairColor'] . '.png';
                $image = imagecreatefrompng($url);
                imagecopy($outputImage,$image,0,0,0,0, $x, $y);
                }
            } 
            if ($hairCheck == 1) {
                $url = 'Layers/Hair/' . $pet['hairType'] . '/' . $pet['hairColor'] . '.png';
                $image = imagecreatefrompng($url);
                imagecopy($outputImage,$image,0,0,0,0, $x, $y);
            }
        }
    }

    
    imagepng($outputImage, $dest);
    
    
    imagedestroy($outputImage);
                        
}