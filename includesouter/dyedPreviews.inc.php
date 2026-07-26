<?php

$userId = $_COOKIE['user_id'];

//Get All Dye Colors
$query = 'SELECT * FROM dyes ORDER BY display';
$stmt = $pdo->prepare($query);
$stmt->execute();
$dyes = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Get All Dyable Items
$query = 'SELECT * FROM itemList WHERE canDye = 1 ORDER BY display';
$stmt = $pdo->prepare($query);
$stmt->execute();
$clothes = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="gameGuides"><<</a>';
echo '</div>';

echo '<h3 style="margin-top: 1rem; margin-bottom: 2rem;">Dyed Items Preview</h3>';

echo '<div class="artcontainerdesigner">';

echo "<div class='artdesigner'>";
echo "<img src='previews/" . $clothes[0]['name'] . $dyes[0]['name'] . ".png' id = 'Preview'>";
echo "</div>";

echo "</div>";

//Form Stuff
echo '<div class="designerBoxes">';
echo '<div>';
echo '<label for="dyeColor" class="form">Dye Color:</label><br>';
echo '<select id="dyeColor"  class="input">';
foreach ($dyes as $dye) {
    echo '<option value="' . $dye['name'] . '">' . $dye['display'] . '</option>';
}
echo '</select>';
echo '</div>';
echo '<div>';
echo '<label for="clothingItem" class="form">Clothing Item:</label><br>';
echo '<select id="clothingItem"  class="input">';
echo '<option value="Bandana">Bandana</option>';
foreach ($clothes as $clothing) {
    echo '<option value="' . $clothing['name'] . '">' . $clothing['display'] . '</option>';
}
echo '</select>';
echo '</div>';
echo '</div>';