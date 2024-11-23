<?php
$id = $_GET['id'];
$userId = $_SESSION['user_id'];

$query = "SELECT * FROM users WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

//Navigation
echo '<div id="onlyOne" class="leftRightButtons">';
if ($id > 1) {
    echo '<a id="leftArrow" href="pet?id=' . ($id - 1) . '"><<</a>';
}
echo '<a href="pet?id=' . ($id + 1) . '">>></a>';


echo '</div>';

/*
//Get List of All Snoozelings
$query = "SELECT id FROM snoozelings WHERE owner_id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
 */
//Get Owner ID
$query = "SELECT owner_id FROM snoozelings WHERE id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

//Buttons
if ($_SESSION["user_id"] == $result["owner_id"]) { 
    echo '<div class="button-bar">
                <button class="fancyButton" onClick="window.location.href=\'/editPet?id=' . $id . '\'">Edit Pet</button>
                <button class="fancyButton" onClick="window.location.href=\'/petJob?id=' . $id . '\'">Change Job</button>';
    
    if ($user['bonded'] != $id) {
        echo  '<button class="fancyButton" onClick="window.location.href=\'../includes/bondSoul.inc.php?id=' . $id . '\'">Bond Souls</button>';
    }
                
               
    echo '</div>';
} elseif ($result['owner_id'] === "0") {
     echo '<div class="button-bar"><p style="font-size: 2rem;" >Up for Adoption</p></div>';
} else {
    //Get Username
    $query = "SELECT username FROM users WHERE id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $result["owner_id"]);
    $stmt->execute();
    $name = $stmt->fetch(PDO::FETCH_ASSOC);
    echo '<div class="button-bar"><p style="font-size: 2rem;" ><strong>Owned By: </strong><a href="profile?id=' . $result["owner_id"] . '">' . htmlspecialchars($name["username"]) . '</a></p></div>';
}

//Pet Title
$query = "SELECT * FROM snoozelings WHERE id = :id;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $id);
$stmt->execute();
$pet = $stmt->fetch(PDO::FETCH_ASSOC);

//Birthday Calculation
$birthday = substr($pet['birthDate'], 5);
$monthNum = $birthday.substr(0, 3);
$monthNum = intval($monthNum);
$dayNum = substr($birthday, -2);
$dayNum = intval($dayNum);
$monthArray = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

if (!($pet['gotchaDate'] === null)) {
    $join = substr($pet['gotchaDate'], 5);
    $joinMonth = $join.substr(0, 3);
    $joinMonth = intval($joinMonth);
    $joinDay = substr($join, -2);
    $joinDay = intval($joinDay);
}

//Secret Explore Time
$now = new DateTime("now", new DateTimezone('UTC'));
$result = $now->format('Y-m-d H:i:s');

//Get Minutes Remaining
$to_time = strtotime($pet['cooldownTime']);
$from_time = strtotime($result);
$diff = round(abs($to_time - $from_time) / 60,0);
//Date Stuff
$now = new DateTime("now", new DateTimezone('UTC'));
$future_date = new DateTime($pet['cooldownTime']);
$interval = $future_date->diff($now);

//Row One
echo '<div class="profilerow">';
echo '<div class="profilecontainerleft">';

//echo "<h3 title='" . $interval->format("%h Hours, %i Minutes") . "'>" . htmlspecialchars($pet["name"]) . "</h3>";
echo "<h3>" . htmlspecialchars($pet["name"]) . "</h3>";
echo "<p>" . $pet['title'] . '</p>';

//Pet Info
echo '<div class="bar profilebox" style="overflow-y: auto;">';
echo '<h4 style="text-align: left; margin-top: 1rem; padding-bottom: .5rem; font-size: 2.2rem;border-bottom: 2px dashed #827188;" >&nbsp;&nbsp;&nbsp;Pet Info</h4>';
echo '<p class="snoozelinginfo"><strong>Pet ID: </strong>' . $pet['id'];
echo '<p class="snoozelinginfo"><strong>Pronouns: </strong>' . $pet['pronouns'];
echo '<p class="snoozelinginfo"><strong>Birthday: </strong>' . $monthArray[$monthNum -1] . " " . $dayNum;
if (!($pet['gotchaDate'] === null)) {
    echo '<p class="snoozelinginfo"><strong>Gotcha Day: </strong>' . $monthArray[$joinMonth -1] . " " . $joinDay;
}
if ($pet['job'] === 'jack') {
    $job = "Jack of All Trades";
} else {
    $job = $pet['job'];
}
echo '<p class="snoozelinginfo"><strong>Current Job: </strong>' . $job;
echo '<p class="snoozelinginfo"><strong>Inspiration Status: </strong>' . $pet['breedStatus'];

