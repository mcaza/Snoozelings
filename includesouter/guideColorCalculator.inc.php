<?php

//Get Values
if (isset($_GET['one']) && isset($_GET['two'])) {
    $one = $_GET['one'];
    $two = $_GET['two'];

}

//Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="gameGuides"><<</a>';
echo '</div>';

echo '<h3>Colors Calculator</h3>';

$query = 'SELECT * FROM colors ORDER BY display ASC';
$stmt = $pdo->prepare($query);
$stmt->execute();
$colorList = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Calculator Part
echo '<div>';
echo '<form action="/guideColorCalculator.php" method="get">';
echo '<div style="display:flex;justify-content:space-evenly;">';
echo '<div>';
if ($one) {
    echo '<img src="Layers/ColorPaws/' . $one . '.png" style="width:200px;" id="colorOne">';
} else {
    echo '<img src="Layers/ColorPaws/Alexandrite.png" style="width:200px;" id="colorOne">';
}

echo '<h1>Color One:</h1>';
echo '<select name="one" id="one">';
if ($one) {
    $query = 'SELECT * FROM colors WHERE name = :name';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $one);
    $stmt->execute();
    $first = $stmt->fetch(PDO::FETCH_ASSOC);
    echo '<option value="' . $first['name'] . '">' . $first['display'] . '</option>';
}

foreach ($colorList as $color) {
    echo '<option value="' . $color['name'] . '">' . $color['display'] . '</option>';
}
echo '</select>';
echo '</div>';
echo '<div>';
if ($two) {
    echo '<img src="Layers/ColorPaws/' . $two . '.png" style="width:200px;" id="colorTwo">';
} else {
    echo '<img src="Layers/ColorPaws/Alexandrite.png" style="width:200px;" id="colorTwo">';
}
echo '<h1>Color Two:</h1>';
echo '<select name="two" id="two">';
if ($two) {
    $query = 'SELECT * FROM colors WHERE name = :name';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $two);
    $stmt->execute();
    $first = $stmt->fetch(PDO::FETCH_ASSOC);
    echo '<option value="' . $first['name'] . '">' . $first['display'] . '</option>';
}

foreach ($colorList as $color) {
    echo '<option value="' . $color['name'] . '">' . $color['display'] . '</option>';
}
echo '</select>';
echo '</div>';
echo '</div>';
echo "<br><br><button class='fancyButton'>Select Colors</button>";
echo '</form>';

echo '</div>';

echo '<hr>';



if ($one && $two) {
    echo '<h1>Possible Colors</h1>';
    
    //Add Color Info to Array
            $color1 = $one;
            $query = 'SELECT * FROM colors where name = :name';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":name", $color1);
            $stmt->execute();
            $info1 = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $color2 = $two;
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

            
            echo '<div style="display:flex;flex-wrap:wrap;justify-content:space-evenly;">';
            foreach ($oneEach as $option) {
                echo '<div><img src="Layers/ColorPaws/' . $option . '.png" style="width:200px"><br><p><b>' . $option . '</b></p></div>';
            }
            echo '</div>';
}
