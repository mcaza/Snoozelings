<?php



//Grab All Colors
$query = 'SELECT * FROM colors ORDER BY display';
$stmt = $pdo->prepare($query);
$stmt->execute();
$colors = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Grab All Fabrics
$query = 'SELECT * FROM fabrics ORDER BY display';
$stmt = $pdo->prepare($query);
$stmt->execute();
$fabrics = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="games"><<</a>';
echo '</div>';

echo '<h3 style="margin-top: 1rem; margin-bottom: 2rem;">Snoozelings Maker</h3>';
 echo '<div class="art-container">';
    

        
            echo "<div class='artlarge'>";
            echo "<img src='' id = 'BottomWingdesigner'>";
            echo "</div>";
        
        echo "<div class='artlarge'>";
        echo "<img src='Layers/Primary/Amethyst.png' id = 'Primarydesigner'>";
        echo "</div>";
        echo "<div class='artlarge'>";
            echo "<img src='' id = 'Cupiddesigner'>";
            echo "</div>";  
   
            echo "<div class='artlarge'>";
            echo "<img src='' id = 'Spotsdesigner'>";
            echo "</div>";
            

            echo "<div class='artlarge'>";
            echo "<img src='' id = 'Bootsdesigner'>";
            echo "</div>";
     echo "<div class='artlarge'>";
            echo "<img src='' id = 'Sublimationdesigner'>";
            echo "</div>";  
    echo "<div class='artlarge'>";
            echo "<img src='' id = 'Eartipdesigner'>";
            echo "</div>";
        echo "<div class='artlarge'>";
        echo "<img src='Layers/Ear/Amethyst.png' id = 'Eardesigner'>";
        echo "</div>";
    echo "<div class='artlarge'>";
            echo "<img src='' id = 'Bellydesigner'>";
            echo "</div>";
        echo "<div class='artlarge'>";
        echo "<img src='Layers/MainLines/Amethyst.png' id = 'Mainlinesdesigner'>";
        echo "</div>";
        echo "<div class='artlarge'>";
            echo "<img src='' id = 'BottomMothdesigner'>";
            echo "</div>";
        echo "<div class='artlarge'>";
        echo "<img src='Layers/Faces/Happy/Eyes/Amethyst.png' id = 'Eyesdesigner'>";
        echo "</div>";
        echo "<div class='artlarge'>";
        echo "<img src='Layers/Faces/Happy/Lines/Amethyst.png' id = 'Facedesigner'>";
        echo "</div>";
       /* if (strlen($pet['clothesBottom']) > 1) {
        $clothesBottom = explode(' ', $pet['clothesBottom']);
        foreach ($clothesBottom as $clothing) {
            echo "<div class='artlarge'>";
         echo "<img src='Layers/ClothesBottom/" . $clothing . ".png'>";  
            echo "</div>";
        } } */
        echo "<div class='artlarge'>";
            echo "<img src='Layers/Hair/Floof/Amethyst.png' id = 'Hairdesigner'>";
            echo "</div>";
        echo "<div class='artlarge'>";
            echo "<img src='' id = 'TopMothdesigner'>";
            echo "</div>";
        echo "<div class='artlarge'>";
            echo "<img src='Layers/Tail/Dragon/End/Amethyst.png' id = 'Taildesigner'>";
            echo "</div>";
            echo "<div class='artlarge'>";
            echo "<img src='Layers/Tail/Dragon/Amethyst.png' id = 'TailTopdesigner'>";
            echo "</div>";
     /*   if ($pet["tailType"] === "Dragon") {
            echo "<div class='artlarge'>";
            echo "<img src='Layers/Tail/Dragon/End/" . $pet["tailColor"] . ".png' id = 'Taildesigner'>";
            echo "</div>";
            echo "<div class='artlarge'>";
            echo "<img src='Layers/Tail/Dragon/" . $pet["mainColor"] . ".png' id = 'TailTopdesigner'>";
            echo "</div>";
        } else {
            echo "<div class='artlarge'>";
        echo "<img src='Layers/Tail/" . $pet["tailType"] . "/" . $pet["tailColor"] . ".png' id = 'Taildesigner'>";
        echo "</div>";
        } */
        echo "<div class='artlarge'>";
        echo "<img src='Layers/Noses/Amethyst.png' id = 'Nosedesigner'>";
        echo "</div>";
  /*  if (strlen($pet['clothesBottom']) > 1) {
    $clothesTop = explode(' ', $pet['clothesTop']);
        foreach ($clothesTop as $clothing) {
            echo "<div class='artlarge'>";
         echo "<img src='Layers/ClothesTop/" . $clothing . ".png'>";  
            echo "</div>";
        } } */
            echo "<div class='artlarge'>";
            echo "<img src='' id = 'TopWingdesigner'>";
            echo "</div>";
        echo "<div class='artlarge'>";
        echo "<img src='Layers/transparentSquare.png'>";
        echo "</div>";
        
        echo "</div>";

//Form Stuff

echo '<div class="designerBoxes">';
echo '<div>';
echo '<label for="mainColor" class="form">Main Color:</label><br>';
echo '<select id="mainColor"  class="input">';
foreach ($colors as $color) {
    echo '<option value="' . $color['name'] . '">' . $color['display'] . '</option>';
}
echo '</select><br>';

echo '<label for="skinColor" class="form">Skin Color:</label><br>';
echo '<select id="skinColor"  class="input">';
foreach ($colors as $color) {
    echo '<option value="' . $color['name'] . '">' . $color['display'] . '</option>';
}
foreach ($fabrics as $fabric) {
    echo '<option value="' . $fabric['name'] . '">' . $fabric['display'] . '</option>';
}
echo '</select><br>';

