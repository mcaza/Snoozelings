<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = 'SELECT * FROM snoozelings WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $pet = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    $pet = false;
}


//Grab All Colors
$query = 'SELECT * FROM colors ORDER BY display';
$stmt = $pdo->prepare($query);
$stmt->execute();
$colors = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Grab All Fabrics
$query = 'SELECT * FROM fabrics ORDER BY display';
$stmt = $pdo->prepare($query);
$stmt->execute();
$fabrics = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="games"><<</a>';
echo '</div>';

echo '<h3 style="margin-top: 1rem; margin-bottom: 2rem;">Snoozeling Designer</h3>';
echo '<div class="art-container">';

echo "<div class='artlarge'>";
if (strpos($pet["specials"], "FeatheredWings") !== false) {
    echo "<img src='Layers/Wings/Pegasus/Bottom/" . $pet["mainColor"] . ".png' id = 'BottomWingdesigner'>";
} else {
    echo "<img src='' id = 'BottomWingdesigner'>";
}
echo "</div>";


echo "<div class='artlarge'>";
if (strpos($pet["specials"], "BugWings") !== false) {
    echo "<img src='Layers/Wings/BugWingBottom.png' id = 'Bottombugdesigner'>";
} else {
    echo "<img src='' id = 'Bottombugdesigner'>";
}
echo "</div>";
        
echo "<div class='artlarge'>";
if ($pet) {
    echo "<img src='Layers/Primary/" . $pet['mainColor'] . ".png' id = 'Primarydesigner'>";
} else {
    echo "<img src='Layers/Primary/Amethyst.png' id = 'Primarydesigner'>";
}
echo "</div>";

echo "<div class='artlarge'>";
if (strpos($pet["specials"], "Cupid") !== false) {
    echo "<img src='Layers/Markings/Cupid/" . $pet["mainColor"] . ".png' id = 'Cupiddesigner'>";
} else {
    echo "<img src='' id = 'Cupiddesigner'>";
}
echo "</div>";  
   
echo "<div class='artlarge'>";
if (strpos($pet["specials"], "Spots") !== false) {
    echo "<img src='Layers/Markings/Spots/" . $pet["mainColor"] . ".png' id = 'Spotsdesigner'>";
} else {
    echo "<img src='' id = 'Spotsdesigner'>";
}
echo "</div>";
            

echo "<div class='artlarge'>";
if (strpos($pet["specials"], "Boots") !== false) {
    echo "<img src='Layers/Markings/Boots/" . $pet["mainColor"] . ".png' id = 'Bootsdesigner'>";
} else {
    echo "<img src='' id = 'Bootsdesigner'>";
}
echo "</div>";

echo "<div class='artlarge'>";
if (strpos($pet["specials"], "Sublimation") !== false) {
    echo "<img src='Layers/Markings/Sublimation/" . $pet["mainColor"] . ".png' id = 'Sublimationdesigner'>";
} else {
    echo "<img src='' id = 'Sublimationdesigner'>";
}
echo "</div>";  

echo "<div class='artlarge'>";
if (strpos($pet["specials"], "EarTip") !== false) {
    echo "<img src='Layers/Other/EarTip.png' id = 'Eartipdesigner'>";
} else {
    echo "<img src='' id = 'Eartipdesigner'>";
}
echo "</div>";

echo "<div class='artlarge'>";
if ($pet) {
    echo "<img src='Layers/Ear/" . $pet['noseColor'] . ".png' id = 'Eardesigner'>";
} else {
    echo "<img src='Layers/Ear/Amethyst.png' id = 'Eardesigner'>";
}
echo "</div>";

echo "<div class='artlarge'>";
if (strpos($pet["specials"], "Belly") !== false) {
    echo "<img src='Layers/Markings/Belly/" . $pet["mainColor"] . ".png' id = 'Bellydesigner'>";
} else {
    echo "<img src='' id = 'Bellydesigner'>";
}
echo "</div>";

