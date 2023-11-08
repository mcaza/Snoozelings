<?php


if (isset($_GET['ID'])) {   
    $id = $_GET['ID'];
}

$query4 = "SELECT * FROM snoozelings WHERE id = :id;";
        $stmt4 = $pdo->prepare($query4);
        $stmt4->bindParam(":id", $id);
        $stmt4->execute();
        $petInfo = $stmt4->fetchAll(PDO::FETCH_ASSOC);

displayPet($petInfo[0], "artlarge");
echo "<p><strong>" . htmlspecialchars($petInfo[0]["name"]) . "'s Pronouns:</strong> " . htmlspecialchars($petInfo[0]["pronouns"]) . "</p>";

