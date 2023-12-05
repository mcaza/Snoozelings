<?php

$query = "SELECT * FROM dailyRecords WHERE id = 1";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
if ($result['journalEntries'] === "1") {
    echo "<p>" . $result['journalEntries'] . " Journal Entry</p>";
} else {
    echo "<p>" . $result['journalEntries'] . " Journal Entries</p>";
}
if ($result['cropsHarvested'] === "1") {
     echo "<p>" . $result['cropsHarvested'] . " Crop Harvested</p>";
} else {
    echo "<p>" . $result['cropsHarvested'] . " Crops Harvested</p>";
}
if ($result['itemsCrafted'] === "1") {
    echo "<p>" . $result['itemsCrafted'] . " Item Crafted</p>";
} else {
    echo "<p>" . $result['itemsCrafted'] . " Items Crafted</p>";
}
if ($result['snoozelingsCrafted'] === "1") {
    echo "<p>" . $result['snoozelingsCrafted'] . " Snoozeling Sewn</p>";
} else {
    echo "<p>" . $result['snoozelingsCrafted'] . " Snoozelings Sewn</p>";
}
if ($result['newMembers'] === "1") {
    echo "<p>" . $result['newMembers'] . " New Member</p>";
} else {
    echo "<p>" . $result['newMembers'] . " New Members</p>";
}
if ($result['kindnessCoins'] === "1") {
    echo "<p>" . $result['kindnessCoins'] . " Kindness Coin Earned</p>";
} else {
    echo "<p>" . $result['kindnessCoins'] . " Kindness Coins Earned</p>";
}






//echo "<p>" . $result['activeMembers'] . " Active Members</p>";