echo "<div class='artlarge'>";
if ($pet) {
    echo "<img src='Layers/MainLines/" . $pet['mainColor'] . ".png' id = 'Mainlinesdesigner'>";
} else {
    echo "<img src='Layers/MainLines/Amethyst.png' id = 'Mainlinesdesigner'>";
}
echo "</div>";


$moths = ['NoFluff','MothFluff','MothFluffRed','MothFluffOrange','MothFluffYellow','MothFluffGreen','MothFluffBlue','MothFluffPurple','MothFluffBrown','MothFluffBlack', 'MothFluffPink', 'MothFluffSilver','MothFluffGold', 'MothFluffPastelPink', 'MothFluffPastelBlue', 'MothFluffPastelPurple', 'MothFluffPastelBrown', 'MothFluffGooseberry', 'MothFluffBlueberry', 'MothFluffTeal', 'MothFluffRainbowLove', 'MothFluffFemaleLove', 'MothFluffMaleLove', 'MothFluffDoubleLove', 'MothFluffAnyLove', 'MothFluffAceLove', 'MothFluffAroLove', 'MothFluffNewSelf', 'MothFluffUniqueSelf', 'MothFluffFluidSelf'];
$check = 0;
foreach ($moths as $moth) {
    if (strpos($pet["specials"], $moth) !== false) {
        if ($moth == "MothFluff") {
            $specialsone = explode(" ", $pet['specials']);
            $num = array_search('MothFluff', $specialsone);
            $letters = $specialsone[$num];
            
            if ($letters == 9) {
                echo "<div class='artlarge'>";
                echo "<img src='Layers/Other/MothFluff/Behind/" . $moth . ".png' id = 'BottomMothdesigner'>";
                echo "</div>";
                $check++;
            }
        } else {
            echo "<div class='artlarge'>";
            echo "<img src='Layers/Other/MothFluff/Behind/" . $moth . ".png' id = 'BottomMothdesigner'>";
            echo "</div>";
            $check++;
        }
    } 
}
if ($check == 0) {
    echo "<div class='artlarge'>";
        echo "<img src='' id = 'BottomMothdesigner'>";
        echo "</div>";
}


echo "<div class='artlarge'>";
if (strpos($pet["specials"], "TinyTooth") !== false) {
    echo "<img src='Layers/Faces/Happy/TinyTooth.png' id = 'Tinytoothdesigner'>";
} else {
    echo "<img src='' id = 'Tinytoothdesigner'>";
}
echo "</div>";

echo "<div class='artlarge'>";
if ($pet) {
    echo "<img src='Layers/Faces/Happy/Eyes/" . $pet['eyeColor'] . ".png' id = 'Eyesdesigner'>";
} else {
    echo "<img src='Layers/Faces/Happy/Eyes/Amethyst.png' id = 'Eyesdesigner'>";
}
echo "</div>";

echo "<div class='artlarge'>";
if ($pet) {
    echo "<img src='Layers/Faces/Happy/Lines/" . $pet['mainColor'] . ".png' id = 'Facedesigner'>";
} else {
    echo "<img src='Layers/Faces/Happy/Lines/Amethyst.png' id = 'Facedesigner'>";
}
echo "</div>";

