<?php

$userId = $_COOKIE['user_id'];


//Get All Non Dyable Clothing Items
$query = 'SELECT * FROM clothes WHERE dye IS NULL ORDER BY display';
$stmt = $pdo->prepare($query);
$stmt->execute();
$clothes = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="gameGuides"><<</a>';
echo '</div>';

echo '<h3 style="margin-top: 1rem; margin-bottom: 2rem;">Regular Items Preview</h3>';

echo '<div class="artcontainerdesigner">';

echo "<div class='artdesigner'>";
echo "<img src='previews/" . $clothes[0]['name'] . ".png' id = 'Preview'>";
echo "</div>";

echo "</div>";

//Form Stuff
echo '<div class="designerBoxes">';
echo '<div>';
echo '<label for="clothingItem" class="form">Clothing Item:</label><br>';
echo '<select id="clothingItem"  class="input">';
foreach ($clothes as $clothing) {
    echo '<option value="' . $clothing['name'] . '">' . $clothing['display'] . '</option>';
}
echo '</select>';
echo '</div>';
echo '</div>';