echo '</div>';
echo '</div>';

//Pet Display
$query = "SELECT * FROM snoozelings WHERE id = :id;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $id);
$stmt->execute();
$petInfo = $stmt->fetch(PDO::FETCH_ASSOC);

echo '<div class="displaycontainerright">';
displayPet($petInfo, "artlarge");
echo "<p><strong>" . htmlspecialchars($petInfo["name"]) . "'s Pronouns:</strong> " . htmlspecialchars($petInfo["pronouns"]) . "</p>";
echo '</div>';
echo '</div>';

echo '<hr>';

//Pet Row Two

echo '<div class="secondrow">';



//Plushie Build
echo '<div class="profilerowtwo" style="border: 2px dashed #827188; border-radius: 20px;overflow-y: auto; height: 305px;">';
echo '<h4 style="text-align: left; margin-top: 1rem; padding-bottom: .5rem; font-size: 2.2rem;border-bottom: 2px dashed #827188; height: " >&nbsp;&nbsp;&nbsp;Plushie Build</h4>';
$query = "SELECT * FROM snoozelings WHERE id = :id;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$queryMainColor = "SELECT * FROM colors WHERE name = :mainColor";
$queryHairColor = "SELECT * FROM colors WHERE name = :haircolor";
$queryTailColor = "SELECT * FROM colors WHERE name = :tailColor";
$queryEyeColor = "SELECT * FROM colors WHERE name = :eyeColor";
$queryNoseColor = "SELECT * FROM colors WHERE name = :noseColor";

$stmt2 = $pdo->prepare($queryMainColor);
$stmt3 = $pdo->prepare($queryHairColor);
$stmt4 = $pdo->prepare($queryTailColor);
$stmt5 = $pdo->prepare($queryEyeColor);
$stmt6 = $pdo->prepare($queryNoseColor);
        
$stmt2->bindParam(":mainColor", $result['mainColor']);
$stmt3->bindParam(":haircolor", $result['hairColor']);
$stmt4->bindParam(":tailColor", $result['tailColor']);
$stmt5->bindParam(":eyeColor", $result['eyeColor']);
$stmt6->bindParam(":noseColor", $result['noseColor']);
        
$stmt2->execute();
$stmt3->execute();
$stmt4->execute();
$stmt5->execute();
$stmt6->execute();
        
$mainColorResults = $stmt2->fetch(PDO::FETCH_ASSOC);
$hairColorResults = $stmt3->fetch(PDO::FETCH_ASSOC);
$tailColorResults = $stmt4->fetch(PDO::FETCH_ASSOC);
$eyeColorResults = $stmt5->fetch(PDO::FETCH_ASSOC);
$noseColorResults = $stmt6->fetch(PDO::FETCH_ASSOC);

if(!$noseColorResults) {
    $nose = $result['noseColor'];
    $title = "Fabric";
} else {
    $nose = $noseColorResults["display"];
    $fabric = $noseColorResults["categories"];
}

echo '<p class="snoozelinginfo box" id="pbmaincolor" title="' . $mainColorResults["categories"] . '"><strong>Main Color: </strong>' . $mainColorResults["display"] . '</p>
        <p class="snoozelinginfo" id="pbhaircolor"title="' . $hairColorResults["categories"] . '"><strong>Hair Color: </strong>' . $hairColorResults["display"] . '</p>
        <p class="snoozelinginfo" id="pbtailcolor"title="' . $tailColorResults["categories"] . '"><strong>Tail Color: </strong>' . $tailColorResults["display"] . '</p>
        <p class="snoozelinginfo" id="pbeyecolor"title="' . $eyeColorResults["categories"] . '"><strong>Eye Color: </strong>' . $eyeColorResults["display"] . '</p>
        <p class="snoozelinginfo" id="pbnosecolor"title="' . $fabric . '"><strong>Skin Color: </strong>' . $nose . '</p>
        <p class="snoozelinginfo" id="pbhairstyle"><strong>Hair Style: </strong>' . $result["hairType"] . '</p>
        <p class="snoozelinginfo" id="pbtailstyle"><strong>Tail Type: </strong>' . $result["tailType"] . '</p>
        <p class="snoozelinginfo" id="pbspecialmarkings" style="margin-bottom: .3rem;"><strong>Special Traits: </strong></p>
        <ul style="text-align: left;margin-top: 0;padding-bottom: 0;font-size:1.6rem;">';
