<?php
if ($_GET['id']) {
    $id = $_GET['id'];
} else {
    $id = 1;
}

//Grab All Pets
$query = "SELECT * FROM snoozelings WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $id);
$stmt->execute();
$pet = $stmt->fetch(PDO::FETCH_ASSOC);

singleImage($pet);

//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="pet?id=' . $id . '"><<</a>';
//echo '<a href="snoozelings/' . $id . '.png" download="snoozelings/' . $id . '.png" class="fancyButton">Download</a>';
echo '</div>';

echo '<h1>Download ' . $pet['name'] . '\'s Image</h1><br>';

echo '<a href="snoozelings/' . $pet['id'] . '.png" download="snoozelings/' . $pet['id'] . '.png" class="fancyButton">Download</a>';

echo '<br><br><br><Br><br>';


/*
$bg = 'Layers/transparentSquare.png';

$numberOfImages = 3;
$x = 1250;
$y = 1250;
$background = imagecreatefrompng($bg);


imageAlphaBlending($background, true);
imageSaveAlpha($background, true);

$primaryUrl = 'Layers/Primary/' . $pet['mainColor'] . '.png';

$pupilsUrl = 'Layers/Faces/Happy/Eyes/' . $pet['eyeColor'] . '.png';

$earUrl = 'Layers/Ear/' . $pet['noseColor'] . '.png';

$linesUrl = 'Layers/MainLines/' . $pet['mainColor'] . '.png';


$outputImage = $background;

$primary = imagecreatefrompng($primaryUrl);
$pupils = imagecreatefrompng($pupilsUrl);
$lines = imagecreatefrompng($linesUrl);
$ear = imagecreatefrompng($earUrl);


$dest = 'snoozelings/' . $pet['id'] . '.png';


imagecopy($outputImage,$primary,0,0,0,0, $x, $y);
imagecopy($outputImage,$pupils,0,0,0,0, $x, $y);
imagecopy($outputImage,$ear,0,0,0,0, $x, $y);
imagecopy($outputImage,$lines,0,0,0,0, $x, $y);




imagepng($outputImage, $dest);

echo '<img src="snoozelings/' . $pet['id'] . '.png" style="width:80%;">';



imagedestroy($outputImage);
*/