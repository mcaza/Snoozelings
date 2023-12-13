<?php

$userId = $_SESSION['user_id'];
if ($_SESSION['reply']) {
    $reply = $_SESSION['reply'];
    unset($_SESSION['reply']);
}

//Get Type
if ($_GET['type']) {
    $type = $_GET['type'];
    $_SESSION['type'] = $type;
} elseif ($_SESSION['type']) {
    $type = $_SESSION['type'];
}

//Get Pet 
$query = 'SELECT * FROM craftingtables WHERE user_id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$query = 'SELECT * FROM snoozelings WHERE id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $result['pet_id']);
$stmt->execute();
$pet = $stmt->fetch(PDO::FETCH_ASSOC);

//Double Check Job
if ($pet['job'] === 'jack' && $type) {
    if ($type === "dye" || $type === "staining") {
        $type = "ingredient";
    }
}

//Date
$now = new DateTime(null, new DateTimezone('UTC'));
$future_date = new DateTime($result['finishtime']);
$interval = $future_date->diff($now);

//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="profile?id=' . $userId . '"><<</a>';
echo '</div>';

//Notification
if ($reply) {
    echo '<div class="returnBar" style="margin-top: 1rem;margin-bottom: 2rem;">';
    echo '<p>' . $reply . '</p>';
    echo '</div>';
}

//Desk and Snoozeling
echo '<div class="craftimages">';
echo '<img src="resources/deskFull.png" style="width:300px; height: auto;">';
displayPet($pet, "artcrafting");
echo '</div>';
echo '<hr>';

//Current Item Crafting
if (!($result['recipe_id'])) {
    echo '<p style="font-size: 2rem">Crafting Table Open</p>';
} else {
    
    
    if ($future_date <= $now) {
        echo '<p style="font-size: 2rem"><strong>Ready for Pickup: </strong>' . $result['display'] . '</p>';
        echo '<form method="POST" action="includes/getCraft.inc.php">';
        echo '<input type="hidden" name="id" value="' . $result['id'] . '">';
        echo '<button  class="fancyButton">Recieve Item</button>';
        echo '</form>';
    } else {
        echo '<p style="font-size: 2rem"><strong>Currently Crafting: </strong>' . $result['display'] . '</p>';
        echo '<img src="items/' . $result['name'] . '.png">';
        //echo '<p style="margin-top: 0;"><i>' . $interval->format("%a days, %h hours, %i minutes, %s seconds") . ' Remaining</i></p>';
        echo '<p style="margin-top: 0;"><i>' . $interval->format("%h hours, %i minutes, %s seconds") . ' Remaining</i></p>';
    }
}


echo '<hr>';

//Type Buttons
echo '<div class="craftbuttons">';
echo '<a href="crafting?type=ingredient" class="craftbutton">Ingredients</a>';
echo '<a href="crafting?type=clothes" class="craftbutton">Clothing</a>';
if ($pet['job'] === 'Crafter' && intval($pet['craftEXP']) > 50) {
    echo '<a href="crafting?type=dye" class="craftbutton">Dyes</a>';
    echo '<a href="crafting?type=dyedclothes" class="craftbutton">Staining</a>';
}
echo '<a href="crafting?type=special" class="craftbutton">Special</a>';
echo '</div>';

//Get Level
$exp = $pet['craftEXP'];
if ($exp < 50 || $pet['job'] === "jack") {
    $level = 1;
} elseif ($exp < 150) {
    $level = 2;
} elseif ($exp < 325) {
    $level = 3;
} elseif ($exp < 600) {
    $level = 4;
} elseif ($exp < 1000) {
    $level = 5;
} else {
    $level = 6;
}

//Show Recipes
$query = 'SELECT * FROM recipes WHERE type = :type AND level <= :level';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":level", $level);
$stmt->bindParam(":type", $type);
$stmt->execute();
$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo '<div class="recipebuttons" style="margin-top:2rem;">';
foreach ($recipes as $recipe) {
    //Get Items & Numbers
    $items = explode(" ", $recipe['items']);
    $numbers = explode(" ", $recipe['numbers']);
    
    //Box Img & Title
    if (!($result['recipe_id'])) {
        //Check Items
        $yes = 1;
        foreach ($items as $item) {
            $query = 'SELECT id FROM items WHERE name = :name AND user_id = :id';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":name", $item);
            $stmt->bindParam(":id", $userId);
            $stmt->execute();
            $inv = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $key = array_search($item, $items);
            $count = count($inv);
            if ($count >= intval($numbers[$key])) {
                
            } else {
                $yes = 0;
            }
        }
        if ($yes === 1) {
            echo '<a href="includes/startrecipe.inc.php?id=' . $recipe['id'] . '" class="recipe have">';
        } else {
            echo '<a href="includes/startrecipe.inc.php?id=' . $recipe['id'] . '" class="recipe">';
        }
        
    } else {
        echo '<div class="recipe">';
    }
        echo '<div class="recipeimg">';
        echo '<img src="items/' . $recipe['name'] . '.png" style="height:100px">';
        echo '</div>';
        echo '<div class="recipetext">';
        echo '<p style="font-size:1.9rem;margin-bottom:.5rem;"><b>' . $recipe['display'] . '</b></p>';
    
        //Display Items Needed
       foreach ($items as $item) {
            $query = 'SELECT display FROM itemList WHERE name = :name';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":name", $item);
            $stmt->execute();
            $itemname = $stmt->fetch(PDO::FETCH_ASSOC);
            $key = array_search($item, $items);
            echo '<p style="margin-top:0;margin-bottom:.4rem;">' . $numbers[$key] . ' x ' . $itemname['display'] . '</p>';
        }
        echo '</div>';
    if (!($result['recipe_id'])) {   
        echo '</a>';
    } else {
        echo '</div>';
    }
}
echo '</div>';



//Change Crafter
if (!($result['recipe_id'])) {   
    echo '<br><hr>';
$crafter = "Crafter";
$jack = "jack";
$query = "SELECT * FROM snoozelings WHERE (job = :jack OR job = :crafter) && owner_id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":jack", $jack);
$stmt->bindParam(":crafter", $crafter);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo '<div><h3 style="margin-bottom: 1rem;">Change Crafter</div>';
echo '<form method="POST" action="includes/changeCrafter.inc.php">';
echo '<label for="status"  class="form">Main Crafter:</label><br>';
echo '<select  class="input" name="snoozeling" id="snoozeling"><br>';
foreach ($results as $snooze) {
    echo '<option value="' . $snooze['id'] . '">#' . $snooze['id'] . ' - ' . htmlspecialchars($snooze['name']) . '</option>';
}
echo '</select><br>';
echo '<button  class="fancyButton">Change Pet</button>';
echo '</form>';
}

