if ($pet) {
    if ($pet['tailType'] == "Lizard") {
        echo "<div class='artlarge'>";
        echo "<img src='Layers/Tail/Lizard/Spikes/" . $pet['tailColor'] . ".png' id = 'Taildesigner'>";
        echo "</div>";
        echo "<div class='artlarge'>";
        echo "<img src='Layers/Tail/Lizard/" . $pet['mainColor'] . ".png' id = 'TailTopdesigner'>";
        echo "</div>";
    } else if ($pet['tailType'] == "Dragon") {
        echo "<div class='artlarge'>";
        echo "<img src='Layers/Tail/Dragon/End/" . $pet['tailColor'] . ".png' id = 'Taildesigner'>";
        echo "</div>";
        echo "<div class='artlarge'>";
        echo "<img src='Layers/Tail/Dragon/" . $pet['mainColor'] . ".png' id = 'TailTopdesigner'>";
        echo "</div>";
    } else if ($pet['tailType'] == "Mermaid") {
        echo "<div class='artlarge'>";
        echo "<img src='Layers/Tail/Mermaid/" . $pet['mainColor'] . ".png' id = 'Taildesigner'>";
        echo "</div>";
        echo "<div class='artlarge'>";
        echo "<img src='' id = 'TailTopdesigner'>";
        echo "</div>";
    } else {
        echo "<div class='artlarge'>";
        echo "<img src='Layers/Tail/" . $pet['tailType'] . "/" . $pet['mainColor'] . ".png' id = 'Taildesigner'>";
        echo "</div>";
        echo "<div class='artlarge'>";
        echo "<img src='' id = 'TailTopdesigner'>";
        echo "</div>";
    }
} else {
    echo "<div class='artlarge'>";
    echo "<img src='Layers/Tail/Dragon/End/Amethyst.png' id = 'Taildesigner'>";
    echo "</div>";
    echo "<div class='artlarge'>";
    echo "<img src='Layers/Tail/Dragon/Amethyst.png' id = 'TailTopdesigner'>";
    echo "</div>";
}


if ($pet['hairType'] == "Knitted") {
    echo "<div class='artlarge'>";
    if (strpos($pet["specials"], "BugWings") !== false) {
        echo "<img src='Layers/Wings/BugWingTop.png' id = 'Topbugdesigner'>";
    } else {
        echo "<img src='' id = 'Topbugdesigner'>";
    }
    echo "</div>";

    echo "<div class='artlarge'>";
    if (strpos($pet["specials"], "FeatheredWings") !== false) {
        echo "<img src='Layers/Wings/Pegasus/Top/" . $pet["mainColor"] . ".png' id = 'TopWingdesigner'>";
    } else {
        echo "<img src='' id = 'TopWingdesigner'>";
    }
    echo "</div>";
}

echo "<div class='artlarge'>";
if ($pet) {
    if ($pet['hairType'] == "Floof") {
        echo "<img src='Layers/Hair/Floof/" . $pet['mainColor'] . ".png' id = 'Hairdesigner'>";
    } else {
        echo "<img src='Layers/Hair/" . $pet['hairType'] . "/" . $pet['hairColor'] . ".png' id = 'Hairdesigner'>";
    }
} else {
    echo "<img src='Layers/Hair/Floof/Amethyst.png' id = 'Hairdesigner'>";
}
echo "</div>";

if ($pet['hairType'] != "Knitted") {
    echo "<div class='artlarge'>";
    if (strpos($pet["specials"], "BugWings") !== false) {
        echo "<img src='Layers/Wings/BugWingTop.png' id = 'Topbugdesigner'>";
    } else {
        echo "<img src='' id = 'Topbugdesigner'>";
    }
    echo "</div>";

    echo "<div class='artlarge'>";
    if (strpos($pet["specials"], "FeatheredWings") !== false) {
        echo "<img src='Layers/Wings/Pegasus/Top/" . $pet["mainColor"] . ".png' id = 'TopWingdesigner'>";
    } else {
        echo "<img src='' id = 'TopWingdesigner'>";
    }
    echo "</div>";
}

