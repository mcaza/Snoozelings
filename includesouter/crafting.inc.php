<?php

date_default_timezone_set('UTC');


$userId = $_COOKIE['user_id'];

//Replies
$query = "SELECT * FROM replies WHERE user_id = :id;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$reply = $stmt->fetch(PDO::FETCH_ASSOC);

//Set Type
if ($_GET['type']) {
    $type = $_GET['type'];
    $query = 'UPDATE users SET lastCraft = :lastcraft WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":lastcraft", $type);
    $stmt->execute();
} else {
    //Get Last Type
    $query = 'SELECT lastCraft FROM users WHERE id = :id AND lastCraft IS NOT NULL';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $lastCraft = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($lastCraft) {
        $type = $lastCraft['lastCraft'];
    } else {
        $type = "ingredient";
    }
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

//Date
$now = new DateTime("now", new DateTimezone('UTC'));
$future_date = new DateTime($result['finishtime']);
$interval = $future_date->diff($now);

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
$query = 'SELECT * FROM recipes WHERE type = :type AND level <= :level ORDER BY level, id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":level", $level);
$stmt->bindParam(":type", $type);
$stmt->execute();
$allRecipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="profile?id=' . $userId . '"><<</a>';
if ($pet['job'] == "Crafter") {
    echo '<p><b>Crafting EXP:</b> Activated</p>';
} else {
    echo '<p><b>Crafting EXP:</b> Off</p>';
}

echo '</div>';



//Notification
if ($reply) {
    echo '<div class="returnBar" style="margin-top: 1rem;margin-bottom:2rem;">';
    echo '<p>' . $reply['message'] . '</p>';
    echo '</div>';
    $query = "DELETE FROM replies WHERE user_id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
}

//Desk and Snoozeling
echo '<div class="craftimages">';
echo '<div class="craftingDeskContainer">';
echo '<img src="resources/table1.png" class="craftingDesk">';
if ($level > 1) {
    echo '<img src="resources/table2.png" class="craftingDesk">';
}

if ($level > 2) {
    echo '<img src="resources/table3.png" class="craftingDesk">';
}

if ($level > 3) {
    echo '<img src="resources/table4.png" class="craftingDesk">';
}

if ($level > 4) {
    echo '<img src="resources/table5.png" class="craftingDesk">';
}

echo '</div>';
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
        echo '<img src="items/' . $result['name'] . '.png" style="width:125px;">';
        //echo '<p style="margin-top: 0;"><i>' . $interval->format("%a days, %h hours, %i minutes, %s seconds") . ' Remaining</i></p>';
        echo '<p style="margin-top: 0;"><i>' . $interval->format("%h hours, %i minutes, %s seconds") . ' Remaining</i></p>';
    }
}



echo '<hr>';

//Type Buttons
echo '<div class="craftbuttons">';
echo '<a href="crafting?type=ingredient" class="craftbutton">Ingredients</a>';
echo '<a href="crafting?type=clothes" class="craftbutton">Clothing</a>';
echo '<a href="crafting?type=dye" class="craftbutton">Dyes</a>';
echo '<a href="crafting?type=design" class="craftbutton">Designs</a>';
echo '<a href="crafting?type=special" class="craftbutton">Special</a>';
echo '</div>';



//Get Holiday Recipes if Any
$now = new DateTime('now', new DateTimezone('UTC'));
$month = $now->format('m');
$month = ltrim($month, '0');


echo '<div class="recipebuttons" style="margin-top:2rem;">';
foreach ($allRecipes as $recipe) {

    if ($month == $recipe['month']) {
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
        if ($yes == 1) {
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
            $query = 'SELECT * FROM itemList WHERE name = :name';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":name", $item);
            $stmt->execute();
            $itemname = $stmt->fetch(PDO::FETCH_ASSOC);
            $key = array_search($item, $items);
            echo '<p style="margin-top:0;margin-bottom:.4rem;" title="' . $itemname['tooltip'] . '">' . $numbers[$key] . ' x ' . $itemname['display'] . '</p>';
        }
        echo '</div>';
    if (!($result['recipe_id'])) {   
        echo '</a>';
    } else {
        echo '</div>';
    }
    }
}



/*
//Show Recipes
$query = 'SELECT * FROM recipes WHERE type = :type AND level <= :level AND month = 0 ORDER BY level, id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":level", $level);
$stmt->bindParam(":type", $type);
$stmt->execute();
$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
*/

$query = 'SELECT list_id, name FROM items WHERE user_id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$inv = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($allRecipes as $recipe) {
    if ($recipe['month'] == 0) {
        //Get Items & Numbers
        $items = explode(" ", $recipe['items']);
        $numbers = explode(" ", $recipe['numbers']);
        


        //Box Img & Title
        if (!($result['recipe_id'])) {
            //Check Items
            $yes = 1;
            
            foreach ($items as $item) {
                $count = 0;
                
                /*
                $query = 'SELECT id FROM items WHERE name = :name AND user_id = :id';
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":name", $item);
                $stmt->bindParam(":id", $userId);
                $stmt->execute();
                $inv = $stmt->fetchAll(PDO::FETCH_ASSOC);
                */
                
                foreach ($inv as $itemCheck) {
                    if ($itemCheck['name'] == $item) {
                        $count++;
                        
                    }
                }
                $key = array_search($item, $items);
                if ($count >= intval($numbers[$key])) {

                } else {
                    $yes = 0;
                }

            }
            if ($yes == 1) {
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
                $query = 'SELECT * FROM itemList WHERE name = :name';
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":name", $item);
                $stmt->execute();
                $itemname = $stmt->fetch(PDO::FETCH_ASSOC);
                $key = array_search($item, $items);
                echo '<p style="margin-top:0;margin-bottom:.4rem;" title="' . $itemname['tooltip'] . '">' . $numbers[$key] . ' x ' . $itemname['display'] . '</p>';
            }
            echo '</div>';
        if (!($result['recipe_id'])) {   
            echo '</a>';
        } else {
            echo '</div>';
        }
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

















