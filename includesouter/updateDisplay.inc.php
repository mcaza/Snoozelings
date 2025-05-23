<?php

//Grab User ID
$userId = $_COOKIE['user_id'];
$id = $_GET['id'];


$query = "SELECT * FROM replies WHERE user_id = :id;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$reply = $stmt->fetch(PDO::FETCH_ASSOC);

//Grab Pet Info from Database
$query = "SELECT * FROM snoozelings WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

singleImage($result);

//Grab USer Info from Database
$query = "SELECT * FROM users WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

//Grab All Titles in Alphebetical Order
$query = "SELECT * FROM titles ORDER BY title";
$stmt = $pdo->prepare($query);
$stmt->execute();
$titles = $stmt->fetchAll(PDO::FETCH_ASSOC);

//FetchDyes
$query = "SELECT * FROM dyes";
$stmt = $pdo->prepare($query);
$stmt->execute();
$dyelist = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="pet?id=' . $id . '"><<</a>';
echo '<a href="downloadImage?id=' . $id . '" class="fancyButton">Download</a>';
//echo '<a href="snoozelings/' . $id . '.png" download="snoozelings/' . $id . '.png" class="fancyButton">Download</a>';
echo '</div>';

if (!function_exists('str_ends_with')) {
    function str_ends_with($haystack, $needle)
    {
        return $needle !== '' ? substr($haystack, -strlen($needle)) === $needle : true;
    }
}

//Session Reply Area
if ($reply) {
    echo '<div class="returnBar" style="margin-top: 1rem;margin-bottom:2rem;">';
    echo '<p>' . $reply['message'] . '</p>';
    echo '</div>';
    $query = "DELETE FROM replies WHERE user_id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
}

echo '<h3 style="margin-bottom: 2rem">Edit ' . htmlspecialchars($result['name']) . "'s Information</h3>";
echo '<form action="../includes/editPet.inc.php" method="post">';
echo '<input type="hidden" name="id" value="' . $id . '">';

//Form "Name"
echo '<label class="form" for="name">New Name:</label><br>';
echo '<input class="input" name="name" type="text" value="' . htmlspecialchars($result['name']) . '"><br>';

//Pronouns Check
switch ($result['pronouns']) {
    case "Any":
        $any = "selected";
        break;
    case "She/Them":
        $sheThem = "selected";
        break;
    case "She/Her":
        $sheHer = "selected";
        break;
    case "He/Him":
        $heHim = "selected";
        break;
    case "He/Them":
        $heThem = "selected";
        break;
    case "They/Them":
        $theyThem = "selected";
        break;
    case "She/Him":
        $sheHim = "selected";
        break;
    case "See Bio":
        $seebio = "selected";
        break;
}
//Form "Pronouns"
echo '<label for="pronouns"  class="form">Snoozeling\'s Pronouns:</label><br>';
echo '<select  class="input" name="pronouns"><br>';
echo '<option value="Any"' . $any . '>Any</option>';
echo '<option value="She/Her"' . $sheHer . '>She/Her</option>';
echo '<option value="He/Him"' . $heHim . '>He/Him</option>';
echo '<option value="They/Them"' . $theyThem . '>They/Them</option>';
echo '<option value="She/Them"' . $sheThem . '>She/Them</option>';
echo '<option value="He/Them"' . $heThem . '>He/Them</option>';
echo '<option value="She/Him"' . $sheHim . '>She/Him</option>';
echo '<option value="See Bio"' . $seebio . '>See Bio</option>';
echo '</select><br>';

//Title
echo '<label for="title"  class="form">Snoozeling\'s Title:</label><br>';
echo '<select  class="input" name="title"><br>';
echo '<option value=""></option>';
foreach ($titles as $title) {
    echo '<option value="' . $title['title'] . '">' . $title['title'] . '</option>';
}
if ($result['farmEXP']  > 999.5) {
    echo '<option value="Crop Whisperer">Crop Whisperer</option>';
}
if ($result['exploreEXP'] > 999.5) {
    echo '<option value="Grand Adventurer">Grand Adventurer</option>';
}
if ($result['craftEXP'] > 999.5) {
    echo '<option value="Hooked on Crafts">Hooked on Crafts</option>';
}
echo "</select><br>";

//Bed Color
echo '<label for="bed"  class="form">Bed Color:</label><br>';
echo '<select  class="input" name="bed"><br>';
echo '<option value=""></option>';
echo '<option value="BrownFree">Brown</option>';
echo '<option value="BlueFree">Blue</option>';
echo '<option value="GreenFree">Green</option>';
echo '<option value="PinkFree">Pink</option>';
echo '<option value="RedFree">Red</option>';