$specialArray = explode(" ", $result["specials"]);
    foreach ($specialArray as $special) {
        if ($special == "FeatheredWings") {
            echo '<li style="margin-bottom:.3rem;margin-left:3rem;">Wings</li>';
        } else if ($special == "BugWings") {
            echo '<li style="margin-bottom:.3rem;margin-left:3rem;">Bug Wings</li>';
        } else if ($special == "EarTip") {
            echo '<li style="margin-bottom:.3rem;margin-left:3rem;">Ear Tip</li>';
        } else if ($special == "TinyTooth") {
            echo '<li style="margin-bottom:.3rem;margin-left:3rem;">Tiny Tooth</li>';
        } else if (str_contains($special,"MothFluff")) {
            //Color Check
            $query = "SELECT * FROM dyes";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $colors = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $ending = "";
            $itemName = "";
            $item = $special;
            foreach ($colors as $x) {
                if (str_ends_with($item, $x['name'])) {
                    $itemName = str_replace($x['name'], "", $item);
                    $ending = $x['display'];
                }
            }

            $othercolors = ['Gold', 'Silver'];
            foreach ($othercolors as $x) {
                if (str_ends_with($item, $x)) {
                    $itemName = str_replace($x, "", $item);
                    $ending = $x;
                }
            }


            if ($ending) {
                //Item Display Name
                $query = "SELECT * FROM itemList WHERE name = :name;";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":name", $itemName);
                $stmt->execute();
                $displayName = $stmt->fetch(PDO::FETCH_ASSOC);
                
                echo '<li style="margin-bottom:.3rem;margin-left:3rem;">Moth Fluff'. ' [' . $ending . '] ' . '</li>';
            } else {
                //Item Display Name
                $query = "SELECT * FROM itemList WHERE name = :name;";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":name", $item);
                $stmt->execute();
                $displayName = $stmt->fetch(PDO::FETCH_ASSOC);

                echo '<li style="margin-bottom:.3rem;margin-left:3rem;">Moth Fluff</li>';
            } 
        } else {
            echo '<li style="margin-bottom:.3rem;margin-left:3rem;">' . $special . '</li>';
        }
            
        }
echo  '</ul>';
echo '</div>';

//Bio Box
echo '<div class="profilerowtwo" style="border: 2px dashed #827188; border-radius: 20px;overflow-y: auto; height: 305px;scroll;overflow-x: hidden;">';
echo '<h4 style="text-align: left; margin-top: 1rem; padding-bottom: .5rem; font-size: 2.2rem;border-bottom: 2px dashed #827188; height: " >&nbsp;&nbsp;&nbsp;Bio</h4>';
    echo '<p class="snoozelinginfo">' . nl2br(htmlspecialchars($pet['bio'])) . '</p>';

echo '</div>';
echo '</div>';
echo '<hr>';

echo '<div class="secondrow">';

//Inspired Snoozelings
echo '<div class="profilerowtwo">';
echo '<div class="itemsapplied bar" style="height: 140px; width: 100%; border: 2px dashed #827188; border-radius: 20px;overflow-y: auto;">';
echo '<h4 style="text-align: left; margin-top: 1rem; padding-bottom: .5rem; font-size: 2.2rem;border-bottom: 2px dashed #827188;" >&nbsp;&nbsp;&nbsp;Snooze Family</h4>';
echo '<div style="display: flex; flex-direction: column; flex-wrap: wrap; column-gap: .5rem; row-gap: .5rem; " >';
if ($pet['parents']) {
    $parents = explode(" ", $pet['parents']);
    echo '<p style="margin-bottom:0"><b>Inspiration:</b></p>';
    echo '<ul style="margin-top:0;">';
    foreach($parents as $parent) {
        $query = 'SELECT * FROM snoozelings WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $parent);
        $stmt->execute();
        $listitem = $stmt->fetch(PDO::FETCH_ASSOC);
        echo '<li style="font-size:1.6rem;text-align: left;"><a href="pet?id=' . $parent . '">' . htmlspecialchars($listitem['name']) . '</a></li>';
    }
    echo '</ul>';
}
if ($pet['parents'] && $pet['inspire']) {
    echo '<hr style="margin-bottom:8px;margin-top:8px;">';
     echo '<p style="margin-bottom:0;margin-top:0px;"><b>Inspiring:</b></p>';
} else if ($pet['inspire']) {
     echo '<p style="margin-bottom:0"><b>Inspired Snoozelings:</b></p>';
}
if ($pet['inspire']) {
    $inspires = explode(" ", $pet['inspire']);
   
    echo '<ul style="margin-top:0;">';
    foreach($inspires as $inspire) {
        $query = 'SELECT name, owner_id FROM snoozelings WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $inspire);
        $stmt->execute();
        $listitem = $stmt->fetch(PDO::FETCH_ASSOC);
        echo '<li style="font-size:1.6rem;text-align: left"><a href="pet?id=' . $inspire . '">' . htmlspecialchars($listitem['name']) . '</a></li>';
    }
    echo '</ul>';
}
echo '</div>';
echo '</div>';
echo '</div>';

