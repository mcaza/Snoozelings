<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //Get Values
    $userId = $_SESSION['user_id'];
    $first = $_POST['first'];
    $second = $_POST['second'];
    $blueprints = $_POST['blueprints'];
    if ($second === "other") {
        $breedid = $_POST['id'];
    }
    
    if ($breedid) {
        if ($breedid === $first) {
            $_SESSION['reply'] = 'You need to use 2 different snoozelings as inspiration.';
            header("Location: ../stitcher?page=new");
        }
    } if ($second === $first) {
        $_SESSION['reply'] = 'You need to use 2 different snoozelings as inspiration.';
            header("Location: ../stitcher?page=new");
    }
    
    //Check if person has max snoozelings
    $query = 'SELECT * FROM snoozelings WHERE owner_id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $snoozelings = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count = count($snoozelings);
    
    if ($count > 9) {
        $_SESSION['reply'] = 'You currently have the max number of snoozelings.';
        header("Location: ../stitcher?page=new");
    }
    
    //If using an ID, check permissions
    if ($breedid) {
    $query = 'SELECT breedStatus FROM snoozelings WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $breedid);
    $stmt->execute();
    $status = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($status['breedStatus'] === 'Closed') {
            $_SESSION['reply'] = 'This snoozeling is not allowed to be used for inspiration.';
            header("Location: ../stitcher?page=new");
        }
    }
    
    //Check for Blueprints
    $bpid = 21;
    $query = 'SELECT * FROM items WHERE list_id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $bpid);
    $stmt->execute();
    $bps = $stmt->fetch(PDO::FETCH_ASSOC);
    $bpcount = count($bps);
    if ($bpcount < $blueprints) {
        $_SESSION['reply'] = 'You have used more blueprints than is in your inventory.';
        header("Location: ../stitcher?page=new");
    }
    
    //Check for bed
    $bed = 27;
    $query = "SELECT * FROM items WHERE list_id = :id LIMIT 1";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $bed);
    $stmt->execute();
    $bed = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$bed) {
        $_SESSION['reply'] = 'You need a Pet Bed for the new snoozeling to sleep in.';
            header("Location: ../stitcher?page=new");
    }   
    
    //Create a Breeding ID
    $query = "INSERT INTO breedings (user_id, one, two, blueprints) VALUES (:user, :one, :two, :blueprints)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user", $userId);
    $stmt->bindParam(":one", $first);
    $stmt->bindParam(":two", $second);
    $stmt->bindParam(":blueprints", $blueprints);
    $stmt->execute();
    
    //Fetch Breeding ID
    $query = "SELECT id FROM breedings WHERE user_id = :id ORDER BY id DESC LIMIT 1";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $breedid = $stmt->fetch(PDO::FETCH_ASSOC);
    $breedingId = $breedid['id'];
    
    //Cycle Through Amount of Blueprints. Create a blueprint for each
    for ($i = 0; $i < $blueprints; $i++) {
        breed($pdo, $first, $second, $userId, $breedingId);
    }
    
    
    //Remove Items (Sewing Kit, Blueprints, Bed)
    $itemArray = [27, 20];
    for ($i = 0; $i < $blueprints; $i++) {
        array_push($itemArray, 21);
    }
    foreach ($itemArray as $item) {
        $query = 'DELETE FROM items WHERE list_id = :id LIMIT 1';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $item);
        $stmt->execute(); 
    }
    
    //Send Letter
    //Grab Snoozeling Names
    $query = 'SELECT * FROM snoozelings WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $first);
    $stmt->execute();
    $nameone = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $query = 'SELECT * FROM snoozelings WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $second);
    $stmt->execute();
    $nametwo = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $title = "Your Blueprints are Ready!!!";
    $fabricnum = rand(600,1000);
    $s = "";
    if ($blueprints > 1) {
        $s = "s";
    }
    $message = "What a perfect balance of both the snoozelings you chose!!!
    
    I used a little bit of " . htmlspecialchars($nameone['name']). " and a little bit of " . htmlspecialchars($nametwo['name']) . '. You picked really good snoozelings for inspiration.
    
    I\'ve made a lot of snoozelings over the years but these two feel special. Like they were meant to be loved by you. It warms my heart to see them again.
    
    Now, I only have enough fabric to make one blueprint so choose wisely. The remaining blueprints will be discarded. My studio is already jam packed with the ' . $fabricnum . ' fabrics I\'ve collected over the last few years so I can\'t store these for you.
    
    <i>(Yes. I have a problem. No. I will not get rid of any fabrics. I need them ALL.)</i>
    
    Click on the link below to choose your next snoozeling.
    
    <strong style="font-size: 2.5rem"><a href="blueprints?id=' . $breedingId . '">Click Here to View Your Blueprint' . $s . '</a></strong>';
    $from = 6;
    $zero = 0;
    $picture = "sewingNPC";
    $now = new DateTime();
    $date = $now->format('Y-m-d H:i:s');
    $query = 'INSERT INTO mail (sender, reciever, title, message, sent, opened, sendtime, picture) VALUES (:sender, :reciever, :title, :message, :sent, :opened, :sendtime, :picture)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":sender", $from);
    $stmt->bindParam(":reciever", $userId);
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":message", $message);
    $stmt->bindParam(":sent", $zero);
    $stmt->bindParam(":opened", $zero);
    $stmt->bindParam(":sendtime", $date);
    $stmt->bindParam(":picture", $picture);
    $stmt->execute();
    
    //Return Message
    $_SESSION['reply'] = 'That should be everything. I\'ll send you a letter when your blueprints are finished.';
    header("Location: ../stitcher?page=new");
    
    
} else {
header("Location: ../index");
    die();
}




