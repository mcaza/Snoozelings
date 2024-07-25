<?php

//Get Records
$query = "SELECT * FROM dailyRecords ORDER BY id DESC LIMIT 1";
$stmt = $pdo->prepare($query);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

echo '<h2>Community Tasks</h2>';

//Display Records
if ($result['journalEntries'] == "1") {
    echo "<p>" . $result['journalEntries'] . " Journal Entry</p>";
} else {
    echo "<p>" . $result['journalEntries'] . " Journal Entries</p>";
}
if ($result['cropsHarvested'] == "1") {
     echo "<p>" . $result['cropsHarvested'] . " Crop Harvested</p>";
} else {
    echo "<p>" . $result['cropsHarvested'] . " Crops Harvested</p>";
}
if ($result['itemsCrafted'] == "1") {
    echo "<p>" . $result['itemsCrafted'] . " Item Crafted</p>";
} else {
    echo "<p>" . $result['itemsCrafted'] . " Items Crafted</p>";
}
if ($result['requestsFilled'] == "1") {
    echo "<p>" . $result['requestsFilled'] . " Request Fulfilled</p>";
} else {
    echo "<p>" . $result['requestsFilled'] . " Requests Fulfilled</p>";
}
if ($result['kindnessCoins'] == "1") {
    echo "<p>" . $result['kindnessCoins'] . " Kindness Coin Earned</p>";
} else {
    echo "<p>" . $result['kindnessCoins'] . " Kindness Coins Earned</p>";
}






//echo "<p>" . $result['activeMembers'] . " Active Members</p>";
