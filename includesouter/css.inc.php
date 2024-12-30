<?php 
    $userId = $_SESSION['user_id'];
    $query = 'SELECT mode FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $mode = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($mode['mode'] == "Dark") {
        echo '<link rel="stylesheet" href="stylesdark.css">';
        
    } else {
        echo '<link rel="stylesheet" href="styles.css">';
    } 