<?php
$id = $_GET['id'];
$userId = $_SESSION['user_id'];

//Get How Many of Item
$query = "SELECT * FROM items WHERE list_id = :item AND user_id = :id AND test = 0";
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
                array_push($dyelist, "Basic");
            }
        }
    }
    
    $dyefix = array_unique($dyelist);
    
    
    
    //Move Basic to Front
    $notwhite = [];
    if(in_array("Basic", $dyefix)) {
        
        foreach ($dyefix as $fix) {
            
            if ($fix == "Basic") {
                
            } else {
                array_push($notwhite, $fix);
            }
            $white = ["Basic"];
            if ($notwhite) {
                $dyefix = array_merge($white, $notwhite);
            } else {
                $dyefix = ['Basic'];
            }
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
    if ($dyefix[0] == "Basic") {
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
    
    if ($item['type'] == "stain") {
        
        $query = "SELECT * FROM snoozelings WHERE owner_id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
        $pets = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<form method='POST' action='includes/useStain.inc.php' onsubmit=\"return confirm('Are you sure you want to apply this stain? This action cannot be reversed.');\">"; 
        echo '<label style="margin-top: 2rem;" for="pet" class="form">Apply to which Snoozeling?</label><br>';
        echo '<select class="input"  name="pet">';
        foreach ($pets as $pet) {
            echo '<option value="' . $pet['id'] . '">' . htmlspecialchars($pet['name']) . '</option>';
        }
        echo '</select><br>';
        
        echo '<label style="margin-top: 2rem;" for="part" class="form">Apply to which body part?</label><br>';
        echo '<select class="input"  name="part">';
        echo '<option value="mainColor">Main Color</option>';
        echo '<option value="eyeColor">Eye Color</option>';
        echo '<option value="hairColor">Hair Color</option>';
        echo '<option value="tailColor">Tail Color</option>';
        echo '<option value="skinColor">Skin Color</option>';
        echo '</select><br>';

        echo '<input type="hidden" name="item" value="' . $item['id'] . '">';
        
           
        echo '<button class="fancyButton">Apply Stain</button>';
        echo '</form>';
    }
    
    if ($item['name'] === "FarmChest" || $item['name'] === "BeachChest" || $item['name'] === "WoodsChest") {
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
    
    if ($item['name'] === "WishToken") {
        echo '<hr>';
        echo '<label for="wish"  class="form"><b>Choose A Wish:</b></label><br>';
        echo '<select  class="input" name="wish" id="wish"><br>';
        echo '<option value="" disabled="disabled"  selected="selected"></option>';
        echo '<option value="item">Free Item</option>';
        echo '<option value="color">Change Color</option>';
        echo '<option value="marking">Add Marking</option>';
        echo '</select><br>';
        
        //Add an Item Form
        $query = "SELECT * FROM itemList ORDER BY name";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo '<div style="display:none;justify-content:center;flex-direction:column;" id="item">';
        echo '<hr>';
        echo '<h1>Free Item</h1>';
        echo '<form method="post" action="includes/wishItem.inc.php">';
        echo '<select  class="input" name="itemid" id="itemid" required><br>';
        echo '<option value="" disabled="disabled"  selected="selected"></option>';
        foreach ($items as $item) {
            echo '<option value="' . $item['id'] . '">' . $item['display'] . '</option>';
        }
        echo '</select>';
        echo '<div><button class="fancyButton">Wish For Item</button></div>';
        echo '</form>';
        echo '</div>';
        
        //Change Color Form
        $query = 'SELECT * FROM colors ORDER BY name';
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $colors = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo '<div style="display:none;justify-content:center;flex-direction:column;" id="colorPet">';
        echo '<hr>';
        echo '<h1>Change Color</h1>';
        echo '<form method="post" action="includes/changeColor.inc.php">';
        echo '<label for="snoozelingid"  class="form">Choose A Pet:</label><br>';
        echo '<select  class="input" name="snoozelingid" id="snoozelingid" required><br>';
        echo '<option value="" disabled="disabled"  selected="selected"></option>';
        foreach ($snoozelings as $pet) {
            echo '<option value="' . $pet['id'] . '">' . htmlspecialchars($pet['name']) . '</option>';
        }
        echo '</select><br>';
        echo '<label for="pet"  class="form">Choose A Color:</label><br>';
        echo '<select  class="input" name="colorid" id="colorid" required><br>';
        echo '<option value="" disabled="disabled"  selected="selected"></option>';
        foreach ($colors as $color) {
            echo '<option value="' . $color['name'] . '">' . $color['display'] . '</option>';
        }
        echo '</select><br>';
        echo '<label for="pet"  class="form">Choose A Body Part:</label><br>';
        echo '<select  class="input" name="bodypart" id="bodypart" required><br>';
        echo '<option value="" disabled="disabled"  selected="selected"></option>';
        echo '<option value="Main">Main Color</option>';
        echo '<option value="Skin">Skin Color</option>';
        echo '<option value="Eye">Eye Color</option>';
        echo '<option value="Hair">Hair Color</option>';
        echo '<option value="Tail">Tail Color</option>';
        echo '</select><br>';
        echo '<div><button class="fancyButton">Wish For Color</button></div>';
        echo '</form>';
        echo '</div>';
        
        //Add Marking Form
        echo '<div style="display:none;justify-content:center;flex-direction:column;" id="marking">';
        echo '<hr>';
        echo '<h1>Add Marking</h1>';
        echo '<form method="post" action="includes/addMarking.inc.php">';
        echo '<label for="pet"  class="form">Choose A Pet:</label><br>';
        echo '<select  class="input" name="m" id="snoozelingid" required><br>';
        echo '<option value="" disabled="disabled"  selected="selected"></option>';
        foreach ($snoozelings as $pet) {
            echo '<option value="' . $pet['id'] . '">' . htmlspecialchars($pet['name']) . '</option>';
        }
        echo '</select><br>';
        echo '<label for="marking"  class="form">Choose A Marking:</label><br>';
        echo '<select  class="input" name="marking" id="marking" required><br>';
        echo '<option value="" disabled="disabled"  selected="selected"></option>';
        echo '<option value="Belly">Belly</option>';
        echo '<option value="Boots">Boots</option>';
        echo '<option value="Cupid">Cupid</option>';
        echo '<option value="EarTip">Ear Tip</option>';
        echo '<option value="Spots">Spots</option>';
        echo '<option value="Sublimation">Sublimation</option>';
        echo '</select><br>';
        echo '<div><button class="fancyButton">Wish For Marking</button></div>';
        echo '</form>';
        echo '</div>';
    } else if ($item['type'] == "cover") {
        echo '<form method="post" action="includes/useCover.inc.php">';
        echo '<input type="hidden" name="item" value="' . $id . '">';
        echo '<button class="fancyButton">Add Bed Cover</button>';
        echo '</form>';
    }


    if ($item['type'] === 'clothesBottom' || $item['type'] === 'clothesTop' || $item['type'] === 'clothesHoodie' || $item['type'] === 'clothesBoth') {
        echo '<form method="post" action="includes/wearClothes.inc.php">';
        echo '<input type="hidden" name="item" value="' . $id . '">';
        echo '<label for="pet"  class="form">Choose A Pet:</label><br>';
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
    
    if ($item['name'] === "Bleach") {
        $query = 'SELECT * FROM items WHERE user_id = :id AND dye IS NOT NULL';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $query = 'SELECT * FROM dyes';
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $dyes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo '<form method="post" action="includes/useBleach.inc.php">';
        echo '<label for="item"  class="form">Choose An Item:</label><br>';
        echo '<select  class="input" name="item" id="item"><br>';
        foreach ($items as $item) {
            if (!str_contains($item['name'], "Bandana")) {
                foreach ($dyes as $dye) {
                    if ($item['dye'] == $dye['name']) {
                        $dyeName = $dye['display'];
                        break;
                    }
                }
                echo '<option value="' . $item['id'] . '">' . $item['display'] . ' [' . $dyeName . ']' . '</option>';
            }
            
        }
        echo '</select>';
        echo '<div><button class="fancyButton">Wear Item</button></div>';
        echo '</form>';
    }
}

echo '</div>';



