$covers = explode(" ", $user['covers']);
foreach ($covers as $cover) {
    echo '<option value="' . $cover . '">' . $cover . '</option>';
}
echo '</select><br>';

//Show Bed
echo '<label for="showbed"  class="form">Bed on Pet Page:</label><br>';
echo '<select  class="input" name="showbed"><br>';
echo '<option value=""></option>';
echo '<option value="1">Yes</option>';
echo '<option value="2">No</option>';
echo '</select><br>';

//List of Current Clothes (Adding Later)
echo '<label for="status"  class="form">Remove Clothes:</label><br>';
if ($result['clothesTop'] || $result['clothesBottom'] || $result['clothesHoodie'] || $result['clothesBoth']) {
    if ($result['clothesTop']) {
        $clothes = explode(" ", $result['clothesTop']);
            foreach ($clothes as $clothing) {
            $newname = "";
                foreach ($dyelist as $dye) {
                    if (str_ends_with($clothing, $dye['name'])) {
                        $newname = str_replace($dye['name'],"",$clothing);
                        $color = $dye['name'];
                        $colordisplay = $dye['display'];
                    } else {

                    }
                }
                $othercolors = ['Gold', 'Silver'];
                foreach ($othercolors as $x) {
                    if (str_ends_with($clothing, $x)) {
                        $newname = str_replace($x,"",$clothing);
                        $color = $x;
                        $colordisplay = $x;
                    }
                }

            $query = 'SELECT * FROM itemList WHERE name = :name';
            $stmt = $pdo->prepare($query);
            if ($newname) {
                $stmt->bindParam(":name", $newname);
            } else {
                $stmt->bindParam(":name", $clothing);
            }
            $stmt->execute();
            $clothe = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($newname) {
                echo '<input type="checkbox" id="' . $clothe['id'] . '" name="' . $clothe['id'] . '" value="' . $clothe['id'] . $clothing . '"><label style="font-size: 1.7rem;" for="' . $clothe['id'] . '">   ' . $clothe['display'] . ' [' . $colordisplay . ']</label><br><br>';
            } else {
                echo '<input type="checkbox" id="' . $clothe['id'] . '" name="' . $clothe['id'] . '" value="' . $clothe['id'] . $clothe['name'] . '"><label style="font-size: 1.7rem;" for="' . $clothe['id'] . '">   ' . $clothe['display'] . '</label><br><br>';
            }

        }
    }
    if ($result['clothesBottom']) {
        $clothes = explode(" ", $result['clothesBottom']);
            foreach ($clothes as $clothing) {
            $newname = "";
            foreach ($dyelist as $dye) {
                    if (str_ends_with($clothing, $dye['name'])) {
                        $newname = str_replace($dye['name'],"",$clothing);
                        $color = $dye['name'];
                        $colordisplay = $dye['display'];
                    } else {

                    }
                }
            $othercolors = ['Gold', 'Silver'];
                foreach ($othercolors as $x) {
                    if (str_ends_with($clothing, $x)) {
                        $newname = str_replace($x,"",$clothing);
                        $color = $x;
                        $colordisplay = $x;
                    }
                }

            $query = 'SELECT * FROM itemList WHERE name = :name';
            $stmt = $pdo->prepare($query);
            if ($newname) {
                $stmt->bindParam(":name", $newname);
            } else {
                $stmt->bindParam(":name", $clothing);
            }
            $stmt->execute();
            $clothe = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($newname) {
                echo '<input type="checkbox" id="' . $clothe['id'] . '" name="' . $clothe['id'] . '" value="' . $clothe['id'] . $clothing . '"><label style="font-size: 1.7rem;" for="' . $clothe['id'] . '">   ' . $clothe['display'] . ' [' . $colordisplay . ']</label><br><br>';
            } else {
                echo '<input type="checkbox" id="' . $clothe['id'] . '" name="' . $clothe['id'] . '" value="' . $clothe['id'] . $clothe['name'] . '"><label style="font-size: 1.7rem;" for="' . $clothe['id'] . '">   ' . $clothe['display'] . '</label><br><br>';
            }

        }
    }
    if ($result['clothesHoodie']) {
        $clothes = explode(" ", $result['clothesHoodie']);
            foreach ($clothes as $clothing) {
            $newname = "";
            foreach ($dyelist as $dye) {
                    if (str_ends_with($clothing, $dye['name'])) {
                        $newname = str_replace($dye['name'],"",$clothing);
                        $color = $dye['name'];
                        $colordisplay = $dye['display'];
                    } else {

                    }
                }
                
                $othercolors = ['Gold', 'Silver'];
                foreach ($othercolors as $x) {
                    if (str_ends_with($clothing, $x)) {
                        $newname = str_replace($x,"",$clothing);
                        $color = $x;
                        $colordisplay = $x;
                    }
                }
            $query = 'SELECT * FROM itemList WHERE name = :name';
            $stmt = $pdo->prepare($query);
            if ($newname) {
                $stmt->bindParam(":name", $newname);
            } else {
                $stmt->bindParam(":name", $clothing);
            }
            $stmt->execute();
            $clothe = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($newname) {
                echo '<input type="checkbox" id="' . $clothe['id'] . '" name="' . $clothe['id'] . '" value="' . $clothe['id'] . $clothing . '"><label style="font-size: 1.7rem;" for="' . $clothe['id'] . '">   ' . $clothe['display'] . ' [' . $colordisplay . ']</label><br><br>';
            } else {
                echo '<input type="checkbox" id="' . $clothe['id'] . '" name="' . $clothe['id'] . '" value="' . $clothe['id'] . $clothe['name'] . '"><label style="font-size: 1.7rem;" for="' . $clothe['id'] . '">   ' . $clothe['display'] . '</label><br><br>';
            }

        }
    }
    if ($result['clothesBoth']) {
        $clothes = explode(" ", $result['clothesBoth']);
        foreach ($clothes as $clothing) {
        $newname = "";
            foreach ($dyelist as $dye) {
                    if (str_ends_with($clothing, $dye['name'])) {
                        $newname = str_replace($dye['name'],"",$clothing);
                        $color = $dye['name'];
                        $colordisplay = $dye['display'];
                    } else {

                    }
                }
            
            $othercolors = ['Gold', 'Silver'];
                foreach ($othercolors as $x) {
                    if (str_ends_with($clothing, $x)) {
                        $newname = str_replace($x,"",$clothing);
                        $color = $x;
                        $colordisplay = $x;
                    }
                }

            $query = 'SELECT * FROM itemList WHERE name = :name';
            $stmt = $pdo->prepare($query);
            if ($newname) {
                $stmt->bindParam(":name", $newname);
            } else {
                $stmt->bindParam(":name", $clothing);
            }
            $stmt->execute();
            $clothe = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($newname) {
                echo '<input type="checkbox" id="' . $clothe['id'] . '" name="' . $clothe['id'] . '" value="' . $clothe['id'] . $clothing . '"><label style="font-size: 1.7rem;" for="' . $clothe['id'] . '">   ' . $clothe['display'] . ' [' . $colordisplay . ']</label><br><br>';
            } else {
                echo '<input type="checkbox" id="' . $clothe['id'] . '" name="' . $clothe['id'] . '" value="' . $clothe['id'] . $clothe['name'] . '"><label style="font-size: 1.7rem;" for="' . $clothe['id'] . '">   ' . $clothe['display'] . '</label><br><br>';
            }

        }
    }
   
    

echo '<br>';
} else {
    echo '<p>Your snoozeling is not wearing any clothes</p><br>';
}