echo '<label for="eyeColor" class="form">Eye Color:</label><br>';
echo '<select id="eyeColor"  class="input">';
foreach ($colors as $color) {
    echo '<option value="' . $color['name'] . '">' . $color['display'] . '</option>';
}
echo '</select><br>';
echo '</div>';
echo '<div>';
echo '<label for="hairColor" class="form">Hair Color:</label><br>';
echo '<select id="hairColor"  class="input">';
foreach ($colors as $color) {
    echo '<option value="' . $color['name'] . '">' . $color['display'] . '</option>';
}
echo '</select><br>';

echo '<label for="hairType" class="form">Hair Style:</label><br>';
echo '<select id="hairType"  class="input">';
echo '<option value="Floof">Floof</option>';
echo '<option value="Forelock">Forelock</option>';
echo '<option value="Knitted">Knitted</option>';
echo '<option value="LizardSpikes">Lizard Spikes</option>';
echo '<option value="Mane">Mane</option>';
echo '<option value="Mohawk">Mohawk</option>';
echo '<option value="Wave">Wave</option>';
echo '</select><br>';
echo '<label for="mothFluff" class="form">Moth Fluff:</label><br>';
echo '<select id="mothFluff"  class="input">';
echo '<option value="NoFluff">No Fluff</option>';
echo '<option value="MothFluff">White</option>';
echo '<option value="MothFluffRed">Red</option>';
echo '<option value="MothFluffOrange">Orange</option>';
echo '<option value="MothFluffYellow">Yellow</option>';
echo '<option value="MothFluffGreen">Green</option>';
echo '<option value="MothFluffBlue">Blue</option>';
echo '<option value="MothFluffPurple">Purple</option>';
echo '<option value="MothFluffBrown">Brown</option>';
echo '<option value="MothFluffBlack">Black</option>';
echo '<option value="MothFluffSilver">Silver</option>';
echo '<option value="MothFluffGold">Gold</option>';
echo '<option value="MothFluffPink">Pink</option>';
echo '<option value="MothFluffPastelPink">Pastel Pink</option>';
echo '<option value="MothFluffPastelBlue">Pastel Blue</option>';
echo '<option value="MothFluffPastelPurple">Pastel Purple</option>';
echo '<option value="MothFluffPastelBrown">Pastel Brown</option>';
echo '<option value="MothFluffGooseberry">Gooseberry</option>';
echo '<option value="MothFluffBlueberry">Blueberry</option>';
echo '<option value="MothFluffTeal">Teal</option>';
echo '<option value="MothFluffRainbowLove">Rainbow Love</option>';
echo '<option value="MothFluffFemaleLove">Female Love</option>';
echo '<option value="MothFluffMaleLove">Male Love</option>';
echo '<option value="MothFluffDoubleLove">Double Love</option>';
echo '<option value="MothFluffAnyLove">Any Love</option>';
echo '<option value="MothFluffAceLove">Ace Love</option>';
echo '<option value="MothFluffAroLove">Aro Love</option>';
echo '<option value="MothFluffNewSelf">New Self</option>';
echo '<option value="MothFluffUniqueSelf">Unique Self</option>';
echo '<option value="MothFluffFluidSelf">Fluid Self</option>';
echo '</select><br>';
echo '</div>';
echo '<div>';
echo '<label for="tailColor" class="form">Tail Color:</label><br>';
echo '<select id="tailColor"  class="input">';
foreach ($colors as $color) {
    echo '<option value="' . $color['name'] . '">' . $color['display'] . '</option>';
}
echo '</select><br>';

echo '<label for="tailType" class="form">Tail Style:</label><br>';
echo '<select id="tailType"  class="input">';
echo '<option value="Dragon">Dragon</option>';
echo '<option value="Knitted">Knitted</option>';
echo '<option value="Lizard">Lizard</option>';
echo '<option value="Long">Long</option>';
echo '<option value="Mermaid">Mermaid</option>';
echo '<option value="Nub">Nub</option>';
echo '<option value="Panther">Panther</option>';
echo '<option value="Pom">Pom</option>';
echo '<option value="Wooly">Wooly</option>';
echo '</select><br>';
echo '</div>';

echo '<div>';
echo '<label style="margin-bottom: 1rem;" class="form">Markings:</label><br>';
echo '<div class="checkBoxDes">';
echo '<input type="checkbox" id="wings"><label class="designerCheck" for="wings">Wings</label><br>';
echo '</div>';

echo '<div class="checkBoxDes">';
echo '<input type="checkbox" id="eartip"><label class="designerCheck" for="eartip">Ear Tip</label><br>';
echo '</div>';

echo '<div class="checkBoxDes">';
echo '<input  type="checkbox" id="belly"><label class="designerCheck" for="belly">Belly</label><br>';
echo '</div>';

echo '<div class="checkBoxDes">';
echo '<input  type="checkbox" id="boots"><label class="designerCheck" for="boots">Boots</label><br>';
echo '</div>';

echo '<div class="checkBoxDes">';
echo '<input type="checkbox" id="spots"><label class="designerCheck" for="spots">Spots</label><br>';
echo '</div>';

echo '<div class="checkBoxDes">';
echo '<input type="checkbox" id="cupid"><label class="designerCheck" for="cupid">Cupid</label><br>';
echo '</div>';

echo '<div class="checkBoxDes">';
echo '<input type="checkbox" id="sublimation"><label class="designerCheck" for="sublimation">Sublimation</label><br>';
echo '</div>';

echo '</div>';
echo '</div>';



echo '</div>';







