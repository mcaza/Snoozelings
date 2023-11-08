<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $colorSearch = $_POST["colorSearch"];
    
    try {
        require_once "includes/dbh-inc.php";
        
        $query = "SELECT * FROM Colors WHERE CONCAT(categories,rarity) LIKE CONCAT('%', :colorSearch, '%')";
        
        $stmt = $pdo->prepare($query);
        
        $stmt->bindParam(":colorSearch", $colorSearch);
        
        $stmt->execute();
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $count = $stmt->rowCount();
        
        $pdo = null;
        $stmt = null;
    
    } catch (PDOException $e) {
        die("Query Failed: " . $e->getMessage());        
    }
} else {
    header("Location: ../showColors.php");
}

?>

<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="">
</head>

<body>
    
    <h3>Search Results:</h3>
    
    <?php
    if (empty($results)) {
        echo "<div>";
        echo "<p>There Were No Results!</p>";
        echo "</div>";
    } else {
        echo "<p><strong>Results:</strong> " . $count . "</p>";
        echo "<select name=\"colors\" id=\"colors\">";
        foreach ($results as $result) {
            echo "<option value=\"" . $result["id"] . "\">" . htmlspecialchars($result["display"]) . "</option>";
        }
        echo "</select>";
        
        foreach ($results as $result) {
            echo "<div>";
            echo "<h4>" . htmlspecialchars($result["display"]) . "</h4><br>";
            echo "<img src=\"Layers/Colors/" . htmlspecialchars($result["name"]) . ".png\" >";
            echo "</div>";
        } 
        
    }
    
    ?>
    
</body>
</html>































