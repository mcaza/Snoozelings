<?php
$userId = $_COOKIE['user_id'];

//Grab All Open Inspiration Pets
$query = 'SELECT * FROM snoozelings WHERE breedStatus = "Open"';
$stmt = $pdo->prepare($query);
$stmt->execute();
$pets = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Add Color Types to Array
$colorArray = [];




foreach ($pets as $pet) {
    //Grab Color Info
    $query = 'SELECT categories FROM colors WHERE name = :color';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":color", $pet['mainColor']);
    $stmt->execute();
    $colorInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    array_push($colorArray, $colorInfo['categories']);
}

echo '<h3>Brown Pets</h3>';
echo '<div style="display:flex;flex-wrap:wrap;justify-content:space-evenly;">';
$counter = 0;
foreach ($colorArray as $color) {
    if(strpos($color, "Brown") !== false) {
        echo '<div style="display:flex;flex-direction:column;">';
        displayPet($pets[$counter],'artStarter');
        echo '<p><b>' . $pets[$counter]['name'] . '</b></p>';
        echo '</div>';
        
    }
    $counter++;
}
echo '</div>'; 
echo '<hr>';

echo '<h3>White Pets</h3>';
echo '<div style="display:flex;flex-wrap:wrap;justify-content:space-evenly;">';
$counter = 0;
foreach ($colorArray as $color) {
    if(strpos($color, "White") !== false) {
        echo '<div style="display:flex;flex-direction:column;">';
        displayPet($pets[$counter],'artStarter');
        echo '<p><b>' . $pets[$counter]['name'] . '</b></p>';
        echo '</div>';
        
    }
    $counter++;
}
echo '</div>'; 
echo '<hr>';

echo '<h3>Black Pets</h3>';
echo '<div style="display:flex;flex-wrap:wrap;justify-content:space-evenly;">';
$counter = 0;
foreach ($colorArray as $color) {
    if(strpos($color, "Black") !== false) {
        echo '<div style="display:flex;flex-direction:column;">';
        displayPet($pets[$counter],'artStarter');
        echo '<p><b>' . $pets[$counter]['name'] . '</b></p>';
        echo '</div>';
        
    }
    $counter++;
}
echo '</div>'; 
echo '<hr>';

echo '<h3>Red Pets</h3>';
echo '<div style="display:flex;flex-wrap:wrap;justify-content:space-evenly;">';
$counter = 0;
foreach ($colorArray as $color) {
    if(strpos($color, "Red") !== false) {
        echo '<div style="display:flex;flex-direction:column;">';
        displayPet($pets[$counter],'artStarter');
        echo '<p><b>' . $pets[$counter]['name'] . '</b></p>';
        echo '</div>';
        
    }
    $counter++;
}
echo '</div>'; 
echo '<hr>';

echo '<h3>Orange Pets</h3>';
echo '<div style="display:flex;flex-wrap:wrap;justify-content:space-evenly;">';
$counter = 0;
foreach ($colorArray as $color) {
    if(strpos($color, "Orange") !== false) {
        echo '<div style="display:flex;flex-direction:column;">';
        displayPet($pets[$counter],'artStarter');
        echo '<p><b>' . $pets[$counter]['name'] . '</b></p>';
        echo '</div>';
        
    }
    $counter++;
}
echo '</div>'; 
echo '<hr>';

echo '<h3>Yellow Pets</h3>';
echo '<div style="display:flex;flex-wrap:wrap;justify-content:space-evenly;">';
$counter = 0;
foreach ($colorArray as $color) {
    if(strpos($color, "Yellow") !== false) {
        echo '<div style="display:flex;flex-direction:column;">';
        displayPet($pets[$counter],'artStarter');
        echo '<p><b>' . $pets[$counter]['name'] . '</b></p>';
        echo '</div>';
        
    }
    $counter++;
}
echo '</div>'; 
echo '<hr>';

echo '<h3>Green Pets</h3>';
echo '<div style="display:flex;flex-wrap:wrap;justify-content:space-evenly;">';
$counter = 0;
foreach ($colorArray as $color) {
    if(strpos($color, "Green") !== false) {
        echo '<div style="display:flex;flex-direction:column;">';
        displayPet($pets[$counter],'artStarter');
        echo '<p><b>' . $pets[$counter]['name'] . '</b></p>';
        echo '</div>';
        
    }
    $counter++;
}
echo '</div>'; 
echo '<hr>';

echo '<h3>Blue Pets</h3>';
echo '<div style="display:flex;flex-wrap:wrap;justify-content:space-evenly;">';
$counter = 0;
foreach ($colorArray as $color) {
    if(strpos($color, "Blue") !== false) {
        echo '<div style="display:flex;flex-direction:column;">';
        displayPet($pets[$counter],'artStarter');
        echo '<p><b>' . $pets[$counter]['name'] . '</b></p>';
        echo '</div>';
        
    }
    $counter++;
}
echo '</div>'; 
echo '<hr>';

echo '<h3>Purple Pets</h3>';
echo '<div style="display:flex;flex-wrap:wrap;justify-content:space-evenly;">';
$counter = 0;
foreach ($colorArray as $color) {
    if(strpos($color, "Purple") !== false) {
        echo '<div style="display:flex;flex-direction:column;">';
        displayPet($pets[$counter],'artStarter');
        echo '<p><b>' . $pets[$counter]['name'] . '</b></p>';
        echo '</div>';
        
    }
    $counter++;
}
echo '</div>'; 
echo '<hr>';

echo '<h3>Pink Pets</h3>';
echo '<div style="display:flex;flex-wrap:wrap;justify-content:space-evenly;">';
$counter = 0;
foreach ($colorArray as $color) {
    if(strpos($color, "Pink") !== false) {
        echo '<div style="display:flex;flex-direction:column;">';
        displayPet($pets[$counter],'artStarter');
        echo '<p><b>' . $pets[$counter]['name'] . '</b></p>';
        echo '</div>';
        
    }
    $counter++;
}
echo '</div>'; 
echo '<hr>';
echo '<h3>Pastel Pets</h3>';
echo '<div style="display:flex;flex-wrap:wrap;justify-content:space-evenly;">';
$counter = 0;
foreach ($colorArray as $color) {
    if(strpos($color, "Pastel") !== false) {
        echo '<div style="display:flex;flex-direction:column;">';
        displayPet($pets[$counter],'artStarter');
        echo '<p><b>' . $pets[$counter]['name'] . '</b></p>';
        echo '</div>';
        
    }
    $counter++;
}
echo '</div>'; 
echo '<hr>';
echo '<h3>Eyeburner Pets</h3>';
echo '<div style="display:flex;flex-wrap:wrap;justify-content:space-evenly;">';
$counter = 0;
foreach ($colorArray as $color) {
    if(strpos($color, "Eyeburner") !== false) {
        echo '<div style="display:flex;flex-direction:column;">';
        displayPet($pets[$counter],'artStarter');
        echo '<p><b>' . $pets[$counter]['name'] . '</b></p>';
        echo '</div>';
        
    }
    $counter++;
}
echo '</div>'; 
echo '<hr>';
echo '<h3>Monochrome Pets</h3>';
echo '<div style="display:flex;flex-wrap:wrap;justify-content:space-evenly;">';
$counter = 0;
foreach ($colorArray as $color) {
    if(strpos($color, "Monochrome") !== false) {
        echo '<div style="display:flex;flex-direction:column;">';
        displayPet($pets[$counter],'artStarter');
        echo '<p><b>' . $pets[$counter]['name'] . '</b></p>';
        echo '</div>';
        
    }
    $counter++;
}
echo '</div>'; 
echo '<hr>';