$moths = ['NoFluff','MothFluff','MothFluffRed','MothFluffOrange','MothFluffYellow','MothFluffGreen','MothFluffBlue','MothFluffPurple','MothFluffBrown','MothFluffBlack', 'MothFluffPink', 'MothFluffSilver','MothFluffGold', 'MothFluffPastelPink', 'MothFluffPastelBlue', 'MothFluffPastelPurple', 'MothFluffPastelBrown', 'MothFluffGooseberry', 'MothFluffBlueberry', 'MothFluffTeal', 'MothFluffRainbowLove', 'MothFluffFemaleLove', 'MothFluffMaleLove', 'MothFluffDoubleLove', 'MothFluffAnyLove', 'MothFluffAceLove', 'MothFluffAroLove', 'MothFluffNewSelf', 'MothFluffUniqueSelf', 'MothFluffFluidSelf'];
$check = 0;
foreach ($moths as $moth) {
    if (strpos($pet["specials"], $moth) !== false) {
        if ($moth == "MothFluff") {
            $specialsone = explode(" ", $pet['specials']);
            $num = array_search('MothFluff', $specialsone);
            $letters = $specialsone[$num];
            
            if ($letters == 9) {
                echo "<div class='artlarge'>";
                echo "<img src='Layers/Other/MothFluff/" . $moth . ".png' id = 'TopMothdesigner'>";
                echo "</div>";
                $check++;
            }
        } else {
            echo "<div class='artlarge'>";
            echo "<img src='Layers/Other/MothFluff/" . $moth . ".png' id = 'TopMothdesigner'>";
            echo "</div>";
            $check++;
        }
    } 
}
if ($check == 0) {
    echo "<div class='artlarge'>";
        echo "<img src='' id = 'TopMothdesigner'>";
        echo "</div>";
}




echo "<div class='artlarge'>";
if ($pet) {
    echo "<img src='Layers/Noses/" . $pet['noseColor'] . ".png' id = 'Nosedesigner'>";
} else {
    echo "<img src='Layers/Noses/Amethyst.png' id = 'Nosedesigner'>";
}
echo "</div>";





echo "<div class='artlarge'>";
echo "<img src='Layers/transparentSquare.png'>";
echo "</div>";
    
echo "</div>";

//Form Stuff

echo '<div class="designerBoxes">';
echo '<div>';
echo '<label for="mainColor" class="form">Main Color:</label><br>';
echo '<select id="mainColor"  class="input">';
foreach ($colors as $color) {
    if ($pet['mainColor'] == $color['name']) {
        echo '<option value="' . $color['name'] . '" selected>' . $color['display'] . '</option>';
    } else {
        echo '<option value="' . $color['name'] . '">' . $color['display'] . '</option>';
    }
}
echo '</select><br>';

echo '<label for="skinColor" class="form">Skin Color:</label><br>';
echo '<select id="skinColor"  class="input">';
foreach ($colors as $color) {
    if ($pet['noseColor'] == $color['name']) {
        echo '<option value="' . $color['name'] . '" selected>' . $color['display'] . '</option>';
    } else {
        echo '<option value="' . $color['name'] . '">' . $color['display'] . '</option>';
    }
}
foreach ($fabrics as $fabric) {
    if ($pet['noseColor'] == $color['name']) {
        echo '<option value="' . $fabric['name'] . '" selected>' . $fabric['display'] . '</option>';
    } else {
        echo '<option value="' . $fabric['name'] . '">' . $fabric['display'] . '</option>';
    }
}
echo '</select><br>';

echo '<label for="eyeColor" class="form">Eye Color:</label><br>';
echo '<select id="eyeColor"  class="input">';
foreach ($colors as $color) {
    if ($pet['eyeColor'] == $color['name']) {
        echo '<option value="' . $color['name'] . '" selected>' . $color['display'] . '</option>';
    } else {
        echo '<option value="' . $color['name'] . '">' . $color['display'] . '</option>';
    }
}
echo '</select><br>';
echo '</div>';
echo '<div>';
echo '<label for="hairColor" class="form">Hair Color:</label><br>';
echo '<select id="hairColor"  class="input">';
foreach ($colors as $color) {
    if ($pet['hairColor'] == $color['name']) {
        echo '<option value="' . $color['name'] . '" selected>' . $color['display'] . '</option>';
    } else {
        echo '<option value="' . $color['name'] . '">' . $color['display'] . '</option>';
    }
}
echo '</select><br>';

