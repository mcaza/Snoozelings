<?php

if (isset($_GET['ID'])) {   
    $id = $_GET['ID'];
}

//Get List of All Snoozelings
$query = "SELECT id FROM snoozelings WHERE owner_id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

//Get Owner ID
$query = "SELECT owner_id FROM snoozelings WHERE id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

/*    //User Navigation
    echo '<div class="leftRightButtons">';
    echo '<a href="collection?id=' . ($id - 1) . '"><<</a>';
    echo '<a href="collection?id=' . ($id + 1) . '">>></a>';
    echo '</div>'; */

if ($_SESSION["user_id"] === $result["owner_id"]) { 
    echo '<div class="button-bar">
                <button class="fancyButton" onClick="window.location.href=\'/editPet?id=' . $id . '\'">Edit Profile</button>
                <button class="fancyButton" onClick="window.location.href=\'/petJob?id=' . $id . '\'">Change Job</button>
                <button class="fancyButton" onClick="window.location.href=\'../includes/bondSoul.inc.php?id=' . $id . '\'">Bond Souls</button>
            </div>';
} elseif ($result['owner_id'] === "0") {
     echo '<div class="button-bar"><p style="font-size: 2rem;" >Up for Adoption</p></div>';
} else {
    //Get Username
    $query = "SELECT username FROM users WHERE id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $result["owner_id"]);
    $stmt->execute();
    $name = $stmt->fetch(PDO::FETCH_ASSOC);
    echo '<div class="button-bar"><p style="font-size: 2rem;" ><strong>Owned By: </strong><a href="profile?id=' . $result["owner_id"] . '">' . htmlspecialchars($name["username"]) . '</a></p></div>';
}