function breed($pdo, $first, $second, $user, $breeding) {
    //Get Info from parent One
    $query = 'SELECT * FROM snoozelings WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $first);
    $stmt->execute();
    $one = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Get Info From Parent Two
    if ($breedid) {
    $query = 'SELECT * FROM snoozelings WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $first);
    $stmt->execute();
    $two = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $query = 'SELECT * FROM snoozelings WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $second);
        $stmt->execute();
        $two = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    //Calculate Main Color
    $query = 'SELECT * FROM colors WHERE name = :name';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $one['mainColor']);
    $stmt->execute();
    $cats1 = $stmt->fetch(PDO::FETCH_ASSOC);
    $mainone = explode(" ", $cats1['categories']);
    
    $query = 'SELECT * FROM colors WHERE name = :name';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $two['mainColor']);
    $stmt->execute();
    $cats2 = $stmt->fetch(PDO::FETCH_ASSOC);
    $maintwo = explode(" ", $cats2['categories']);
    $mainColors = array_merge($mainone, $maintwo);
    
    //Check For Mix Colors
    if (in_array("Red", $mainColors) && in_array("Yellow", $mainColors)) {
        array_push($mainColors, "Orange");
    }
    if (in_array("Red", $mainColors) && in_array("White", $mainColors)) {
        array_push($mainColors, "Pink");
    }
    if (in_array("Red", $mainColors) && in_array("Blue", $mainColors)) {
        array_push($mainColors, "Purple");
    }
    if (in_array("Blue", $mainColors) && in_array("Yellow", $mainColors)) {
        array_push($mainColors, "Green");
    }
    if (in_array("Green", $mainColors)) {
        array_push($mainColors, "Yellow");
        array_push($mainColors, "Blue");
    }
    if (in_array("Orange", $mainColors)) {
        array_push($mainColors, "Yellow");
        array_push($mainColors, "Red");
    }
    if (in_array("Pink", $mainColors)) {
        array_push($mainColors, "White");
        array_push($mainColors, "Red");
    }
    if (in_array("Purple", $mainColors)) {
        array_push($mainColors, "Red");
        array_push($mainColors, "Blue");
    }
    
    //Remove Duplicates
    $mainColors = array_unique($mainColors);
    $mainColors = array_values($mainColors);
    
    //Grab Sub Colors
    $subcolors = [];
    foreach ($mainColors as $color) {
        $query = "SELECT * FROM colors WHERE categories LIKE CONCAT('%', :colorSearch, '%')";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":colorSearch", $color);
        $stmt->execute();
        $subs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($subs as $sub) {
            if ($sub['rarity'] === "Rare") {
                
            } else {
                array_push($subcolors, $sub['name']);
            }
        }
    }
    $subcolors = array_unique($subcolors);
    $subcolors = array_values($subcolors);
    
    //Check For Rare Colors
    $rare = [];
    if ($cats1['rarity'] === 'Rare') {
        array_push($rare, $cats1['name']);
    }
    if ($cats2['rarity'] === 'Rare') {
        array_push($rare, $cats2['name']);
    }
    if ((in_array("Black", $mainone) && in_array("Eyeburner", $maintwo)) || (in_array("Black", $maintwo) && in_array("Eyeburner", $mainone))) {
        array_push($rare, "Retro");
    }
    if ((in_array("Black", $mainone) && in_array("Red", $maintwo)) || (in_array("White", $mainone) && in_array("Red", $maintwo)) || (in_array("Black", $maintwo) && in_array("Red", $mainone)) || (in_array("White", $maintwo) && in_array("Red", $mainone))) {
        array_push($rare, "RedPanda");
    }
    if ((in_array("Black", $mainone) && in_array("Yellow", $maintwo)) || (in_array("Yellow", $mainone) && in_array("Brown", $maintwo)) || (in_array("Black", $maintwo) && in_array("Yellow", $mainone)) || (in_array("Yellow", $maintwo) && in_array("Brown", $mainone))) {
        array_push($rare, "Bee");
    }
    if ((in_array("Black", $mainone) && in_array("Grey", $maintwo)) || (in_array("Grey", $mainone) && in_array("White", $maintwo)) || (in_array("Black", $maintwo) && in_array("Grey", $mainone)) || (in_array("Grey", $maintwo) && in_array("White", $mainone))) {
        array_push($rare, "Raccoon");
    }
    if ((in_array("Green", $mainone) && in_array("Brown", $maintwo)) || (in_array("Green", $maintwo) && in_array("Brown", $mainone))) {
        array_push($rare, "Sloth");
    }
    if ((in_array("Black", $mainone) && in_array("Pink", $maintwo)) || (in_array("White", $mainone) && in_array("Pink", $maintwo)) || (in_array("Black", $maintwo) && in_array("Pink", $mainone)) || (in_array("White", $maintwo) && in_array("Pink", $mainone))) {
        array_push($rare, "ColliePink");
    }
    if ((in_array("Black", $mainone) && in_array("Blue", $maintwo)) || (in_array("White", $mainone) && in_array("Blue", $maintwo)) || (in_array("Black", $maintwo) && in_array("Blue", $mainone)) || (in_array("White", $maintwo) && in_array("Blue", $mainone))) {
        array_push($rare, "CollieBlue");
    }
    if ($one['mainColor'] === "Oatmeal" || $two['mainColor'] === "Oatmeal") {
        if (in_array("Red", $mainone) || in_array("Green", $mainone) || in_array("Blue", $mainone) || in_array("Red", $maintwo) || in_array("Green", $maintwo) || in_array("Blue", $maintwo)) {
            array_push($rare, "DinoOatmeal");
        }
    }
    if ($one['mainColor'] === "Banana" || $two['mainColor'] === "Banana") {
        if (in_array("Brown", $mainone) || in_array("Brown", $maintwo)) {
            array_push($rare, "BananaPeel");
        }
    }
    if ((in_array("Eyeburner", $mainone) && in_array("White", $maintwo)) || (in_array("Eyeburner", $maintwo) && in_array("White", $maintwo))) {
        array_push($rare, "Paint");
    }
    if ((in_array("Pastel", $mainone) && in_array("Black", $maintwo)) || (in_array("Pastel", $maintwo) && in_array("Black", $maintwo))) {
        array_push($rare, "Chalkboard");
    }
    
    $rare = array_unique($rare);
    $rare = array_values($rare);
    //Calculate if Rare
    if ($rare) {
        $num = rand(0, 100);
        if ($num < 50) {
            $count = count($rare) -1;
            $num = rand(0, $count);
            $mainColor = $rare[$num];
        } else {
            $count = count($subcolors) -1;
            $num = rand(0, $count);
            $mainColor = $subcolors[$num];
        }
    } else {
        $count = count($subcolors) -1;
            $num = rand(0, $count);
            $mainColor = $subcolors[$num];
    }
    
    //Eye Color
    if (in_array($mainColor, $rare)) {
        $num = rand(0, 100);
        if ($num < 50) {
            $eyeColor = $mainColor;
        } else {
            //Calculate Eye Color
    $query = 'SELECT * FROM colors WHERE name = :name';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $one['eyeColor']);
    $stmt->execute();
    $cats1 = $stmt->fetch(PDO::FETCH_ASSOC);
    $mainone = explode(" ", $cats1['categories']);
    
    $query = 'SELECT * FROM colors WHERE name = :name';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $two['eyeColor']);
    $stmt->execute();
    $cats2 = $stmt->fetch(PDO::FETCH_ASSOC);
    $maintwo = explode(" ", $cats2['categories']);
    $mainColors = array_merge($mainone, $maintwo);
    
    //Check For Mix Colors
    if (in_array("Red", $mainColors) && in_array("Yellow", $mainColors)) {
        array_push($mainColors, "Orange");
    }
    if (in_array("Red", $mainColors) && in_array("White", $mainColors)) {
        array_push($mainColors, "Pink");
    }
    if (in_array("Red", $mainColors) && in_array("Blue", $mainColors)) {
        array_push($mainColors, "Purple");
    }
    if (in_array("Blue", $mainColors) && in_array("Yellow", $mainColors)) {
        array_push($mainColors, "Green");
    }
    if (in_array("Green", $mainColors)) {
        array_push($mainColors, "Yellow");
        array_push($mainColors, "Blue");
    }
    if (in_array("Orange", $mainColors)) {
        array_push($mainColors, "Yellow");
        array_push($mainColors, "Red");
    }
    if (in_array("Pink", $mainColors)) {
        array_push($mainColors, "White");
        array_push($mainColors, "Red");
    }
    if (in_array("Purple", $mainColors)) {
        array_push($mainColors, "Red");
        array_push($mainColors, "Blue");
    }
    
    //Remove Duplicates
    $mainColors = array_unique($mainColors);
    $mainColors = array_values($mainColors);
    
    //Grab Sub Colors
    $subcolors = [];
    foreach ($mainColors as $color) {
        $query = "SELECT * FROM colors WHERE categories LIKE CONCAT('%', :colorSearch, '%')";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":colorSearch", $color);
        $stmt->execute();
        $subs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($subs as $sub) {
            if ($sub['rarity'] === "Rare") {
                
            } else {
                array_push($subcolors, $sub['name']);
            }
        }
    }
    $subcolors = array_unique($subcolors);
    $eyecolors = array_values($subcolors);
            
            $count = count($eyecolors)-1;
            $num = rand(0, $count);
            $eyeColor = $eyecolors[$num];
        } 
    } else {
        //Calculate Eye Color
    $query = 'SELECT * FROM colors WHERE name = :name';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $one['eyeColor']);
    $stmt->execute();
    $cats1 = $stmt->fetch(PDO::FETCH_ASSOC);
    $mainone = explode(" ", $cats1['categories']);
    
    $query = 'SELECT * FROM colors WHERE name = :name';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $two['eyeColor']);
    $stmt->execute();
    $cats2 = $stmt->fetch(PDO::FETCH_ASSOC);
    $maintwo = explode(" ", $cats2['categories']);
    $mainColors = array_merge($mainone, $maintwo);
    
    //Check For Mix Colors
    if (in_array("Red", $mainColors) && in_array("Yellow", $mainColors)) {
        array_push($mainColors, "Orange");
    }
    if (in_array("Red", $mainColors) && in_array("White", $mainColors)) {
        array_push($mainColors, "Pink");
    }
    if (in_array("Red", $mainColors) && in_array("Blue", $mainColors)) {
        array_push($mainColors, "Purple");
    }
    if (in_array("Blue", $mainColors) && in_array("Yellow", $mainColors)) {
        array_push($mainColors, "Green");
    }
    if (in_array("Green", $mainColors)) {
        array_push($mainColors, "Yellow");
        array_push($mainColors, "Blue");
    }
    if (in_array("Orange", $mainColors)) {
        array_push($mainColors, "Yellow");
        array_push($mainColors, "Red");
    }
    if (in_array("Pink", $mainColors)) {
        array_push($mainColors, "White");
        array_push($mainColors, "Red");
    }
    if (in_array("Purple", $mainColors)) {
        array_push($mainColors, "Red");
        array_push($mainColors, "Blue");
    }
    
    //Remove Duplicates
    $mainColors = array_unique($mainColors);
    $mainColors = array_values($mainColors);
    
    //Grab Sub Colors
    $subcolors = [];
    foreach ($mainColors as $color) {
        $query = "SELECT * FROM colors WHERE categories LIKE CONCAT('%', :colorSearch, '%')";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":colorSearch", $color);
        $stmt->execute();
        $subs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($subs as $sub) {
            if ($sub['rarity'] === "Rare") {
                
            } else {
                array_push($subcolors, $sub['name']);
            }
        }
    }
    $subcolors = array_unique($subcolors);
    $eyecolors = array_values($subcolors);
            
            $count = count($eyecolors)-1;
            $num = rand(0, $count);
            $eyeColor = $eyecolors[$num];
    }
    
    //Nose/Ear Color Selection
    $fabrics = [];
    $fabricnames = [];
    $query = 'SELECT name FROM colors';
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $colors = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($colors as $color) {
        array_push($fabricnames, $color['name']);
    }
    
    if (!in_array($one['noseColor'], $fabricnames)) {
        array_push($fabrics, $one['noseColor']);
    }
    
    if (!in_array($two['noseColor'], $fabricnames)) {
        array_push($fabrics, $two['noseColor']);
    }
    if (count($fabrics) > 0) {
        if (in_array($mainColor, $rare)) {
            $num = rand(0, 100);
            if ($num < 50) {
                $count = count($fabrics) - 1;
                $num = rand(0, $count);
                $noseColor = $fabrics[$num];
            } else {
                $noseColor = $mainColor;
            }
        } else {
        $count = count($fabrics) -1;
        $num = rand(0, $count);
        $noseColor = $fabrics[$num];
        }    
    } elseif (in_array($mainColor, $rare)) {
        $num = rand(0, 100);
            if ($num < 50) {
                $noseColor = $mainColor;
            } else {
                        $query = 'SELECT * FROM colors WHERE name = :name';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $one['noseColor']);
    $stmt->execute();
    $cats1 = $stmt->fetch(PDO::FETCH_ASSOC);
    $mainone = explode(" ", $cats1['categories']);
    
    $query = 'SELECT * FROM colors WHERE name = :name';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $two['noseColor']);
    $stmt->execute();
    $cats2 = $stmt->fetch(PDO::FETCH_ASSOC);
    $maintwo = explode(" ", $cats2['categories']);
    $mainColors = array_merge($mainone, $maintwo);
        $mainColors = array_unique($mainColors);
    $mainColors = array_values($mainColors);
        
        $count = count($mainColors) - 1;
        $num = rand(0, $count);
        $noseColor = $mainColors[$num];
            }
} else {
        $query = 'SELECT * FROM colors WHERE name = :name';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $one['noseColor']);
    $stmt->execute();
    $cats1 = $stmt->fetch(PDO::FETCH_ASSOC);
    $mainone = explode(" ", $cats1['categories']);
    
    $query = 'SELECT * FROM colors WHERE name = :name';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $two['noseColor']);
    $stmt->execute();
    $cats2 = $stmt->fetch(PDO::FETCH_ASSOC);
    $maintwo = explode(" ", $cats2['categories']);
    $mainColors = array_merge($mainone, $maintwo);
        $mainColors = array_unique($mainColors);
    $mainColors = array_values($mainColors);
        $count = count($mainColors)-1;
        $num = rand(0, $count);
        $noseColor = $mainColors[$num];
    }
    
    //Calculate Hair Color
        if (in_array($mainColor, $rare)) {
        $num = rand(0, 100);
        if ($num < 50) {
            $hairColor = $mainColor;
        } else {
                    $query = 'SELECT * FROM colors WHERE name = :name';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $one['hairColor']);
    $stmt->execute();
    $cats1 = $stmt->fetch(PDO::FETCH_ASSOC);
    $mainone = explode(" ", $cats1['categories']);
    
    $query = 'SELECT * FROM colors WHERE name = :name';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $two['hairColor']);
    $stmt->execute();
    $cats2 = $stmt->fetch(PDO::FETCH_ASSOC);
    $maintwo = explode(" ", $cats2['categories']);
    $mainColors = array_merge($mainone, $maintwo);
        $mainColors = array_unique($mainColors);
    $mainColors = array_values($mainColors);
            
            //Grab Sub Colors
    $subcolors = [];
    foreach ($mainColors as $color) {
        $query = "SELECT * FROM colors WHERE categories LIKE CONCAT('%', :colorSearch, '%')";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":colorSearch", $color);
        $stmt->execute();
        $subs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($subs as $sub) {
            if ($sub['rarity'] === "Rare") {
                
            } else {
                array_push($subcolors, $sub['name']);
            }
        }
    }
    $subcolors = array_unique($subcolors);
    $haircolors = array_values($subcolors);
            
            
        
        $count = count($subcolors)-1;
        $num = rand(0, $count);
        $hairColor = $haircolors[$num];
        }
    } else {
                                $query = 'SELECT * FROM colors WHERE name = :name';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $one['hairColor']);
    $stmt->execute();
    $cats1 = $stmt->fetch(PDO::FETCH_ASSOC);
    $mainone = explode(" ", $cats1['categories']);
    
    $query = 'SELECT * FROM colors WHERE name = :name';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $two['hairColor']);
    $stmt->execute();
    $cats2 = $stmt->fetch(PDO::FETCH_ASSOC);
    $maintwo = explode(" ", $cats2['categories']);
    $mainColors = array_merge($mainone, $maintwo);
        $mainColors = array_unique($mainColors);
    $mainColors = array_values($mainColors);
            
                       //Grab Sub Colors
    $subcolors = [];
    foreach ($mainColors as $color) {
        $query = "SELECT * FROM colors WHERE categories LIKE CONCAT('%', :colorSearch, '%')";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":colorSearch", $color);
        $stmt->execute();
        $subs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($subs as $sub) {
            if ($sub['rarity'] === "Rare") {
                
            } else {
                array_push($subcolors, $sub['name']);
            }
        }
    }
    $subcolors = array_unique($subcolors);
    $haircolors = array_values($subcolors);
        
        $count = count($subcolors)-1;
        $num = rand(0, $count);
        $hairColor = $haircolors[$num];
        }
    

    
    //Calculate Tail Color
    if (in_array($mainColor, $rare)) {
        $num = rand(0, 100);
        if ($num < 50) {
            $tailColor = $mainColor;
        } else {
            $num = rand(0, 100);
            if ($num < 50) {
                $tailColor = $hairColor;
            } else {
                                    $query = 'SELECT * FROM colors WHERE name = :name';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $one['tailColor']);
    $stmt->execute();
    $cats1 = $stmt->fetch(PDO::FETCH_ASSOC);
    $mainone = explode(" ", $cats1['categories']);
    
    $query = 'SELECT * FROM colors WHERE name = :name';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $two['tailColor']);
    $stmt->execute();
    $cats2 = $stmt->fetch(PDO::FETCH_ASSOC);
    $maintwo = explode(" ", $cats2['categories']);
    $mainColors = array_merge($mainone, $maintwo);
        $mainColors = array_unique($mainColors);
    $mainColors = array_values($mainColors);
                
                //Grab Sub Colors
    $subcolors = [];
    foreach ($mainColors as $color) {
        $query = "SELECT * FROM colors WHERE categories LIKE CONCAT('%', :colorSearch, '%')";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":colorSearch", $color);
        $stmt->execute();
        $subs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($subs as $sub) {
            if ($sub['rarity'] === "Rare") {
                
            } else {
                array_push($subcolors, $sub['name']);
            }
        }
    }
    $subcolors = array_unique($subcolors);
    $tailcolors = array_values($subcolors);
        
        $count = count($subcolors)-1;
        $num = rand(0, $count);
        $tailColor = $tailcolors[$num];
            }
        }
    } else {
        $query = 'SELECT * FROM colors WHERE name = :name';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $one['tailColor']);
    $stmt->execute();
    $cats1 = $stmt->fetch(PDO::FETCH_ASSOC);
    $mainone = explode(" ", $cats1['categories']);
    
    $query = 'SELECT * FROM colors WHERE name = :name';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $two['tailColor']);
    $stmt->execute();
    $cats2 = $stmt->fetch(PDO::FETCH_ASSOC);
    $maintwo = explode(" ", $cats2['categories']);
    $mainColors = array_merge($mainone, $maintwo);
        $mainColors = array_unique($mainColors);
    $mainColors = array_values($mainColors);
        
        //Grab Sub Colors
    $subcolors = [];
    foreach ($mainColors as $color) {
        $query = "SELECT * FROM colors WHERE categories LIKE CONCAT('%', :colorSearch, '%')";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":colorSearch", $color);
        $stmt->execute();
        $subs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($subs as $sub) {
            if ($sub['rarity'] === "Rare") {
                
            } else {
                array_push($subcolors, $sub['name']);
            }
        }
    }
    $subcolors = array_unique($subcolors);
    $tailcolors = array_values($subcolors);
        
        $count = count($subcolors)-1;
        $num = rand(0, $count);
        $tailColor = $tailcolors[$num];
    }
    
    $hairTypes = [];
    $tailTypes = [];
    
    array_push($hairTypes, $one['hairType']);
    array_push($hairTypes, $two['hairType']);
    $num = rand(0, 1);
    $hairType = $hairTypes[$num];
    
    array_push($tailTypes, $one['tailType']);
    array_push($tailTypes, $two['tailType']);
    $num = rand(0, 1);
    $tailType = $tailTypes[$num];
    
    $specialsone = explode(" ", $one['specials']);
    $specialstwo = explode(" ", $two['specials']);
    
    $specials = array_merge($specialsone, $specialstwo);
    $specials = array_unique($specials);
    $specials = array_values($specials);
    
    $newspec = "";
    foreach ($specials as $special) {
        $num = rand(0, 1);
        if ($num === 0) {
            $newspec .= $special . " ";
        }
    }
    $newspec = trim($newspec);
    
    
    //Add to Blueprint
    $query = 'INSERT INTO blueprints (owner_id, breeding_id, mainColor, hairColor, tailColor, eyeColor, noseColor, hairType, tailType, specials) VALUES (:owner, :breeding, :mainColor, :hairColor, :tailColor, :eyeColor, :noseColor, :hairType, :tailType, :specials)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":owner", $user);
    $stmt->bindParam(":breeding", $breeding);
    $stmt->bindParam(":mainColor", $mainColor);
    $stmt->bindParam(":hairColor", $hairColor);
    $stmt->bindParam(":tailColor", $tailColor);
    $stmt->bindParam(":eyeColor", $eyeColor);
    $stmt->bindParam(":noseColor", $noseColor);
    $stmt->bindParam(":hairType", $hairType);
    $stmt->bindParam(":tailType", $tailType);
    $stmt->bindParam(":specials", $newspec);
    $stmt->execute();
    
}













