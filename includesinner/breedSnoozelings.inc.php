<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    //Get Values
    if ($_COOKIE['user_id']) {
        $userId = $_COOKIE['user_id'];
    } else {
        header("Location: ../login");
        die();
    }
    
    $first = $_POST['first'];
    $second = $_POST['second'];
    $blueprints = $_POST['blueprints'];
    if ($second === "other") {
        $breedid = $_POST['id'];
    } else {
        $breedid = false;
    }
    if ($breedid) {
        if ($breedid === $first) {
                $reply = "You need to use 2 different snoozelings as inspiration.";
                $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":user_id", $userId);
                $stmt->bindParam(":message", $reply);
                $stmt->execute();
            header("Location: ../stitcher?page=new");
            die();
        }
    } if ($second === $first) {
        $reply = "You need to use 2 different snoozelings as inspiration.";
                $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":user_id", $userId);
                $stmt->bindParam(":message", $reply);
                $stmt->execute();
        header("Location: ../stitcher?page=new");
        die();
    }
    
    //Check if breeding already
    $query = 'SELECT * FROM blueprints WHERE owner_id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $blueprintCheck = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($blueprintCheck) {
            $reply = "You have already have blueprints arriving soon in the mail.";
        $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":message", $reply);
        $stmt->execute();
        header("Location: ../stitcher?page=new");
        die();
    }
    
    //Check if person has open slot
    $query = 'SELECT * FROM snoozelings WHERE owner_id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $snoozelings = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count = count($snoozelings);
    
    $query = 'SELECT * FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $bedscheck = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (intval($bedscheck['petBeds']) <= $count) {
            $reply = "You do not have any empty pet beds.";
                $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":user_id", $userId);
                $stmt->bindParam(":message", $reply);
                $stmt->execute();
        header("Location: ../stitcher?page=new");
        die();
    }
    
    
    
    //If using an ID, check permissions
    if ($breedid) {
    $query = 'SELECT breedStatus FROM snoozelings WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $breedid);
    $stmt->execute();
    $status = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($status['breedStatus'] === 'Closed') {
                $reply = "This snoozeling is not allowed to be used for inspiration.";
                $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":user_id", $userId);
                $stmt->bindParam(":message", $reply);
                $stmt->execute();
            header("Location: ../stitcher?page=new");
            die();
        }
    }
    
    //Check for Blueprints
    $bpid = 137;
    $query = 'SELECT * FROM items WHERE list_id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $bpid);
    $stmt->execute();
    $bps = $stmt->fetch(PDO::FETCH_ASSOC);
    $bpcount = count($bps);
    if ($bpcount < $blueprints) {
            $reply = "You have used more blueprints than you have in your inventory.";
            $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":user_id", $userId);
            $stmt->bindParam(":message", $reply);
            $stmt->execute();
        header("Location: ../stitcher?page=new");
        die();
    }
    
    //Create a Breeding ID
    $query = "INSERT INTO breedings (user_id, one, two, blueprints) VALUES (:user, :one, :two, :blueprints)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user", $userId);
    $stmt->bindParam(":one", $first);
    if ($breedid) {
        $stmt->bindParam(":two", $breedid);
    } else {
        $stmt->bindParam(":two", $second);
    }
    $stmt->bindParam(":blueprints", $blueprints);
    $stmt->execute();
    
    //Fetch Breeding ID
    $query = "SELECT id FROM breedings WHERE user_id = :id ORDER BY id DESC LIMIT 1";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $breedidid = $stmt->fetch(PDO::FETCH_ASSOC);
    $breedingId = $breedidid['id'];
    
    //Cycle Through Amount of Blueprints. Create a blueprint for each
    for ($i = 0; $i < $blueprints; $i++) {
        breed($pdo, $first, $second, $userId, $breedingId, $breedid);
    }
    
    
    //Remove Items (Sewing Kit, Blueprints, Bed)
    $itemArray = [209];
    for ($i = 0; $i < $blueprints; $i++) {
        array_push($itemArray, 137);
    }
    foreach ($itemArray as $item) {
        $query = 'DELETE FROM items WHERE list_id = :id AND user_id = :user LIMIT 1';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $item);
        $stmt->bindParam(":user", $userId);
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
    if ($breedid) {
        $stmt->bindParam(":id", $breedid);
    } else {
        $stmt->bindParam(":id", $second);
    }
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
        $reply = "That should be everything. I\'ll send you a letter when your blueprints are finished.";
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
    header("Location: ../stitcher?page=new");
    
    
} else {
header("Location: ../index");
    die();
}

