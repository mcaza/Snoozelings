<?php

//Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="gameGuides"><<</a>';
echo '</div>';

echo '<h3>Color Guide</h3>';

echo '<h2 style="text-align:center;margin-left:30px;">Basic Information</h2>';

echo '<p style="text-align:center;margin: 0px 40px 15px 30px;">The Colors System determines the snoozelings\'s five colors: main, hair, tail, skin, and eyes.<br><br>As of the April 2025 update, colors no longer hold specific rarities.<br><br>Now all have equal rarities but can still be found in a variety of ways: creating new snoozelings, festivals, events, Wish Tokens, and many more ways in the future.<br><br>Though there are still some special creation-only colors that are not available with <b><i>starter snoozelings</i></b> including but not limited to: Bee, Banana Peel, Chalkboard, Collie, Dino Oatmeal, Eyeburner, Raccoon, Red Panda, Retro, Sloth</p>';

echo '<h2 style="text-align:center;margin-bottom:10px;">Color Traits</h2>';

echo '<p style="text-align:center;margin: 0px 40px 15px 30px;">Each color has three traits that are used in the calculation of creating new snoozelings.<br><br><b>Color -</b> This is the prime coloration from the color scheme.<br><br><i>Black, Blue, Brown, Green, Grey, Orange, Pink, Purple, Red, White, or Yellow</i><br><br><b>Category -</b> This is the general activity or item family that it belongs to.</b><br><br><i>Animal, Festival, Healthy, Hobbies, Natural, Treats, or Underground</i><br><br><b>Hue -</b> This is the shade or intensity of the color.</b><br><br><i>Dark, Eyeburner, Matte, Monochrome, Pastel, Primary, or Secondary</i></p>';

echo '<h2 style="text-align:center;margin-bottom:10px;">List of Colors</h2>';

echo '<div style="display:flex;flex-wrap:wrap;justify-content:space-evenly;gap:10px;">';

$query = 'SELECT * FROM colors ORDER BY name ASC';
$stmt = $pdo->prepare($query);
$stmt->execute();
$colorList = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($colorList as $color) {
    echo '<div style="width: 200px;border:silver 2px dashed;border-radius:25px;">';
    echo '<img src="Layers/ColorPaws/' . $color['name'] . '.png" style="width:150px;">';
    echo '<p><b>' . $color['display'] . '</b><br>';
    echo $color['color'] . '<br>' . $color['category'] . '<br>' . $color['hue'] . '</p>';
    echo '</div>';
}

echo '</div>';

echo '<p><i>Page is Updated Automatically When New Colors Are Added</i></p>';