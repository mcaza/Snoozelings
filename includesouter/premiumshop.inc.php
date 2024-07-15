<?php

$userId = $_SESSION['user_id'];

//Get all Products
$query = "SELECT * FROM products WHERE hidden = 0 ORDER BY price ASC;";
$stmt = $pdo->prepare($query);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo '<h3 style="margin-bottom: 20px;">Early Access Codes</h3>';

echo '<div class="shop">';

foreach ($results as $result) {
    if ($result['type'] == 1) {
        echo '<div class="product"><a href="product?id=' . $result['id'] . '">';
        echo '<img src="resources/' . $result['image'] . '.png">';
        echo '<h2>' . $result['title'] . '</h2>';
        if ($result['title2']) {
            echo '<p>' . $result['title2'] . '</p>';
        } else {
            echo '<p>      </p>';
        }
        echo '</a></div>';
    }
}

echo '</div>';

echo '<h3 style="margin-bottom: 20px;margin-top: 20px;">Custom Items</h3>';

echo '<div class="shop">';

foreach ($results as $result) {
    if ($result['type'] == 2) {
        echo '<div class="product"><a href="product?id=' . $result['id'] . '">';
        echo '<img src="resources/' . $result['image'] . '.png">';
        echo '<h2>' . $result['title'] . '</h2>';
        if ($result['title2']) {
            echo '<p>' . $result['title2'] . '</p>';
        } else {
            echo '<p>      </p>';
        }
        echo '</a></div>';
    }
}

echo '</div>';