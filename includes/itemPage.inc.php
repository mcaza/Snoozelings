<?php
$id = $_GET['id'] + 1;
$userId = $_SESSION['user_id'];

//Get How Many of Item
$query = "SELECT * FROM items WHERE list_id = :item AND user_id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->bindParam(":item", $id);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$count = count($results);

//Get Item Information
$query = "SELECT * FROM itemList WHERE id = :item";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":item", $id);
$stmt->execute();
$item = $stmt->fetch(PDO::FETCH_ASSOC);

//Get Snoozelings
$query = "SELECT * FROM snoozelings WHERE owner_id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$snoozelings = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Type Edit
$type = ucfirst($item['type']);
if ($item['type'] === 'clothesBottom') {
    $type = "Clothes [Bottom]";
}
if ($item['type'] === 'clothesTop') {
    $type = "Clothes [Top]";
}

//Back to Pack Arrows
 echo '<div class="leftRightButtons">';
echo '<a href="pack"><<</a>';
echo '</div>';

echo '<div class="itemPageRow">';
echo '<div class="itemPage">';
echo '<img src="items/' . $item['name'] . '.png" style="width: 150px;">';
echo '<h4>' . $item['display'] . '</h4>';
echo '<p><i>' . $item['description'] . '</i></p>';
echo '</div>';
echo '<div class="itemPageRight">';
echo '<p><strong>Type: </strong>' . $type . '</p>';
echo '<p><strong>Rarity: </strong>' . ucfirst($item['rarity']) . '</p>';
echo '<p><strong>Quantity: </strong>' . $count . '</p>';
echo '</div>';
if ($item['name'] === "PlanterBox") {
    echo '<button class="fancyButton" onClick="window.location.href=\'includes/useBox.inc.php\'">Add Farm Plot</button>';
}
if ($item['type'] === 'fabric' || $item['type'] === 'design') {
echo "<form action='../includes/useItem.inc.php' onsubmit=\"return confirm('Are you sure you want to use this item?');\">";
echo '<label for="snoozeling" class="form">Pick a Snoozeling:</label><br>';
echo '<select class="input"  name="snoozeling">';
foreach ($snoozelings as $snooze) {
    echo '<option value="' . $snooze['id'] . '">' . htmlspecialchars($snooze['name']) . '</option>';
}
echo '</select><br>';
echo "<button>Use Item</button>";
echo '</form>';
}
echo '</div>';