$hairs = ['Floof', 'Forelock', 'Knitted', 'LizardSpikes', 'Mane', 'Mohawk', 'Wave'];
$hairDisplay = ['Floof', 'Forelock', 'Knitted', 'Lizard Spikes', 'Mane', 'Mohawk', 'Wave'];
$round = 0;
echo '<label for="hairType" class="form">Hair Style:</label><br>';
echo '<select id="hairType"  class="input">';
foreach ($hairs as $hair) {
    if ($pet['hairType'] == $hair) {
        echo '<option value="' . $hair . '" selected>' . $hairDisplay[$round] . '</option>';
    } else {
        echo '<option value="' . $hair . '">' . $hairDisplay[$round] . '</option>';
    }
    $round++;
}
echo '</select><br>';
echo '<label for="mothFluff" class="form">Moth Fluff:</label><br>';
echo '<select id="mothFluff"  class="input">';
$moths = ['NoFluff','MothFluff','MothFluffRed','MothFluffOrange','MothFluffYellow','MothFluffGreen','MothFluffBlue','MothFluffPurple','MothFluffBrown','MothFluffBlack', 'MothFluffPink', 'MothFluffSilver','MothFluffGold', 'MothFluffPastelPink', 'MothFluffPastelBlue', 'MothFluffPastelPurple', 'MothFluffPastelBrown', 'MothFluffGooseberry', 'MothFluffBlueberry', 'MothFluffTeal', 'MothFluffRainbowLove', 'MothFluffFemaleLove', 'MothFluffMaleLove', 'MothFluffDoubleLove', 'MothFluffAnyLove', 'MothFluffAceLove', 'MothFluffAroLove', 'MothFluffNewSelf', 'MothFluffUniqueSelf', 'MothFluffFluidSelf'];
$mothDisplay = ['No Fluff','White','Red','Orange','Yellow','Green','Blue','Purple','Brown','Black', 'Pink', 'Silver','Gold', 'Pastel Pink', 'Pastel Blue', 'Pastel Purple', 'Pastel Brown', 'Gooseberry', 'Blueberry', 'Teal', 'Rainbow Love', 'Female Love', 'Male Love', 'Double Love', 'Any Love', 'Ace Love', 'Aro Love', 'New Self', 'Unique Self', 'Fluid Self'];
    $round = 0;
foreach ($moths as $moth) {
    if (strpos($pet["specials"], $moth) !== false) {
        echo '<option value="' . $moth . '" selected>' . $mothDisplay[$round] . '</option>';
    } else {
        echo '<option value="' . $moth . '">' . $mothDisplay[$round] . '</option>';
    }
    $round++;
}
echo '</select><br>';
echo '</div>';
echo '<div>';
echo '<label for="tailColor" class="form">Tail Color:</label><br>';
echo '<select id="tailColor"  class="input">';
foreach ($colors as $color) {
    if ($pet['tailColor'] == $color['name']) {
        echo '<option value="' . $color['name'] . '" selected>' . $color['display'] . '</option>';
    } else {
        echo '<option value="' . $color['name'] . '">' . $color['display'] . '</option>';
    }
    
}
echo '</select><br>';

$tails = ['Dragon','Knitted','Lizard','Long','Mermaid','Nub','Panther','Pom','Wooly'];
$tailDisplay = ['Dragon','Knitted','Lizard','Long','Mermaid','Nub','Panther','Pom','Wooly'];
$round = 0;
echo '<label for="tailType" class="form">Tail Style:</label><br>';
echo '<select id="tailType"  class="input">';
foreach ($tails as $tail) {
    if ($pet['tailType'] == $tail) {
        echo '<option value="' . $tail . '" selected>' . $tailDisplay[$round] . '</option>';
    } else {
        echo '<option value="' . $tail . '">' . $tailDisplay[$round] . '</option>';
    }
    $round++;
}
echo '</select><br>';
echo '</div>';


echo '</div>';

echo '<hr>';

echo '<div class="designerBoxes">';
echo '<div>';
echo '<label style="margin-bottom: 1rem;" class="form">Starter Markings:</label><br>';

echo '<div class="checkBoxDes">';
if (strpos($pet["specials"], "Belly") !== false) {
    echo '<input  type="checkbox" id="belly" checked><label class="designerCheck" for="belly">Belly</label><br>';
} else {
    echo '<input  type="checkbox" id="belly"><label class="designerCheck" for="belly">Belly</label><br>';
}
echo '</div>';

