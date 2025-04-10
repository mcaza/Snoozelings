<?php

$id = $_GET['id'];
$userId = $_COOKIE['user_id'];

$query = 'SELECT * FROM blueprints WHERE id = :id';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

displayPet($result, "artlarge");
echo '<p><i>"I think I\'m ready to come home now."</i></p>';
echo '<form  method="post" action="includes/addSnoozeling.inc.php">';
    echo '<label style="margin-top:2rem" class="form" for="name" required>Name Your Snoozeling:</label><br>';
    echo '<input class="form" type="text" name="name"><br>';
    echo '<label class="form" for="pronouns" required>Snoozeling\'s Pronouns</label><br>';
    echo '<select class="input" name="pronouns">';
    echo '<option value="Any">Any</option>';
    echo '<option value="He/Him">He/Him</option>';
    echo '<option value="She/Her">She/Her</option>';
    echo '<option value="They/Them">They/Them</option>';
    echo '<option value="She/Them">She/Them</option>';
    echo '<option value="He/Them">He/Them</option>';
    echo '</select>';
    echo '<input type="hidden" name="id" value="' . $id . '">';
    echo '<div><button class="fancyButton">Adopt Snoozeling</button></div>';
    echo "</form>";


/* function displayStarter($pet, $class) {    
    
    echo '<div class="art-container">';
    if (strpos($pet["specials"], "Wings") !== false) {
            echo "<div class='${class}'>";
            echo "<img src='Layers/Wings/Pegasus/Bottom/" . $pet["mainColor"] . ".png' id = 'Wingsbottomone'>";
            echo "</div>";
        }
        echo "<div class='${class}'>";
        echo "<img src='Layers/Primary/" . $pet["mainColor"] . ".png' id = 'Primaryone'>";
        echo "</div>";
    if (strpos($pet["specials"], "Spots") !== false) {
            echo "<div class='${class}'>";
            echo "<img src='Layers/Markings/Spots/" . $pet["mainColor"] . ".png' id = 'Spotsone'>";
            echo "</div>";
        }
    if (strpos($pet["specials"], "Belly") !== false) {
            echo "<div class='${class}'>";
            echo "<img src='Layers/Markings/Belly/" . $pet["mainColor"] . ".png' id = 'Bellyone'>";
            echo "</div>";
        }
    if (strpos($pet["specials"], "Boots") !== false) {
            echo "<div class='${class}'>";
            echo "<img src='Layers/Markings/Boots/" . $pet["mainColor"] . ".png' id = 'Bootsone'>";
            echo "</div>";
        }
        echo "<div class='${class}'>";
        echo "<img src='Layers/Ear/" . $pet["noseColor"] . ".png' id = 'Earone'>";
        echo "</div>";
        echo "<div class='${class}'>";
        echo "<img src='Layers/MainLines/" . $pet["mainColor"] . ".png' id = 'Mainlinesone'>";
        echo "</div>";
        echo "<div class='${class}'>";
        echo "<img src='Layers/Faces/Happy/Eyes/" . $pet["eyeColor"] . ".png' id = 'Eyesone'>";
        echo "</div>";
        echo "<div class='${class}'>";
        echo "<img src='Layers/Faces/Happy/Lines/" . $pet["mainColor"] . ".png' id = 'Faceone'>";
        echo "</div>";
        echo "<div class='${class}'>";
        if ($pet["hairType"] === "Floof") {
        echo "<img src='Layers/Hair/" . $pet["hairType"] . "/" . $pet["mainColor"] . ".png' id = 'Hairone'>";
        } else {
            echo "<img src='Layers/Hair/" . $pet["hairType"] . "/" . $pet["hairColor"] . ".png' id = 'Hairone'>";
        }
        echo "</div>";
        if ($pet["tailType"] === "Dragon") {
            echo "<div class='${class}'>";
            echo "<img src='Layers/Tail/Dragon/End/" . $pet["tailColor"] . ".png' id = 'Tailone'>";
            echo "</div>";
            echo "<div class='${class}'>";
            echo "<img src='Layers/Tail/Dragon/" . $pet["mainColor"] . ".png' id = 'TailTopone'>";
            echo "</div>";
        } else {
            echo "<div class='${class}'>";
        echo "<img src='Layers/Tail/" . $pet["tailType"] . "/" . $pet["tailColor"] . ".png' id = 'Tailone'>";
        echo "</div>";
        }
        echo "<div class='${class}'>";
        echo "<img src='Layers/Noses/" . $pet["noseColor"] . ".png' id = 'Noseone'>";
        echo "</div>";
    if (strpos($pet["specials"], "Wings") !== false) {
            echo "<div class='${class}'>";
            echo "<img src='Layers/Wings/Pegasus/Top/" . $pet["mainColor"] . ".png' id = 'Wingstopone'>";
            echo "</div>";
        }
        echo "<div class='${class}'>";
        echo "<img src='Layers/transparentSquare.png'>";
        echo "</div>";
        
        echo "</div>";
                        
} */