//Breeding Status Check
switch ($result['breedStatus']) {
    case "Closed":
        $closed = "selected";
        break;
    case "Open":
        $open = "selected";
        break;
    case "Friends":
        $friends = "selected";
        break;
}

//Form Breeding Status
echo '<label for="status"  class="form">Pet Inspiration:</label><br>';
echo '<select  class="input" name="status" id="status"><br>';
echo '<option value="Closed"' . $closed . '>Closed</option>';
echo '<option value="Open"' . $open . '>Open</option>';
//echo '<option value="Friends"' . $friends . '>Friends Only</option>';
echo '</select><br>';

//Breeding Status Javascript
if ($closed === "selected") {
    echo '<div id="breedingInfoDiv"><p id="breedingInfo" style="margin-top: 0" >Only you can use this pet as inspiration.</p></div>';
} elseif ($open === "selected") {
    echo '<div id="breedingInfoDiv"><p id="breedingInfo" style="margin-top: 0" >Any users can use this pet as inspiration.</p></div>';
}

echo '<hr>';
echo '<label for="bio"  class="form">Pet Bio:</label><br>';
echo '<textarea id="bio" name="bio" rows="12" cols="70" name="bio">' . htmlspecialchars($result['bio']) . '</textarea>';
echo '<p><i>Bios Cannot be Longer than 500 Characters</i></p>';
echo '<hr>';

//Blank Field Warning
echo '<p><i>Any Blank Fields Will Not Be Changed</i></p>';

//Submit Button
echo '<div>';
echo '<button  class="fancyButton">Update Pet</button>';
echo '</div>';
echo '</form>';