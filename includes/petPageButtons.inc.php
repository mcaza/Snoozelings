<?php

if (isset($_GET['ID'])) {   
    $id = $_GET['ID'];
}

$query = "SELECT owner_id FROM snoozelings WHERE id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SESSION["user_id"] === $result["owner_id"]) { 
    echo '<div class="button-bar">
                <button class="fancyButton">Edit Profile</button>
                <button class="fancyButton">Change Job</button>
                <button class="fancyButton" onClick="window.location.href=\'includes/bondSoul.inc.php?ID=' . $id . '\'">Bond Souls</button>
            </div>';
} else {
    $query = "SELECT username FROM users WHERE id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    
    $name = $stmt->fetch(PDO::FETCH_ASSOC);
    echo '<div class="button-bar"><p style="font-size: 2rem;" ><strong>Owned By: </strong><a href="profile?ID=' . $id . '">' . htmlspecialchars($name["username"]) . '</a></p></div>';
}