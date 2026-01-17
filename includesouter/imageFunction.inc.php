<?php

function resetImage($snooze, $pdo) {
    
    //Hair Layering
    $attached = ['Floof'];
    $bang = ['Braid','Forelock','Holiday','Knitted','LizardSpikes','Mane','Mohawk','Wave'];
    $back = ['Braid','Forelock','Holiday','Wave','Mohawk'];
    $front = ['Braid','Holiday','Knitted'];
    $spine = ['LizardSpikes'];
    $chest = ['Mane'];

    //Get Pet Info For Testing
    $id = $snooze;
    $query = 'SELECT * FROM snoozelings WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $pet = $stmt->fetch(PDO::FETCH_ASSOC);

    //FetchDyes
    $query = "SELECT * FROM dyes ORDER BY id DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $dyelist = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

        //Dye Name Check + Silver + Gold
        $newname = "";
        $color = "";
        foreach ($dyelist as $dye) {
                if (str_ends_with($cloth, $dye['name'])) {
                    $newname = str_replace($dye['name'],"",$cloth);
                    $color = $dye['name'];
                    break;
                } else {

                }
            }


        $query = 'SELECT * FROM clothes WHERE name = :name';
        $stmt = $pdo->prepare($query);
        if ($newname) {
            $stmt->bindParam(":name", $newname);
        } else {
            $stmt->bindParam(":name", $cloth);
        }
        $stmt->execute();
        $temp = $stmt->fetch(PDO::FETCH_ASSOC);
        array_push($clothingInfo,$temp);
    }

    //Hoodie Check
    $hoodie = false;
    foreach ($clothingInfo as $check) {
        if ($check['hoodie'] == 1) {
            $hoodie = true;
        }
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
    $wings = false;
     if (strpos($pet["specials"], "BugWings") !== false) {
        $url = 'Layers/Wings/BugWingBottom.png';
        $image = imagecreatefrompng($url);
        imagecopy($outputImage,$image,0,0,0,0, $x, $y);
         $wings = true;
    }
    if (strpos($pet["specials"], "FeatheredWings") !== false) {
        $url = 'Layers/Wings/Pegasus/Bottom/' . $pet['mainColor'] . '.png';
        $image = imagecreatefrompng($url);
        imagecopy($outputImage,$image,0,0,0,0, $x, $y);
        $wings = true;
    }

    //Back Wing Decor
    $count = 0;
    foreach ($clothingInfo as $clothing) {
        if ($clothing["wings"]) {
            $url = 'Layers/Clothes/BWD/' . $clothes[$count] . '.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);
            $wings = true;
        }
        $count++;
    }

    //Back Antler Decor
    $count = 0;
    foreach ($clothingInfo as $clothing) {
        if ($clothing["antlers"]) {
            $url = 'Layers/Clothes/BAD/' . $clothes[$count] . '.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);
        }
        $count++;
    }

    //Clothing Layer #1
    $count = 0;
    foreach ($clothingInfo as $clothing) {
        $layers = explode(" ", $clothing['layers']);
        if (in_array("1",$layers)) {
            $url = 'Layers/Clothes/1/' . $clothes[$count] . '.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);
        }
        $count++;
    }

    //Back Hair Piece
    if (!$hoodie && in_array($pet['hairType'],$back)) {
        $url = 'Layers/Hair/' . $pet['hairType'] . '/Back/' . $pet['hairColor'] . '.png';
        $image = imagecreatefrompng($url);
        imagecopy($outputImage,$image,0,0,0,0, $x, $y);
    }

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
    } else if ($pet['tailType'] == "Tailless" || $pet['tailType'] == "Pom") {

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
        $url = 'Layers/Markings/Sublimation/' . $pet['mainColor'] . '.png';
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
    if ($hoodie == false && in_array($pet['hairType'],$attached)) {
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
    $count = 0;
    foreach ($clothingInfo as $clothing) {
        $layers = explode(" ", $clothing['layers']);
        if (in_array("2",$layers)) {
            $url = 'Layers/Clothes/2/' . $clothes[$count] . '.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);
        }
        $count++;
    }

    //Clothing Layer #3
    $count = 0;
    foreach ($clothingInfo as $clothing) {
        $layers = explode(" ", $clothing['layers']);
        if (in_array("3",$layers)) {
            $url = 'Layers/Clothes/3/' . $clothes[$count] . '.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);
        }
        $count++;
    }

    //Clothing Layer #4
    $count = 0;
    foreach ($clothingInfo as $clothing) {
        $layers = explode(" ", $clothing['layers']);
        if (in_array("4",$layers)) {
            $url = 'Layers/Clothes/4/' . $clothes[$count] . '.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);
        }
        $count++;
    }



    //Clothing Layer #5
    $count = 0;
    foreach ($clothingInfo as $clothing) {
        $layers = explode(" ", $clothing['layers']);
        if (in_array("5",$layers)) {
            $url = 'Layers/Clothes/5/' . $clothes[$count] . '.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);
        }
        $count++;
    }

    //Chest Hair Piece
    if (!$hoodie && in_array($pet['hairType'],$chest)) {
        $url = 'Layers/Hair/' . $pet['hairType'] . '/Chest/' . $pet['hairColor'] . '.png';
        $image = imagecreatefrompng($url);
        imagecopy($outputImage,$image,0,0,0,0, $x, $y);
    }

    //Clothing Layer #6
    $count = 0;
    foreach ($clothingInfo as $clothing) {
        $layers = explode(" ", $clothing['layers']);
        if (in_array("6",$layers)) {
            $url = 'Layers/Clothes/6/' . $clothes[$count] . '.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);
        }
        $count++;
    }

    //Clothing Layer #7
    $count = 0;
    foreach ($clothingInfo as $clothing) {
        $layers = explode(" ", $clothing['layers']);
        if (in_array("7",$layers)) {
            $url = 'Layers/Clothes/7/' . $clothes[$count] . '.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);
        }
        $count++;
    }

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

        $url = 'Layers/Faces/Cheeky/Lines/' . $pet['mainColor'] . '.png';
        $image = imagecreatefrompng($url);
        imagecopy($outputImage,$image,0,0,0,0, $x, $y); 
    } 


    //Bangs Hair Piece
    if ($hoodie == false && in_array($pet['hairType'],$bang)) {
        $url = 'Layers/Hair/' . $pet['hairType'] . '/Bang/' . $pet['hairColor'] . '.png';
        $image = imagecreatefrompng($url);
        imagecopy($outputImage,$image,0,0,0,0, $x, $y);
    }




    //Pom Tail
    if($pet['tailType'] == "Pom") {
        $url = 'Layers/Tail/' . $pet['tailType'] . '/' . $pet['tailColor'] . '.png';
        $image = imagecreatefrompng($url);
        imagecopy($outputImage,$image,0,0,0,0, $x, $y);
    }


    //Clothing Layer #8
    $count = 0;
    foreach ($clothingInfo as $clothing) {
        $layers = explode(" ", $clothing['layers']);
        if (in_array("8",$layers)) {
            $url = 'Layers/Clothes/8/' . $clothes[$count] . '.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);
        }
        $count++;
    }

    //Clothing Layer #9
    $count = 0;
    foreach ($clothingInfo as $clothing) {
        $layers = explode(" ", $clothing['layers']);
        if (in_array("9",$layers)) {
            $url = 'Layers/Clothes/9/' . $clothes[$count] . '.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);
        }
        $count++;
    }

    //Front Moth Fluff
    if ($mothtype) {
        $url = 'Layers/Other/MothFluff/' . $moth . '.png';
        $image = imagecreatefrompng($url);
        imagecopy($outputImage,$image,0,0,0,0, $x, $y);
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
    $count = 0;
    foreach ($clothingInfo as $clothing) {
        if ($clothing["wings"]) {
            $url = 'Layers/Clothes/FWD/' . $clothes[$count] . '.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);
            $wings = true;
        }
        $count++;
    }

    //Sleeves IF Wings
    if ($wings == true) {
        $count = 0;
        foreach ($clothingInfo as $clothing) {
            if ($clothing["sleeve"]) {
                $url = 'Layers/Clothes/Sleeves/' . $clothes[$count] . '.png';
                $image = imagecreatefrompng($url);
                imagecopy($outputImage,$image,0,0,0,0, $x, $y);
            }
            $count++;
        }

    }

    //Front Hair Piece
    if (!$hoodie && in_array($pet['hairType'],$front)) {
        $url = 'Layers/Hair/' . $pet['hairType'] . '/Front/' . $pet['hairColor'] . '.png';
        $image = imagecreatefrompng($url);
        imagecopy($outputImage,$image,0,0,0,0, $x, $y);
    }

    //Front Antler Decor
    $count = 0;
    foreach ($clothingInfo as $clothing) {
        if ($clothing["antlers"]) {
            $url = 'Layers/Clothes/FAD/' . $clothes[$count] . '.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);
        }
        $count++;
    }

    //Clothing Layer #10
    $count = 0;
    foreach ($clothingInfo as $clothing) {
        $layers = explode(" ", $clothing['layers']);
        if (in_array("10",$layers)) {
            $url = 'Layers/Clothes/10/' . $clothes[$count] . '.png';
            $image = imagecreatefrompng($url);
            imagecopy($outputImage,$image,0,0,0,0, $x, $y);
        }
        $count++;
    }

    //Finish Image
    imagepng($outputImage, $dest);
    imagedestroy($outputImage);
    
}





























