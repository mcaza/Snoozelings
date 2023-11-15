<?php

if (isset($_GET['ID'])) {   
    $id = $_GET['ID'];
}

    $query3 = "SELECT * FROM snoozelings WHERE id = :id;";
    $stmt3 = $pdo->prepare($query3);
    $stmt3->bindParam(":id", $id);
    $stmt3->execute();
    
    $result = $stmt3->fetch(PDO::FETCH_ASSOC);
    echo "<h3>" . htmlspecialchars($result["name"]) . "</h3>";
    echo "<p>" . $result['title'] . '</p>';
        
    
