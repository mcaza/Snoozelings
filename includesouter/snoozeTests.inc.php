<?php

$userId = $_COOKIE['user_id'];

//Get Pet Info For Testing
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = 'SELECT * FROM snoozelings WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $pet = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    $id = 1;
    $query = 'SELECT * FROM snoozelings WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $pet = $stmt->fetch(PDO::FETCH_ASSOC);
}

//Set Mood
if (!$pet['mood']) {
    $mood = "Happy";
} else {
    $mood = $pet['mood'];
}

//Clothes String. Temporary for Testing
$clothes = [];
if($pet["clothesBoth"]) {
    $list = explode(" ", $pet['clothesBoth']);
    foreach ($list as $item) {
        array_push($clothes,$item); 
    }
}
if($pet["clothesTop"]) {
    $list = explode(" ", $pet['clothesTop']);
    foreach ($list as $item) {
        array_push($clothes,$item); 
    }
}
if($pet["clothesBottom"]) {
    $list = explode(" ", $pet['clothesBottom']);
    foreach ($list as $item) {
        array_push($clothes,$item); 
    } 
}
if($pet["clothesHoodie"]) {
    $list = explode(" ", $pet['clothesHoodie']);
    foreach ($list as $item) {
        array_push($clothes,$item); 
    }
}


//Get All Clothing Info
$clothingInfo = [];
foreach ($clothes as $cloth) {
    $query = 'SELECT * FROM clothes WHERE name = :name';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $cloth);
    $stmt->execute();
    $temp = $stmt->fetch(PDO::FETCH_ASSOC);
    array_push($clothingInfo,$temp);
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
    
$dest = 'snoozeImages/' . $pet['id'] . '.png';

//Back Wings
 if (strpos($pet["specials"], "BugWings") !== false) {
    $url = 'Layers/Wings/BugWingBottom.png';
    $image = imagecreatefrompng($url);
    imagecopy($outputImage,$image,0,0,0,0, $x, $y);
}
if (strpos($pet["specials"], "FeatheredWings") !== false) {
    $url = 'Layers/Wings/Pegasus/Bottom/' . $pet['mainColor'] . '.png';
    $image = imagecreatefrompng($url);
    imagecopy($outputImage,$image,0,0,0,0, $x, $y);
}

//Back Wing Decor
foreach ($clothingInfo as $clothing) {
    if ($clothing["wings"]) {
        $url = 'Layers/Clothes/BWD/' . $clothing['name'] . '.png';
        $image = imagecreatefrompng($url);
        imagecopy($outputImage,$image,0,0,0,0, $x, $y);
    }
}

//Back Antler Decor
foreach ($clothingInfo as $clothing) {
    if ($clothing["antlers"]) {
        $url = 'Layers/Clothes/BAD/' . $clothing['name'] . '.png';
        $image = imagecreatefrompng($url);
        imagecopy($outputImage,$image,0,0,0,0, $x, $y);
    }
}

//Clothing Layer #1
foreach ($clothingInfo as $clothing) {
    $layers = explode(" ", $clothing['layers']);
    if (in_array("1",$layers)) {
        $url = 'Layers/Clothes/1/' . $clothing['name'] . '.png';
        $image = imagecreatefrompng($url);
        imagecopy($outputImage,$image,0,0,0,0, $x, $y);
    }
}

//Back Hair Piece

