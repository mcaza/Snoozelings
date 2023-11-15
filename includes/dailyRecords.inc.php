<?php

$query = "SELECT * FROM dailyRecords WHERE id = 1";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
echo "<p>" . $result['journalEntries'] . " Journal Entries</p>";
echo "<p>" . $result['cropsHarvested'] . " Crops Harvested</p>";
echo "<p>" . $result['snoozelingsCrafted'] . " Snoozelings Crafted</p>";
//echo "<p>" . $result['itemsCrafted'] . " Items Crafted</p>";
//echo "<p>" . $result['activeMembers'] . " Active Members</p>";
echo "<p>" . $result['newMembers'] . " New Members</p>";
echo "<p>" . $result['kindnessCoins'] . " Kindness Coins Earned</p>";
    