echo '<div class="checkBoxDes">';
if (strpos($pet["specials"], "Boots") !== false) {
    echo '<input  type="checkbox" id="boots" checked><label class="designerCheck" for="boots">Boots</label><br>';
} else {
    echo '<input  type="checkbox" id="boots"><label class="designerCheck" for="boots">Boots</label><br>';
}
echo '</div>';

echo '<div class="checkBoxDes">';
if (strpos($pet["specials"], "Cupid") !== false) {
    echo '<input type="checkbox" id="cupid" checked><label class="designerCheck" for="cupid">Cupid</label><br>';
} else {
    echo '<input type="checkbox" id="cupid"><label class="designerCheck" for="cupid">Cupid</label><br>';
}
echo '</div>';

echo '<div class="checkBoxDes">';
if (strpos($pet["specials"], "EarTip") !== false) {
    echo '<input type="checkbox" id="eartip" checked><label class="designerCheck" for="eartip">Ear Tip</label><br>';
} else {
    echo '<input type="checkbox" id="eartip"><label class="designerCheck" for="eartip">Ear Tip</label><br>';
}
echo '</div>';

echo '<div class="checkBoxDes">';
if (strpos($pet["specials"], "Spots") !== false) {
    echo '<input type="checkbox" id="spots" checked><label class="designerCheck" for="spots">Spots</label><br>';
} else {
    echo '<input type="checkbox" id="spots"><label class="designerCheck" for="spots">Spots</label><br>';
}
echo '</div>';

echo '<div class="checkBoxDes">';
if (strpos($pet["specials"], "Sublimation") !== false) {
    echo '<input type="checkbox" id="sublimation" checked><label class="designerCheck" for="sublimation">Sublimation</label><br>';
} else {
    echo '<input type="checkbox" id="sublimation"><label class="designerCheck" for="sublimation">Sublimation</label><br>';
}
echo '</div>';
echo '</div>';

echo '<div>';
echo '<label style="margin-bottom: 1rem;" class="form">Crafted Designs:</label><br>';

echo '<div class="checkBoxDes">';
if (strpos($pet["specials"], "BugWings") !== false) {
    echo '<input type="checkbox" id="bugwings" checked><label class="designerCheck" for="bugwings">Bug Wings</label><br>';
} else {
    echo '<input type="checkbox" id="bugwings"><label class="designerCheck" for="bugwings">Bug Wings</label><br>';
}

echo '</div>';

echo '<div class="checkBoxDes">';
if (strpos($pet["specials"], "FeatheredWings") !== false) {
    echo '<input type="checkbox" id="wings" checked><label class="designerCheck" for="wings" >Feathered Wings</label><br>';
} else {
    echo '<input type="checkbox" id="wings"><label class="designerCheck" for="wings">Feathered Wings</label><br>';
}
echo '</div>';

echo '<div class="checkBoxDes">';
if (strpos($pet["specials"], "TinyTooth") !== false) {
    echo '<input type="checkbox" id="tooth" checked><label class="designerCheck" for="tooth">Tiny Tooth</label><br>';
} else {
    echo '<input type="checkbox" id="tooth"><label class="designerCheck" for="tooth">Tiny Tooth</label><br>';
}
echo '</div>';

echo '</div>';

echo '</div>';


if ($_SESSION['user_id']) {
    $userId = $_SESSION['user_id'];
    
    echo '<hr>';

    $query = 'SELECT * FROM snoozelings WHERE owner_id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $snoozelings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<form method="post" action="includes/importPet.inc.php">';
    echo '<label for="pet"  class="form">Import Pet:</label><br>';
    echo '<select name="pet" id="pet">';
    foreach ($snoozelings as $snoozes) {
        echo '<option value="' . $snoozes['id'] . '">' . $snoozes['name'] . '</option>';
    }
    echo '</select><br><br>';
    echo "<button class='fancyButton'>Import Pet</button>";
    echo '</form>';
}


echo '</div>';