//Tail Piece
if ($pet['tailType'] == "Mermaid") {
    $url = 'Layers/Tail/Mermaid/' . $pet['mainColor'] . '.png';
    $image = imagecreatefrompng($url);
    imagecopy($outputImage,$image,0,0,0,0, $x, $y);
} else if ($pet['tailType'] == "Dragon") {
    $url = 'Layers/Tail/Dragon/End/' . $pet['tailColor'] . '.png';
    $image = imagecreatefrompng($url);
    imagecopy($outputImage,$image,0,0,0,0, $x, $y);
    $url = 'Layers/Tail/Dragon/' . $pet['mainColor'] . '.png';
    $image = imagecreatefrompng($url);
    imagecopy($outputImage,$image,0,0,0,0, $x, $y);
} else if ($pet['tailType'] == "Lizard") {
    $url = 'Layers/Tail/Lizard/Spikes/' . $pet['tailColor'] . '.png';
    $image = imagecreatefrompng($url);
    imagecopy($outputImage,$image,0,0,0,0, $x, $y);
    $url = 'Layers/Tail/Lizard/' . $pet['mainColor'] . '.png';
    $image = imagecreatefrompng($url);
    imagecopy($outputImage,$image,0,0,0,0, $x, $y);
} else if ($pet['Tailless'] == "Lizard") {
    
} else {
    $url = 'Layers/Tail/' . $pet['tailType'] . '/' . $pet['tailColor'] . '.png';
    $image = imagecreatefrompng($url);
    imagecopy($outputImage,$image,0,0,0,0, $x, $y);
}

//Primary Color
$url = 'Layers/Primary/' . $pet['mainColor'] . '.png';
$image = imagecreatefrompng($url);
imagecopy($outputImage,$image,0,0,0,0, $x, $y);

//Cupid Marking
if (strpos($pet["specials"], "Cupid") !== false) {
    $url = 'Layers/Markings/Cupid/' . $pet['mainColor'] . '.png';
    $image = imagecreatefrompng($url);
    imagecopy($outputImage,$image,0,0,0,0, $x, $y);
}

//Spots Marking
if (strpos($pet["specials"], "Spots") !== false) {
    $url = 'Layers/Markings/Spots/' . $pet['mainColor'] . '.png';
    $image = imagecreatefrompng($url);
    imagecopy($outputImage,$image,0,0,0,0, $x, $y);
}

//Boots Marking
if (strpos($pet["specials"], "Boots") !== false) {
    $url = 'Layers/Markings/Boots/' . $pet['mainColor'] . '.png';
    $image = imagecreatefrompng($url);
    imagecopy($outputImage,$image,0,0,0,0, $x, $y);
}

//Sublimation Marking
if (strpos($pet["specials"], "Sublimation") !== false) {
    $url = 'Layers/Markings/Submilmation/' . $pet['mainColor'] . '.png';
    $image = imagecreatefrompng($url);
    imagecopy($outputImage,$image,0,0,0,0, $x, $y);
}

//Collie Marking
if (strpos($pet["specials"], "Collie") !== false) {
    $url = 'Layers/Other/Collie.png';
    $image = imagecreatefrompng($url);
    imagecopy($outputImage,$image,0,0,0,0, $x, $y);
}

//Foxy Marking
if (strpos($pet["specials"], "Foxy") !== false) {
    $url = 'Layers/Markings/Foxy/' . $pet['mainColor'] . '.png';
    $image = imagecreatefrompng($url);
    imagecopy($outputImage,$image,0,0,0,0, $x, $y);
}

//Scales Marking
if (strpos($pet["specials"], "Scales") !== false) {
    $url = 'Layers/Markings/Scales/' . $pet['mainColor'] . '.png';
    $image = imagecreatefrompng($url);
    imagecopy($outputImage,$image,0,0,0,0, $x, $y);
}

//Ear Tip Marking
if (strpos($pet["specials"], "EarTip") !== false) {
    $url = 'Layers/Other/EarTip.png';
    $image = imagecreatefrompng($url);
    imagecopy($outputImage,$image,0,0,0,0, $x, $y);
}

//Scales Marking
if (strpos($pet["specials"], "Scales") !== false) {
    $url = 'Layers/Markings/Scales/' . $pet['mainColor'] . '.png';
    $image = imagecreatefrompng($url);
    imagecopy($outputImage,$image,0,0,0,0, $x, $y);
}

//Skeleton Marking
if (strpos($pet["specials"], "Skeleton") !== false) {
    $url = 'Layers/Other/Skeleton.png';
    $image = imagecreatefrompng($url);
    imagecopy($outputImage,$image,0,0,0,0, $x, $y);
}