//Small Right Boxes
echo '<div class="profilerowtwo">';

//Clothes Box
echo '<div class="itemsapplied box" style="height: 140px; width: 100%; border: 2px dashed #827188; border-radius: 20px;margin-bottom: 2.1rem; overflow-y: auto;">';
echo '<h4 style="text-align: left; margin-top: 1rem; padding-bottom: .5rem; font-size: 2.2rem;border-bottom: 2px dashed #827188;" >&nbsp;&nbsp;&nbsp;Snooze Clothes</h4>';
$clothes = [];
$list = "";
if ($pet['clothesBoth']) {
    $temp = explode(" ", $pet['clothesBoth']);
    foreach ($temp as $tempie) {
        array_push($clothes, $tempie);
    }
    
}
if ($pet['clothesTop']) {
    $temp = explode(" ", $pet['clothesTop']);
    foreach ($temp as $tempie) {
        array_push($clothes, $tempie);
    }
}
if ($pet['clothesBottom']) {
    $temp = explode(" ", $pet['clothesBottom']);
    foreach ($temp as $tempie) {
        array_push($clothes, $tempie);
    }
}
if ($pet['clothesHoodie']) {
    $temp = explode(" ", $pet['clothesHoodie']);
    foreach ($temp as $tempie) {
        array_push($clothes, $tempie);
    }
}
echo '<div style="display: flex; flex-direction: row; flex-wrap: wrap; column-gap: .5rem; row-gap: .5rem; justify-content: center;">';
foreach ($clothes as $item) {    
    //Color Check
    $query = "SELECT * FROM dyes";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $colors = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $ending = "";
    $itemName = "";
    foreach ($colors as $x) {
        if (str_ends_with($item, $x['name'])) {
            $itemName = str_replace($x['name'], "", $item);
            $ending = $x['display'];
        }
    }
    
    $othercolors = ['Gold', 'Silver'];
    foreach ($othercolors as $x) {
        if (str_ends_with($item, $x)) {
            $itemName = str_replace($x, "", $item);
            $ending = $x;
        }
    }
    
    
    if ($ending) {
        //Item Display Name
        $query = "SELECT * FROM itemList WHERE name = :name;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":name", $itemName);
        $stmt->execute();
        $displayName = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo '<img src="items/' . $item . '.png" style="width: 25%;border-radius:20px;border: 2px solid silver;" title="' . $displayName['display'] . ' [' . $ending . '] ' . '">';
    } else {
        //Item Display Name
        $query = "SELECT * FROM itemList WHERE name = :name;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":name", $item);
        $stmt->execute();
        $displayName = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo '<img src="items/' . $item . '.png" style="width: 25%;border-radius:20px;border: 2px solid silver;" title="' . $displayName['display'] . '">';
    }
    
}
echo '</div>';
echo '</div>';


echo '</div>';


echo '</div>';
echo '</div>';

echo '<hr>';

//Bottom Space
echo '<div id="bottomSpace">';
if ($result['boops']) {
    $boops = explode(" ", $result["boops"]);
    $buuopsNum = count($boops);
} else {
    $boops = [];
    $buuopsNum = 0;
}
echo '<p><b>Boop Count:</b> ' . $buuopsNum . '</p>';
if (in_array($userId,$boops)) {
    echo '<p><i>You have already booped this snoozeling\'s snoot</i></p>';
} else {
    echo '<form action="includes/boopSnoot.inc.php" method="post">';
    echo '<input type="hidden" id="id" name="id" value="' . $id . '">';
    echo '<button  class="fancyButton">Boop ' . $result['name'] . '\'s Snoot</button>';
    echo '</form>';
}
echo '</div>'; 














