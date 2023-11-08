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
    if ($result["job"] === "jack") {
        echo "<p>Jack of all Trades</p>";
    } else {
        switch ($result["job"]) {
            case "Farmer":
                if ($result["farmEXP"] < 50) {
                    echo "<p>Level 1 " . $result["job"];
                } elseif ($result["farmEXP"] < 150) {
                    echo "<p>Level 2 " . $result["job"];
                } elseif ($result["farmEXP"] < 325) {
                    echo "<p>Level 3 " . $result["job"];
                } elseif ($result["farmEXP"] < 600) {
                    echo "<p>Level 4 " . $result["job"];
                } elseif ($result["farmEXP"] < 1000) {
                    echo "<p>Level 5 " . $result["job"];
                } else {
                    echo "<p>Crop Whisperer</p>";
                }
            break;
            case "Explorer":
                if ($result["exploreEXP"] < 50) {
                    echo "<p>Level 1 " . $result["job"];
                } elseif ($result["exploreEXP"] < 150) {
                    echo "<p>Level 2 " . $result["job"];
                } elseif ($result["exploreEXP"] < 325) {
                    echo "<p>Level 3 " . $result["job"];
                } elseif ($result["exploreEXP"] < 600) {
                    echo "<p>Level 4 " . $result["job"];
                } elseif ($result["exploreEXP"] < 1000) {
                    echo "<p>Level 5 " . $result["job"];
                } else {
                    echo "<p>Grand Adventurer</p>";
                }
            break;
            case "Crafter":
                if ($result["craftEXP"] < 50) {
                    echo "<p>Level 1 " . $result["job"];
                } elseif ($result["craftEXP"] < 150) {
                    echo "<p>Level 2 " . $result["job"];
                } elseif ($result["craftEXP"] < 325) {
                    echo "<p>Level 3 " . $result["job"];
                } elseif ($result["craftEXP"] < 600) {
                    echo "<p>Level 4 " . $result["job"];
                } elseif ($result["craftEXP"] < 1000) {
                    echo "<p>Level 5 " . $result["job"];
                } else {
                    echo "<p>Hooked on Crafts</p>";
                }
            break;
        }
        
    }