//Belly Marking
if (strpos($pet["specials"], "Belly") !== false) {
    $url = 'Layers/Markings/Belly/' . $pet['mainColor'] . '.png';
    $image = imagecreatefrompng($url);
    imagecopy($outputImage,$image,0,0,0,0, $x, $y);
}

//Ears
if(strpos($pet["specials"], "EarBands") !== false) {
    $url = 'Layers/Other/EarBands/' . $pet['noseColor'] . '.png';
    $image = imagecreatefrompng($url);
    imagecopy($outputImage,$image,0,0,0,0, $x, $y);
} else {
    $url = 'Layers/Ear/' . $pet['noseColor'] . '.png';
    $image = imagecreatefrompng($url);
    imagecopy($outputImage,$image,0,0,0,0, $x, $y);
}

//Face if NOT Cheeky
if($mood != "Cheeky") {
    //Eyes
    $url = 'Layers/Faces/' . $mood . '/Eyes/'. $pet['eyeColor'] . '.png';
    $image = imagecreatefrompng($url);
    imagecopy($outputImage,$image,0,0,0,0, $x, $y);
    
    //Tiny Tooth
    if (strpos($pet["specials"],"TinyTooth") !== false) {
        $url = 'Layers/Faces/' . $mood . '/TinyTooth.png';
        $image = imagecreatefrompng($url);
        imagecopy($outputImage,$image,0,0,0,0, $x, $y);
    }
    
    //Face
    $url = 'Layers/Faces/' . $mood . '/Lines/'. $pet['mainColor'] . '.png';
    $image = imagecreatefrompng($url);
    imagecopy($outputImage,$image,0,0,0,0, $x, $y);
    
    //Tear Drop
    if ($pet['mood'] === 'Overwhelmed') {
           $url = 'Layers/Other/tear.png';
        $image = imagecreatefrompng($url);
        imagecopy($outputImage,$image,0,0,0,0, $x, $y);
    }
}

//Main Lines
$url = 'Layers/MainLines/' . $pet['mainColor'] . '.png';
$image = imagecreatefrompng($url);
imagecopy($outputImage,$image,0,0,0,0, $x, $y);

//Floof Hair
if ($pet['hairType'] == "Floof") {
    $url = 'Layers/Hair/Floof/' . $pet['mainColor'] . '.png';
    $image = imagecreatefrompng($url);
    imagecopy($outputImage,$image,0,0,0,0, $x, $y);
}

//Nose
$url = 'Layers/Noses/' . $pet['noseColor'] . '.png';
$image = imagecreatefrompng($url);
imagecopy($outputImage,$image,0,0,0,0, $x, $y);

//Back Moth Piece
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

//Clothing Layer #2
foreach ($clothingInfo as $clothing) {
    $layers = explode(" ", $clothing['layers']);
    if (in_array("2",$layers)) {
        $url = 'Layers/Clothes/2/' . $clothing['name'] . '.png';
        $image = imagecreatefrompng($url);
        imagecopy($outputImage,$image,0,0,0,0, $x, $y);
    }
}

//Clothing Layer #3
foreach ($clothingInfo as $clothing) {
    $layers = explode(" ", $clothing['layers']);
    if (in_array("3",$layers)) {
        $url = 'Layers/Clothes/3/' . $clothing['name'] . '.png';
        $image = imagecreatefrompng($url);
        imagecopy($outputImage,$image,0,0,0,0, $x, $y);
    }
}

//Clothing Layer #4
foreach ($clothingInfo as $clothing) {
    $layers = explode(" ", $clothing['layers']);
    if (in_array("4",$layers)) {
        $url = 'Layers/Clothes/4/' . $clothing['name'] . '.png';
        $image = imagecreatefrompng($url);
        imagecopy($outputImage,$image,0,0,0,0, $x, $y);
    }
}

