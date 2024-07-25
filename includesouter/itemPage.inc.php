<?php
$id = $_GET['id'];
$userId = $_SESSION['user_id'];

//Get How Many of Item
$query = "SELECT * FROM items WHERE list_id = :item AND user_id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->bindParam(":item", $id);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$count = count($results);

//Get Item Information
$query = "SELECT * FROM itemList WHERE id = :item";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":item", $id);
$stmt->execute();
$item = $stmt->fetch(PDO::FETCH_ASSOC);

//Get Snoozelings
$query = "SELECT * FROM snoozelings WHERE owner_id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$snoozelings = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Get Dyes
if ($item['canDye'] == 1 || $item['name'] == "Bandana") {
    $dyelist = [];
    for ($i = 0; $i < $count; $i++) {
        foreach ($results as $dye) {
            if ($dye['dye']) {
                array_push($dyelist, $dye['dye']);
            } else {
                array_push($dyelist, "White");
            }
        }
    }
    
    $dyefix = array_unique($dyelist);
    
    
    //Move White to Front
    $notwhite = [];
    if(in_array("White", $dyefix)) {
        foreach ($dyefix as $fix) {
            if ($fix == "White") {
                
            } else {
                array_push($notwhite, $fix);
            }
            $white = ["White"];
            $dyefix = array_merge($white, $notwhite);
        }
    }
    
    $dyedisplays = [];
    foreach ($dyefix as $word) {
        if ($word == "Silver") {
            array_push($dyedisplays, "Silver");
        } else if ($word == "Gold") {
            array_push($dyedisplays, "Gold");
        } else {
            $query = "SELECT * FROM dyes WHERE name = :name";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":name", $word);
            $stmt->execute();
            $dyeName = $stmt->fetch(PDO::FETCH_ASSOC);
            array_push($dyedisplays, $dyeName['display']);
        }
    }
        
}




//Type Edit
$type = ucfirst($item['type']);
if ($item['type'] === 'clothesBottom') {
    $type = "Clothes [Bottom]";
}
if ($item['type'] === 'clothesTop') {
    $type = "Clothes [Top]";
}
if ($item['type'] === 'clothesHoodie') {
    $type = "Clothes [Hoodie]";
}
if ($item['type'] === 'clothesBoth') {
    $type = "Clothes [Both]";
}

//Back to Pack Arrows
 echo '<div class="leftRightButtons">';
echo '<a href="pack"><<</a>';
echo '</div>';

echo '<div class="itemPageRow">';
echo '<div class="itemPage">';
if ($dyefix || $item['type'] === 'clothesBottom' || $item['type'] === 'clothesTop' || $item['type'] === 'clothesHoodie' || $item['type'] === 'clothesBoth') {
    if ($dyefix[0] == "White") {
        echo '<img id="itemicon" src="items/' . $item['name'] . '.png" style="width: 150px;">';
        echo '<h4 id="colortitle">' . $item['display'] . /* ' [' . $dyedisplays[0] . ']' . */ '</h4>';
    } else {
        echo '<img id="itemicon" src="items/' . $item['name'] . $dyefix[0] . '.png" style="width: 150px;border-radius:50px;border:4px solid silver;">';
        echo '<h4 id="colortitle">' . $item['display'] . /* ' [' . $dyedisplays[0] . ']' . */ '</h4>';
    }
} else {
    echo '<img id="itemicon" src="items/' . $item['name'] . '.png" style="width: 150px;">';
    echo '<h4 id="colortitle">' . $item['display'] . '</h4>';
}


echo '<p><i>' . $item['description'] . '</i></p>';
echo '</div>';
echo '<div class="itemPageRight">';
echo '<p><strong>Type: </strong>' . $type . '</p>';
echo '<p><strong>Rarity: </strong>' . ucfirst($item['rarity']) . '</p>';
echo '<p><strong>Quantity: </strong>' . $count . '</p>';
echo '</div>';

if ($results) {
    //Planter Box - Add Farm Plot
    if ($item['name'] === "PlanterBox") {
        echo '<form method="post" action="includes/useBox.inc.php">';
        echo '<button class="fancyButton">Add Farm Plot</button>';
        echo '</form>';
    }
    
    if ($item['name'] === "PetBed") {
        echo '<form method="post" action="includes/usePetBed.inc.php">';
        echo '<button class="fancyButton">Add Pet Bed</button>';
        echo '</form>';
    }
    
    if ($item['name'] === "FarmChest" || $item['name'] === "BeachChest" || $item['name'] === "ForestChest") {
        //Check for Key
        //Check for Key
        $query = 'SELECT * FROM items WHERE user_id = :id AND name = "Key"';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
        $keycheck = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($keycheck) {
            echo '<form method="post" action="includes/openChest.inc.php" onclick="return confirm(\'This action will consume a single key. Are you sure you want to continue?\')" >';
            echo '<input type="hidden" name="type" value="' . $item['name'] . '">';
            echo '<button class="fancyButton">Open Chest</button>';
            echo '</form>';
        } else {
            echo '<p>Chests require 1 key to open</p>';
        }
        
        
    }


    if ($item['type'] === 'clothesBottom' || $item['type'] === 'clothesTop' || $item['type'] === 'clothesHoodie' || $item['type'] === 'clothesBoth') {
        echo '<form method="post" action="includes/wearClothes.inc.php">';
        echo '<input type="hidden" name="item" value="' . $id . '">';
        echo '<input type="hidden" name="item" value="' . $id . '">';
        echo '<label for="area"  class="form">Choose A Pet:</label><br>';
        echo '<select  class="input" name="pet" id="pet"><br>';
        foreach ($snoozelings as $pet) {
            echo '<option value="' . $pet['id'] . '">' . htmlspecialchars($pet['name']) . '</option>';
        }
        echo '</select><br>';
        if (count($dyefix) > 0) {
            echo '<label for="area"  class="form">Choose A Color:</label><br>';
            echo '<select  class="input" name="color" id="color"><br>';
            foreach ($dyefix as $dye) {
                switch ($dye) {
                    case "PastelPink":
                        $ending = "Pastel Pink";
                        break;
                    case "PastelBrown":
                        $ending = "Pastel Brown";
                        break;
                    case "PastelPurple":
                        $ending = "Pastel Purple";
                        break;
                    case "PastelBlue":
                        $ending = "Pastel Blue";
                        break;
                    case "RainbowLove":
                        $ending = "Rainbow Love";
                        break;
                    case "FemaleLove":
                        $ending = "Female Love";
                        break;
                    case "MaleLove":
                        $ending = "Male Love";
                        break;
                    case "DoubleLove":
                        $ending = "Double Love";
                        break;
                    case "AnyLove":
                        $ending = "Any Love";
                        break;
                    case "AceLove":
                        $ending = "Ace Love";
                        break;
                    case "AroLove":
                        $ending = "Ace Love";
                        break;
                    case "NewSelf":
                        $ending = "New Self";
                        break;
                    case "UniqueSelf":
                        $ending = "Unique Self";
                        break;
                    case "FluidSelf":
                        $ending = "Fluid Self";
                        break;
                    default:
                        $ending = $dye;
                }
                echo '<option value="' . $dye . '">' . $ending . '</option>';
            }
        }
        echo '</select>';
        echo '<div><button class="fancyButton">Wear Item</button></div>';
        echo '</form>';

    }
}

echo '</div>';



