//Nose Function
    function chooseNose($mainColors, $pdo) {
    $mainColors = array_unique($mainColors);
    $mainColors = array_values($mainColors);
        
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

        $count = count($subcolors) - 1;
        $num = rand(0, $count);
        $noseColor = $subcolors[$num];
        return $noseColor;
    }


function breed($pdo, $first, $second, $user, $breeding, $breedid) {
    $rares = ['BananaPeel','Bee','Chalkboard','Collie','DinoOatmeal','Paint','Raccoon','RedPanda','Retro','Sloth'];
    $fabrics =['Acorns','CowBlue','CowBrown','CowGrey','CowPink','Forest','GoldHearts','HolidayBlanket','Leaves','Mistletoe','Ocean','PastelBlueDots','PastelBrownDots','PastelPinkDots','PastelPurpleDots','PastelShapes','PinkPetals','PurplePlaid','RetroFloor','SilverHearts','Spooky','Waves','HolidayTreats'];
    $matches =['FallenLeaves','Waterfall','Latte','Ink','Taffy','Basil','Gold','Holiday','Basil','Leaf','Lagoon','Pastel','Toffee','CottonCandy','Shell','IceCavern','Flower','Pillow','Pigment','Silver','Mandarin','Blueberry','Cornflower'];
    
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
    $stmt->bindParam(":id", $breedid);
    $stmt->execute();
    $two = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $query = 'SELECT * FROM snoozelings WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $second);
        $stmt->execute();
        $two = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    //Grab all Colors
    $query = 'SELECT * FROM colors';
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $colorList = $stmt->fetchAll(PDO::FETCH_ASSOC);
      
    //Add Color Info to Array
    $color1 = $one['mainColor'];
    $query = 'SELECT * FROM colors where name = :name';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $color1);
    $stmt->execute();
    $info1 = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $color2 = $two['mainColor'];
    $query = 'SELECT * FROM colors where name = :name';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $color2);
    $stmt->execute();
    $info2 = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $colors = [];
    $hues = [];
    $categories = [];
    
    array_push($colors,$info1['color'],$info2['color']);
    array_push($hues,$info1['hue'],$info2['hue']);
    array_push($categories,$info1['category'],$info2['category']);
            
    $options = [];
    foreach ($colorList as $color) {
        foreach ($colors as $col) {
            if ($color['color'] == $col) {
                foreach ($hues as $hue) {
                    if ($color['hue'] == $hue) {
                        foreach ($categories as $category) {
                            if ($color['category'] == $category) {
                                array_push($options,$color['name']);
                            }
                        }
                    }
                }
            }
        }
    }
            
    $oneEach = array_unique($options);
    $oneEach = array_values($oneEach);
    $count = count($oneEach) -1;
    $num = rand(0, $count);
    $mainColor = $oneEach[$num];
    
    //Eye Color
    
    //Check if rare. Roll to pass down rare.
    $num = 0;
    foreach($rares as $rare) {
        if ($rare == $mainColor) {
            $num = rand(0,100);
        }
    }
    
    if ($num > 50) {
        $eyeColor = $mainColor;
    } else {
        //Add Color Info to Array
        $color1 = $one['eyeColor'];
        $query = 'SELECT * FROM colors where name = :name';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":name", $color1);
        $stmt->execute();
        $info1 = $stmt->fetch(PDO::FETCH_ASSOC);

        $color2 = $two['eyeColor'];
        $query = 'SELECT * FROM colors where name = :name';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":name", $color2);
        $stmt->execute();
        $info2 = $stmt->fetch(PDO::FETCH_ASSOC);

        $colors = [];
        $hues = [];
        $categories = [];

        array_push($colors,$info1['color'],$info2['color']);
        array_push($hues,$info1['hue'],$info2['hue']);
        array_push($categories,$info1['category'],$info2['category']);

        $options = [];
        foreach ($colorList as $color) {
            foreach ($colors as $col) {
                if ($color['color'] == $col) {
                    foreach ($hues as $hue) {
                        if ($color['hue'] == $hue) {
                            foreach ($categories as $category) {
                                if ($color['category'] == $category) {
                                    array_push($options,$color['name']);
                                }
                            }
                        }
                    }
                }
            }
        }

        $oneEach = array_unique($options);
        $oneEach = array_values($oneEach);
        $raresRemoved = [];
        foreach ($oneEach as $check) {
            $z = 0;
            foreach ($rares as $rare) {
                if ($check == $rare) {
                    $z = 1;
                }
            }
            if ($z == 0) {
                array_push($raresRemoved,$check);
            }
        }

        $count = count($raresRemoved) -1;
        $num = rand(0, $count);
        $eyeColor = $raresRemoved[$num];
    }
    
    
    //Nose/Ear Color Selection
    
    //Check for Fabrics
    $count = 0;
    foreach ($fabrics as $fabric) {
        if ($fabric == $one['noseColor']) {
            $noseOne = $matches[$count];
        } else {
            $count++;
        }
    }
    
    $count = 0;
    foreach ($fabrics as $fabric) {
        if ($fabric == $two['noseColor']) {
            $noseTwo = $matches[$count];
        } else {
            $count++;
        }
    }
    
    if ($noseOne) {
        $color1 = $noseOne;
    } else {
        $color1 = $one['noseColor'];
    }
    
    if ($noseTwo) {
        $color2 = $noseTwo;
    } else {
        $color2 = $two['noseColor'];
    }
    
    //Check if rare. Roll to pass down rare.
    $num = 0;
    foreach($rares as $rare) {
        if ($rare == $mainColor) {
            $num = rand(0,100);
        }
    }
    
    if ($num > 50) {
        $noseColor = $mainColor;
    } else {
        //Add Color Info to Array
        
        $query = 'SELECT * FROM colors where name = :name';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":name", $color1);
        $stmt->execute();
        $info1 = $stmt->fetch(PDO::FETCH_ASSOC);
        
        
        $query = 'SELECT * FROM colors where name = :name';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":name", $color2);
        $stmt->execute();
        $info2 = $stmt->fetch(PDO::FETCH_ASSOC);

        $colors = [];
        $hues = [];
        $categories = [];

        array_push($colors,$info1['color'],$info2['color']);
        array_push($hues,$info1['hue'],$info2['hue']);
        array_push($categories,$info1['category'],$info2['category']);

        $options = [];
        foreach ($colorList as $color) {
            foreach ($colors as $col) {
                if ($color['color'] == $col) {
                    foreach ($hues as $hue) {
                        if ($color['hue'] == $hue) {
                            foreach ($categories as $category) {
                                if ($color['category'] == $category) {
                                    array_push($options,$color['name']);
                                }
                            }
                        }
                    }
                }
            }
        }

        $oneEach = array_unique($options);
        $oneEach = array_values($oneEach);

        $raresRemoved = [];
        foreach ($oneEach as $check) {
            $z = 0;
            foreach ($rares as $rare) {
                if ($check == $rare) {
                    $z = 1;
                }
            }
            if ($z == 0) {
                array_push($raresRemoved,$check);
            }
        }
        
        $count = count($raresRemoved) -1;
        $num = rand(0, $count);
        $noseColor = $raresRemoved[$num];
    }
    
    //Calculate Hair Color
    
    //Check if rare. Roll to pass down rare.
    $num = 0;
    foreach($rares as $rare) {
        if ($rare == $mainColor) {
            $num = rand(0,100);
        }
    }
    
    if ($num > 50) {
        $hairColor = $mainColor;
    } else {
        //Add Color Info to Array
        $color1 = $one['hairColor'];
        $query = 'SELECT * FROM colors where name = :name';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":name", $color1);
        $stmt->execute();
        $info1 = $stmt->fetch(PDO::FETCH_ASSOC);

        $color2 = $two['hairColor'];
        $query = 'SELECT * FROM colors where name = :name';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":name", $color2);
        $stmt->execute();
        $info2 = $stmt->fetch(PDO::FETCH_ASSOC);

        $colors = [];
        $hues = [];
        $categories = [];

        array_push($colors,$info1['color'],$info2['color']);
        array_push($hues,$info1['hue'],$info2['hue']);
        array_push($categories,$info1['category'],$info2['category']);

        $options = [];
        foreach ($colorList as $color) {
            foreach ($colors as $col) {
                if ($color['color'] == $col) {
                    foreach ($hues as $hue) {
                        if ($color['hue'] == $hue) {
                            foreach ($categories as $category) {
                                if ($color['category'] == $category) {
                                    array_push($options,$color['name']);
                                }
                            }
                        }
                    }
                }
            }
        }

        $oneEach = array_unique($options);
        $oneEach = array_values($oneEach);
        $raresRemoved = [];
        foreach ($oneEach as $check) {
            $z = 0;
            foreach ($rares as $rare) {
                if ($check == $rare) {
                    $z = 1;
                }
            }
            if ($z == 0) {
                array_push($raresRemoved,$check);
            }
        }

        $count = count($raresRemoved) -1;
        $num = rand(0, $count);
        $hairColor = $raresRemoved[$num];
    }

    
    //Calculate Tail Color
    //Check if rare. Roll to pass down rare.
    $num = 0;
    foreach($rares as $rare) {
        if ($rare == $mainColor) {
            $num = rand(0,100);
        }
    }
    
    if ($num > 50) {
        $tailColor = $mainColor;
    } else {
        //Add Color Info to Array
        $color1 = $one['tailColor'];
        $query = 'SELECT * FROM colors where name = :name';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":name", $color1);
        $stmt->execute();
        $info1 = $stmt->fetch(PDO::FETCH_ASSOC);

        $color2 = $two['tailColor'];
        $query = 'SELECT * FROM colors where name = :name';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":name", $color2);
        $stmt->execute();
        $info2 = $stmt->fetch(PDO::FETCH_ASSOC);

        $colors = [];
        $hues = [];
        $categories = [];

        array_push($colors,$info1['color'],$info2['color']);
        array_push($hues,$info1['hue'],$info2['hue']);
        array_push($categories,$info1['category'],$info2['category']);

        $options = [];
        foreach ($colorList as $color) {
            foreach ($colors as $col) {
                if ($color['color'] == $col) {
                    foreach ($hues as $hue) {
                        if ($color['hue'] == $hue) {
                            foreach ($categories as $category) {
                                if ($color['category'] == $category) {
                                    array_push($options,$color['name']);
                                }
                            }
                        }
                    }
                }
            }
        }

        $oneEach = array_unique($options);
        $oneEach = array_values($oneEach);
        $raresRemoved = [];
        foreach ($oneEach as $check) {
            $z = 0;
            foreach ($rares as $rare) {
                if ($check == $rare) {
                    $z = 1;
                }
            }
            if ($z == 0) {
                array_push($raresRemoved,$check);
            }
        }

        $count = count($raresRemoved) -1;
        $num = rand(0, $count);
        $tailColor = $raresRemoved[$num];
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
    $specialsUnique = array_unique($specials);
    $specialsUnique = array_values($specialsUnique);
    
    $newspec = "";
    foreach ($specialsUnique as $special) {
        $x = 1;
        $tmp = array_count_values($specials);
        $x = $tmp[$special];
        $num = rand(0, 100);
        if ($x == 2) {
            if ($num < 65) {
                $newspec .= $special . " ";
            }
        } else {
            if ($num < 45) {
                $newspec .= $special . " ";
            }
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