//Clothing Layer #5
foreach ($clothingInfo as $clothing) {
    $layers = explode(" ", $clothing['layers']);
    if (in_array("5",$layers)) {
        $url = 'Layers/Clothes/5/' . $clothing['name'] . '.png';
        $image = imagecreatefrompng($url);
        imagecopy($outputImage,$image,0,0,0,0, $x, $y);
    }
}

//Clothing Layer #6
foreach ($clothingInfo as $clothing) {
    $layers = explode(" ", $clothing['layers']);
    if (in_array("6",$layers)) {
        $url = 'Layers/Clothes/6/' . $clothing['name'] . '.png';
        $image = imagecreatefrompng($url);
        imagecopy($outputImage,$image,0,0,0,0, $x, $y);
    }
}

//Clothing Layer #7
foreach ($clothingInfo as $clothing) {
    $layers = explode(" ", $clothing['layers']);
    if (in_array("7",$layers)) {
        $url = 'Layers/Clothes/7/' . $clothing['name'] . '.png';
        $image = imagecreatefrompng($url);
        imagecopy($outputImage,$image,0,0,0,0, $x, $y);
    }
}


//Bangs


//Front Antler Decor
foreach ($clothingInfo as $clothing) {
    if ($clothing["antlers"]) {
        $url = 'Layers/Clothes/FAD/' . $clothing['name'] . '.png';
        $image = imagecreatefrompng($url);
        imagecopy($outputImage,$image,0,0,0,0, $x, $y);
    }
}

//Clothing Layer #8
foreach ($clothingInfo as $clothing) {
    $layers = explode(" ", $clothing['layers']);
    if (in_array("8",$layers)) {
        $url = 'Layers/Clothes/8/' . $clothing['name'] . '.png';
        $image = imagecreatefrompng($url);
        imagecopy($outputImage,$image,0,0,0,0, $x, $y);
    }
}

//Clothing Layer #9
foreach ($clothingInfo as $clothing) {
    $layers = explode(" ", $clothing['layers']);
    if (in_array("9",$layers)) {
        $url = 'Layers/Clothes/9/' . $clothing['name'] . '.png';
        $image = imagecreatefrompng($url);
        imagecopy($outputImage,$image,0,0,0,0, $x, $y);
    }
}

//Front Wings
 if (strpos($pet["specials"], "BugWings") !== false) {
    $url = 'Layers/Wings/BugWingTop.png';
    $image = imagecreatefrompng($url);
    imagecopy($outputImage,$image,0,0,0,0, $x, $y);
    $wings = true;
}
if (strpos($pet["specials"], "FeatheredWings") !== false) {
    $url = 'Layers/Wings/Pegasus/Top/' . $pet['mainColor'] . '.png';
    $image = imagecreatefrompng($url);
    imagecopy($outputImage,$image,0,0,0,0, $x, $y);
    $wings = true;
}

//Front Wing Decor
foreach ($clothingInfo as $clothing) {
    if ($clothing["wings"]) {
        $url = 'Layers/Clothes/FWD/' . $clothing['name'] . '.png';
        $image = imagecreatefrompng($url);
        imagecopy($outputImage,$image,0,0,0,0, $x, $y);
        $wings = true;
    }
}

//Sleeves IF Wings
if ($wings == true) {
    foreach ($clothingInfo as $clothing) {
        if ($clothing["sleeve"]) {
            $url = 'Layers/Clothes/Sleeves/' . $clothing['name'] . '.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);
            $wings = true;
        }
    }
}

//Clothing Layer #10
foreach ($clothingInfo as $clothing) {
    $layers = explode(" ", $clothing['layers']);
    if (in_array("10",$layers)) {
        $url = 'Layers/Clothes/10/' . $clothing['name'] . '.png';
        $image = imagecreatefrompng($url);
        imagecopy($outputImage,$image,0,0,0,0, $x, $y);
    }
}
//Finish Image
imagepng($outputImage, $dest);
imagedestroy($outputImage);

//Display Image
echo '<img src="snoozeImages/' . $pet['id'] . '.png" style="width:400px;height:auto;">';
































